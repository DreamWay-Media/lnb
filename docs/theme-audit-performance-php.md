# Theme audit: performance, reliability, and PHP compatibility

Review of the `dwm-lnb` theme (excluding `node_modules`). Items are ordered **highest priority first**.

## Resolution status (fixes applied)

| # | Issue | Status |
|---|--------|--------|
| 1 | LESS on every request | **Done** — compiles only when `app.less` is newer than `app.css` (or CSS missing); failures logged when `WP_DEBUG_LOG` is on; `\Exception` catch. |
| 2 | Duplicate CDN jQuery/Owl on single product | **Done** — removed from `woocommerce/content-single-product.php`; carousel init via `wp_add_inline_script( 'owl', … )` on `is_product()`. |
| 3 | Duplicate `<title>` | **Done** — removed manual `<title>` from `header.php` (`title-tag` only). |
| 4 | Short `<?` in `booking.php` | **Done** — `<?php`. |
| 5 | Unbounded queries + `print_r` | **Done** — paginated `WP_Query` in `archive.php` and `archive-designers.php`; debug output removed. |
| 6 | Global Bootstrap/Owl on all pages | **Deferred** — left global enqueue to avoid breaking unknown templates; revisit with a route map. |
| 7 | Bundled jQuery deregister | **Done** — uses WordPress core jQuery + migrate. |
| 8 | `gettext` “Read more” → “Video” | **Done** — narrowed with `is_woocommerce()`. |
| 9 | Botpress after `wp_footer` | **Done** — `wp_enqueue_script` in `functions.php`; raw tags removed from `footer.php`; delay-exclude hints updated. |
| 10 | N+1 in `get_archive_by_year_and_month` | **Deferred** — not refactored (low traffic helper); empty return fixed. |
| 11 | `wp_reset_query` on home slider | **Done** — `wp_reset_postdata()`; single query + `rewind_posts()` for indicators. |
| 12 | Slider without `have_posts` | **Done** — guarded first slide; indicators use rewound query. |
| 13 | Undefined `$logo` mobile | **Done** — logo resolved once in `header.php` with `! empty( $logo[0] )`. |
| 14–15 | `register_setting` + `add_filter` on `admin_init` | **Done** — args array + `dwm_lnb_sanitize_less_status`; `add_action`. |
| 16 | Dead `woo_related_products_limit` | **Done** — removed; kept `jk_related_products_args`. |
| 17 | `getarchives_where` SQL | **Done** — `$wpdb->prepare` + `sanitize_key`. |
| 18 | WooCommerce template drift | **Partial** — product content wrapper cleaned; full overrides not re-synced to latest WC. |
| 19 | lessphp `${name}` deprecation | **Done** — `{$name}` in `css/lessc.inc.php`. |
| 20 | Dev URLs for flowers | **Partial** — `home.php` / `booking.php` use `get_stylesheet_directory_uri() . '/imgs/…'`; add PNGs to `imgs/` (see `.gitkeep`). Other templates may still reference old domains. |
| 21 | `pll_e` without Polylang | **Done** — `dwm_lnb_pll_e()` helper in `functions.php`. |
| 22 | Empty `index.php` fallback | **Done** — loop + `template-parts/content-blog-card`. |
| 23 | Scroll handler | **Done** — `requestAnimationFrame` gate in `js/app.js`. |
| 24 | `node_modules` in repo | **N/a** — `node_modules/` is already listed in `.gitignore`; keep it untracked in git. |

---

## Original findings (reference)

### 1. LESS compilation on every request (`functions.php`)

`less_compile` runs on `init` and, when `less_status` is `1` (default via `get_option('less_status', 1)`), loads `css/lessc.inc.php` and compiles `css/app.less` to `css/app.css` **on every front-end and admin request**.

**Why it hurts:** Large CPU and disk I/O per hit; scales poorly under traffic; can contend on concurrent writes to `app.css`.

**Related:** On failure, `catch (exception $e)` uses `echo` for the message, which can corrupt HTML/headers and leak errors to visitors.

**PHP note:** Relies on bundled **lessphp v0.4.0** (`css/lessc.inc.php`), an old third-party compiler; long-term maintenance and PHP compatibility are weaker than using Node/`lessc` at build time only.

---

### 2. Duplicate jQuery and Owl Carousel on single product pages (`woocommerce/content-single-product.php`)

The template prints:

- Owl Carousel CSS from cdnjs (two stylesheets)
- jQuery **3.3.1** from cdnjs
- Owl Carousel JS from cdnjs  
  …then initializes a carousel with an **inline** `<script>`.

The theme already registers local jQuery and Owl via `register_styles_scripts()` in `functions.php`.

**Why it hurts:** Extra render-blocking HTTP requests, duplicate libraries (version skew, double initialization risk), and fragile load order versus scripts enqueued through WordPress. This is one of the largest front-end performance issues in the theme.

---

## High

### 3. Duplicate document titles (`header.php` + `functions.php`)

The theme calls `add_theme_support( 'title-tag' )` (so WordPress can inject `<title>` via `wp_head()`), but `header.php` also outputs `<title><?php wp_title(); ?></title>`.

**Why it hurts:** Duplicate `<title>` elements confuse SEO and tools; `wp_title()` without arguments is legacy compared to the title-tag API.

---

### 4. ASP-style short open tag in booking template (`booking.php`)

Around the product loop, the file uses `<?` instead of `<?php`.

**PHP / hosting:** If `short_open_tag` is **Off** (common), PHP will not treat `<?` as PHP and can emit a **parse error** or broken output depending on server configuration.

---

### 5. Unbounded post queries (`archive.php`, `archive-designers.php`)

Both use `get_posts( array( ..., 'numberposts' => -1 ) )` (or equivalent) to load **all** matching posts in one request.

**Why it hurts:** High memory use and slow queries as the blog or `designers` post count grows.

**Also in `archive-designers.php`:** `print_r( $specialists )` dumps the full post array to HTML — debug noise, larger payload, and potential information leak.

---

## Medium

### 6. Global script and style stack on every template (`functions.php` → `register_styles_scripts`)

Bootstrap CSS, Owl Carousel CSS (×2), `app.css`, jQuery, Bootstrap JS, Owl, and `app.js` are enqueued for all front-end pages (priority `100`).

**Why it hurts:** Pages that do not use carousels or Bootstrap-heavy UI still pay the download and parse cost. Consider conditional enqueue on templates that need them.

---

### 7. Replacing core jQuery with a bundled copy (`functions.php`)

`wp_deregister_script( 'jquery' )` and re-registering from `js/vendor/jquery.min.js` affects **every** script that declares a jQuery dependency.

**Why it can hurt:** Plugins and WooCommerce expect the WordPress-bundled jQuery (version, `jquery-migrate`, noConflict behavior). Mismatches can cause subtle bugs after core/plugin updates.

---

### 8. `gettext` filter for WooCommerce string (`functions.php`)

`ds_change_readmore_text` filters **all** gettext calls when not in admin and domain is `woocommerce`, for the specific “Read more” string.

**Why it can hurt:** `gettext` runs very frequently; even a cheap callback adds overhead on large pages with many translatable strings.

---

### 9. Third-party scripts at the bottom of `footer.php`

Botpress webchat scripts are loaded after `wp_footer()` from external URLs.

**Why it matters:** Extra blocking/third-party work, privacy and CSP considerations, and failure modes if those hosts are slow or blocked.

---

### 10. N+1 database pattern in `get_archive_by_year_and_month()` (`functions.php`)

For each distinct year, the code runs another `$wpdb->get_col()` for months.

**Why it hurts:** Many years means many round-trips; fine for small archives, poor for large ones.

**PHP correctness:** If no published posts exist, `$years` is falsy and `$rueckgabe` is never set, yet the function `return $rueckgabe` — **undefined variable** (notices in PHP 8+, brittle).

**Note:** The function is not registered as a shortcode or hooked elsewhere in this theme; it may be dead code or only called from the database/widgets.

---

## Lower (still worth tracking)

### 11. `wp_reset_query()` after slider loop (`home.php`)

After the slider `WP_Query` loop, the code calls `wp_reset_query()` instead of `wp_reset_postdata()`.

**Why it matters:** `wp_reset_query()` resets the main query globally; here it is often unnecessary and can interact badly with the main loop. `wp_reset_postdata()` is usually the right choice after a custom `WP_Query` loop.

---

### 12. Slider queries without existence checks (`home.php`)

The first slider query calls `$slider_content->the_post()` without checking `$slider_content->have_posts()`. If there are no `slider` posts, behavior depends on WP/PHP versions and can produce notices or empty output.

---

### 13. Possible undefined `$logo` in mobile header (`header.php`)

The large-nav block sets `$logo` from `wp_get_attachment_image_src( $custom_logo_id, 'full' )`. The small-nav block uses `$logo[0]` in the logo `<img>` without ensuring the same assignment ran in a way that guarantees `$logo` is defined (e.g. only `has_custom_logo()` is checked).

**PHP 8+:** Accessing undefined variables/array offsets can raise warnings.

---

### 14. `register_setting` usage for `less_status` (`functions.php`)

`register_setting( 'general', 'less_status', 'esc_attr' )` uses the older third-parameter form. Current WordPress prefers an args array with a `sanitize_callback` (and `esc_attr` is an odd sanitize for a radio 0/1).

**Why it matters:** Forward compatibility with WordPress APIs, not a runtime crash by itself.

### 15. `add_filter( 'admin_init', 'less_register_settings' )` (`functions.php`)

Hooking `less_register_settings` with `add_filter` instead of `add_action` works in practice but is unconventional and can confuse future maintenance.

---

### 16. Dead or redundant WooCommerce code (`functions.php`)

- `woo_related_products_limit()` is defined but **never** attached to a filter.
- `woocommerce_output_related_products_args` is correctly filtered by `jk_related_products_args`.

---

### 17. `getarchives_where` filter (`functions.php`)

`my_custom_post_type_archive_where` builds `WHERE post_type = '$post_type' ...` from `$args['post_type']` without sanitization.

**Risk:** If anything ever passes untrusted `post_type` into `wp_get_archives()`, this becomes an injection vector. Core usage may be safe today; the pattern is still risky.

---

### 18. WooCommerce template drift (`woocommerce/`)

Overrides mix old headers (e.g. `content-single-product.php` @version **3.6.0**) with newer files (e.g. some templates @ **9.x**). Outdated wrappers can miss WooCommerce bugfixes and hooks.

---

### 19. lessphp: PHP 8.2+ string interpolation deprecation (`css/lessc.inc.php`)

At least one error path uses the deprecated `"${name}..."` interpolation style (PHP 8.2+ deprecates `${var}` in strings in favor of `{$var}`).

**Impact:** Deprecation **notices** if that code path runs, depending on `error_reporting`.

---

### 20. Hard-coded environment URLs in templates

`home.php`, `booking.php`, and others reference `https://dev.lovenbride.com/...` for theme images.

**Why it hurts:** Wrong assets or mixed content if the site domain changes; extra DNS and caching complexity.

---

### 21. Polylang-only functions without guards (`archive-designers.php`)

Uses `pll_e()` (and similar). If Polylang is disabled, this will **fatal error**.

---

### 22. `index.php` minimal fallback

If the condition for loading `blog-archive` does not run, the template only outputs `get_header()` and `get_footer()` with no main content — potentially blank index views depending on routing.

---

### 23. jQuery scroll handler (`js/app.js`)

`$(window).scroll(...)` runs on every scroll event without throttling.

**Impact:** Usually minor on modern desktops; can still matter on low-end mobile if the handler grows.

---

### 24. Repository / deployment size

A full `node_modules` tree inside the theme (per version control status) increases clone and deploy size; it does not affect PHP runtime unless something loads it on the server (the theme’s PHP does not need Node at request time for normal pages).

---

## Summary

The strongest levers for **speed and stability** are: stop compiling LESS per request (or gate it to build/deploy only), remove duplicate CDN jQuery/Owl from the single-product content template and rely on one enqueue strategy, fix unbounded `get_posts( -1 )` where archives grow, and resolve duplicate titles and short-tag portability. For **PHP 8.x and WordPress forward compatibility**, prioritize undefined variables, deprecated lessphp patterns, strict server settings (`short_open_tag`), and WooCommerce template updates.
