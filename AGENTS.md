# WP Backstage Contributor Guide

## Purpose

WP Backstage exists to provide a more unified API over the many different admin
and configuration surfaces that have accumulated across WordPress over time.
Rather than treating post types, taxonomies, options pages, users, nav menu
items, widgets, dashboard widgets, and their fields as unrelated systems, this
plugin gives them a shared component and field model.

This guide is intentionally high level. It should help contributors and coding
agents orient quickly, then point them to the code that defines the real
contract. If this file and the implementation ever disagree, follow the code
and update the docs.

## Methodology

- Bootstrap starts in `wp-backstage.php`, which defines constants, explicitly
  requires classes, and boots `WP_Backstage`.
- `WP_Backstage` is the orchestrator. It registers built-in field classes,
  exposes lifecycle hooks, configures shared admin JS/CSS/KSES behavior, and
  connects the plugin to WordPress.
- Components extend `WP_Backstage_Component`. Each concrete component adapts a
  WordPress object or screen into the shared field model: parse args,
  normalize field definitions, render through field classes, sanitize through
  field classes, and persist to the correct storage.
- The main component surfaces in this plugin are post types, taxonomies,
  options pages, users, nav menu items, widgets, and dashboard widgets.
- Fields extend `WP_Backstage_Field`. A field owns its type-specific schema,
  rendering, sanitization, list-table output, optional validation, and
  optional inline assets.
- Portability is a core goal. A field should be implemented once and then work
  across the supported component contexts rather than being reimplemented per
  component.
- Safe project configuration timing is `wp_backstage_init`, after built-in
  field classes have been registered.
- When documentation starts to repeat implementation detail, prefer pointing to
  code or a dedicated skill instead of freezing the contract here.

## Code Map

- `wp-backstage.php`
  - Bootstrap entrypoint, explicit class requires, plugin hooks.
- `includes/class-wp-backstage.php`
  - Main orchestrator, lifecycle, field registry, shared scripts and styles.
- `includes/class-wp-backstage-component.php`
  - Base component behavior and shared field flow.
- `includes/fields/class-wp-backstage-field.php`
  - Base field behavior.
- `includes/`
  - Concrete component classes.
- `includes/fields/`
  - Built-in field classes.
- `examples/tests.php`
  - Live usage examples across supported component types.
- `.codex/skills/field-creator/SKILL.md`
  - Detailed guidance for creating or updating field classes.
- `composer.json`
  - Source of truth for repository scripts.
- `phpcs.xml`
  - Source of truth for PHP coding standards and prefixing rules.

## Components

Use `includes/class-wp-backstage-component.php` as the starting point for
understanding component behavior.

- Concrete components in `includes/` show how the shared model is applied to
  each WordPress surface.
- If changing component behavior, prefer changes that preserve the shared
  component pattern instead of introducing one-off behavior in a single
  surface.
- Read the concrete class you are touching for its public API and lifecycle.
- Use `examples/tests.php` when you need to see how components are configured
  in practice.

## Fields

Use `includes/fields/class-wp-backstage-field.php` as the starting point for
understanding field behavior.

- Built-in field classes live in `includes/fields/`.
- Built-in field registration happens in `WP_Backstage::register_field_classes()`
  in `includes/class-wp-backstage.php`.
- Built-in field files are explicitly required in `wp-backstage.php`.
- Project-specific fields can be added by registering them on
  `wp_backstage_register_field_classes`.
- For detailed field-authoring guidance, use `$field-creator` rather than
  expanding this file with low-level field contracts.
- Prefer field-class-first changes for field behavior.
- Avoid introducing new usage of deprecated field helpers in `WP_Backstage` or
  `WP_Backstage_Component`.
- Field JS is organized around `window.wpBackstage` and per-field modules under
  `window.wpBackstage.fields`; inspect `includes/class-wp-backstage.php` and
  the relevant field class for the live pattern.

## Scripts

Use `composer.json` as the source of truth for build, lint, fix, and clean
commands.

- Common entry points are `composer install`, `composer run lint`,
  `composer run fix`, `composer run build`, and `composer run clean`.
- When changing tooling guidance, update `composer.json` first and keep this
  file as a pointer.
- Use `phpcs.xml` to understand the repository's PHP standards.

## Working Style

- Follow the code over legacy docs or stale notes.
- Verify claims with targeted reads and searches in the classes you are
  changing.
- Use `examples/tests.php` as a usage reference when behavior is unclear.
- Keep this guide durable and readable by pointing to code and skills instead
  of copying detailed contracts into it.
