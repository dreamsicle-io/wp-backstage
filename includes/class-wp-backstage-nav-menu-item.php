<?php
/**
 * WP Backstage Nav Menu Item
 *
 * @since       1.1.0
 * @package     wp_backstage
 * @subpackage  includes
 */

/**
 * WP Backstage Nav Menu Item
 *
 * @since       1.1.0
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Nav_Menu_Item extends WP_Backstage {

	/**
	 * Default Args
	 * 
	 * @var  array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'field_groups' => array(), 
	);

	/**
	 * Default Field Group Args
	 * 
	 * @var  array  $default_field_group_args  The default field group arguments for this instance.
	 */
	protected $default_field_group_args = array(
		'id'          => '', 
		'title'       => '', 
		'description' => '', 
		'fields'      => array(), 
	);

	/**
	 * Required Args
	 * 
	 * @var  array  $required_args  The required arguments for this instance. Arguments in this array will throw an error if empty.
	 */
	protected $required_args = array();

	/**
	 * Add
	 * 
	 * @param   array              $args  An array of arguments for this instance.
	 * @return  WP_Backstage_Nav_Menu_Item  A fully constructed instance of `WP_Backstage_Nav_Menu_Item`. 
	 */
	public static function modify( $args = array() ) {

		$Nav_Menu_Item = new WP_Backstage_Nav_Menu_Item( $args );
		$Nav_Menu_Item->init();
		return $Nav_Menu_Item;

	}

	/**
	 * Construct
	 * 
	 * @since   1.1.0
	 * @param   array  $args  An array of arguments.
	 * @return  void 
	 */
	protected function __construct( $args = array() ) {

		/* $this->default_field_args = array_merge( $this->default_field_args, array(
			'has_column'  => false, 
			'is_sortable' => false, 
		) );
		$this->default_address_args = array_merge( $this->default_address_args, array(
			'max_width'  => '50em', 
		) );
		$this->default_code_args = array_merge( $this->default_code_args, array(
			'max_width'  => '50em', 
		) );
		$this->default_editor_args = array_merge( $this->default_editor_args, array(
			'max_width'  => '50em', 
		) ); */
		$this->slug = 'nav_menu_item';
		$this->set_args( $args );
		$this->screen_id = array( 'nav-menus' );
		$this->nonce_key = '_wp_backstage_nav_menu_item_nonce';
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 * 
	 * @since   1.1.0
	 * @param   array  $args  An array of arguments.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {
		$this->args = wp_parse_args( $args, $this->default_args );
	}

	/**
	 * Set Errors
	 * 
	 * @since   1.1.0
	 * @return  void 
	 */
	protected function set_errors() {

		if ( is_array( $this->required_args ) && ! empty( $this->required_args ) ) {

			foreach ( $this->required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_nav_menu_item_arg', sprintf( 
						/* translators: 1:required arg key. */
						__( '[nav_menu_item] The %1$s key is required.', 'wp-backstage' ), 
						'<code>' . $required_arg . '</code>'
					) );

				}

			}

		}

	}

	/**
	 * Init
	 * 
	 * @since   1.1.0
	 * @return  void 
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_edit_nonce' ), 10, 5 );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_field_groups' ), 10, 5 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'save' ), 10, 3 );
		add_filter( 'manage_nav-menus_columns', array( $this, 'add_field_columns' ), 20 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_nav_menu_item_script' ), 10 );

		parent::init();

	}

	public function add_screen_options() {
		// echo 'HELLO!!!!';
	}

	/**
	 * Get Field Groups
	 * 
	 * @since   1.1.0
	 * @return  array  An array of field group argument arrays.  
	 */
	protected function get_field_groups() {

		$field_groups = array();

		if ( is_array( $this->args['field_groups'] ) && ! empty( $this->args['field_groups'] ) ) {
			
			foreach ( $this->args['field_groups'] as $field_group ) {
			
				$field_groups[] = wp_parse_args( $field_group, $this->default_field_group_args );
			
			}
		
		}

		return $field_groups;

	}

	/**
	 * Get Fields
	 * 
	 * @since   1.1.0
	 * @return  array  An array of field argument arrays.
	 */
	protected function get_fields() {

		$field_groups = $this->get_field_groups();
		$fields = array();

		if ( is_array( $field_groups ) && ! empty( $field_groups ) ) {
			
			foreach ( $field_groups as $field_group ) {
			
				if ( is_array( $field_group['fields'] ) && ! empty( $field_group['fields'] ) ) {

					foreach ( $field_group['fields'] as $field ) {

						$fields[] = wp_parse_args( $field, $this->default_field_args );

					}

				}
			
			}
		
		}

		return $fields;

	}

	/**
	 * Render Field Groups
	 * 
	 * @since   1.1.0
	 * @param   int      $item_id  The nav menu item ID.
	 * @param   WP_Post  $item     The nav menu item post object.
	 * @param   int      $depth    The depth of menu item.
	 * @param   object   $args     An object of menu item arguments.
	 * @param   int      $id       The ID of the nav menu that this item is related to.
	 * @return  void 
	 */
	public function render_field_groups( $item_id = 0, $item = null, $depth = 0, $args = null, $id = 0 ) {

		$field_groups = $this->get_field_groups();

		if ( is_array( $field_groups ) && ! empty( $field_groups ) ) { 

			foreach ( $field_groups as $field_group ) { ?>

				<h2><?php 

					echo wp_kses( $field_group['title'], $this->kses_p ); 

				?></h2>

				<?php if ( ! empty( $field_group['description'] ) ) { ?>

					<p class="description"><?php 

						echo wp_kses( $field_group['description'], $this->kses_p );

					?></p>

				<?php } ?>

				<?php $this->render_fields( $field_group, $item ); ?>

			<?php }

		}

	}

	/**
	 * Render Fields
	 * 
	 * @since   1.1.0
	 * @param   array    $field_group  An array of field group arguments.
	 * @param   WP_User  $user         An instance of `WP_User`.
	 * @return  void 
	 */
	protected function render_fields( $field_group = array(), $item = null ) {

		if ( is_array( $field_group['fields'] ) && ! empty( $field_group['fields'] ) ) {
			
			foreach ( $field_group['fields'] as $field ) {
				
				$field_name = $field['name'];
				$field['value'] = get_post_meta( $item->ID, $field_name, true );
				$field['name'] = sprintf( '%1$s[%2$d]', $field_name, $item->ID );
				$input_class = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';

				if ( ! in_array( $field['type'], $this->non_regular_text_fields ) ) {
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$default_rows = 3;
					$default_cols = 20;
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : $default_cols;
					$field['input_attrs']['class'] = sprintf( 'widefat %1$s', $input_class );
				}

				if ( $field['type'] === 'code' ) {
					$field['settings_key'] = $field_name;
				}

				$field = apply_filters( $this->format_field_action( 'args' ), $field, $item ); ?>

				<div 
				class="<?php echo esc_attr( sprintf( 'field-%1$s', $field_name ) ); ?> description-wide"
				data-field-name="<?php echo esc_attr( $field_name ); ?>"><?php 

					do_action( $this->format_field_action( 'before' ), $field, $item );

					$this->render_field_by_type( $field ); 

					do_action( $this->format_field_action( 'after' ), $field, $item );

				?></div>

			<?php }

		}

	}

	/**
	 * Save
	 * 
	 * @since   1.1.0
	 * @param   int    $menu_id  The ID of the menu that the item is in.
	 * @param   int    $item_id  The ID of the menu item.
	 * @param   array  $menu_item_data  The menu item data.
	 * @return  void 
	 */
	public function save( $menu_id = 0, $item_id = 0, $menu_item_data = array() ) {

		if ( ! current_user_can( 'edit_post', $item_id ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( empty( $_POST[$this->nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$this->nonce_key], 'add' ) && ! wp_verify_nonce( $_POST[$this->nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $_POST[$field['name']][$item_id] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']][$item_id] );

					update_post_meta( $item_id, $field['name'], $value );

					$values[$field['name']] = $value;

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set', 'radio' ) ) ) {

					$value = ( $field['type'] === 'radio' ) ? '' : false;

					update_post_meta( $item_id, $field['name'], $value );

					$values[$field['name']] = $value;

				} 

			}

			if ( ! empty( $this->args['group_meta_key'] ) ) {

				update_post_meta( $item_id, $this->args['group_meta_key'], $values );

			}

		}

	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Adds all generated fields to the hidden columns array by default, so as 
	 * to not choke up the UI. Note that this will only work if this post type's 
	 * columns UI has never been modified by the user. Hooked to 
	 * `default_hidden_columns`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/default_hidden_columns/ Hook: default_hidden_columns
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * 
	 * @since   1.1.0
	 * @param   array      $hidden  An array of hidden columns.
	 * @param   WP_Screen  $screen  An instance of `WP_Screen`.
	 * @return  void 
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $this->is_screen( 'id', $this->screen_id ) ) {

			$fields = $this->get_fields();

			if ( is_array( $fields ) && ! empty( $fields ) ) {

				foreach ( $fields as $field ) {

					$hidden[] = $field['name'];

				}

			}

		}

		return $hidden;

	}

	/**
	 * Inline Nav Menu Item Script
	 * 
	 * @since   1.1.0
	 * @return  void  
	 */
	public function inline_nav_menu_item_script() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		} ?>

		<script 
		id="wp_backstage_nav_menu_item_script"
		type="text/javascript">

			(function($) {

				var navMenuItemHandleTimer = null;

				function getInitialItems() {
					const itemList = document.getElementById('menu-to-edit');
					const items = itemList.querySelectorAll('.menu-item');
					return Array.from(items);
				}

				function getNewItems() {
					const itemList = document.getElementById('menu-to-edit');
					const items = itemList.querySelectorAll('.menu-item');
					return Array.from(items).filter(item => ! item.hasAttribute('data-wp-backstage-initialized'));
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-menu-item') {
							const newItems = getNewItems();
							for (var i = 0; i < newItems.length; i++) {
								const newItem = newItems[i];
								window.wpBackstage.colorPicker.initAll(newItem);
								window.wpBackstage.datePicker.initAll(newItem);
								window.wpBackstage.address.initAll(newItem);
								window.wpBackstage.mediaUploader.initAll(newItem);
								window.wpBackstage.editor.initAll(newItem);
								window.wpBackstage.codeEditor.initAll(newItem);
								initAllNavMenuItemHandles(newItem);
								newItem.setAttribute('data-wp-backstage-initialized', true);
							}
						}
					}
				}

				function init() {
					const initialItems = getInitialItems();
					for (var i = 0; i < initialItems.length; i++) {
						initialItems[i].setAttribute('data-wp-backstage-initialized', true);
					}
					$(document).ajaxSuccess(handleSuccess);
				}

				function handleNavMenuItemHandleClick(e = null) {
					var { parentNode } = e.target;
					if (navMenuItemHandleTimer) {
						clearTimeout(navMenuItemHandleTimer);
					}
					while (! parentNode.classList.contains('menu-item')) {
						parentNode = parentNode.parentNode;
					}
					navMenuItemHandleTimer = setTimeout(function() {
						if (parentNode.classList.contains('menu-item-edit-active')) {
							window.wpBackstage.editor.refreshAll(parentNode);
							window.wpBackstage.codeEditor.refreshAll(parentNode);
						}
					}, 750);
				}

				function handleScreenOptionChange(e = null) {
					const fieldContainers = document.querySelectorAll('[data-field-name="' + e.target.value + '"]');
					for (var i = 0; i < fieldContainers.length; i++) {
						const fieldContainer = fieldContainers[i];
						if (fieldContainer && ! fieldContainer.classList.contains('hidden-field')) {
							window.wpBackstage.editor.refreshAll(fieldContainer);
							window.wpBackstage.codeEditor.refreshAll(fieldContainer);
						}
					}
				}

				function initNavMenuItemHandle(handle = null) {
					handle.addEventListener('click', handleNavMenuItemHandleClick);
				}
				
				function initAllNavMenuItemHandles(container = null) {
					container = container || document.getElementById('menu-to-edit');
					const navMenuItemHandles = container.querySelectorAll('.menu-item-handle .item-edit');
					if (navMenuItemHandles && (navMenuItemHandles.length > 0)) {
						for (var i = 0; i < navMenuItemHandles.length; i++) {
							initNavMenuItemHandle(navMenuItemHandles[i]);
						}
					}
				}

				function initScreenOption(checkbox = null) {
					checkbox.addEventListener('change', handleScreenOptionChange);
				}

				function handleNavMenuSortStop(e = null, ui = null) {
					const item = ui.item[0];
					if (item.classList.contains('menu-item')) {
						window.wpBackstage.editor.refreshAll(item);
						window.wpBackstage.codeEditor.refreshAll(item);
					}
				}

				function initNavMenuSortable() {
					const sortable = document.getElementById('menu-to-edit');
					$(sortable).on('sortstop', handleNavMenuSortStop);
				}

				function initAllScreenOptions() {
					const checkboxes = document.querySelectorAll('.metabox-prefs input[type="checkbox"]');
					if (checkboxes && (checkboxes.length > 0)) {
						for (var i = 0; i < checkboxes.length; i++) {
							initScreenOption(checkboxes[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
					initAllNavMenuItemHandles();
					initNavMenuSortable();
					initAllScreenOptions();
				});

			})(jQuery);

		</script>

	<?php }

}
