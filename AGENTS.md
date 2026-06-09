# AGENTS.md

This directory contains `makotokw2026`, a custom WordPress theme running on `blog.makotokw.com`. It is based on `_s` (Underscores) and customized for personal blog use. This is not a general-purpose distributable theme — the code is written specifically for kwLog (blog.makotokw.com).

**This is a classic theme by design. Block theme (FSE) support is intentionally out of scope.** The theme uses the PHP template hierarchy (`header.php`, `index.php`, `singular.php`, `footer.php`, etc.) and there is no `theme.json`. Do not propose or perform a migration to a block theme / Full Site Editing, and do not treat the absence of `theme.json` or FSE features as a defect. Appearance is controlled through `src/styles/` (SCSS) and PHP templates, not through the Site Editor.

## Requirements

- PHP 7.4 or later (see `require` in `composer.json`).
- WordPress 6.0 or later (see `minimum_supported_wp_version` in `phpcs.xml`).
- Node.js version as specified in `.node-version`. Package management via Yarn.
- `config.php` must exist in the theme root. If it does not exist, copy `config.php.sample` and fill in the values. `config.php` is not tracked by git and defines `WP_THEME_*` constants (Google Analytics, OGP, Twitter, GitHub account, etc.).
- Some display logic depends on `WP_THEME_*` constants, kwLog-specific categories/taxonomies, and hardcoded post IDs. Do not generalize these.

## Directory Structure

- `functions.php`: Theme entry point. Requires `inc/*.php` files in order.
- `inc/`: Feature modules split by responsibility: `admin`, `breadcrumbs`, `comments`, `featured-image`, `font-awesome`, `ga`, `jetpack`, `ogp`, `related`, `seo`, `share`, `taxonomy`, `template-tags`, `debug`. Add new logic to the appropriate file and register it with `require` in `functions.php`.
- `template-parts/`: Partials loaded via `get_template_part()` (`content.php`, `content-summary.php`, `content-inline.php`, `content-help.php`, `content-none.php`).
- `templates/`: Custom page templates (`template-archives.php`, `template-categories.php`, `template-help.php`, `template-memos.php`, `template-portfolios.php`, `template-tags.php`, and others under `templates/inc/`).
- `comments.php`, `footer.php`, `header.php`, `index.php`, `searchform.php`, `sidebar.php`, `singular.php`: Root-level templates following the WordPress template hierarchy.
- `src/`: Pre-build frontend assets.
  - `src/scripts/index.js`: JS entry point, includes `components/`, `utils/`, and `shims/`.
  - `src/styles/`: SCSS with an ITCSS-style layer structure from `01-lib` to `07-utilities`. Three entry points: `style.scss`, `style-editor.scss`, `amazonjs.scss`.
  - `src/style.css.ejs`: EJS template that generates `style.css` (WordPress theme header).
- `dist/`: Vite build output (`style.css`, `style.js`, `style-editor.css`, etc.). Generated — do not edit manually.
- `amazonjs.css`: The result of Vite copying `dist/amazonjs.css` to the theme root (referenced by the AmazonJS plugin). Do not edit manually.
- `style.css`: WordPress theme header. Auto-generated from `src/style.css.ejs` at build time.
- `languages/`: `.po` / `.mo` / `.pot` files. Text domain is `makotokw`.
- `assets/`: Static assets.
- `vendor/`, `node_modules/`: Dependencies. Do not edit.
- `.reference/`: External source references (e.g. the base `_s` theme source). Gitignored — not tracked, not used at runtime. Do not place internal notes here.
- `playground/`: Developer-facing HTML pages for visually checking components and typography. Not build targets — open directly in a browser.

## Build and Assets

Builds are handled by Vite (`vite.config.js`). Output is written to `dist/` with fixed filenames (no hashes), and referenced by `wp_enqueue_*` calls in `functions.php`.

```sh
yarn install
yarn dev         # Vite dev server (port 5173, host=0.0.0.0)
yarn build       # Production build (also regenerates style.css)
yarn build:dev   # Non-minified build
```

- When `WP_THEME_DEBUG` is true and the Vite dev server is running, `functions.php` loads ES modules from the dev server instead of `dist/` (for HMR). Reachability from Docker is checked via `host.docker.internal:5173` (`makotokw_is_vite_running`).
- `dist/`, `style.css`, and `amazonjs.css` are build artifacts. To change the appearance, edit files in `src/` and run `yarn build`. Do not edit the generated files directly.
- jQuery is aliased to WordPress's bundled version via `src/scripts/shims/jquery-global.js`. Using `import 'jquery'` in theme JS resolves to the global `jQuery`.

## Lint and Quality Checks

```sh
yarn lint:js                                                   # ESLint (src/ and *.config.js)
yarn lint:css                                                  # Stylelint (src/styles)
composer install                                               # First time only
./vendor/bin/phpcs                                             # WordPress-Core + PHPCompatibility (PHP 7.4-)
./vendor/bin/parallel-lint --exclude vendor --exclude node_modules .
```

- Allowed prefixes for global functions and constants (as defined in `phpcs.xml`): `makotokw_`, `wp_theme_`, `wp_ogp_`, `ogp_`, `og_`. All new globals must start with one of these.
- The text domain is `makotokw`. If you add translatable strings, update the POT file with `yarn lang:1st-pot`.

## Coding Guidelines (Theme-Specific)

- PHP must follow WordPress Coding Standards: tab indentation, Yoda conditions, and consistent use of `esc_*` / `wp_kses_*` for output escaping. Running `phpcs` will catch most issues.
- Never output unescaped variables. All `echo`'d values must pass through `esc_html`, `esc_attr`, `esc_url`, or `wp_kses_post`.
- Follow existing file naming and module boundaries. If a new responsibility arises, create a new file under `inc/` and add it to the `require` list in `functions.php`.
- Template-tag-style functions belong in `inc/template-tags.php`. OGP, SEO, and share logic each have their own dedicated files.
- Configuration values should flow through `WP_THEME_*` constants defined in `config.php`. Do not scatter literals across templates.
- New frontend JS components go in `src/scripts/components/` and must be imported from `src/scripts/index.js`. Styles should be placed in the appropriate ITCSS layer (`01-lib` through `07-utilities`).
- Post listing, categories, and taxonomies depend on kwLog's operational setup (see `inc/taxonomy.php`). When modifying taxonomy registration or hardcoded IDs, confirm the impact on templates, post meta, and existing posts.

## Cautions When Editing

- `dist/`, `style.css`, `amazonjs.css`, `vendor/`, `node_modules/`, and `languages/*.mo` are generated or dependency files. Do not edit them directly.
- `config.php` contains personal account information and analytics IDs. Do not commit or print its contents.
- Several items are intentionally removed from `wp_head` via `makotokw_setup`: `feed_links`, `rsd_link`, `wlwmanifest_link`, `wp_generator`, emoji scripts, etc. Only restore them when explicitly requested.
- When `WP_THEME_OGP` is true, Jetpack's OGP output is suppressed and the theme's own OGP is used (`inc/ogp.php`). Be careful about conflicts with Jetpack when touching OGP-related code.

## Verifying Changes

- Test locally by installing the theme in a local WordPress instance.
- After changing assets, run `yarn build` and confirm that `dist/` and `style.css` are regenerated. When using the Vite dev server, enable `WP_DEBUG` and open the browser with `yarn dev` running.
- Before reporting a task as complete, run at minimum `parallel-lint` and `phpcs` to verify PHP syntax and coding standards. If you cannot run them, state that explicitly.
