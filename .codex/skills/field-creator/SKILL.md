---
name: field-creator
description: Guide for adding or updating a WP Backstage field class. Use when creating a new built-in or custom field type that extends WP_Backstage_Field, or when refining an existing field class to match the repo's contracts for tags, args, REST schema, rendering, styling, list-table output, and the window.wpBackstage.fields JS API.
---

# Field Creator

Create WP Backstage field classes that feel native to the codebase.

## Purpose

Use this skill when a task involves adding, updating, or reviewing a field class that extends `WP_Backstage_Field`.

Prefer field-class-first changes. Do not introduce new usage of deprecated `WP_Backstage` or `WP_Backstage_Component` field helpers.

## Start Here

Read the base class and the closest sibling fields before editing:

- `includes/fields/class-wp-backstage-field.php`
- `includes/fields/class-wp-backstage-select-users-field.php` for filter links and REST links
- `includes/fields/class-wp-backstage-code-field.php` for `init()`, inline assets, and JS lifecycle
- `includes/fields/class-wp-backstage-email-field.php`, `includes/fields/class-wp-backstage-number-field.php`, and `includes/fields/class-wp-backstage-range-field.php` for `validate()`

## Registration Workflow

If adding a built-in field to this plugin:

1. Add `includes/fields/class-wp-backstage-<type>-field.php`.
2. Require it in `wp-backstage.php`.
3. Register it in `WP_Backstage::register_field_classes()` in `includes/class-wp-backstage.php`.

If adding a project-specific field outside the plugin:

1. Create a class extending `WP_Backstage_Field`.
2. On `wp_backstage_register_field_classes`, call `$wp_backstage->register_field_class( '<type>', new My_Field_Class() );`.

## Field Contract

### `$tags`

Tags are small behavioral flags checked by components. Use only the tags that match the control you are building.

- `text_control`: Treat as a single-line text-style control in component layouts.
- `textarea_control`: Treat as a multi-line control in component layouts.
- `select_control`: Treat as a select-style control where supported.
- `remove_label_for`: Components should render a `<fieldset><legend>` pattern instead of a `label[for]`.
- `hide_label`: Components should keep the label for accessibility but visually hide it with `screen-reader-text`.
- `is_filterable`: The field can participate in generic list-table filters when the field config also sets `is_filterable => true`.

Pick tags carefully. They affect component markup around the field, not the field control itself.

### `$default_args`

Use `$default_args` only for field-type-specific values that live under `field['args']`.

- Every supported arg should have a default.
- Do not duplicate common top-level field args like `name`, `label`, `value`, `description`, `input_attrs`, or `show_in_rest`.
- Read field args through `get_args()` so `field['args']` is always normalized.

### `$schema`

`$schema` is the field's REST schema and is returned by `get_schema()`.

- It is used when components register meta for fields with `show_in_rest => true`.
- It must match the stored shape after `sanitize()`.
- Use accurate REST types such as `string`, `integer`, `number`, `boolean`, `array`, or `object`.
- Add `items` or nested schema details when the stored value is structured.

REST exposure is controlled per field by `show_in_rest`, not by a field-class switch.

### `init()`

Use `init()` for field-specific registration work such as enqueueing editor settings, adding extra hooks, or printing extra inline assets.

- If you override `init()`, call `parent::init()` so the field still hooks `inline_style()` and `inline_script()`.
- Keep `init()` for registration and setup, not rendering.

### `sanitize()`

`sanitize()` is the last field-specific transformation before persistence.

- It only runs when the submitted field key is present.
- Treat empty-like values safely and return the storage-native fallback for your type.
- Prefer core WordPress sanitizers when they fit: `sanitize_text_field()`, `sanitize_textarea_field()`, `sanitize_email()`, `esc_url_raw()`, `absint()`, and similar helpers.
- Return a value that matches `$schema`.

### `validate()`

Use `validate()` when a field needs user-facing validation before save.

- Return `null` when valid.
- Return `$this->validation_error( 'Message' )` when invalid.
- Keep the message human-readable and translatable.
- This is currently used by the taxonomy quick-add validation path, so do not rely on it as the only safety net.

### `add_rest_api_link()`

Use `add_rest_api_link()` when the stored value points at another WordPress record such as a post, user, term, or attachment.

- Call `$response->add_link( $this->get_rest_api_link_key( $field ), rest_url( ... ), array( 'embeddable' => true ) );`.
- Only add the link when the referenced record ID is valid.
- Keep the stored value and the REST link separate: `sanitize()` stores the ID, `add_rest_api_link()` exposes the relationship.

### `inline_style()`

Print field-specific CSS from `inline_style()` only when the field needs it.

- Output a real `<style>` tag.
- Use a stable ID in the existing pattern: `wp_backstage_<type>_field_style`.
- Scope selectors from the field root, usually `.wp-backstage-field--type-<type>`.

### `inline_script()`

Print field-specific JS from `inline_script()` only when the field needs it.

- Output a real `<script>` tag.
- Use a stable ID in the existing pattern: `wp_backstage_<type>_field_script`.
- Register the field API on `window.wpBackstage.fields.<namespace>`.
- Prefer `<namespace>` equal to the field `type` if the field implements `setValue()` or `getValue()`, because generic setters/getters look up `window.wpBackstage.fields[field.dataset.fieldType]`.

### `render_column()`

`render_column()` is responsible for safe list-table output.

- Escape text with `esc_html()`.
- Escape URLs with `esc_url()`.
- Escape titles and attributes with `esc_attr()`.
- Strip unexpected markup from labels with `wp_strip_all_tags()` before output.

If the field is filterable, build a filter URL with `$this->get_filter_url( $field, $value )` and render a safe link.

If the value should also link to another record, give each action its own anchor. Do not make one link do two jobs.

Typical pattern:

```php
$record_id  = absint( $value );
$label      = wp_strip_all_tags( get_the_title( $record_id ) );
$record_url = get_edit_post_link( $record_id );
$filter_url = $this->get_filter_url( $field, $record_id );
```

Override `get_filter_args()` too when a filterable field needs custom filter options, as `select_posts` and `select_users` do.

### `render()`

`render()` should render only the field control markup.

- Do not render labels.
- Do not render descriptions.
- Do not render help wrappers that duplicate component markup.
- Use only `<span>` elements for containers and supporting markup so the field is safe inside `<p>` tags, KSES contexts, and all WP Backstage components.
- The interactive control itself may still be the native element it needs: `<input>`, `<select>`, or `<textarea>`.

Use the base helpers consistently:

- `root_class( $field )`: prints the required root classes and any extra modifiers.
- `element_id( $field, $suffix )`: prints a stable ID for the main control or a sub-element.
- `input_attrs( $field, $ignored )`: prints remaining attributes from `input_attrs` while letting `render()` own core attributes like `id`, `name`, `value`, and `type`.

Baseline shape:

```php
<?php

/* ... */

public function render( array $field ): void { ?>
	<span
	class="<?php $this->root_class( $field ); ?>"
	id="<?php $this->element_id( $field, 'container' ); ?>"
	data-field-id="<?php $this->element_id( $field ); ?>"
	data-field-type="<?php echo esc_attr( $field['type'] ); ?>">
		<input
		type="text"
		name="<?php echo esc_attr( $field['name'] ); ?>"
		id="<?php $this->element_id( $field ); ?>"
		value="<?php echo esc_attr( $field['value'] ); ?>"
		<?php $this->input_attrs( $field, array( 'type', 'name', 'id', 'value' ) ); ?> />
	</span>
<?php }
```

## Notes

Field classes render controls only. Labels and descriptions belong to the consuming component.

- Components already decide how labels, descriptions, legends, and accessibility wrappers are rendered.
- A field class should not duplicate that markup.
- If a field needs explanatory text inside the control itself, keep it minimal and use `<span>` wrappers.

## Styling

Follow the same BEM direction as existing fields.

Required root classes are added automatically:

- `wp-backstage-field`
- `wp-backstage-field--type-{$field['type']}`,

Build descendants and modifiers from there, for example:

- `.wp-backstage-field--type-example .wp-backstage-field__control`
- `.wp-backstage-field--type-example .wp-backstage-field__button`
- `.wp-backstage-field--type-example.wp-backstage-field--is-empty`

## JS API

Not every field needs every method. Simple scalar inputs often work with native DOM fallbacks. Add field JS only when the field needs lifecycle hooks or custom value handling.

All field JS must be generic and component-agnostic. Quick edit, widgets, nav menus, taxonomy forms, repeated renders, and AJAX-hydrated UIs all rely on the same generic entry points. A field script should be able to initialize, refresh, reset, and read or write values without knowing which component rendered it.

- Scope all queries to the passed control or container.
- Be safe on repeated calls.
- Use `data-field-id` and `data-field-type` from the root wrapper instead of page-global assumptions.
- Implement `setValue()` and `getValue()` only when the native fallback is not enough.

API shape:

```javascript
(function($) {

	function init(control) {}
	function initAll(container = document) {}
	function refresh(control) {}
	function refreshAll(container = document) {}
	function reset(control) {}
	function resetAll(container = document) {}
	function setValue(control, value = null) {}
	function getValue(control) {}

	window.wpBackstage.fields.example = {
		initAll: initAll,
		init: init,
		refreshAll: refreshAll,
		refresh: refresh,
		resetAll: resetAll,
		reset: reset,
		setValue: setValue,
		getValue: getValue,
	};

})(jQuery);
```

## Verification

When the task includes code changes, verify the field in the smallest useful way:

1. Use the `$code-refiner` skill to verify that the code matches stylistically.
2. Run `composer run lint` on the edited PHP files.
3. If the field was added as a built-in, confirm the new require and registration entries were added.
4. If the field is filterable or REST-exposed, verify those paths against a known sibling.

## Plasticity

Treat this skill as a living contract.

When a field implementation reveals a repeatable pattern that is not captured here, prompt the developer to update the skill so the pattern is codified for the next field instead of being rediscovered ad hoc.
