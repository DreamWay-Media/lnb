# Code review — second pass (post-fix)

Full pass over the `dwm-lnb` theme after recent performance and compatibility fixes. Findings are ordered **highest severity first**. This document does not repeat resolved items from the first audit unless there is residual risk.

**Follow-up:** Subsequent theme changes addressed the items below (product markup, ACF wrappers, pagination, child-theme CSS URIs, LESS lock, GA via constant/filter, home ACF page ID helper, single-query archive months, nav/i18n, related-products filter removal, translated strings, `content.php` flower URLs). See git history for details.

---

## Critical / high (historical — addressed in code)

### 1. Invalid product summary markup (`productimizer_custom_author_field` in `functions.php`)

The callback mixes opening and closing `div.info` with conditional branches. If only `space_required` is set (no `size`), output can include a closing `</div>` without a matching open wrapper. If neither field is set, a stray `</div>` can still appear. When both fields are set, nesting of `.info`, `.product_size`, and `.space_required` is easy to get wrong.

**Impact:** Broken DOM, unpredictable CSS on single product pages.

**Recommendation:** Open one wrapper only when at least one field has content; close once at the end, or output two independent blocks.

---

### 2. ACF dependency without guard (`home.php`, WooCommerce field callback)

`home.php` calls `get_field( …, 68 )` in many places. `productimizer_custom_author_field()` uses `get_field` / `the_field` with no `function_exists( 'get_field' )` check.

**Impact:** If Advanced Custom Fields is deactivated, PHP fatals on undefined function.

**Recommendation:** Guard with `function_exists( 'get_field' )` and fallbacks, or document ACF as required.

---

### 3. Pagination variable logic bug (`template-parts/blog-archive.php`)

Code uses `max( 1, (int) get_query_var( 'paged' ) )` and then `if ( $paged_num < 1 )` to read `page`. The first `max` makes `$paged_num` never less than 1, so the fallback to `page` is dead code. Setups that rely on the `page` query var for pagination may get wrong page numbers for the taxonomy query.

**Recommendation:** Read `paged` first, then `page`, then default to 1, without forcing `max( 1, … )` before the `page` fallback.

---

## Medium

### 4. Child theme asset path inconsistency (`functions.php`)

Bootstrap and Owl CSS use `get_template_directory_uri()` (parent). `app.css` and JS use `get_stylesheet_directory_uri()` (child when active).

**Impact:** Child themes cannot override vendor CSS via the child folder without filters.

**Recommendation:** Use stylesheet directory for all bundled assets, or document parent-only vendor files.

---

### 5. LESS compile concurrency

LESS still runs on `init` when `app.less` is newer than `app.css`. Rare, but concurrent requests after deploy can race on writing `app.css`.

**Recommendation:** File lock, or compile only in admin / CLI / deploy.

---

### 6. Hardcoded GA4 ID (`dwm_lnb_output_theme_gtag`)

Default measurement ID is set in code (filterable). Staging clones may report to production GA.

**Recommendation:** Default to empty until configured via option or constant.

---

### 7. Hardcoded home ACF page ID (`home.php`)

Page ID `68` is hardcoded for many `get_field` calls. Breaks after migration or wrong environment.

**Recommendation:** Tie to `page_on_front` or a filter (see `dwm_lnb_home_acf_page_id` pattern in `home-blog-carousel.php`).

---

### 8. `jk_related_products_args` with related output removed

Filter remains while `woocommerce_output_related_products` is removed. Harmless dead code.

---

### 9. `get_archive_by_year_and_month()` N+1 queries

One extra query per year for months. Fine for small archives only.

---

### 10. Global front-end asset stack

Bootstrap, Owl, and `app.js` still load on every front-end request. Revisit conditional enqueue when templates are mapped.

---

## Lower

### 11. Internationalization

Some menu registrations omit a consistent text domain. `ds_change_readmore_text` returns hardcoded English `Video` (not passed through `__()`).

### 12. Bundled `css/lessc.inc.php`

Legacy lessphp; prefer Node/`lessc` at build time long term.

### 13. Legacy templates (e.g. `content.php`)

May still reference old dev hostnames in static markup.

### 14. Third-party scripts

Botpress, Trustindex, etc. — plan for CSP and outage handling.

### 15. `less_status` storage

Sanitized as string `0`/`1`; `less_compile` uses `(int)` — OK if the settings form keeps submitting those values.

---

## Positive notes (since first review)

- LESS compile gated on file mtimes; errors logged instead of echoed.
- No duplicate CDN jQuery/Owl on single product; carousel init uses `wp_add_inline_script` on `owl`.
- Blog taxonomy path can use a dedicated `WP_Query` when the main query is wrong.
- `index.php` and `dwm_lnb_is_blog_category_or_tag_archive()` improve routing when conditionals fail.
- Single logo resolution in `header.php`; duplicate `title` removed.
- Paginated archives replace unbounded `get_posts` where updated.
- `getarchives_where` uses prepared SQL; `dwm_lnb_pll_e()` helps when Polylang is off.

---

## Suggested follow-up order

1. Fix product summary markup and add ACF guards on critical templates.
2. Fix `blog-archive.php` pagination (`paged` vs `page`).
3. Align vendor CSS paths for child themes (or document).
4. Harden GA and home page ID for multiple environments.
5. Optional: conditional assets, LESS locking, batch archive month queries.
