<?php
/**
 * WP Backstage Taxonomy
 *
 * @package     wp_backstage
 * @subpackage  includes
 */

/**
 * WP Backstage Taxonomy
 *
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Taxonomy extends WP_Backstage {

	/**
	 * Default Args
	 * 
	 * @var  array  $default_args  The default arguments for this instance.
	 */
	protected $default_args = array(
		'singular_name'   => '', 
		'plural_name'     => '', 
		'description'     => '', 
		'public'          => true, 
		'hierarchical'    => true, 
		'with_front'      => false, 
		'archive_base'    => '', 
		'rest_base'       => '', 
		'fields'          => array(), 
	);

	/**
	 * Required Args
	 * 
	 * @var  array  $required_args  The required argument keys for this instance.
	 */
	protected $required_args = array(
		'singular_name', 
		'plural_name', 
	);

	/**
	 * Required Args - Modify
	 * 
	 * @since 1.1.0
	 * @var   array  $required_args  The required argument keys for this instance if modifying.
	 */
	protected $required_args_modify = array();

	/**
	 * Add
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 * 
	 * @since   0.0.1
	 * @param   string                 $slug  The slug for the taxonomy.
	 * @param   array                  $args  The arguments for this instance.
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_User`. 
	 */
	public static function add( $slug = '', $args = array() ) {

		$Taxonomy = new WP_Backstage_Taxonomy( $slug, $args );
		$Taxonomy->init();
		return $Taxonomy;

	}

	/**
	 * Modify
	 *
	 * @link    https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 * 
	 * @since   1.1.0
	 * @param   string                 $slug  The slug for the taxonomy.
	 * @param   array                  $args  The arguments for this instance.
	 * @return  WP_Backstage_Taxonomy  A fully constructed instance of `WP_Backstage_User`. 
	 */
	public static function modify( $slug = '', $args = array() ) {

		$Taxonomy = new WP_Backstage_Taxonomy( $slug, $args, false );
		$Taxonomy->init();
		return $Taxonomy;

	}

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @since   1.1.0   Adds $new parameter for distinguishing between `add` and `modify` behavior.
	 * @param   string  $slug  The developer-provided slug for the taxonomy.
	 * @param   array   $args  The developer-provided arguments for this instance.
	 * @param   bool    $new   Whether this instance constructs a new taxonomy or modifies an existing one.
	 * @return  void 
	 */
	protected function __construct( $slug = '', $args = array(), $new = true ) {

		$this->default_field_args = array_merge( $this->default_field_args, array(
			'has_column'  => false, 
			'is_sortable' => false, 
		) );
		$this->new = boolval( $new );
		$this->slug = sanitize_title_with_dashes( $slug );
		$this->set_args( $args );
		$this->screen_id = sprintf( 'edit-%1$s', $this->slug );
		$this->nonce_key = sprintf( '_wp_backstage_taxonomy_%1$s_nonce', $this->slug );
		$this->set_errors();

		parent::__construct();

	}

	/**
	 * Set Args
	 * 
	 * @since   0.0.1
	 * @param   array  $args  The developer-provided arguments for this instance.
	 * @return  void
	 */
	protected function set_args( $args = array() ) {

		$this->args = wp_parse_args( $args, $this->default_args );

		if ( empty( $this->args['singular_base'] ) ) {

			$this->args['singular_base'] = $this->slug;

		}

		if ( empty( $this->args['archive_base'] ) ) {

			$this->args['archive_base'] = $this->slug;

		}

		if ( empty( $this->args['menu_name'] ) ) {

			if ( ! empty( $this->args['plural_name'] ) ) {

				$this->args['menu_name'] = $this->args['plural_name'];

			} elseif ( ! empty( $this->args['singular_name'] ) ) {

				$this->args['menu_name'] = $this->args['singular_name'];

			} else {

				$this->args['menu_name'] = $this->slug;

			}

		}

	}

	/**
	 * Set Errors
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	protected function set_errors() {

		if ( empty( $this->slug ) ) {
			
			$this->errors[] = new WP_Error( 'required_taxonomy_slug', sprintf( 
				/* translators: 1: taxonomy slug. */
				__( '[taxonomy: %1$s] A slug is required when adding a new taxonomy.', 'wp-backstage' ), 
				$this->slug
			) );
		
		} elseif ( strlen( $this->slug ) > 32 ) {
			
			$this->errors[] = new WP_Error( 'taxonomy_slug_length', sprintf( 
				/* translators: 1: taxonomy slug. */
				__( '[taxonomy: %1$s] A taxonomy slug must be between 1 and 32 characters.', 'wp-backstage' ), 
				$this->slug
			) );
		
		} elseif ( $this->new && in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error( 'taxonomy_exists', sprintf( 
				/* translators: 1: taxonomy slug, 2: method suggestion */
				__( '[taxonomy: %1$s] A taxonomy with this slug already exists. Use the %2$s method to modify an existing taxonomy.', 'wp-backstage' ), 
				$this->slug,
				'<code>WP_Backstage_Taxonomy::modify()</code>'
			) );

		} elseif ( ! $this->new && ! in_array( $this->slug, get_taxonomies() ) ) {

			$this->errors[] = new WP_Error( 'taxonomy_not_exists', sprintf( 
				/* translators: 1: taxonomy slug, 2: method suggestion */
				__( '[taxonomy: %1$s] A taxonomy with this slug does not exist. Use the %2$s method to create a new taxonomy.', 'wp-backstage' ), 
				$this->slug,
				'<code>WP_Backstage_Taxonomy::add()</code>'
			) );

		}

		$required_args = ! $this->new ? $this->required_args_modify : $this->required_args;

		if ( is_array( $required_args ) && ! empty( $required_args ) ) {

			foreach ( $required_args as $required_arg ) {

				if ( empty( $this->args[$required_arg] ) ) {

					$this->errors[] = new WP_Error( 'required_taxonomy_arg', sprintf( 
						/* translators: 1: taxonomy slug, 2:required arg key. */
						__( '[taxonomy: %1$s] The %2$s key is required.', 'wp-backstage' ), 
						$this->slug, 
						'<code>' . $required_arg . '</code>'
					) );

				}

			}

		}

	}

	/**
	 * Init
	 * 
	 * @since   0.0.1
	 * @since   1.1.0  Ensures a new taxonomy is only registered if adding a new one.
	 * @return  void 
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		if ( $this->new ) {
			add_action( 'init', array( $this, 'register' ), 0 );
		}
		add_action( sprintf( '%1$s_add_form_fields', $this->slug ), array( $this, 'render_add_nonce' ), 10 );
		add_action( sprintf( '%1$s_term_edit_form_top', $this->slug ), array( $this, 'render_edit_nonce' ), 10 );
		add_action( sprintf( '%1$s_add_form_fields', $this->slug ), array( $this, 'render_add_fields' ), 10 );
		add_action( sprintf( '%1$s_edit_form_fields', $this->slug ), array( $this, 'render_edit_fields' ), 10, 2 );
		add_action( sprintf( 'edited_%1$s', $this->slug ), array( $this, 'save' ), 10, 2 );
		add_action( sprintf( 'created_%1$s', $this->slug ), array( $this, 'save' ), 10, 2 );
		add_filter( sprintf( 'manage_edit-%1$s_columns', $this->slug ), array( $this, 'add_field_columns' ), 10 );
		add_filter( sprintf( 'manage_edit-%1$s_sortable_columns', $this->slug ), array( $this, 'manage_sortable_columns' ), 10 );
		add_filter( sprintf( 'manage_%1$s_custom_column', $this->slug ), array( $this, 'manage_admin_column_content' ), 10, 3 );
		add_filter( 'terms_clauses', array( $this, 'manage_sorting' ), 10, 3 );
		add_action( 'admin_print_footer_scripts', array( $this, 'inline_taxonomy_script' ), 10 );
		add_filter( 'default_hidden_columns', array( $this, 'manage_default_hidden_columns' ), 10, 2 );

		parent::init();

	}

	/**
	 * Get Label
	 *
	 * A utility method to get a localized label for the various taxonomy labels
	 * needed when registering a taxonomy.
	 * 
	 * @param  string  $template  A localized `sprintf()` template where `%1$s` is the taxonomy 
	 *                            singular name and `%2$s` is the taxonomy plural name.
	 * @param  array   $field     An array of field arguments.
	 * @return strint  The formatted text.
	 */
	protected function get_label( $template = '' ) {

		return sprintf(
			/* translators: 1: taxonomy singular name, 2: taxonomy plural name. */
			$template,
			$this->args['singular_name'], 
			$this->args['plural_name']
		);

	}

	/**
	 * Register
	 *
	 * This method does the actual registration of the taxonomy. It will set 
	 * everything needed to extend WordPress to allow for our new taxonomy such 
	 * as adding all the labels, setting the rewrite rules and REST API base, 
	 * and configures the WP admin UI.
	 *
	 * @link   https://developer.wordpress.org/reference/functions/register_taxonomy/ register_taxonomy()
	 * @link   https://developer.wordpress.org/reference/classes/wp_taxonomy/ WP_Taxonomy
	 * 
	 * @since  0.0.1
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'                       => $this->args['plural_name'],
			'singular_name'              => $this->args['singular_name'],
			'menu_name'                  => $this->args['plural_name'],
			'all_items'                  => $this->get_label( __( 'All %2$s', 'wp-backstage' ) ),
			'parent_item'                => $this->get_label( __( 'Parent %1$s', 'wp-backstage' ) ),
			'parent_item_colon'          => $this->get_label( __( 'Parent %1$s:', 'wp-backstage' ) ),
			'new_item_name'              => $this->get_label( __( 'New %1$s Name', 'wp-backstage' ) ),
			'add_new_item'               => $this->get_label( __( 'Add New %1$s', 'wp-backstage' ) ),
			'edit_item'                  => $this->get_label( __( 'Edit %1$s', 'wp-backstage' ) ),
			'update_item'                => $this->get_label( __( 'Update %1$s', 'wp-backstage' ) ),
			'view_item'                  => $this->get_label( __( 'View %1$s', 'wp-backstage' ) ),
			'separate_items_with_commas' => $this->get_label( __( 'Separate %2$s with commas', 'wp-backstage' ) ),
			'add_or_remove_items'        => $this->get_label( __( 'Add or remove %2$s', 'wp-backstage' ) ),
			'choose_from_most_used'      => $this->get_label( __( 'Choose from the most used %2$s', 'wp-backstage' ) ),
			'popular_items'              => $this->get_label( __( 'Popular %2$s', 'wp-backstage' ) ),
			'search_items'               => $this->get_label( __( 'Search %2$s', 'wp-backstage' ) ),
			'not_found'                  => $this->get_label( __( 'No %2$s Found', 'wp-backstage' ) ),
			'no_terms'                   => $this->get_label( __( 'No %2$s', 'wp-backstage' ) ),
			'items_list'                 => $this->get_label( __( '%2$s list', 'wp-backstage' ) ),
			'items_list_navigation'      => $this->get_label( __( '%2$s list navigation', 'wp-backstage' ) ),
			'back_to_items'              => $this->get_label( __( 'Back to %2$s', 'wp-backstage' ) ),
		);

		$rewrite = array(
			'slug'                       => $this->args['archive_base'],
			'with_front'                 => $this->args['with_front'],
			'hierarchical'               => $this->args['hierarchical'],
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => $this->args['hierarchical'],
			'public'                     => $this->args['public'],
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => $this->args['public'],
			'show_tagcloud'              => $this->args['public'],
			'rewrite'                    => $this->args['public'] ? $rewrite : false,
			'show_in_rest'               => ( $this->args['public'] && ! empty( $this->args['rest_base'] ) ),
			'rest_base'                  => $this->args['rest_base'],
		);

		register_taxonomy( $this->slug, $this->args['post_types'], $args );

	}

	/**
	 * Get Fields
	 * 
	 * @since   0.0.1
	 * @return  array  An array of field arguments if there are any, or an empty array.
	 */
	protected function get_fields() {

		$fields = array();

		if ( is_array( $this->args['fields'] ) && ! empty( $this->args['fields'] ) ) {
			
			foreach ( $this->args['fields'] as $field ) {
			
				$fields[] = wp_parse_args( $field, $this->default_field_args );
			
			}
		
		}

		return $fields;

	}

	/**
	 * Render Add Fields
	 *
	 * This will render all fields on the taxonomy management screen. Note that 
	 * this passes the taxonomy string, though this is not necessary, as this 
	 * method is only hooked to `{taxonomy}_add_form_fields`. This means that 
	 * this will only run on this instance's taxonomy.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/ {taxonomy}_add_form_fields
	 * 
	 * @since   0.0.1
	 * @param   string  $taxonomy  The taxonomy slug as registered.
	 * @return  void 
	 */
	public function render_add_fields( $taxonomy = '' ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			foreach ( $fields as $field ) { 

				$field = apply_filters( $this->format_field_action( 'add_args' ), $field ); ?>

				<div class="form-field"><?php 

					do_action( $this->format_field_action( 'add_before' ), $field );

					$this->render_field_by_type( $field );

					do_action( $this->format_field_action( 'add_after' ), $field );

				?></div>

			<?php }

		}

	}

	/**
	 * Render Edit Fields
	 *
	 * This will render all fields on the edit singular term screen. An instance 
	 * of `WP_Term` is passed as the first argument. Note that this also passes 
	 * the taxonomy string, though this is not necessary, as this method is only 
	 * hooked to `{taxonomy}_edit_form_fields`. This means that this will only 
	 * run on terms for this instance's taxonomy.
	 * 
	 * @link    https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/ {taxonomy}_edit_form_fields
	 * @link    https://developer.wordpress.org/reference/classes/wp_term/ WP_Term
	 * 
	 * @since   0.0.1
	 * @param   WP_Term  $term      An instance of `WP_Term`.
	 * @param   string   $taxonomy  The taxonomy slug as registered.
	 * @return  void 
	 */
	public function render_edit_fields( $term = null, $taxonomy = null ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			foreach ( $fields as $field ) {

				$field['value'] = get_term_meta( $term->term_id, $field['name'], true );
				$field['show_label'] = false;

				if ( in_array( $field['type'], $this->textarea_control_fields ) ) {
					$input_class = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';
					$default_rows = ( $field['type'] === 'editor' ) ? 15 : 5;
					$field['input_attrs']['class'] = ( $field['type'] === 'editor' ) ? $input_class : sprintf( 'large-text %1$s', $input_class );
					$field['input_attrs']['rows'] = isset( $field['input_attrs']['rows'] ) ? $field['input_attrs']['rows'] : $default_rows;
					$field['input_attrs']['cols'] = isset( $field['input_attrs']['cols'] ) ? $field['input_attrs']['cols'] : 50;
				}

				$field = apply_filters( $this->format_field_action( 'edit_args' ), $field, $term ); ?>

				<tr class="form-field">
					
					<th scope="row">
						
						<?php if ( ! in_array( $field['type'], $this->remove_label_for_fields ) ) { ?>
						
							<label for="<?php echo sanitize_title_with_dashes( $field['name'] ); ?>"><?php 

								echo wp_kses( $field['label'], $this->kses_label ); 

							?></label>

						<?php } else { ?>

							<span><?php 

								echo wp_kses( $field['label'], $this->kses_label ); 

							?></span>

						<?php } ?>

					</th>

					<td><?php 

						do_action( $this->format_field_action( 'edit_before' ), $field, $term );

						$this->render_field_by_type( $field, $term ); 

						do_action( $this->format_field_action( 'edit_after' ), $field, $term );

					?></td>

				</tr>

			<?php }

		}

	}

	/**
	 * Save
	 *
	 * Saves the form data as individual keys. Also saves a full array 
	 * of `$field['name'] => $value` pairs as a new custom field with the 
	 * `group_meta_key` argument as the key.
	 *
	 * @todo    Document `$tt_id` better.
	 * 
	 * @since   0.0.1
	 * @param   int  $term_id  The ID of the term being saved.
	 * @param   int  $tt_id    the tt ID of the term being saved.
	 * @return  void 
	 */
	public function save( $term_id = 0, $tt_id = 0 ) {

		if ( ! current_user_can( 'manage_categories' ) ) { return; }
		if ( ! $_POST || empty( $_POST ) ) { return; }
		if ( empty( $_POST[$this->nonce_key] ) ) { return; }
		if ( ! wp_verify_nonce( $_POST[$this->nonce_key], 'add' ) && ! wp_verify_nonce( $_POST[$this->nonce_key], 'edit' ) ) { return; }

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {
			
			$values = array();

			foreach ( $fields as $field ) {

				if ( isset( $_POST[$field['name']] ) ) {

					$value = $this->sanitize_field( $field, $_POST[$field['name']] );

					update_term_meta( $term_id, $field['name'], $value );

					$values[$field['name']] = $value;

				} elseif ( in_array( $field['type'], array( 'checkbox', 'checkbox_set', 'radio' ) ) ) {

					$value = ( $field['type'] === 'radio' ) ? '' : false;

					update_term_meta( $term_id, $field['name'], $value );

					$values[$field['name']] = $value;

				} 

			}

			if ( ! empty( $this->args['group_meta_key'] ) ) {

				update_term_meta( $term_id, $this->args['group_meta_key'], $values );

			}

		}

	}

	/**
	 * Manage Admin Column Content
	 * 
	 * @since   0.0.1
	 * @param   string  $content  The already-set content for this column.
	 * @param   string  $column   The column name.
	 * @param   int     $term_id  The ID of the term for this row.
	 * @return  string  The populated column content for this column.
	 */
	public function manage_admin_column_content( $content = '', $column = '', $term_id = 0 ) {

		$field = $this->get_field_by( 'name', $column );

		if ( ! empty( $field ) ) {

			$value = get_term_meta( $term_id, $column, true );

			// short circuit the column content and allow developer to add their own.
			$content = apply_filters( $this->format_column_content_filter( $column ), $content, $field, $value, $term_id );
			if ( ! empty( $content ) ) {
				return $content;
			}

			$formatted_value = $this->format_field_value( $value, $field );

			if ( ! empty( $formatted_value ) ) {

				$content = $formatted_value;

			} else {

				$content = '&horbar;';

			}

		}

		return $content;

	}

	/**
	 * Manage Sorting
	 *
	 * Adds sorting by parsing the `SQL` statements on the `parse_term_query` 
	 * hook. 
	 *
	 * @todo    Try to normalize this with other queryies by using `meta_query`. 
	 *          If this is still not possible, Ensure term sorting does not 
	 *          ignore those terms without the meta value logged in the termmeta 
	 *          table.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/parse_term_query/ Hook: parse_term_query
	 * 
	 * @since   0.0.1
	 * @param   array  $pieces      An array of query pieces that make up the `SQL` statement.
	 * @param   array  $taxonomies  An array of taxonomy names that this query is handling.
	 * @param   array  $args        An array of arguments
	 * @return  array  The filtered query pieces with new sorting applied.
	 */
	public function manage_sorting( $pieces = array(), $taxonomies = array(), $args = array() ) {

		global $wpdb; 

		if ( in_array( $this->slug, $taxonomies ) ) {

			$orderby = isset( $_GET['orderby'] ) ? esc_attr( $_GET['orderby'] ) : ''; 

			if ( ! empty( $orderby ) ) {

				$field = $this->get_field_by( 'name', $orderby );

				if ( is_array( $field ) && ! empty( $field ) ) {

					if ( $field['has_column'] && $field['is_sortable'] ) {

						$pieces['join']    .= ' INNER JOIN ' . $wpdb->termmeta . ' AS tm ON t.term_id = tm.term_id ';
						$pieces['where']   .= ' AND tm.meta_key = "' . esc_attr( $field['name'] ) . '" '; 

						if ( $field['type'] === 'number' ) {
							$pieces['orderby']  = ' ORDER BY CAST(tm.meta_value AS SIGNED) '; 
						} else {
							$pieces['orderby']  = ' ORDER BY tm.meta_value '; 
						}

					}

				}

			}

		}

		return $pieces;
		
	}

	/**
	 * Manage Default Hidden Columns
	 *
	 * Adds all generated fields to the hidden columns array by default, so as 
	 * to not choke up the UI. Note that this will only work if this taxonomy's 
	 * columns UI has never been modified by the user. Hooked to 
	 * `default_hidden_columns`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/default_hidden_columns/ Hook: default_hidden_columns
	 * @link    https://developer.wordpress.org/reference/classes/wp_screen/ WP_Screen
	 * 
	 * @since   0.0.1
	 * @param   array      $hidden  An array of hidden columns.
	 * @param   WP_Screen  $screen  An instance of `WP_Screen`.
	 * @return  void 
	 */
	public function manage_default_hidden_columns( $hidden = array(), $screen = null ) {

		if ( $screen->taxonomy === $this->slug ) {

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
	 * Inline Taxonomy Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_taxonomy_script() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) || ! $this->is_screen( 'base', 'edit-tags' ) ) {
			return;
		} ?>

		<script 
		id="wp_backstage_taxonomy_script"
		type="text/javascript">

			(function($) {

				function resetForm() {
					const form = document.querySelector('#addtag');
					form.reset();
					window.wpBackstage.colorPicker.resetAll(form);
					window.wpBackstage.codeEditor.resetAll(form);
					window.wpBackstage.mediaUploader.resetAll(form);
				}

				function handleSuccess(e = null, request = null, settings = null) {
					if (settings && settings.data) {
						const params = new URLSearchParams(settings.data);
						const action = params.get('action');
						if (action === 'add-tag') {
							resetForm();
						}
					}
				}

				function init() {
					$(document).ajaxSuccess(handleSuccess);
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					init();
				});

			})(jQuery);

		</script>

	<?php }

}