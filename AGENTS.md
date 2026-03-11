# WP Backstage 4.0 Contributor Guide

## 1. Purpose and Scope
- This guide is for contributors and coding agents working inside this repository.
- It is architecture-first and repo-internal, not a consumer integration manual.
- Source of truth is current 4.0 code in this repo.
- If legacy wiki guidance conflicts with code, follow code and update docs accordingly.
- Keep this guide timeless. Do not add release-specific checklists.

## 2. Bootstrap/Lifecycle Map
1. WordPress loads [`wp-backstage.php`](./wp-backstage.php).
2. `wp-backstage.php` explicitly requires all core/component/field classes.
3. On `plugins_loaded` (priority `10`), `WP_Backstage::init()` is called.
4. `WP_Backstage::init()` wires:
   - `after_setup_theme` (priority `10`) -> `register_field_classes()`.
   - `after_setup_theme` (priority `20`) -> `register_init_hook()` -> `do_action( 'wp_backstage_init' )`.
5. Safe initialization point for project/consumer configuration is `wp_backstage_init`.
6. Test harness behavior:
   - `wp_backstage_require_tests()` runs on `after_setup_theme` priority `0`.
   - It conditionally requires [`examples/tests.php`](./examples/tests.php) when `apply_filters( 'wp_backstage_tests_enabled', true )` is truthy.

## 3. Architecture Map
- Bootstrap entrypoint:
  - [`wp-backstage.php`](./wp-backstage.php) (constants, class requires, plugin hooks, activation/deactivation/uninstall callbacks).
- Main orchestrator:
  - [`includes/class-wp-backstage.php`](./includes/class-wp-backstage.php) (field registry, global admin scripts/styles, KSES contexts, lifecycle hooks).
- Shared component base:
  - [`includes/class-wp-backstage-component.php`](./includes/class-wp-backstage-component.php) (field utilities, common rendering/sanitization helpers, table/filter helpers, nonce helpers).
- Components:
  - Post type, taxonomy, options, user, nav menu item, widget + widget base in `includes/`.
- Field system:
  - Base field class + concrete types in `includes/fields/`.
  - Field classes own schema, sanitization, render behavior, and optional JS integration.
- Front-end/admin JS model:
  - Global object `window.wpBackstage` created by main class.
  - Per-field JS modules register under `window.wpBackstage.fields.<key>`.

## 4. Component Contracts
- Canonical public factory methods:
  - `WP_Backstage_Post_Type::add()` / `WP_Backstage_Post_Type::modify()`
  - `WP_Backstage_Taxonomy::add()` / `WP_Backstage_Taxonomy::modify()`
  - `WP_Backstage_Options::add()`
  - `WP_Backstage_User::modify()`
  - `WP_Backstage_Nav_Menu_Item::modify()`
  - `WP_Backstage_Widget::add()`
- Contract expectations:
  - Components parse incoming args against defaults, validate required args, and call `init()`.
  - Component `init()` methods must call `parent::init()`.
  - Save handlers sanitize via field classes (`$field_class->sanitize(...)`), then persist to relevant meta/options storage.
  - REST registration is schema-driven per field (`$field_class->get_schema()` + per-field `show_in_rest`).
  - Table-aware components honor `has_column`, `is_sortable`, `is_filterable` where supported.

## 5. Field Contracts
- Base field contract lives in [`includes/fields/class-wp-backstage-field.php`](./includes/fields/class-wp-backstage-field.php).
- Required/primary extension methods:
  - `get_schema()`
  - `sanitize()`
  - `render()`
  - `render_column()`
- Optional extension methods:
  - `validate()` (currently used by taxonomy create validation path).
  - `add_rest_api_link()` (for embeddable REST link augmentation).
  - `inline_style()` / `inline_script()`.
- Field tag semantics used by components:
  - `text_control`
  - `textarea_control`
  - `select_control`
  - `remove_label_for`
  - `hide_label`
  - `is_filterable`
- JS integration convention:
  - Register field behavior on `window.wpBackstage.fields.<key>`.
  - Typical optional methods: `initAll`, `init`, `refreshAll`, `refresh`, `resetAll`, `reset`, `setValue`.
- Normalized field configuration surface (component-level defaults):
  - `type`, `name`, `label`, `title`, `value`, `description`, `help`, `show_label`, `show_in_rest`, `options`, `input_attrs`, `args`.
  - Table-oriented flags (`has_column`, `is_sortable`, `is_filterable`) are enabled by relevant components.

## 6. Hooking Conventions
- Global orchestration hooks:
  - `wp_backstage_init`
  - `wp_backstage_register_field_classes`
- Dynamic per-component hook patterns:
  - `wp_backstage_{slug}_field_args`
  - `wp_backstage_{slug}_field_before`
  - `wp_backstage_{slug}_field_after`
  - `wp_backstage_{slug}_{column}_column_content`
- Widget dynamic hooks:
  - `wp_backstage_widget_output_{slug}`
  - `wp_backstage_widget_form_{slug}`
  - `wp_backstage_widget_save_{slug}`
- Taxonomy list-table query helpers:
  - `wp_backstage_{slug}_terms_list_table_query`
  - `wp_backstage_{slug}_terms_list_table_count_query`
- Field extensibility hook:
  - Register custom field classes using `wp_backstage_register_field_classes` and `WP_Backstage::register_field_class()`.

## 7. Editing and Coding Rules
- Do not introduce new usage of deprecated pathways in:
  - `WP_Backstage` legacy inline/script helpers.
  - `WP_Backstage_Component` deprecated render/sanitize helper methods.
- Prefer field-class-first changes for field behavior.
- Preserve explicit bootstrap requires in [`wp-backstage.php`](./wp-backstage.php).
- If adding a new field class:
  - Add class file under `includes/fields/`.
  - Require it in `wp-backstage.php`.
  - Register it in `WP_Backstage::register_field_classes()`.
  - Add JS module under `window.wpBackstage.fields` only if needed.
- Keep save handlers guarded by capability and nonce checks.
- Maintain escaping/sanitization patterns aligned with existing code.
- Respect project standards:
  - PHP compatibility target: `7.4+`.
  - PHPCS/WPCS rules in [`phpcs.xml`](./phpcs.xml), including global prefixing with `wp_backstage`.

## 8. Verification Workflow
- Verify claims with targeted search:
  - `rg -n "do_action\\( 'wp_backstage_init'|wp_backstage_register_field_classes|register_field_class|get_field_class|get_field_classes" wp-backstage.php includes/class-wp-backstage.php`
  - `rg -n "WP_Backstage_Post_Type::add|WP_Backstage_Post_Type::modify|WP_Backstage_Taxonomy::add|WP_Backstage_Taxonomy::modify|WP_Backstage_Options::add|WP_Backstage_User::modify|WP_Backstage_Nav_Menu_Item::modify|WP_Backstage_Widget::add" examples/tests.php`
  - `rg -n "has_tag\\( 'text_control'|has_tag\\( 'textarea_control'|has_tag\\( 'select_control'|has_tag\\( 'remove_label_for'|has_tag\\( 'hide_label'|has_tag\\( 'is_filterable'" includes`
  - `rg -n "window\\.wpBackstage\\.fields\\." includes/fields`
- Cross-check field argument guidance against live field implementations and [`examples/tests.php`](./examples/tests.php).
- Syntax sanity:
  - Run `php -l` against plugin root PHP files plus `includes/` and `examples/`.
- Acceptance criteria:
  - No deprecated-path recommendations.
  - No 3.7-only API claims presented as 4.0 truth.
  - All documented hooks/methods/commands resolve in this repo.

## 9. Legacy-Doc Corrections
- Consumer initialization guidance:
  - Prefer `wp_backstage_init` for configuration timing (not generic `after_setup_theme`), so field classes are already registered.
- Code field args:
  - 4.0 built-in code field uses `args.language` (for example: `php`, `html`, `css`, `javascript`, `json`), not `args.mime`.
- Options REST exposure:
  - No top-level options-page `show_in_rest` argument in `WP_Backstage_Options` defaults.
  - REST visibility is controlled per field via `show_in_rest`.
- Date field format behavior:
  - 4.0 sanitize path normalizes date values to `Y-m-d`; docs should not claim configurable save format.
- Field type reality:
  - `password` is not a registered built-in field type in default 4.0 field registry.
- Legacy typos/headings to correct when encountered:
  - `select-ysers` -> `select-users`.
  - Taxonomy section heading text that incorrectly says post types.

## 10. Quick Commands
- Install/update dev dependencies:
  - `composer install`
  - `composer update`
- Lint/fix:
  - `composer run lint`
  - `composer run fix`
- Build artifacts:
  - `composer run build`
  - `composer run build-pot`
  - `composer run build-docs`
- Clean artifacts:
  - `composer run clean`
- Hook maintenance:
  - `composer run update-hooks`
- Syntax sanity example:
  - `php -l wp-backstage.php`
