<?php
/**
 * WP Backstage
 *
 * @package     wp_backstage
 * @subpackage  includes
 */

/**
 * WP Backstage
 *
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage {

	/**
	 * Slug
	 *
	 * This is the main text identifier of the instance. It is alpha-numeric and
	 * only contains lowercase letters, underscores and hyphens. The slug is used
	 * when building nonces, creating dynamic hooks, and registering post types, 
	 * taxonomies, and options pages. Note that on instances of `WP_Backstage_User`, 
	 * the slug is set to `user`. The slug is sanitized using WordPress's 
	 * `sanitize_title_with_dashes()` function that is used when sanitizing 
	 * slugs.
	 *
	 * @link https://developer.wordpress.org/reference/functions/sanitize_title_with_dashes/ sanitize_title_with_dashes()
	 * 
	 * @var  string  $slug  the text slug that identifies the instance.
	 */
	protected $slug = '';

	/**
	 * Errors
	 * 
	 * @var  array  $errors  The array of all errors on the instance.
	 */
	protected $errors = array();

	/**
	 * Screen ID
	 *
	 * @link  https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 * 
	 * @var  string|array  $screen_id  The screen ID or IDs that apply to this instance.
	 */
	protected $screen_id = '';

	/**
	 * Has Media
	 * 
	 * @var  bool  $has_media  Whether this instance has media fields or not.
	 */
	protected $has_media = false;

	/**
	 * Has Date
	 * 
	 * @var  bool  $has_date  Whether this instance has date fields or not.
	 */
	protected $has_date = false;

	/**
	 * Has Color
	 * 
	 * @var  bool  $has_color  Whether this instance has color fields or not.
	 */
	protected $has_color = false;

	/**
	 * Has Address
	 * 
	 * @var  bool  $has_address  Whether this instance has address fields or not.
	 */
	protected $has_address = false;

	/**
	 * Has Editor
	 * 
	 * @var  bool  $has_editor  Whether this instance has editor fields or not.
	 */
	protected $has_editor = false;

	/**
	 * Code Editors
	 * 
	 * @var  array  $code_editors  An array of this instance's code editors.
	 */
	protected $code_editors = array();

	/**
	 * Countries
	 * 
	 * @var  array  $countries  An array of localized countries.
	 */
	protected $countries = array();

	/**
	 * US States
	 * 
	 * @var  array  $us_states  An array of localized US states.
	 */
	protected $us_states = array();

	/**
	 * Default Field Args
	 * 
	 * @var  array  $default_field_args  An array of default field args.
	 */
	protected $default_field_args = array(
		'type'        => 'text', 
		'name'        => '', 
		'label'       => '', 
		'title'       => '', 
		'value'       => null, 
		'disabled'    => false, 
		'description' => '', 
		'show_label'  => true, 
		'options'     => array(),
		'input_attrs' => array(),
		'args'        => array(), 
	);

	/**
	 * Date Format
	 * 
	 * @var  string  $date_format  The php date format.
	 */
	protected $date_format = '';

	/**
	 * Default Option Args
	 * 
	 * @var  array  $default_option_args  An array of default option arguments.
	 */
	protected $default_option_args = array(
		'value'       => '', 
		'label'       => '', 
		'disabled'    => false,
	);

	/**
	 * Default Media Uploader Args
	 * 
	 * @var  array  $default_media_uploader_args  An array of default media field arguments.
	 */
	protected $default_media_uploader_args = array(
		'multiple' => false, 
		'type'     => '', 
	);

	/**
	 * Default Date Args
	 * 
	 * @var  array  $default_date_args  An array of default date field arguments.
	 */
	protected $default_date_args = array(
		'format' => 'yy-mm-dd', 
	);

	/**
	 * Default Color Args
	 * 
	 * @var  array  $default_color_args  An array of default color field arguments.
	 */
	protected $default_color_args = array(
		'mode'     => '', 
		'palettes' => true, 
	);

	/**
	 * Default Editor Args
	 * 
	 * @var  array  $default_editor_args  An array of default editor field arguments.
	 */
	protected $default_editor_args = array(
		'max_width'     => '100%', 
		'format_select' => false, 
		'media_buttons' => false, 
		'kitchen_sink'  => false, 
	);

	/**
	 * Default Code Args
	 * 
	 * @var  array  $default_code_args  An array of default code editor arguments.
	 */
	protected $default_code_args = array(
		'mime'      => 'text/html', 
		'max_width' => '100%', 
	);

	/**
	 * Default Address Args
	 * 
	 * @var  array  $default_address_args  An array of default address arguments.
	 */
	protected $default_address_args = array(
		'max_width' => '100%', 
	);

	/**
	 * Default Address Values
	 * 
	 * @var  array  $default_address_values  An array of default address field arguments.
	 */
	protected $default_address_values = array(
		'country'   => 'US', 
		'address_1' => '', 
		'address_2' => '', 
		'city'      => '', 
		'state'     => '', 
		'zip'       => '', 
	);

	/**
	 * Remove Label For Fields
	 * 
	 * @var  array  $remove_label_for_fields  Field types that should have the `for` attribute removed labels.
	 */
	protected $remove_label_for_fields = array( 
		'radio', 
		'checkbox_set', 
		'time', 
		'address', 
	);

	/**
	 * Non Regular Text Fields
	 * 
	 * @var  array  $non_regular_text_fields  Field types that do not include text-style inputs.
	 */
	protected $non_regular_text_fields = array( 
		'number', 
		'textarea', 
		'editor', 
		'select', 
		'checkbox', 
		'checkbox_set', 
		'radio', 
		'media', 
		'code', 
		'date', 
		'time', 
		'address' 
	);

	/**
	 * Textarea Control Fields
	 * 
	 * @var  array  $textarea_control_fields  Field types that use a textarea input as a control.
	 */
	protected $textarea_control_fields = array( 
		'editor', 
		'textarea', 
		'code', 
	);

	/**
	 * KSES P
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @var  array  $kses_p  KSES configuration for paragraph tags.
	 */
	protected $kses_p = array(
		'a' => array(
			'class'  => array(), 
			'id'     => array(), 
			'style'  => array(), 
			'href'   => array(),
			'title'  => array(), 
			'target' => array(), 
			'rel'    => array(), 
		),
		'br' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'em' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'strong' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'code' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'i' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
	);

	/**
	 * KSES Label
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses/ wp_kses()
	 *
	 * @var  array  $kses_label  KSES configuration for label tags.
	 */
	protected $kses_label = array(
		'em' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'strong' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'code' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
		'i' => array(
			'class' => array(), 
			'id'    => array(), 
			'style' => array(), 
		),
	);

	/**
	 * Time Pieces
	 *
	 * This configuration is used in order to create the 3 `<select>` fields 
	 * needed to create a time string as `00:00:00`. This will register the 
	 * localized label and set the number of options that are necessary for each 
	 * time piece (`hour`, `minute`, `second`) respectively.
	 * 
	 * @var  array  $time_pieces  The configuration for time fields.
	 */
	protected $time_pieces = array();

	/**
	 * Global Code Settings
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_enqueue_code_editor/ wp_enqueue_code_editor()
	 *
	 * @var  array $global_code_settings  Global settings for CodeMirror.
	 */
	protected $global_code_settings = array( 
		'codemirror' => array(
			'lineWrapping' => false, 
		), 
	);

	/**
	 * nonce Key
	 *
	 * @link  https://developer.wordpress.org/reference/functions/wp_nonce_field/ wp_nonce_field
	 * @link  https://codex.wordpress.org/WordPress_Nonces WP nonces
	 * 
	 * @var  string  $nonce_key  The key for nonce fields.
	 */
	protected $nonce_key = '_wp_backstage_nonce';

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	protected function __construct() {

		$this->date_format = get_option( 'date_format' );
		$this->time_pieces = array(
			'hour'   => array( 
				'label'          => __( 'Hour', 'wp-backstage' ),  
				'number_options' => 24,  
			), 
			'minute' => array( 
				'label'          => __( 'Minute', 'wp-backstage' ),  
				'number_options' => 60,  
			), 
			'second' => array( 
				'label'          => __( 'Second', 'wp-backstage' ),  
				'number_options' => 60, 
			), 
		);
		$this->countries = array(
			'AF' => __( 'Afghanistan', 'wp_backstage' ), 
			'AL' => __( 'Albania', 'wp_backstage' ), 
			'DZ' => __( 'Algeria', 'wp_backstage' ), 
			'AS' => __( 'American Samoa', 'wp_backstage' ), 
			'AD' => __( 'Andorra', 'wp_backstage' ), 
			'AO' => __( 'Angola', 'wp_backstage' ), 
			'AI' => __( 'Anguilla', 'wp_backstage' ), 
			'AQ' => __( 'Antarctica', 'wp_backstage' ), 
			'AG' => __( 'Antigua and Barbuda', 'wp_backstage' ), 
			'AR' => __( 'Argentina', 'wp_backstage' ), 
			'AM' => __( 'Armenia', 'wp_backstage' ), 
			'AW' => __( 'Aruba', 'wp_backstage' ), 
			'AU' => __( 'Australia', 'wp_backstage' ), 
			'AT' => __( 'Austria', 'wp_backstage' ), 
			'AZ' => __( 'Azerbaijan', 'wp_backstage' ), 
			'BS' => __( 'Bahamas', 'wp_backstage' ), 
			'BH' => __( 'Bahrain', 'wp_backstage' ), 
			'BD' => __( 'Bangladesh', 'wp_backstage' ), 
			'BB' => __( 'Barbados', 'wp_backstage' ), 
			'BY' => __( 'Belarus', 'wp_backstage' ), 
			'BE' => __( 'Belgium', 'wp_backstage' ), 
			'BZ' => __( 'Belize', 'wp_backstage' ), 
			'BJ' => __( 'Benin', 'wp_backstage' ), 
			'BM' => __( 'Bermuda', 'wp_backstage' ), 
			'BT' => __( 'Bhutan', 'wp_backstage' ), 
			'BO' => __( 'Bolivia', 'wp_backstage' ), 
			'BA' => __( 'Bosnia and Herzegovina', 'wp_backstage' ), 
			'BW' => __( 'Botswana', 'wp_backstage' ), 
			'BV' => __( 'Bouvet Island', 'wp_backstage' ), 
			'BR' => __( 'Brazil', 'wp_backstage' ), 
			'BQ' => __( 'British Antarctic Territory', 'wp_backstage' ), 
			'IO' => __( 'British Indian Ocean Territory', 'wp_backstage' ), 
			'VG' => __( 'British Virgin Islands', 'wp_backstage' ), 
			'BN' => __( 'Brunei', 'wp_backstage' ), 
			'BG' => __( 'Bulgaria', 'wp_backstage' ), 
			'BF' => __( 'Burkina Faso', 'wp_backstage' ), 
			'BI' => __( 'Burundi', 'wp_backstage' ), 
			'KH' => __( 'Cambodia', 'wp_backstage' ), 
			'CM' => __( 'Cameroon', 'wp_backstage' ), 
			'CA' => __( 'Canada', 'wp_backstage' ), 
			'CT' => __( 'Canton and Enderbury Islands', 'wp_backstage' ), 
			'CV' => __( 'Cape Verde', 'wp_backstage' ), 
			'KY' => __( 'Cayman Islands', 'wp_backstage' ), 
			'CF' => __( 'Central African Republic', 'wp_backstage' ), 
			'TD' => __( 'Chad', 'wp_backstage' ), 
			'CL' => __( 'Chile', 'wp_backstage' ), 
			'CN' => __( 'China', 'wp_backstage' ), 
			'CX' => __( 'Christmas Island', 'wp_backstage' ), 
			'CC' => __( 'Cocos [Keeling] Islands', 'wp_backstage' ), 
			'CO' => __( 'Colombia', 'wp_backstage' ), 
			'KM' => __( 'Comoros', 'wp_backstage' ), 
			'CG' => __( 'Congo - Brazzaville', 'wp_backstage' ), 
			'CD' => __( 'Congo - Kinshasa', 'wp_backstage' ), 
			'CK' => __( 'Cook Islands', 'wp_backstage' ), 
			'CR' => __( 'Costa Rica', 'wp_backstage' ), 
			'HR' => __( 'Croatia', 'wp_backstage' ), 
			'CU' => __( 'Cuba', 'wp_backstage' ), 
			'CY' => __( 'Cyprus', 'wp_backstage' ), 
			'CZ' => __( 'Czech Republic', 'wp_backstage' ), 
			'CI' => __( 'Côte d’Ivoire', 'wp_backstage' ), 
			'DK' => __( 'Denmark', 'wp_backstage' ), 
			'DJ' => __( 'Djibouti', 'wp_backstage' ), 
			'DM' => __( 'Dominica', 'wp_backstage' ), 
			'DO' => __( 'Dominican Republic', 'wp_backstage' ), 
			'NQ' => __( 'Dronning Maud Land', 'wp_backstage' ), 
			'DD' => __( 'East Germany', 'wp_backstage' ), 
			'EC' => __( 'Ecuador', 'wp_backstage' ), 
			'EG' => __( 'Egypt', 'wp_backstage' ), 
			'SV' => __( 'El Salvador', 'wp_backstage' ), 
			'GQ' => __( 'Equatorial Guinea', 'wp_backstage' ), 
			'ER' => __( 'Eritrea', 'wp_backstage' ), 
			'EE' => __( 'Estonia', 'wp_backstage' ), 
			'ET' => __( 'Ethiopia', 'wp_backstage' ), 
			'FK' => __( 'Falkland Islands', 'wp_backstage' ), 
			'FO' => __( 'Faroe Islands', 'wp_backstage' ), 
			'FJ' => __( 'Fiji', 'wp_backstage' ), 
			'FI' => __( 'Finland', 'wp_backstage' ), 
			'FR' => __( 'France', 'wp_backstage' ), 
			'GF' => __( 'French Guiana', 'wp_backstage' ), 
			'PF' => __( 'French Polynesia', 'wp_backstage' ), 
			'TF' => __( 'French Southern Territories', 'wp_backstage' ), 
			'FQ' => __( 'French Southern and Antarctic Territories', 'wp_backstage' ), 
			'GA' => __( 'Gabon', 'wp_backstage' ), 
			'GM' => __( 'Gambia', 'wp_backstage' ), 
			'GE' => __( 'Georgia', 'wp_backstage' ), 
			'DE' => __( 'Germany', 'wp_backstage' ), 
			'GH' => __( 'Ghana', 'wp_backstage' ), 
			'GI' => __( 'Gibraltar', 'wp_backstage' ), 
			'GR' => __( 'Greece', 'wp_backstage' ), 
			'GL' => __( 'Greenland', 'wp_backstage' ), 
			'GD' => __( 'Grenada', 'wp_backstage' ), 
			'GP' => __( 'Guadeloupe', 'wp_backstage' ), 
			'GU' => __( 'Guam', 'wp_backstage' ), 
			'GT' => __( 'Guatemala', 'wp_backstage' ), 
			'GG' => __( 'Guernsey', 'wp_backstage' ), 
			'GN' => __( 'Guinea', 'wp_backstage' ), 
			'GW' => __( 'Guinea-Bissau', 'wp_backstage' ), 
			'GY' => __( 'Guyana', 'wp_backstage' ), 
			'HT' => __( 'Haiti', 'wp_backstage' ), 
			'HM' => __( 'Heard Island and McDonald Islands', 'wp_backstage' ), 
			'HN' => __( 'Honduras', 'wp_backstage' ), 
			'HK' => __( 'Hong Kong SAR China', 'wp_backstage' ), 
			'HU' => __( 'Hungary', 'wp_backstage' ), 
			'IS' => __( 'Iceland', 'wp_backstage' ), 
			'IN' => __( 'India', 'wp_backstage' ), 
			'ID' => __( 'Indonesia', 'wp_backstage' ), 
			'IR' => __( 'Iran', 'wp_backstage' ), 
			'IQ' => __( 'Iraq', 'wp_backstage' ), 
			'IE' => __( 'Ireland', 'wp_backstage' ), 
			'IM' => __( 'Isle of Man', 'wp_backstage' ), 
			'IL' => __( 'Israel', 'wp_backstage' ), 
			'IT' => __( 'Italy', 'wp_backstage' ), 
			'JM' => __( 'Jamaica', 'wp_backstage' ), 
			'JP' => __( 'Japan', 'wp_backstage' ), 
			'JE' => __( 'Jersey', 'wp_backstage' ), 
			'JT' => __( 'Johnston Island', 'wp_backstage' ), 
			'JO' => __( 'Jordan', 'wp_backstage' ), 
			'KZ' => __( 'Kazakhstan', 'wp_backstage' ), 
			'KE' => __( 'Kenya', 'wp_backstage' ), 
			'KI' => __( 'Kiribati', 'wp_backstage' ), 
			'KW' => __( 'Kuwait', 'wp_backstage' ), 
			'KG' => __( 'Kyrgyzstan', 'wp_backstage' ), 
			'LA' => __( 'Laos', 'wp_backstage' ), 
			'LV' => __( 'Latvia', 'wp_backstage' ), 
			'LB' => __( 'Lebanon', 'wp_backstage' ), 
			'LS' => __( 'Lesotho', 'wp_backstage' ), 
			'LR' => __( 'Liberia', 'wp_backstage' ), 
			'LY' => __( 'Libya', 'wp_backstage' ), 
			'LI' => __( 'Liechtenstein', 'wp_backstage' ), 
			'LT' => __( 'Lithuania', 'wp_backstage' ), 
			'LU' => __( 'Luxembourg', 'wp_backstage' ), 
			'MO' => __( 'Macau SAR China', 'wp_backstage' ), 
			'MK' => __( 'Macedonia', 'wp_backstage' ), 
			'MG' => __( 'Madagascar', 'wp_backstage' ), 
			'MW' => __( 'Malawi', 'wp_backstage' ), 
			'MY' => __( 'Malaysia', 'wp_backstage' ), 
			'MV' => __( 'Maldives', 'wp_backstage' ), 
			'ML' => __( 'Mali', 'wp_backstage' ), 
			'MT' => __( 'Malta', 'wp_backstage' ), 
			'MH' => __( 'Marshall Islands', 'wp_backstage' ), 
			'MQ' => __( 'Martinique', 'wp_backstage' ), 
			'MR' => __( 'Mauritania', 'wp_backstage' ), 
			'MU' => __( 'Mauritius', 'wp_backstage' ), 
			'YT' => __( 'Mayotte', 'wp_backstage' ), 
			'FX' => __( 'Metropolitan France', 'wp_backstage' ), 
			'MX' => __( 'Mexico', 'wp_backstage' ), 
			'FM' => __( 'Micronesia', 'wp_backstage' ), 
			'MI' => __( 'Midway Islands', 'wp_backstage' ), 
			'MD' => __( 'Moldova', 'wp_backstage' ), 
			'MC' => __( 'Monaco', 'wp_backstage' ), 
			'MN' => __( 'Mongolia', 'wp_backstage' ), 
			'ME' => __( 'Montenegro', 'wp_backstage' ), 
			'MS' => __( 'Montserrat', 'wp_backstage' ), 
			'MA' => __( 'Morocco', 'wp_backstage' ), 
			'MZ' => __( 'Mozambique', 'wp_backstage' ), 
			'MM' => __( 'Myanmar [Burma]', 'wp_backstage' ), 
			'NA' => __( 'Namibia', 'wp_backstage' ), 
			'NR' => __( 'Nauru', 'wp_backstage' ), 
			'NP' => __( 'Nepal', 'wp_backstage' ), 
			'NL' => __( 'Netherlands', 'wp_backstage' ), 
			'AN' => __( 'Netherlands Antilles', 'wp_backstage' ), 
			'NT' => __( 'Neutral Zone', 'wp_backstage' ), 
			'NC' => __( 'New Caledonia', 'wp_backstage' ), 
			'NZ' => __( 'New Zealand', 'wp_backstage' ), 
			'NI' => __( 'Nicaragua', 'wp_backstage' ), 
			'NE' => __( 'Niger', 'wp_backstage' ), 
			'NG' => __( 'Nigeria', 'wp_backstage' ), 
			'NU' => __( 'Niue', 'wp_backstage' ), 
			'NF' => __( 'Norfolk Island', 'wp_backstage' ), 
			'KP' => __( 'North Korea', 'wp_backstage' ), 
			'VD' => __( 'North Vietnam', 'wp_backstage' ), 
			'MP' => __( 'Northern Mariana Islands', 'wp_backstage' ), 
			'NO' => __( 'Norway', 'wp_backstage' ), 
			'OM' => __( 'Oman', 'wp_backstage' ), 
			'PC' => __( 'Pacific Islands Trust Territory', 'wp_backstage' ), 
			'PK' => __( 'Pakistan', 'wp_backstage' ), 
			'PW' => __( 'Palau', 'wp_backstage' ), 
			'PS' => __( 'Palestinian Territories', 'wp_backstage' ), 
			'PA' => __( 'Panama', 'wp_backstage' ), 
			'PZ' => __( 'Panama Canal Zone', 'wp_backstage' ), 
			'PG' => __( 'Papua New Guinea', 'wp_backstage' ), 
			'PY' => __( 'Paraguay', 'wp_backstage' ), 
			'YD' => __( 'People\'s Democratic Republic of Yemen', 'wp_backstage' ), 
			'PE' => __( 'Peru', 'wp_backstage' ), 
			'PH' => __( 'Philippines', 'wp_backstage' ), 
			'PN' => __( 'Pitcairn Islands', 'wp_backstage' ), 
			'PL' => __( 'Poland', 'wp_backstage' ), 
			'PT' => __( 'Portugal', 'wp_backstage' ), 
			'PR' => __( 'Puerto Rico', 'wp_backstage' ), 
			'QA' => __( 'Qatar', 'wp_backstage' ), 
			'RO' => __( 'Romania', 'wp_backstage' ), 
			'RU' => __( 'Russia', 'wp_backstage' ), 
			'RW' => __( 'Rwanda', 'wp_backstage' ), 
			'BL' => __( 'Saint Barthélemy', 'wp_backstage' ), 
			'SH' => __( 'Saint Helena', 'wp_backstage' ), 
			'KN' => __( 'Saint Kitts and Nevis', 'wp_backstage' ), 
			'LC' => __( 'Saint Lucia', 'wp_backstage' ), 
			'MF' => __( 'Saint Martin', 'wp_backstage' ), 
			'PM' => __( 'Saint Pierre and Miquelon', 'wp_backstage' ), 
			'VC' => __( 'Saint Vincent and the Grenadines', 'wp_backstage' ), 
			'WS' => __( 'Samoa', 'wp_backstage' ), 
			'SM' => __( 'San Marino', 'wp_backstage' ), 
			'SA' => __( 'Saudi Arabia', 'wp_backstage' ), 
			'SN' => __( 'Senegal', 'wp_backstage' ), 
			'RS' => __( 'Serbia', 'wp_backstage' ), 
			'CS' => __( 'Serbia and Montenegro', 'wp_backstage' ), 
			'SC' => __( 'Seychelles', 'wp_backstage' ), 
			'SL' => __( 'Sierra Leone', 'wp_backstage' ), 
			'SG' => __( 'Singapore', 'wp_backstage' ), 
			'SK' => __( 'Slovakia', 'wp_backstage' ), 
			'SI' => __( 'Slovenia', 'wp_backstage' ), 
			'SB' => __( 'Solomon Islands', 'wp_backstage' ), 
			'SO' => __( 'Somalia', 'wp_backstage' ), 
			'ZA' => __( 'South Africa', 'wp_backstage' ), 
			'GS' => __( 'South Georgia and the South Sandwich Islands', 'wp_backstage' ), 
			'KR' => __( 'South Korea', 'wp_backstage' ), 
			'ES' => __( 'Spain', 'wp_backstage' ), 
			'LK' => __( 'Sri Lanka', 'wp_backstage' ), 
			'SD' => __( 'Sudan', 'wp_backstage' ), 
			'SR' => __( 'Suriname', 'wp_backstage' ), 
			'SJ' => __( 'Svalbard and Jan Mayen', 'wp_backstage' ), 
			'SZ' => __( 'Swaziland', 'wp_backstage' ), 
			'SE' => __( 'Sweden', 'wp_backstage' ), 
			'CH' => __( 'Switzerland', 'wp_backstage' ), 
			'SY' => __( 'Syria', 'wp_backstage' ), 
			'ST' => __( 'São Tomé and Príncipe', 'wp_backstage' ), 
			'TW' => __( 'Taiwan', 'wp_backstage' ), 
			'TJ' => __( 'Tajikistan', 'wp_backstage' ), 
			'TZ' => __( 'Tanzania', 'wp_backstage' ), 
			'TH' => __( 'Thailand', 'wp_backstage' ), 
			'TL' => __( 'Timor-Leste', 'wp_backstage' ), 
			'TG' => __( 'Togo', 'wp_backstage' ), 
			'TK' => __( 'Tokelau', 'wp_backstage' ), 
			'TO' => __( 'Tonga', 'wp_backstage' ), 
			'TT' => __( 'Trinidad and Tobago', 'wp_backstage' ), 
			'TN' => __( 'Tunisia', 'wp_backstage' ), 
			'TR' => __( 'Turkey', 'wp_backstage' ), 
			'TM' => __( 'Turkmenistan', 'wp_backstage' ), 
			'TC' => __( 'Turks and Caicos Islands', 'wp_backstage' ), 
			'TV' => __( 'Tuvalu', 'wp_backstage' ), 
			'UM' => __( 'U.S. Minor Outlying Islands', 'wp_backstage' ), 
			'PU' => __( 'U.S. Miscellaneous Pacific Islands', 'wp_backstage' ), 
			'VI' => __( 'U.S. Virgin Islands', 'wp_backstage' ), 
			'UG' => __( 'Uganda', 'wp_backstage' ), 
			'UA' => __( 'Ukraine', 'wp_backstage' ), 
			'SU' => __( 'Union of Soviet Socialist Republics', 'wp_backstage' ), 
			'AE' => __( 'United Arab Emirates', 'wp_backstage' ), 
			'GB' => __( 'United Kingdom', 'wp_backstage' ), 
			'US' => __( 'United States', 'wp_backstage' ), 
			'ZZ' => __( 'Unknown or Invalid Region', 'wp_backstage' ), 
			'UY' => __( 'Uruguay', 'wp_backstage' ), 
			'UZ' => __( 'Uzbekistan', 'wp_backstage' ), 
			'VU' => __( 'Vanuatu', 'wp_backstage' ), 
			'VA' => __( 'Vatican City', 'wp_backstage' ), 
			'VE' => __( 'Venezuela', 'wp_backstage' ), 
			'VN' => __( 'Vietnam', 'wp_backstage' ), 
			'WK' => __( 'Wake Island', 'wp_backstage' ), 
			'WF' => __( 'Wallis and Futuna', 'wp_backstage' ), 
			'EH' => __( 'Western Sahara', 'wp_backstage' ), 
			'YE' => __( 'Yemen', 'wp_backstage' ), 
			'ZM' => __( 'Zambia', 'wp_backstage' ), 
			'ZW' => __( 'Zimbabwe', 'wp_backstage' ), 
			'AX' => __( 'Åland Islands', 'wp_backstage' ), 
		);
		$this->us_states = array(
			'AL' => __( 'Alabama', 'wp_backstage' ), 
			'AK' => __( 'Alaska', 'wp_backstage' ), 
			'AZ' => __( 'Arizona', 'wp_backstage' ), 
			'AR' => __( 'Arkansas', 'wp_backstage' ), 
			'CA' => __( 'California', 'wp_backstage' ), 
			'CO' => __( 'Colorado', 'wp_backstage' ), 
			'CT' => __( 'Connecticut', 'wp_backstage' ), 
			'DE' => __( 'Delaware', 'wp_backstage' ), 
			'DC' => __( 'District Of Columbia', 'wp_backstage' ), 
			'FL' => __( 'Florida', 'wp_backstage' ), 
			'GA' => __( 'Georgia', 'wp_backstage' ), 
			'HI' => __( 'Hawaii', 'wp_backstage' ), 
			'ID' => __( 'Idaho', 'wp_backstage' ), 
			'IL' => __( 'Illinois', 'wp_backstage' ), 
			'IN' => __( 'Indiana', 'wp_backstage' ), 
			'IA' => __( 'Iowa', 'wp_backstage' ), 
			'KS' => __( 'Kansas', 'wp_backstage' ), 
			'KY' => __( 'Kentucky', 'wp_backstage' ), 
			'LA' => __( 'Louisiana', 'wp_backstage' ), 
			'ME' => __( 'Maine', 'wp_backstage' ), 
			'MD' => __( 'Maryland', 'wp_backstage' ), 
			'MA' => __( 'Massachusetts', 'wp_backstage' ), 
			'MI' => __( 'Michigan', 'wp_backstage' ), 
			'MN' => __( 'Minnesota', 'wp_backstage' ), 
			'MS' => __( 'Mississippi', 'wp_backstage' ), 
			'MO' => __( 'Missouri', 'wp_backstage' ), 
			'MT' => __( 'Montana', 'wp_backstage' ), 
			'NE' => __( 'Nebraska', 'wp_backstage' ), 
			'NV' => __( 'Nevada', 'wp_backstage' ), 
			'NH' => __( 'New Hampshire', 'wp_backstage' ), 
			'NJ' => __( 'New Jersey', 'wp_backstage' ), 
			'NM' => __( 'New Mexico', 'wp_backstage' ), 
			'NY' => __( 'New York', 'wp_backstage' ), 
			'NC' => __( 'North Carolina', 'wp_backstage' ), 
			'ND' => __( 'North Dakota', 'wp_backstage' ), 
			'OH' => __( 'Ohio', 'wp_backstage' ), 
			'OK' => __( 'Oklahoma', 'wp_backstage' ), 
			'OR' => __( 'Oregon', 'wp_backstage' ), 
			'PA' => __( 'Pennsylvania', 'wp_backstage' ), 
			'RI' => __( 'Rhode Island', 'wp_backstage' ), 
			'SC' => __( 'South Carolina', 'wp_backstage' ), 
			'SD' => __( 'South Dakota', 'wp_backstage' ), 
			'TN' => __( 'Tennessee', 'wp_backstage' ), 
			'TX' => __( 'Texas', 'wp_backstage' ), 
			'UT' => __( 'Utah', 'wp_backstage' ), 
			'VT' => __( 'Vermont', 'wp_backstage' ), 
			'VA' => __( 'Virginia', 'wp_backstage' ), 
			'WA' => __( 'Washington', 'wp_backstage' ), 
			'WV' => __( 'West Virginia', 'wp_backstage' ), 
			'WI' => __( 'Wisconsin', 'wp_backstage' ), 
			'WY' => __( 'Wyoming', 'wp_backstage' ), 
		);
		$this->has_media = ! empty( $this->get_field_by( 'type', 'media' ) );
		$this->has_date = ! empty( $this->get_field_by( 'type', 'date' ) );
		$this->has_color = ! empty( $this->get_field_by( 'type', 'color' ) );
		$this->has_address = ! empty( $this->get_field_by( 'type', 'address' ) );
		$this->has_editor = ! empty( $this->get_field_by( 'type', 'editor' ) );
		$this->code_editors = $this->get_fields_by( 'type', 'code' );

	}

	/**
	 * Has Errors
	 *
	 * A utility method to easily check if the instance has errors or not.
	 * 
	 * @since   0.0.1
	 * @return  bool  Whether the instance has errors or not. 
	 */
	protected function has_errors() {
		return is_array( $this->errors ) && ! empty( $this->errors );
	}

	/**
	 * Print Errors
	 *
	 * @link     https://developer.wordpress.org/reference/classes/wp_error/ WP_Error()
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function print_errors() {

		if ( $this->has_errors() ) {

			foreach ( $this->errors as $error ) {
				
				if ( is_wp_error( $error ) ) {

					$message = sprintf( 
						/* translators: 1: error message. */
						__( 'Error: %1$s', 'wp-backstage' ), 
						$error->get_error_message() 
					); ?>

					<div class="notice notice-error">

						<p><?php 
				
							echo wp_kses( $message, $this->kses_p );

						?></p>

					</div>
				
				<?php }
			
			}

		}

	}

	/**
	 * Is Screen
	 *
	 * A utility method to easily check values returned by `get_current_screen()`. 
	 *
	 * @link     https://developer.wordpress.org/reference/functions/get_current_screen/ get_current_screen()
	 * 
	 * @since   0.0.1
	 * @param   string        $key    The key of the `WP_Screen` object to check.
	 * @param   string|array  $value  The value or array of values to check.
	 * @return  bool          If the match was successful or not. 
	 */
	protected function is_screen( $key = '', $value = '' ) {

		$screen = get_current_screen();

		if ( is_array( $value ) ) {
			return in_array( $screen->$key, $value );
		} else {
			return ( $value === $screen->$key );
		}

	}

	/**
	 * Init
	 *
	 * Hook all methods to WordPress.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/add_action/ add_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/reference/hooks/admin_notices/ hook: admin_notices
	 * @link    https://developer.wordpress.org/reference/hooks/admin_head/ hook: admin_head
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts/ hook: admin_print_footer_scripts
	 * @link    https://developer.wordpress.org/plugins/hooks/actions/ WP Actions
	 * @link    https://developer.wordpress.org/plugins/hooks/filters/ WP Filters
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function init() {

		if ( $this->has_errors() ) {
			add_action( 'admin_notices', array( $this, 'print_errors' ) );
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_action( 'admin_head', array( $this, 'add_admin_head_style_action' ), 10 );
		add_action( 'admin_print_footer_scripts', array( $this, 'add_admin_footer_script_action' ), 10 );
		$this->hook_inline_styles();
		$this->hook_inline_scripts();

	}

	/**
	 * Add Admin Head Style Action
	 *
	 * Dynamically hook the formatted head style action that is unique to this
	 * instance. This provides a better place to hook inline styles. This is 
	 * attached to the `admin_head` hook.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/do_action/ do_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_head/ hook: admin_head
	 *
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_admin_head_style_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_head_style_action() );
	}

	/**
	 * Add Admin Footer Script Action
	 *
	 * Dynamically hook the formatted footer script action that is unique to this
	 * instance. This provides a better place to hook inline scripts. This is 
	 * attached to the `admin_print_footer_scripts`.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/do_action/ do_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts/ hook: admin_print_footer_scripts
	 *
	 * @since   0.0.1
	 * @return  void 
	 */
	public function add_admin_footer_script_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_footer_script_action() );
	}

	/**
	 * Format Head Style Action
	 * 
	 * @since   0.0.1 
	 * @return  string  the formatted action name.
	 */
	protected function format_head_style_action() {
		return sprintf( 
			'wp_backstage_%1$s_print_head_styles', 
			esc_attr( $this->slug ) 
		);
	}

	/**
	 * Format Footer Script Action
	 * 
	 * @since   0.0.1 
	 * @return  string  the formatted action name.
	 */
	protected function format_footer_script_action() {
		return sprintf( 
			'wp_backstage_%1$s_print_footer_scripts', 
			esc_attr( $this->slug ) 
		);;
	}

	/**
	 * Format Field Action
	 *
	 * A utility method to get a formatted action name for the field `before` and
	 * `after` actions. 
	 *
	 * @since   0.0.1 
	 * @param   string  $suffix  The suffix to append to the action name (`before`, `after`).
	 * @return  string  the formatted action name.
	 */
	protected function format_field_action( $suffix = '' ) {
		return sprintf( 
			'wp_backstage_%1$s_field%2$s', 
			esc_attr( $this->slug ), 
			! empty( $suffix ) ? '_' . esc_attr( $suffix ) : '' 
		);
	}

	/**
	 * Format Column Content Filter
	 *
	 * A utility method to get a formatted filter name for the column content. 
	 * The resulting filter name is the filter that is used to shortcircuit the
	 * column content and allows developers to add their own.
	 *
	 * @since   0.0.1 
	 * @param   string  $column  The column name.
	 * @return  string  the formatted action name.
	 */
	protected function format_column_content_filter( $column = '' ) {
		return sprintf( 
			'wp_backstage_%1$s_%2$s_column_content', 
			esc_attr( $this->slug ), 
			esc_attr( $column ) 
		);
	}

	/**
	 * Hook Inline Styles
	 *
	 * This hooks all inline style methods to this instance's formatted head 
	 * style action.
	 *
	 * @since   0.0.1 
	 * @return  void
	 */
	protected function hook_inline_styles() {

		$actions = array(
			'inline_editor_style', 
		);

		if ( ! empty( $actions ) ) {
			foreach ( $actions as $action ) {
				add_action( $this->format_head_style_action(), array( $this, $action ), 10 );
			}
		}

	}

	/**
	 * Hook Inline Scripts
	 *
	 * This hooks all inline script methods to this instance's formatted footer 
	 * script action.
	 *
	 * @since   0.0.1 
	 * @return  void
	 */
	protected function hook_inline_scripts() {

		$actions = array(
			'inline_media_uploader_script', 
			'inline_date_picker_script', 
			'inline_color_picker_script', 
			'inline_code_editor_script', 
			'inline_address_script', 
			'inline_editor_script', 
		);

		if ( ! empty( $actions ) ) {
			foreach ( $actions as $action ) {
				add_action( $this->format_footer_script_action(), array( $this, $action ), 10 );
			}
		}

	}

	/**
	 * Render Edit nonce
	 *
	 * Renders a nonce with this instance's `$nonce_key` and the action set to
	 * `edit`.
	 * 
	 * @since   0.0.1
	 * @return  string  The formatted `edit` nonce.
	 */
	public function render_edit_nonce() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'edit', $this->nonce_key );

	}

	/**
	 * Render Add nonce
	 *
	 * Renders a nonce with this instance's `$nonce_key` with the action set to
	 * `add`.
	 * 
	 * @since   0.0.1
	 * @return  string  The formatted `add` nonce.
	 */
	public function render_add_nonce() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'add', $this->nonce_key );

	}

	/**
	 * Enqueue Admin Scripts
	 *
	 * Conditionally enqueue required scripts and styles. This handles enqueues
	 * for the media uploader, WP editor, and color picker. This is also responsible 
	 * for loading up jQuery UI Core and required jQuery UI widgets like the date 
	 * picker and sortable. Finally, this will initialize all code editor instances.
	 *
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/ wp_enqueue_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_style/ wp_enqueue_style()
	 * @link    https://developer.wordpress.org/reference/functions/wp_add_inline_script/ wp_add_inline_script()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_media/ wp_enqueue_media()
	 * @link    https://developer.wordpress.org/reference/functions/did_action/ did_action()
	 * @link    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ hook: admin_enqueue_scripts
	 * @link    https://developer.wordpress.org/themes/basics/including-css-javascript/ Including CSS and Javascript in WP
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function enqueue_admin_scripts() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		if ( $this->has_editor ) {

			// `did_action()` returns the amount of times an action has been run,
			// not a bool. Since this returns an integer and since it will return
			// `0` if the action has never been run, it is safe to use as a boolean.
			if ( ! did_action( 'wp_enqueue_editor' ) ) {
				wp_enqueue_editor();
			}

		}

		if ( $this->has_media || $this->has_date ) {

			if ( ! wp_script_is( 'jquery-ui-core', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-core' );
			}

			if ( ! wp_script_is( 'jquery-ui-theme-default', 'enqueued' ) ) {
				wp_enqueue_style( 
					'jquery-ui-theme-default', 
					'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', 
					array(), 
					'1.12.1' 
				);
			}

		}

		if ( $this->has_media ) {

			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}

		}

		if ( $this->has_date ) {

			if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}

		}

		if ( $this->has_color ) {

			if ( ! wp_script_is( 'wp-color-picker', 'enqueued' ) ) {
				wp_enqueue_script( 'wp-color-picker' );
			}
			if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
				wp_enqueue_style( 'wp-color-picker' );
			}

		}

		if ( ! empty( $this->code_editors ) ) {

			foreach ( $this->code_editors as $code_editor ) {

				$code_editor_args = wp_parse_args( $code_editor['args'], $this->default_code_args );

				$code_editor_settings = wp_enqueue_code_editor( array_merge( $this->global_code_settings, array( 
					'type' => $code_editor_args['mime'], 
				) ) );

				if ( $code_editor_settings ) {

					wp_add_inline_script(
						'code-editor',
						sprintf(
							'jQuery( function() { if (document.querySelector("textarea#%1$s")) { wp.codeEditor.initialize( "%1$s", %2$s ); } } );',
							sanitize_title_with_dashes( $code_editor['name'] ), 
							wp_json_encode( $code_editor_settings )
						)
					);

				}

			}

		}

	}

	/**
	 * Sanitize Text
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_text_field/ sanitize_text_field()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a string.
	 * @return  string  a text field sanitized string. 
	 */
	public function sanitize_text( $value = '' ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize Textarea
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_textarea_field/ sanitize_textarea_field()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a string.
	 * @return  string  a textarea sanitized string. 
	 */
	public function sanitize_textarea( $value = '' ) {
		return sanitize_textarea_field( $value );
	}

	/**
	 * Sanitize Editor
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/wp_kses_post/ wp_kses_post()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a string.
	 * @return  string  the string sanitized as post content. 
	 */
	public function sanitize_editor( $value = '' ) {
		return wp_kses_post( $value );
	}

	/**
	 * Sanitize Code
	 * 
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a string.
	 * @return  string  An unsanitized string. 
	 */
	public function sanitize_code( $value = '' ) {
		return is_string( $value ) ? $value : ''; // unsanitized
	}

	/**
	 * Sanitize Number
	 * 
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   int|float  $value  The value to sanitize. Expects a numeric value.
	 * @return  float      a float, or null if empty. 
	 */
	public function sanitize_number( $value = null ) {
		return ( $value !== '' ) ? floatval( $value ) : null;
	}

	/**
	 * Sanitize URL
	 * 
	 * @link    https://codex.wordpress.org/Function_Reference/esc_url esc_url()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a URL.
	 * @return  string  A URL. 
	 */
	public function sanitize_url( $value = '' ) {
		return esc_url( $value );
	}

	/**
	 * Sanitize Email
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/sanitize_email/ sanitize_email()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects an email address.
	 * @return  string  An email address. 
	 */
	public function sanitize_email( $value = '' ) {
		return sanitize_email( $value );
	}

	/**
	 * Sanitize Checkbox
	 * 
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   bool  $value  The value to sanitize. Expects a value that can be cast to a boolean.
	 * @return  bool  A boolean. 
	 */
	public function sanitize_checkbox( $value = false ) {
		return boolval( $value );
	}

	/**
	 * Sanitize Checkbox Set
	 * 
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   array  $value  The value to sanitize. Expects an array of values.
	 * @return  array  An array of values. 
	 */
	public function sanitize_checkbox_set( $value = array() ) {
		if ( ! is_array( $value ) ) {
			$value = array();
		}
		return array_map( 'esc_attr', $value );
	}

	/**
	 * Sanitize Address
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/esc_attr/ esc_attr()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   array  $value  The value to sanitize. Expects an array of address `key => value` pairs.
	 * @return  array  An array of address key => value pairs. 
	 */
	public function sanitize_address( $value = array() ) {
		if ( ! is_array( $value ) ) {
			$value = array();
		}
		return array_map( 'esc_attr', $value );
	}

	/**
	 * Sanitize Time
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/esc_attr/ esc_attr()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   array   $value  The value to sanitize. Expects an array of 3 2-digit time values.
	 * @return  string  a string as `00:00:00`. 
	 */
	public function sanitize_time( $value = array() ) {
		if ( ! is_array( $value ) || empty( $value ) ) {
			$value = array( '00', '00', '00' );
		}
		return implode( ':', array_map( 'esc_attr', $value ) );
	}

	/**
	 * Sanitize Single Media
	 * 
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   int  $value  The value to sanitize. Expects an attachment ID.
	 * @return  int  An integer, or null if empty. 
	 */
	public function sanitize_single_media( $value = null ) {
		return ( $value !== '' ) ? intval( $value ) : null;
	}

	/**
	 * Sanitize Multi Media
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   string  $value  The value to sanitize. Expects a CSV of attachment IDs.
	 * @return  array   An array of integers. 
	 */
	public function sanitize_multi_media( $value = '' ) {
		return ! empty( $value ) ? array_map( 'intval', explode( ',', $value ) ) : null;
	}

	/**
	 * Sanitize Field
	 *
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   array  $field  The field args.
	 * @param   mixed  $value  The field value.
	 * @return  mixed  The sanitized value according to the field type. 
	 */
	public function sanitize_field( $field = array(), $value = null ) {

		switch ( $field['type'] ) {
			case 'textarea':
				$value = $this->sanitize_textarea( $value );
				break;
			case 'editor':
				$value = $this->sanitize_editor( $value ); 
				break;
			case 'code':
				$value = $this->sanitize_code( $value ); 
				break;
			case 'number':
				$value = $this->sanitize_number( $value );
				break;
			case 'url':
				$value = $this->sanitize_url( $value );
				break;
			case 'email':
				$value = $this->sanitize_email( $value );
				break;
			case 'checkbox':
				$value = $this->sanitize_checkbox( $value );
				break;
			case 'checkbox_set':
				$value = $this->sanitize_checkbox_set( $value );
				break;
			case 'address':
				$value = $this->sanitize_address( $value );
				break;
			case 'time':
				$value = $this->sanitize_time( $value );
				break;
			case 'media':
				$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
				if ( $args['multiple'] ) {
					$value = $this->sanitize_multi_media( $value );
				} else {
					$value = $this->sanitize_single_media( $value );
				}
				break;
			default:
				$value = $this->sanitize_text( $value );
				break;
		}

		return $value;

	}

	/**
	 * Get Sanitize Callback
	 *
	 * Since the `WP_Backstage_Options` class is using the WP Settings API, it 
	 * is necessary to provide a `sanitize_callback` to the `register_setting()` 
	 * function. This method provides a mask of all of this class's 
	 * `sanitize_field` methods as strings per field type.
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/register_setting/ register_setting()
	 * @link    https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data Validating, Sanitizing, and Escaping User Data in WP
	 * 
	 * @since   0.0.1
	 * @param   array   $field  The field args.
	 * @return  string  The sanitize callback function name as a string. 
	 */
	protected function get_sanitize_callback( $field = array() ) {

		switch ( $field['type'] ) {
			case 'textarea':
				$callback = 'sanitize_textarea';
				break;
			case 'editor':
				$callback = 'sanitize_editor';
				break;
			case 'code':
				$callback = 'sanitize_code';
				break;
			case 'number':
				$callback = 'sanitize_number';
				break;
			case 'url':
				$callback = 'sanitize_url';
				break;
			case 'email':
				$callback = 'sanitize_email';
				break;
			case 'checkbox':
				$callback = 'sanitize_checkbox';
				break;
			case 'checkbox_set':
				$callback = 'sanitize_checkbox_set';
				break;
			case 'address':
				$callback = 'sanitize_address';
				break;
			case 'time':
				$callback = 'sanitize_time';
				break;
			case 'media':
				$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
				if ( $args['multiple'] ) {
					$callback = 'sanitize_multi_media';
				} else {
					$callback = 'sanitize_single_media';
				}
				break;
			default:
				$callback = 'sanitize_text';
				break;
		}

		return $callback;

	}

	/**
	 * Get Fields
	 * 
	 * @since   0.0.1
	 * @return  array  an array of field arg arrays. 
	 */
	protected function get_fields() {
		return array();
	}

	/**
	 * Get Fields By
	 *
	 * Get all fields that matches the passed `$key` and `$value`.
	 * 
	 * @since   0.0.1
	 * @param   string  $key     the key of the field arg to check.
	 * @param   mixed   $value   the value of the passed field arg key to check.
	 * @param   int     $number  the number of fields to return.
	 * @return  array   an array of field arg arrays if found, or an empty array.
	 */
	protected function get_fields_by( $key = '', $value = null, $number = 0 ) {

		$fields = $this->get_fields();
		$result = array();

		if ( ! empty( $key ) && ( is_array( $fields ) && ! empty( $fields ) ) ) {

			$i = 0;

			foreach ( $fields as $field ) {

				if ( isset( $field[$key] ) && ( $field[$key] === $value ) ) {

					$result[] = $field;

					if ( ( $number > 0 ) && ( $number === ( $i + 1 ) ) ) {
						break;
					}

					$i++;

				}

			}

		}

		return $result;

	}

	/**
	 * Get Field By
	 *
	 * Get the first field that matches the passed `$key` and `$value`.
	 * 
	 * @since   0.0.1
	 * @param   string  $key     the key of the field arg to check.
	 * @param   mixed   $value   the value of the passed field arg key to check.
	 * @return  array   the first field arg array if found, or an empty array.
	 */
	protected function get_field_by( $key = '', $value = null ) {

		$fields = $this->get_fields_by( $key, $value, 1 );
		$result = null;

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			$result = $fields[0];

		}

		return $result;

	}

	/**
	 * Render Field By Type
	 *
	 * This will render a field by type, given an array of field arguments. 
	 * Depending on the field type, different render field methods will be 
	 * called in order to render the appropriate field HTML.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field args.
	 * @return  void
	 */
	protected function render_field_by_type( $field = array() ) {

		if ( empty( $field ) ) {
			return;
		}

		switch ( $field['type'] ) {
			case 'textarea':
				$this->render_textarea( $field );
				break;
			case 'editor':
				$this->render_editor( $field );
				break;
			case 'select':
				$this->render_select( $field );
				break;
			case 'radio':
				$this->render_radio( $field );
				break;
			case 'checkbox':
				$this->render_checkbox( $field );
				break;
			case 'checkbox_set':
				$this->render_checkbox_set( $field );
				break;
			case 'media':
				$this->render_media_uploader( $field );
				break;
			case 'date':
				$this->render_date( $field );
				break;
			case 'time':
				$this->render_time( $field );
				break;
			case 'color':
				$this->render_color( $field );
				break;
			case 'code':
				$this->render_code( $field );
				break;
			case 'address':
				$this->render_address( $field );
				break;
			default:
				$this->render_input( $field );
				break;
		}
	}

	/**
	 * Format Field Value
	 *
	 * This will format a fields value based on a given array of field args. 
	 * According to the field type, different formatting will be applied to the 
	 * value.
	 * 
	 * @since   0.0.1
	 * @param   mixed  $value  The value to format.
	 * @param   array  $field  An array of field arguments.
	 * @return  void
	 */
	protected function format_field_value( $value = null, $field = array() ) {

		$content = '';

		if ( ! empty( $value ) && ( is_array( $field ) && ! empty( $field ) ) ) {

			switch ( $field['type'] ) {
				case 'url':
					$content = '<a href="' . esc_attr( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a>';
					break;
				case 'email':
					$content = '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
					break;
				case 'tel':
					$content = '<a href="tel:' . esc_attr( preg_replace('/[^0-9]/', '', $value ) ) . '">' . esc_html( $value ) . '</a>';
					break;
				case 'radio':
					$labels = $this->get_option_labels( $field );
					$content = esc_html( $labels[$value] );
					break;
				case 'select':
					$labels = $this->get_option_labels( $field );
					$content = esc_html( $labels[$value] );
					break;
				case 'checkbox':
					$content = '<i class="dashicons dashicons-yes"></i><span class="screen-reader-text">' . esc_html__( 'true', 'wp-backstage' ) . '</span>';
					break;
				case 'textarea':
					$content = wpautop( sanitize_textarea_field( $value ) );
					break;
				case 'editor':
					$content = wpautop( wp_kses_post( $value ) );
					break;
				case 'code':
					$content = '<textarea disabled rows="3" style="font-size:10px;">' . esc_textarea( $value ) . '</textarea>';
					break;
				case 'color':
					$icon_style = 'display:block;width:24px;height:24px;border:1px solid #e1e1e1;background-color:' . esc_attr( $value ) . ';';
					$content = '<i style="' . $icon_style . '" title="' . esc_attr( $value ) . '" aria-hidden="true"></i>';
					break;
				case 'date':
					$content = date( $this->date_format, strtotime( $value ) );
					break;
				case 'checkbox_set':
					if ( is_array( $value ) && ! empty( $value ) ) {
						$option_labels = $this->get_option_labels( $field );
						foreach( $value as $key ) {
							$labels[] = $option_labels[$key];
						}
					}
					$content = esc_html( implode( ', ', $labels ) );
					break;
				case 'address':
					$value = is_array( $value ) ? $value : array();
					$address = wp_parse_args( $value, $this->default_address_values );
					$formatted_address_url = sprintf( 
						esc_url( 'https://www.google.com/maps/place/%1$s%2$s%3$s%4$s%5$s%6$s' ),
						! empty( $address['address_1'] ) ? urlencode( $address['address_1'] ) : '', 
						! empty( $address['address_2'] ) ? ',+' . urlencode( $address['address_2'] ) : '', 
						! empty( $address['city'] ) ? ',+' . urlencode( $address['city'] ) : '', 
						! empty( $address['state'] ) ? ',+' . urlencode( $address['state'] ) : '', 
						! empty( $address['zip'] ) ? ',+' . urlencode( $address['zip'] ) : '', 
						! empty( $address['country'] ) ? ',+' . urlencode( $address['country'] ) : '' 
					);
					$line_2 = ! empty( $address['address_2'] ) ? ' ' . $address['address_2'] : '';
					$formatted_address = sprintf( 
						'%1$s%2$s%3$s%4$s%5$s%6$s', 
						! empty( $address['address_1'] ) ? $address['address_1'] : '', 
						! empty( $address['address_2'] ) ? ' ' . $address['address_2'] : '', 
						! empty( $address['city'] ) ? '<br/>' . $address['city'] : '', 
						! empty( $address['state'] ) ? ', ' . $address['state'] : '', 
						! empty( $address['zip'] ) ? ' ' . $address['zip'] : '', 
						! empty( $address['country'] ) ? ', ' . $address['country'] : '' 
					);
					$icon_style = 'font-size:inherit;height:auto;width:auto;margin-top:-2px;margin-right:2px;vertical-align:middle;';
					$content = sprintf( 
						'<address><a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s<span>%3$s<span><a></address>', 
						esc_url( $formatted_address_url ), 
						'<i class="dashicons dashicons-location" aria-hidden="true" style="' . $icon_style . '"></i>', 
						wp_kses( $formatted_address, $this->kses_p ) 

					);
					break;
				case 'media':
					$thumbnail_size = 20;
					$thumbnail_style = 'height:' . $thumbnail_size . 'px;width:auto;margin:0 4px 4px 0;display:block;float:left;border:1px solid #e1e1e1;';
					if ( is_array( $value ) ) {
						$value = array_map( 'absint', $value );
					} else {
						$value = array( absint( $value ) );
					}
					$attachments = array();
					foreach( $value as $i => $attachment_id ) {
						$attachments[] = wp_get_attachment_image( 
							intval( $attachment_id ), 
							array($thumbnail_size, $thumbnail_size), 
							true, 
							array( 
								'style' => $thumbnail_style, 
								'title' => get_the_title( $attachment_id ), 
							) 
						);
					}
					$content = implode( '', $attachments );
					break;
				default:
					$content = $value;
					break;
			}

		}

		return $content;

	}

	/**
	 * Add Field Columns
	 *
	 * This will embed the field columns into the columns array. Looping through 
	 * the already-set column names, if the column name is `comments`, `date`, 
	 * or `posts`, The new field columns will be placed before the first instance 
	 * of one of them. This method is hooked by objects screens that have tables, 
	 * like `WP_Backstage_User`, `WP_Backstage_Post_Type`, and 
	 * `WP_Backstage_Taxonomy`. Columns will only be placed for the field if the 
	 * field's `has_column` argument is set to `true`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/ hook: manage_{$post_type}_posts_columns
	 * 
	 * @since   0.0.1
	 * @param   string  $columns  The columns that are currently set.
	 * @return  array   The filtered columns with the new columns added. 
	 */
	public function add_field_columns( $columns = array() ) {

		if ( is_array( $columns ) && ! empty( $columns ) ) {
		
			$fields = $this->get_fields();

			// Add all field columns
			if ( is_array( $fields ) && ! empty( $fields ) ) {

				// set which columns should be removed to make way 
				// for new columns (will be added back later as is), 
				// date is included by default, but sometimes comments
				// are there, and this should be at the end as well
				$columns_to_remove = array( 'comments', 'date', 'posts' );

				$removed_columns = array();

				// unset removed columns to make space 
				// also ensure storage of the original
				// column for resetting later
				if ( ! empty( $columns_to_remove ) ) {
					foreach ( $columns_to_remove as $removed ) {
						if ( isset( $columns[$removed] ) ) {
							$removed_columns[$removed] = $columns[$removed];
							unset( $columns[$removed] );
						}
					}
				}

				foreach ( $fields as $field ) {
					if ( $field['has_column'] ) {
						$columns[$field['name']] = $field['label'];
					}
				}

				// reset stored removed columns
				if ( ! empty( $columns_to_remove ) ) {
					foreach ( $columns_to_remove as $removed ) {
						if ( isset( $removed_columns[$removed] ) ) {
							$columns[$removed] = $removed_columns[$removed];
						}
					}
				}

			}

		}

		return $columns;

	}

	/**
	 * Manage Sortable Columns
	 *
	 * This will set which columns are sortable. This method is hooked by object 
	 * screens that have tables, like `WP_Backstage_User`, 
	 * `WP_Backstage_Post_Type`, and `WP_Backstage_Taxonomy`. Columns will only 
	 * be made sortable if the field's `is_sortable` argument is set to `true`.
	 *
	 * @link    https://developer.wordpress.org/reference/hooks/manage_this-screen-id_sortable_columns/ hook: manage_{$screen_id}_sortable_columns
	 * 
	 * @since   0.0.1
	 * @param   array  $columns  The sortable columns that are currently set.
	 * @return  array  The sortable columns with the new sortable columns added. 
	 */
	public function manage_sortable_columns( $columns = array() ) {

		$fields = $this->get_fields();

		if ( is_array( $fields ) && ! empty( $fields ) ) {

			foreach ( $fields as $field ) {

				if ( $field['has_column'] && $field['is_sortable'] ) {

					$columns[$field['name']] = $field['name'];

				}

			}

		}

		return $columns;

	}

	/**
	 * Format Attrs
	 *
	 * A utility method for formatting an array of `$key => $value` pairs into a
	 * string of sanitized HTML element attributes.
	 * 
	 * @since   0.0.1
	 * @param   array   $attrs  An array of attributes as `$key => $value` pairs.
	 * @return  string  The imploded, escaped, formatted attributes.
	 */
	protected function format_attrs( $attrs = array() ) {

		$formatted_attrs = array();

		if ( is_array( $attrs ) && ! empty( $attrs ) ) {
			
			foreach ( $attrs as $key => $field['value'] ) {
				
				$formatted_attrs[] = sprintf( 
					'%1$s="%2$s"', 
					esc_attr( trim( $key ) ), 
					esc_attr( trim( $field['value'] ) ) 
				);

			}
			
		}

		return implode( ' ', $formatted_attrs );
	}

	/**
	 * Get Option Labels
	 *
	 * A utility method to get the localized labels for a given field. This will 
	 * return a `$value => $label` array that can be used to pluck an option 
	 * label for a given option value for a field. This is useful when displaying 
	 * the value of a `radio`, `checkbox`, or `checkbox_set` where the value is 
	 * not "pretty".
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  array  An array of `$value => $label` pairs.
	 */
	protected function get_option_labels( $field = array() ) {
		
		$option_labels = array();
		
		if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
			
			foreach( $field['options'] as $option ) {
				
				$option_labels[$option['value']] = $option['label'];
		
			}
		
		}

		return $option_labels;
	}

	/**
	 * Render Input
	 *
	 * Render an input field. This method will handle all HTML `<input>` types 
	 * except for `radio`, `checkbox`, and those with their own methods like 
	 * `date`. 
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_input( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>">

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label ); 
					
					?></label>

					<br/>

				<?php } ?>

				<input 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Date
	 *
	 * Render a date field using `jQuery UI Datepicker`. This was separated out 
	 * from this class's `render_input()` method because of the JavaScript 
	 * integration. This UI method ensures a full-proof way of ensuring date 
	 * strings are always ISO compliant.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_date( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_date_args ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-date-picker-id="<?php echo esc_attr( $id ); ?>"
		data-date-picker-format="<?php echo esc_attr( $args['format'] ); ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label ); 
					
					?></label>

					<br/>

				<?php } ?>

				<input 
				size="12"
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				style="width:auto;"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Time Options
	 *
	 * This is used in order to create all `<option>` elements needed to create 
	 * a time piece `<select>` as used in this class's `render_time()` method. 
	 * 
	 * @since   0.0.1
	 * @param   int     $number    The number of options to render.
	 * @param   string  $selected  The selected option's value.
	 * @return  void
	 */
	protected function render_time_options( $number = 0, $selected = '' ) {

		if ( ! $number > 0 ) {
			return;
		}

		for ($i = 0; $i < $number; $i++) {
			$option = esc_attr( $i );
			if ( strlen( $option ) === 1 ) {
				$option = '0' . $option;
			}
			printf( '<option value="%1$s" %2$s>%1$s</option>', esc_attr( $option ), selected( $option, $selected ) );
		}

	}

	/**
	 * Render Time
	 *
	 * Render a time field. This will create the 3 `<select>` fields needed to 
	 * create a time string as `00:00:00`. This UI method ensures a full-proof
	 * way of ensuring time strings are always ISO compliant.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_time( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value_pieces = ! empty( $field['value'] ) ? explode( ':', $field['value'] ) : array(); ?>

		<fieldset 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<?php if ( $field['show_label'] ) { ?>

				<legend 
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
				style="padding:2px 0;font-size:inherit;"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></legend>

			<?php } ?>

			<div 
			id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>"
			style="padding:0 0 2px;">

				<?php 
				$i = 0;
				foreach( $this->time_pieces as $piece_key => $piece ) {

					$select_name = sprintf( '%1$s[%2$s]', $field['name'], $piece_key );
					$select_id = sprintf( '%1$s_%2$s', $id, $piece_key );
					$selected = ( isset( $value_pieces[$i] ) && ! empty( $value_pieces[$i] ) ) ? $value_pieces[$i] : ''; ?>

					<span style="display:inline-block;vertical-align:top;">

						<label 
						for="<?php echo esc_attr( $select_id ); ?>"
						style="display:inline-block;padding:0 2px;">

							<small><?php 

								echo wp_kses( $piece['label'], $this->kses_label ); 
							
							?></small>

						</label>

						<br/>

						<select 
						name="<?php echo esc_attr( $select_name ); ?>" 
						id="<?php echo esc_attr( $select_id ); ?>" 
						aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
						<?php disabled( true, $field['disabled'] ); ?>
						<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php

							$this->render_time_options( $piece['number_options'], $selected );

						?></select>

						<?php 
						if ( ($i + 1) < count( $this->time_pieces ) ) {
							echo '<span class="sep">:</span>';
						} ?>

					</span>

					<?php 
					$i++;

				} ?>

			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</fieldset>

	<?php }

	/**
	 * Render Color
	 *
	 * Render a color picker field. This uses the the native `Iris` JavaScript 
	 * library as included in WordPress Core to render the same robust color 
	 * pickers found in WordPress. The field is configurable with arguments for 
	 * `hsl` and `hsv` color modes, as well as custom color palettes.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_color( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_color_args );

		if ( is_array( $args['palettes'] ) ) {
			$palettes = implode( ',', array_map( 'esc_attr', $args['palettes'] ) );
		} else {
			$palettes = $args['palettes'] ? 'true' : 'false';
		} ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-color-picker-id="<?php echo esc_attr( $id ); ?>"
		data-color-picker-mode="<?php echo esc_attr( $args['mode'] ); ?>"
		data-color-picker-palettes="<?php echo $palettes; ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label ); 
					
					?></label>

					<br/>

				<?php } ?>

				<input 
				type="text" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="<?php echo esc_attr( $field['value'] ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Checkbox
	 *
	 * Render a checkbox field. This was separated out from this class's 
	 * `render_input()` method because the markup is significantly different.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_checkbox( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<input 
				type="checkbox" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				value="1" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php checked( true, $field['value'] ); ?>
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				<label 
				id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
				for="<?php echo esc_attr( $id ); ?>"
				style="display:inline-block;"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></label>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Textarea
	 *
	 * Render a textarea field.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_textarea( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

					echo esc_textarea( $field['value'] );

				?></textarea>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Editor
	 *
	 * This will render a WordPress editor complete with `TinyMCE` and 
	 * `quicktags`. These provide a WYSIWYG environment where content creation 
	 * can happen in a familiar WordPress flow. All WordPress caveats, like 
	 * bugs when moving WP Editors around in the DOM in meta boxes, and bugs 
	 * when displaying a meta box that was hidden on page load, have been handled.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_editor( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_editor_args );
		$input_class = isset( $field['input_attrs']['class'] ) ? $field['input_attrs']['class'] : '';
		$field['input_attrs']['class'] = sprintf( 'wp-editor-area %1$s', $input_class ); ?>


		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-editor-id="<?php echo esc_attr( $id ); ?>"
		data-media-buttons="<?php echo ( $args['media_buttons'] ) ? 'true' : 'false'; ?>"
		data-format-select="<?php echo ( $args['format_select'] ) ? 'true' : 'false'; ?>"
		data-kitchen-sink="<?php echo ( $args['kitchen_sink'] ) ? 'true' : 'false'; ?>"
		style="max-width:<?php echo $args['max_width']; ?>;">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

					echo esc_textarea( $field['value'] );

				?></textarea>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Code
	 *
	 * Render a code editor using the native `CodeMirror` integration in 
	 * WordPress Core. This field supports multiple mime types like 
	 * `text/javascript`, `text/css`, `text/html`, and `application/pdf`, etc. 
	 * WordPress's provided configuration will lint, show errors in code, and 
	 * provide autocompletes. All WordPress caveats, like bugs when moving code 
	 * editors around in the DOM in meta boxes, and bugs when displaying a meta 
	 * box that was hidden on page load, have been handled.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_code( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_code_args ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-code-editor-id="<?php echo esc_attr( $id ); ?>"
		style="max-width:<?php echo $args['max_width']; ?>;">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;margin-bottom:4px;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></label>

					<br/>

				<?php } ?>

				<textarea 
				type="<?php echo esc_attr( $field['type'] ); ?>" 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

					echo esc_textarea( $field['value'] );

				?></textarea>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Select
	 *
	 * Render a select that allow for a single value to be set for a 
	 * field. The options are set as an array of the field's `options` key. 
	 * These can be dynamically created by looping post types, taxonomies, 
	 * users, options, etc.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_select( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<?php if ( $field['show_label'] ) { ?>

					<label 
					id="<?php printf( '%1$s_label', esc_attr( $id ) ); ?>"
					for="<?php echo esc_attr( $id ); ?>"
					style="display:inline-block;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></label>

					<br/>

				<?php } ?>

				<select 
				name="<?php echo esc_attr( $field['name'] ); ?>" 
				id="<?php echo esc_attr( $id ); ?>" 
				aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
				<?php disabled( true, $field['disabled'] ); ?>
				<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

					if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

						foreach ( $field['options'] as $option ) { 

							$option = wp_parse_args( $option, $this->default_option_args );
							$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value']; ?>

							<option 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php selected( $option['value'], $field['value'] ); ?>
							<?php disabled( true, $option['disabled'] ); ?>><?php 

								echo strip_tags( $option_label );

							?></option>

						<?php }

					}

				?></select>
			
			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Radio
	 *
	 * Render a set of radios that allow for a single value to be set for a 
	 * field. The options are set as an array of the field's `options` key. 
	 * These can be dynamically created by looping post types, taxonomies, 
	 * users, options, etc.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_radio( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] ); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<fieldset 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>">

				<?php if ( $field['show_label'] ) { ?>

					<legend style="padding:2px 0;font-size:inherit;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></legend>

				<?php } ?>

				<?php 
				if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

					foreach ( $field['options'] as $i => $option ) { 

						$option = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_title_with_dashes( $option['value'] ) ); ?>

						<div 
						id="<?php printf( esc_attr( '%1$s_input_container' ), $input_id ); ?>"
						style="padding:2px 0;">

							<input
							type="radio" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php echo $this->format_attrs( $field['input_attrs'] ); ?>
							<?php echo ( empty( $field['value'] ) && ( $i === 0 ) ) ? checked( true, true, false ) : checked( $option['value'], $field['value'], false ); ?>
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?>/>

							<label 
							id="<?php printf( '%1$s_label', esc_attr( $input_id ) ); ?>"
							for="<?php echo esc_attr( $input_id ); ?>"
							style="display:inline-block;margin:0;"><?php 

								echo esc_html( $option_label );
							
							?></label>

						</div>

					<?php }

				} ?>
			
			</fieldset>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Render Checkbox Set
	 *
	 * Render a set of checkboxes that allow for multiple values to be set for a 
	 * field. The options are set as an array of the field's `options` key. 
	 * These can be dynamically created by looping post types, taxonomies, 
	 * users, options, etc.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_checkbox_set( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = is_array( $field['value'] ) ? $field['value'] : array(); ?>

		<div 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>">

			<fieldset 
			id="<?php echo esc_attr( $id ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>">

				<?php if ( $field['show_label'] ) { ?>

					<legend 
					id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
					style="padding:2px 0;font-size:inherit;"><?php 

						echo wp_kses( $field['label'], $this->kses_label );
					
					?></legend>

				<?php } ?>

				<?php 
				if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

					foreach ( $field['options'] as $option ) { 

						$option = wp_parse_args( $option, $this->default_option_args );
						$option_label = ! empty( $option['label'] ) ? $option['label'] : $option['value'];
						$input_id = sprintf( esc_attr( '%1$s_%2$s' ), $id, sanitize_title_with_dashes( $option['value'] ) ); ?>

						<div 
						id="<?php printf( esc_attr( '%1$s_input_container' ), $input_id ); ?>"
						style="padding:2px 0;">

							<input
							type="checkbox" 
							id="<?php echo esc_attr( $input_id ); ?>" 
							name="<?php echo esc_attr( $field['name'] ); ?>[]" 
							value="<?php echo esc_attr( $option['value'] ); ?>"
							<?php echo $this->format_attrs( $field['input_attrs'] ); ?>
							<?php disabled( true, ( $option['disabled'] || $field['disabled'] ) ); ?>
							<?php checked( true, in_array( $option['value'], $value ) ); ?>/>

							<label 
							id="<?php printf( '%1$s_label', esc_attr( $input_id ) ); ?>"
							for="<?php echo esc_attr( $input_id ); ?>"
							style="display:inline-block;margin:0;"><?php 

								echo esc_html( $option_label );
							
							?></label>

						</div>

					<?php }

				} ?>
			
			</fieldset>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p );
				
				?></p>

			<?php } ?>

		</div>

	<?php }

	/**
	 * Get Media Uploader Label
	 *
	 * A utility method to get a label for various UI elements in the media 
	 * uploader field's markup. 
	 * 
	 * @param  string  $template  A localized `sprintf()` template where `%1$s` is the field's label.
	 * @param  array   $field     An array of field arguments.
	 * @return strint  The formatted text.
	 */
	protected function get_media_uploader_label( $template = '', $field = array() ) {

		if ( ! empty( $template ) ) {

			return sprintf( 
				/* translators: 1: image label. */
				$template, 
				$field['label'] 
			);

		} else {

			return $field['label'];

		}

	}

	
	/**
	 * Render Media Uploader Thumbnail
	 *
	 * Render the media uploader thumbnail used for displaying selected images, 
	 * and for rendering the template that the media field will use in JS to 
	 * render previews. Note that for `$type`, `clone` is used for actual 
	 * thumbnails while `template` is used to output a template for the media 
	 * uploader.
	 *
	 * @since   0.0.1 
	 * @param   string  $attachment_id  The attachment ID of the media post to render.
	 * @param   string  $type           The type of thumbnail as `template` or `clone`. 
	 * @param   string  $args           An array of media uploader field arguments.
	 * @return  void
	 */
	protected function render_media_uploader_thumbnail( $attachment_id = 0, $type = 'clone', $args = array() ) {

		$orientation_class = 'portrait';
		$src = '';
		$cursor_style = ( $args['multiple'] ) ? 'cursor:move;' : 'cursor:normal;';
		$display_style = ( $type === 'template' ) ? 'display:none;' : 'display:block;';

		if ( ( $attachment_id > 0 ) && ( $type === 'clone' ) ) {
			
			$image_attrs = wp_get_attachment_image_src( absint( $attachment_id ), 'medium', true );
			$src = $image_attrs[0];
			
			if ( $image_attrs[1] > $image_attrs[2] ) {
				$orientation_class = 'landscape';
			}

		}

		if ( ( $attachment_id > 0 ) || ( $type === 'template' ) ) {

			$thumbnail_type_attr = sprintf( 
				'data-media-uploader-%1$s="%2$s"', 
				esc_attr( $type ), 
				( $type === 'clone' ) ? absint( $attachment_id ) : 'true' 
			);

			$mime_type = ( $type !== 'template' ) ? get_post_mime_type( $attachment_id ) : ''; ?>

			<figure 
			tabindex="0" 
			class="attachment" 
			style="<?php echo esc_attr( $cursor_style . $display_style ); ?>"
			<?php echo $thumbnail_type_attr; ?>>

				<div 
				class="attachment-preview <?php echo esc_attr( $orientation_class ); ?>"
				style="<?php echo esc_attr( $cursor_style ); ?>">

					<div class="thumbnail">

						<div class="centered">

							<img src="<?php echo esc_url( $src ); ?>">

						</div>

						<div class="filename" style="<?php echo ( strpos( $mime_type, 'image' ) === false ) ? 'display:block;' : 'display:none;'; ?>">

							<div class="filename-inside-div"><?php 

								if ($type !== 'template') {

									echo esc_html( basename( get_attached_file( $attachment_id ) ) );

								}

							?></div>

						</div>

					</div>

				</div>

				<button 
				type="button" 
				class="check" 
				tabindex="0">
					
					<i 
					class="media-modal-icon"
					style="background-position:-60px 0;"></i>

					<span class="screen-reader-text"><?php 

						echo esc_attr( $this->get_media_uploader_label( __( 'Remove %1$s', 'wp-backstage' ), $field ) ); 

					?></span>

				</button>

			</figure>

		<?php }

	}

	/**
	 * Render Media Uploader
	 *
	 * The media uploader field is capable of selecting media files of all mime 
	 * types, and supports single and multiple image selection. This field is 
	 * deeply integrated into the WordPress Media Uploader, and there are 
	 * arguments for mime type selection. Fields that allow multiple attachments 
	 * to be selected also support selective removal, addition, and drag-and-drop
	 * sorting.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_media_uploader( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
		$modal_button_template = $args['multiple'] ? __( 'Add to %1$s', 'wp-backstage' ) : __( 'Set %1$s', 'wp-backstage' ); ?>

		<fieldset 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-media-uploader-id="<?php echo esc_attr( $id ); ?>"
		data-media-uploader-multiple="<?php echo $args['multiple'] ? 'true' : 'false'; ?>"
		data-media-uploader-type="<?php echo esc_attr( $args['type'] ); ?>"
		data-media-uploader-title="<?php echo esc_attr( $field['label'] ); ?>"
		data-media-uploader-button="<?php echo esc_attr( $this->get_media_uploader_label( $modal_button_template, $field ) ); ?>">

			<?php if ( $field['show_label'] ) { ?>
				
				<legend 
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
				style="cursor:pointer;padding:2px 0;font-size:inherit;"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
			
				?></legend>

			<?php } ?>

			<div 
			id="<?php printf( esc_attr( '%1$s_preview' ), $id ); ?>"
			style="<?php echo empty( $field['value'] ) ? 'display:none;' : 'display:block;'; ?>">

				<?php
				$this->render_media_uploader_thumbnail( '', 'template', $args ); 

				if ( ! empty( $field['value'] ) ) {

					if ( is_array( $field['value'] ) ) {

						foreach ( $field['value'] as $attachment_id ) {

							$this->render_media_uploader_thumbnail( absint( $attachment_id ), 'clone', $args );

						}

					} else {

						$this->render_media_uploader_thumbnail( absint( $field['value'] ), 'clone', $args );
					}

				} ?>

			</div>

			<div class="clear"></div>

			<div style="padding:4px 0 2px;">

				<button 
				id="<?php printf( esc_attr( '%1$s_button_set' ), $id ); ?>"
				type="button"
				class="button"
				style="<?php echo ! empty( $field['value'] ) ? 'display:none;' : 'display:inline-block;'; ?>"
				<?php disabled( true, ! empty( $field['value'] ) ); ?>><?php 

						echo esc_html( $this->get_media_uploader_label( __( 'Upload %1$s', 'wp-backstage' ), $field ) ); 

				?></button>

				<?php if ( $args['multiple'] ) { ?>

					<button 
					id="<?php printf( esc_attr( '%1$s_button_add' ), $id ); ?>"
					type="button"
					class="button"
					style="<?php echo empty( $field['value'] ) ? 'display:none;' : 'display:inline-block;'; ?>"
					<?php disabled( true, empty( $field['value'] ) ); ?>><?php 

							echo esc_html( $this->get_media_uploader_label( __( 'Add to %1$s', 'wp-backstage' ), $field ) ); 

					?></button>

				<?php } ?>

				<button 
				id="<?php printf( esc_attr( '%1$s_button_remove' ), $id ); ?>"
				type="button" 
				class="button"
				style="<?php echo empty( $field['value'] ) ? 'display:none;' : 'display:inline-block;'; ?>"
				<?php disabled( true, empty( $field['value'] ) ); ?>><?php 

						echo esc_html( $this->get_media_uploader_label( __( 'Remove %1$s', 'wp-backstage' ), $field ) ); 

				?></button>

			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 

				?></p>

			<?php } ?>

			<input 
			type="hidden" 
			id="<?php echo esc_attr( $id ); ?>" 
			name="<?php echo esc_attr( $field['name'] ); ?>" 
			value="<?php echo is_array( $field['value'] ) ? esc_attr( implode( ',', $field['value'] ) ) : esc_attr( $field['value'] ); ?>"
			aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
			<?php echo $this->format_attrs( $field['input_attrs'] ); ?> />

		</fieldset>

	<?php } 

	/**
	 * Render Address
	 *
	 * Render a group of fields that will provide all necessary inputs to create 
	 * a full address. The value of this field is an array of address pieces as 
	 * `country`, `address`, `address_2`, `city`, `state`, `zip`. If the US is 
	 * selected as the country, then a `<select>` of localized US states will 
	 * replace the "State/Province/Region" input.
	 * 
	 * @since   0.0.1
	 * @param   array  $field  An array of field arguments.
	 * @return  void 
	 */
	protected function render_address( $field = array() ) {

		$field = wp_parse_args( $field, $this->default_field_args );
		$id = sanitize_title_with_dashes( $field['name'] );
		$value = is_array( $field['value'] ) ? $field['value'] : array();
		$values = wp_parse_args( $value, $this->default_address_values );
		$args = wp_parse_args( $field['args'], $this->default_address_args ); ?>

		<fieldset 
		id="<?php printf( esc_attr( '%1$s_container' ), $id ); ?>"
		data-address-id="<?php echo esc_attr( $id ); ?>"
		style="max-width:<?php echo esc_attr( $args['max_width'] ); ?>;">

			<?php if ( $field['show_label'] ) { ?>

				<legend 
				id="<?php printf( '%1$s_legend', esc_attr( $id ) ); ?>"
				style="display:inline-block;font-size:inherit;"><?php 

					echo wp_kses( $field['label'], $this->kses_label ); 
				
				?></legend>

			<?php } ?>

			<div id="<?php printf( esc_attr( '%1$s_input_container' ), $id ); ?>" >

				<div id="<?php printf( esc_attr( '%1$s_country_container' ), $id ); ?>">

					<label 
					for="<?php printf( esc_attr( '%1$s_country' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'Country', 'wp_backstage' ), $this->kses_label );  
						
						?></small>

					</label>

					<br/>

					<select
					id="<?php printf( esc_attr( '%1$s_country' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[country]' ), $field['name'] ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

						foreach ( $this->countries as $country_code => $country_label ) { ?>

							<option 
							value="<?php echo esc_attr( $country_code ); ?>"
							<?php selected( $country_code, $values['country'] ); ?>><?php 

								echo esc_html( $country_label ); 

							?></option>

						<?php }

					?></select>

				</div>

				<div id="<?php printf( esc_attr( '%1$s_address_1_container' ), $id ); ?>">

					<label 
					for="<?php printf( esc_attr( '%1$s_address_1' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'Address', 'wp_backstage' ), $this->kses_label ); 
						
						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( esc_attr( '%1$s_address_1' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[address_1]' ), $field['name'] ); ?>"
					value="<?php echo esc_attr( $values['address_1'] ); ?>"
					aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				</div>

				<div id="<?php printf( esc_attr( '%1$s_address_2_container' ), $id ); ?>">

					<label 
					for="<?php printf( esc_attr( '%1$s_address_2' ), $id ); ?>"
					style="display:inline-block;">
						
						<small><?php 

							echo wp_kses( __( 'Address (Line 2)', 'wp_backstage' ), $this->kses_label ); 
						
						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( esc_attr( '%1$s_address_2' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[address_2]' ), $field['name'] ); ?>"
					value="<?php echo esc_attr( $values['address_2'] ); ?>"
					aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				</div>

				<div id="<?php printf( esc_attr( '%1$s_city_container' ), $id ); ?>"
				style="width:49%;float:left;margin-right:2%;">

					<label 
					for="<?php printf( esc_attr( '%1$s_city' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'City', 'wp_backstage' ), $this->kses_label ); 
						
						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( esc_attr( '%1$s_city' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[city]' ), $field['name'] ); ?>"
					value="<?php echo esc_attr( $values['city'] ); ?>"
					aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				</div>

				<div id="<?php printf( esc_attr( '%1$s_state_container' ), $id ); ?>"
				style="width:49%;float:left;">

					<label 
					for="<?php printf( esc_attr( '%1$s_state' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'State / Province / Region', 'wp_backstage' ), $this->kses_label ); 
						
						?></small>

					</label>

					<br/>

					<input 
					type="text" 
					id="<?php printf( esc_attr( '%1$s_state' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[state]' ), $field['name'] ); ?>"
					value="<?php echo esc_attr( $values['state'] ); ?>"
					aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>

				</div>

				<div id="<?php printf( esc_attr( '%1$s_us_state_container' ), $id ); ?>"
				style="width:49%;float:left;">

					<label 
					for="<?php printf( esc_attr( '%1$s_us_state' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'State', 'wp_backstage' ), $this->kses_label ); 
						
						?></small>

					</label>

					<br/>

					<select
					id="<?php printf( esc_attr( '%1$s_us_state' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[state]' ), $field['name'] ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>><?php 

						foreach ( $this->us_states as $us_state_code => $us_state_name ) { ?>

							<option 
							value="<?php echo esc_attr( $us_state_code ); ?>"
							<?php selected( $us_state_code, $values['state'] ); ?>><?php 

								echo esc_html( $us_state_name ); 

							?></option>

						<?php }

					?></select>

				</div>

				<div class="clear"></div>

				<div id="<?php printf( esc_attr( '%1$s_zip_container' ), $id ); ?>">

					<label 
					for="<?php printf( esc_attr( '%1$s_zip' ), $id ); ?>"
					style="display:inline-block;">

						<small><?php 

							echo wp_kses( __( 'Zip Code', 'wp_backstage' ), $this->kses_label );
						
						?></small>

					</label>

					<br/>

					<input 
					type="tel" 
					id="<?php printf( esc_attr( '%1$s_zip' ), $id ); ?>"
					name="<?php printf( esc_attr( '%1$s[zip]' ), $field['name'] ); ?>"
					value="<?php echo esc_attr( $values['zip'] ); ?>"
					aria-describedby="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>"
					style="width:100%;"
					<?php disabled( true, $field['disabled'] ); ?>
					<?php echo $this->format_attrs( $field['input_attrs'] ); ?>/>
				
				</div>

			</div>

			<?php if ( ! empty( $field['description'] ) ) { ?>

				<p 
				id="<?php printf( esc_attr( '%1$s_description' ), $id ); ?>" 
				class="description"><?php 

					echo wp_kses( $field['description'], $this->kses_p ); 
				
				?></p>

			<?php } ?>

		</fieldset>

	<?php }

	/**
	 * Inline Editor Style
	 *
	 * Conditionally inlines the editor field style if this instance has any 
	 * editor fields.
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_editor_style() {

		if ( ! $this->has_editor ) {
			return;
		} ?>

		<style 
		id="wp_backstage_editor_style"
		type="text/css">

			.mce-toolbar .mce-btn.mce-active, 
			.mce-toolbar .mce-btn.mce-active button, 
			.mce-toolbar .mce-btn.mce-active i, 
			.mce-toolbar .mce-btn.mce-active:hover button, 
			.mce-toolbar .mce-btn.mce-active:hover i {
				color: inherit;
			}

			.form-field .wp-editor-area {
				border-width: 0;
			}

		</style>

	<?php }

	/**
	 * Inline Media Uploader Script
	 *
	 * Conditionally inlines the media uploader script if this instance has any 
	 * media uploaders.
	 *
	 * @link    https://codex.wordpress.org/Javascript_Reference/wp.media wp.media
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://jqueryui.com/sortable/ jQuery UI Sortable
	 * @link    https://jqueryui.com/ jQuery UI
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_media_uploader_script() {

		if ( ! $this->has_media ) {
			return;
		} ?>

		<script 
		id="wp_backstage_media_uploader_script"
		type="text/javascript">

			(function($) {

				function init(uploader = null) {
					
					if (! uploader) { 
						return; 
					}
						
					const fieldId = uploader.getAttribute('data-media-uploader-id');
					const input = uploader.querySelector('#' + fieldId);
					const legend = uploader.querySelector('#' + fieldId + '_legend');
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const setButton = uploader.querySelector('#' + fieldId + '_button_set');
					const addButton = uploader.querySelector('#' + fieldId + '_button_add');
					const removeButton = uploader.querySelector('#' + fieldId + '_button_remove');
					const preview = uploader.querySelector('#' + fieldId + '_preview');
					const previewTemplate = uploader.querySelector('[data-media-uploader-template]');
					const initialClones = uploader.querySelectorAll('[data-media-uploader-clone]');
					const title = uploader.getAttribute('data-media-uploader-title');
					const buttonText = uploader.getAttribute('data-media-uploader-button');
					const type = uploader.getAttribute('data-media-uploader-type');
					const isMultiple = (uploader.getAttribute('data-media-uploader-multiple') === 'true');
					
					const modal = wp.media({
						title: title,
						multiple: isMultiple, 
						library: { type: type || 'image' }, 
						button: { text: buttonText },
						frame: 'select', 
					});

					function handleOpen(e = null) {
						modal.open();
					}
					function handleRemove(e = null) {
						e.preventDefault();
						removeClones();
						resetField();
					}
					function handleSelect() {
						const selection = modal.state().get('selection').toJSON();
						if (selection && (selection.length > 0)) {
							var saveIds = (input.value && isMultiple) ? input.value.split(',').map(function(id) { return parseInt(id); }) : [];
							if (! isMultiple) {
								removeClones();
							}
							for (var i = 0; i < selection.length; i++) {
								const attachment = selection[i];
								const attachmentId = parseInt(attachment.id, 10);
								saveIds.push(attachmentId);
								preview.appendChild(getClone(attachment));
							}
							setField(saveIds.join(','));
							if (isMultiple) {
								refreshSorting();
							}
						}
					}
					function getClone(attachment = null) {
						const clone = previewTemplate.cloneNode(true);
						const cloneImg = clone.querySelector('img');
						const orientationContainer = clone.querySelector('.attachment-preview');
						const filename = clone.querySelector('.filename > div');

						clone.removeAttribute('data-media-uploader-template');
						clone.setAttribute('data-media-uploader-clone', parseInt(attachment.id, 10));
						cloneImg.setAttribute('src', attachment.mime.includes('image') ? attachment.url : attachment.icon);
						clone.style.display = 'block';

						if (attachment.width > attachment.height) {
							orientationContainer.classList.remove('portrait');
							orientationContainer.classList.add('landscape');
						} else {
							orientationContainer.classList.add('portrait');
							orientationContainer.classList.remove('landscape');
						}
						filename.innerHTML = attachment.filename;
						filename.style.display = (attachment.mime.indexOf('image') === -1) ? 'block' : 'none';

						initClone(clone);

						return clone;
					}
					function removeClones() {
						const clones = getClones();
						if (clones && (clones.length > 0)) {
							for (var i = 0; i < clones.length; i++) {
								preview.removeChild(clones[i]);
							}
						}
					}
					function enableButton(button = null) {
						if (button) {
							button.removeAttribute('disabled', true);
							button.style.display = 'inline-block';
						}
					}
					function disableButton(button = null) {
						if (button) {
							button.setAttribute('disabled', true);
							button.style.display = 'none';
						}
					}
					function setField(value = null) {
						input.value = value;
						preview.style.display = 'block';
						disableButton(setButton);
						enableButton(removeButton);
						if (isMultiple) {
							enableButton(addButton);
						}
					}
					function resetField() {
						input.value = '';
						preview.style.display = 'none';
						enableButton(setButton);
						disableButton(removeButton);
						if (isMultiple) {
							disableButton(addButton);
						}
					}
					function initSorting() {
						$(preview).sortable({
							items: '[data-media-uploader-clone]', 
							stop: handleSortStop,  
						});
					}
					function refreshSorting() {
						$(preview).sortable('refresh');
					}
					function handleSortStop(e = null, ui = null) {
						const { item } = ui;
						if (item[0].classList.contains('attachment')) {
							const clones = getClones();
							const saveIds = [];
							if (clones && (clones.length > 0)) {
								for (var i = 0; i < clones.length; i++) {
									const attachmentId = parseInt(clones[i].getAttribute('data-media-uploader-clone'), 10);
									saveIds.push(attachmentId);
								}
							}
							input.value = saveIds.join(',');
						}
					}
					function handleCloneMouseEnter(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.add('selected');
							e.target.classList.add('details');
						}
					}
					function handleCloneMouseLeave(e = null) {
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.classList.remove('selected');
							e.target.classList.remove('details');
						}
					}
					function handleCloneClick(e = null) {
						e.preventDefault();
						if (e.target.getAttribute('data-media-uploader-clone')) {
							e.target.focus();
						} else {
							getParentClone(e.target).focus();
						}
					}
					function handleCheckClick(e = null) {
						e.preventDefault();
						const clone = getParentClone(e.target);
						const attachmentId = parseInt(clone.getAttribute('data-media-uploader-clone'), 10);
						var values = input.value ? input.value.split(',').map(function(id) { return parseInt(id, 10); }) : [];
						const valuesIndex = values.indexOf(attachmentId);
						if (valuesIndex !== -1) {
							const removed = values.splice(valuesIndex, 1);
						}
						input.value = values.join(',');
						preview.removeChild(clone);
						if (! input.value) {
							resetField();
						}
					}
					function initClone(clone = null) {
						if (clone) {
							const check = clone.querySelector('.check');
							clone.addEventListener('mouseenter', handleCloneMouseEnter);
							clone.addEventListener('mouseleave', handleCloneMouseLeave);
							clone.addEventListener('click', handleCloneClick);
							check.addEventListener('click', handleCheckClick);
						}
					}
					function getClones() {
						return preview.querySelectorAll('[data-media-uploader-clone]');
					}
					function getParentClone(el = null) {
						while ((el = el.parentElement) && ! el.getAttribute('data-media-uploader-clone'));
						return el;
					}

					modal.on('select', handleSelect);
					setButton.addEventListener('click', handleOpen);
					removeButton.addEventListener('click', handleRemove);
					if (legend) {
						legend.addEventListener('click', handleOpen);
					}
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleOpen);
						}
					}
					if (initialClones && (initialClones.length > 0)) {
						for (var i = 0; i < initialClones.length; i++) {
							initClone(initialClones[i]);
						}
					}
					if (isMultiple) {
						addButton.addEventListener('click', handleOpen);
						initSorting();
					}
					uploader.mediaUploader = {
						reset: function() {
							removeClones();
							resetField();
						}, 
					};
				}

				function initAll() {
					const uploaders = document.querySelectorAll('[data-media-uploader-id]');
					if (uploaders && (uploaders.length > 0)) {
						for (var i = 0; i < uploaders.length; i++) {
							init(uploaders[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					initAll();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Datepicker Script
	 *
	 * Conditionally inlines the date picker script if this instance has any 
	 * date fields.
	 * 
	 * @link    https://jqueryui.com/datepicker/ jQuery UI Datepicker
	 * @link    https://jqueryui.com/ jQuery UI
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP Javascript Reference
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_date_picker_script() {

		if ( ! $this->has_date ) {
			return;
		} ?>

		<script 
		id="wp_backstage_date_picker_script"
		type="text/javascript">

			(function($) {

				function init(datePicker = null) {
					
					if (! datePicker) { 
						return;
					}

					const fieldId = datePicker.getAttribute('data-date-picker-id');
					const format = datePicker.getAttribute('data-date-picker-format');
					const input = datePicker.querySelector('#' + fieldId);

					$(input).datepicker({
						dateFormat: format || 'yy-mm-dd', 
					});
				}

				function initAll() {
					const datePickers = document.querySelectorAll('[data-date-picker-id]');
					if (datePickers && (datePickers.length > 0)) {
						for (var i = 0; i < datePickers.length; i++) {
							init(datePickers[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					initAll();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Colorpicker Script
	 *
	 * Conditionally inlines the color picker script if this instance has any 
	 * color fields.
	 * 
	 * @link    http://automattic.github.io/Iris/ Iris
	 * @link    https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ New Color Picker in WP 3.5
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_color_picker_script() {

		if ( ! $this->has_color ) {
			return;
		} ?>

		<script 
		id="wp_backstage_color_picker_script"
		type="text/javascript">

			(function($) {

				function init(colorPicker = null) {
					
					if (! colorPicker) { 
						return;
					}

					const fieldId = colorPicker.getAttribute('data-color-picker-id');
					const input = colorPicker.querySelector('#' + fieldId);
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const mode = colorPicker.getAttribute('data-color-picker-mode');
					var palettes = colorPicker.getAttribute('data-color-picker-palettes');
					palettes = palettes.startsWith('#') ? palettes.split(',') : (palettes === 'true');

					function handleLabelClick(e) {
						e.preventDefault();
						resultButton = colorPicker.querySelector('.wp-color-result');
						if (resultButton) {
							resultButton.focus();
						}
					}

					var options = {
						defaultColor: false, // bool, string
						palettes: palettes // bool, []
					};
					// Add seperately to ensure default WP setting 
					// is respected if no mode is set.
					if (mode) {
						options.mode = mode; // string (hsl, hsv)
					}

					$(input).wpColorPicker(options);
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleLabelClick);
						}
					}
				}

				function initAll() {
					const colorPickers = document.querySelectorAll('[data-color-picker-id]');
					if (colorPickers && (colorPickers.length > 0)) {
						for (var i = 0; i < colorPickers.length; i++) {
							init(colorPickers[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					initAll();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Code Editor Script
	 *
	 * Conditionally inlines the code editor script if this instance has any 
	 * code editor fields. All of the initializer functions fire at window load,
	 * to ensure that all CodeMirror instances have finished initializing first.
	 * 
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_code_editor/ wp_enqueue_code_editor()
	 * @link    https://make.wordpress.org/core/tag/codemirror/ CodeMirror in WP
	 * @link    https://codemirror.net/ CodeMirror
	 * @link    https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-included-and-registered-by-wordpress Default Scripts Included by WP
	 * @link    https://codex.wordpress.org/Javascript_Reference WP Javascript Reference
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_code_editor_script() {

		if ( empty( $this->code_editors ) ) {
			return;
		} ?>

		<script 
		id="wp_backstage_code_editor_script"
		type="text/javascript">

			(function($) {

				function init(codeEditor = null) {
					
					if (! codeEditor) { 
						return;
					}

					const fieldId = codeEditor.getAttribute('data-code-editor-id');
					const labels = document.querySelectorAll('[for="' + fieldId + '"]');
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					const CodeMirrorInst = codeMirrorEl.CodeMirror;
					var timer = null;

					function handleLabelClick(e = null) {
						CodeMirrorInst.focus();
					}

					CodeMirrorInst.on('change', function(instance, changes) {
						clearTimeout(timer);
						timer = setTimeout(function() {
							instance.save();
						}, 750);
					});
					if (labels && (labels.length > 0)) {
						for (var i = 0; i < labels.length; i++) {
							labels[i].addEventListener('click', handleLabelClick);
						}
					}
				}
				function refresh(codeEditor = null) {
					const codeMirrorEl = codeEditor.querySelector('.CodeMirror');
					const CodeMirrorInst = codeMirrorEl.CodeMirror;
					CodeMirrorInst.refresh();
				}
				function initAll() {
					const codeEditors = document.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							init(codeEditors[i]);
						}
					}
				}
				function refreshAll(container = null) {
					container = container || document;
					const codeEditors = container.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							refresh(codeEditors[i]);
						}
					}
				}
				function initScreenOption(checkbox = null) {

					function handleChange(e = null) {
						const { value } = e.target;
						const metaBox = document.querySelector('#' + value);
						if (metaBox && ! metaBox.classList.contains('closed')) {
							refreshAll(metaBox);
						}
					}

					if (checkbox) {
						checkbox.addEventListener('change', handleChange);
					}
				}
				function initMetaBoxSortable(sortable = null) {

					function handleSortStop(e = null, ui = null) {
						const { item } = ui;
						if (item[0].classList.contains('postbox')) {
							refreshAll(item[0]);
						}
					}

					if (sortable) {
						$(sortable).on('sortstop', handleSortStop);
					}
				}
				function initMetaBoxSortableHandle(handle = null) {

					function handleClick(e = null) {
						var { parentNode } = e.target;
						while (! parentNode.classList.contains('postbox')) {
							parentNode = parentNode.parentNode;
						}
						if (! parentNode.classList.contains('closed')) {
							refreshAll(parentNode);
						}
					}

					if (handle) {
						handle.addEventListener('click', handleClick);
					}
				}
				function initAllMetaBoxSortables() {
					const metaBoxSortables = document.querySelectorAll('.meta-box-sortables');
					if (metaBoxSortables && (metaBoxSortables.length > 0)) {
						for (var i = 0; i < metaBoxSortables.length; i++) {
							initMetaBoxSortable(metaBoxSortables[i]);
						}
					}
				}
				function initAllMetaBoxSortableHandles() {
					const metaBoxSortableHandles = document.querySelectorAll('.meta-box-sortables .postbox > .ui-sortable-handle, .meta-box-sortables .postbox > .handlediv');
					if (metaBoxSortableHandles && (metaBoxSortableHandles.length > 0)) {
						for (var i = 0; i < metaBoxSortableHandles.length; i++) {
							initMetaBoxSortableHandle(metaBoxSortableHandles[i]);
						}
					}
				}
				function initAllScreenOptions() {
					const checkboxes = document.querySelectorAll('.metabox-prefs input[type="checkbox"]');
					if (checkboxes && (checkboxes.length > 0)) {
						for (var i = 0; i < checkboxes.length; i++) {
							initScreenOption(checkboxes[i]);
						}
					}
				}

				window.addEventListener('load', function(e) {
					initAll();
					initAllMetaBoxSortables();
					initAllMetaBoxSortableHandles();
					initAllScreenOptions();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Address Script
	 *
	 * Conditionally inlines the address script if this instance has any 
	 * address fields.
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_address_script() {

		if ( ! $this->has_address ) {
			return;
		} ?>

		<script 
		id="wp_backstage_address_script"
		type="text/javascript">

			(function($) {

				function init(address = null) {
					
					if (! address) { 
						return;
					}

					const fieldId = address.getAttribute('data-address-id');
					const countrySelect = address.querySelector('#' + fieldId + '_country');
					const stateContainer = address.querySelector('#' + fieldId + '_state_container');
					const usStateContainer = address.querySelector('#' + fieldId + '_us_state_container');

					function enableField(field = null) {
						const control = field.querySelector('input, textarea, select');
						control.removeAttribute('disabled');
						field.style.display = 'block';
					}
					function disableField(field = null) {
						const control = field.querySelector('input, textarea, select');
						control.setAttribute('disabled', true);
						field.style.display = 'none';
					}
					function toggleByCountry(value = '') {
						if (value === 'US') {
							enableField(usStateContainer)
							disableField(stateContainer);
						} else {
							enableField(stateContainer)
							disableField(usStateContainer);
						}
					}
					function handleCountryChange(e = null) {
						toggleByCountry(e.target.value);
					}
					
					toggleByCountry(countrySelect.value);
					countrySelect.addEventListener('change', handleCountryChange);
				}

				function initAll() {
					const addresses = document.querySelectorAll('[data-address-id]');
					if (addresses && (addresses.length > 0)) {
						for (var i = 0; i < addresses.length; i++) {
							init(addresses[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', function(e) {
					initAll();
				});

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Editor Script
	 *
	 * Conditionally inlines the editor script if this instance has any 
	 * editor fields.
	 *
	 * @todo     Find out why gallery shortcodes are not being rendered visually.
	 *
	 * @link     https://codex.wordpress.org/Javascript_Reference/wp.editor wp.editor
	 * @link     https://developer.wordpress.org/reference/functions/wp_enqueue_editor/ wp_enqueue_editor()
	 * @link     https://make.wordpress.org/core/2017/05/20/editor-api-changes-in-4-8/ WP Editor API Changes in 4.8
	 * @link     https://codex.wordpress.org/Javascript_Reference WP JavaScript Reference
	 * @link     https://www.tiny.cloud/docs/demo/basic-example/ Tiny MCE Example
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_editor_script() {

		if ( ! $this->has_editor ) {
			return;
		} ?>

		<script 
		id="wp_backstage_editor_script"
		type="text/javascript">

			(function($) {

				function destroy(editor = null) {
					if (! editor) { 
						return;
					}
					const fieldId = editor.getAttribute('data-editor-id');
					wp.editor.remove(fieldId);
				}

				function init(editor = null) {
					
					if (! editor) { 
						return;
					}

					const fieldId = editor.getAttribute('data-editor-id');
					const textarea = editor.querySelector('#' + fieldId);
					const mediaButtons = (editor.getAttribute('data-media-buttons') === 'true');
					const formatSelect = (editor.getAttribute('data-format-select') === 'true');
					const kitchenSink = (editor.getAttribute('data-kitchen-sink') === 'true');
					var timer = null;

					function handleSetup(e = null, wpEditor = null) {
						const { id } = wpEditor.settings;
						if (id === fieldId) {
							wpEditor.settings.plugins = 'charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview';
							wpEditor.settings.toolbar1 = 'bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link';
							if (formatSelect) {
								wpEditor.settings.toolbar1 = 'formatselect,' + wpEditor.settings.toolbar1;
							}
							if (kitchenSink) {
								wpEditor.settings.toolbar1 += ',wp_adv';
								wpEditor.settings.toolbar2 = 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help';
							}
							wpEditor.on('change', function(e) {
								clearTimeout(timer);
								timer = setTimeout(function() {
									wpEditor.save();
								}, 750);
							});
						} 
						
					}

					wp.editor.initialize(fieldId, {
						mediaButtons: mediaButtons, 
						quicktags: true, 
						tinymce: {
							wpautop: true, 
						}, 
					});

					$(document).on( 'tinymce-editor-setup', handleSetup);

				}
				function destroyAll(container = null) {
					container = container || document;
					const editors = container.querySelectorAll('[data-editor-id]');
					if (editors && (editors.length > 0)) {
						for (var i = 0; i < editors.length; i++) {
							destroy(editors[i]);
						}
					}
				}
				function initAll(container = null) {
					container = container || document;
					const editors = container.querySelectorAll('[data-editor-id]');
					if (editors && (editors.length > 0)) {
						for (var i = 0; i < editors.length; i++) {
							init(editors[i]);
						}
					}
				}
				function reInitAll(container = null) {
					container = container || document;
					destroyAll(container);
					initAll(container);
				}
				function initMetaBoxSortable(sortable = null) {
					
					function handleSortStop(e = null, ui = null) {
						const { item } = ui;
						if (item[0].classList.contains('postbox')) {
							reInitAll(item[0]);
						}
					}

					if (sortable) {
						$(sortable).on('sortstop', handleSortStop);
					}
				}
				function initMetaBoxSortableHandle(handle = null) {
					
					function handleClick(e = null) {
						var { parentNode } = e.target;
						while (! parentNode.classList.contains('postbox')) {
							parentNode = parentNode.parentNode;
						}
						if (! parentNode.classList.contains('closed')) {
							reInitAll(parentNode);
						}
					}

					if (handle) {
						handle.addEventListener('click', handleClick);
					}
				}
				function initScreenOption(checkbox = null) {

					function handleChange(e = null) {
						const { value } = e.target;
						const metaBox = document.querySelector('#' + value);
						if (metaBox && ! metaBox.classList.contains('closed')) {
							reInitAll(metaBox);
						}
					}

					if (checkbox) {
						checkbox.addEventListener('change', handleChange);
					}
				}
				function initAllMetaBoxSortables() {
					const metaBoxSortables = document.querySelectorAll('.meta-box-sortables');
					if (metaBoxSortables && (metaBoxSortables.length > 0)) {
						for (var i = 0; i < metaBoxSortables.length; i++) {
							initMetaBoxSortable(metaBoxSortables[i]);
						}
					}
				
				}
				function initAllMetaBoxSortableHandles() {
					const metaBoxSortableHandles = document.querySelectorAll('.meta-box-sortables .postbox > .ui-sortable-handle, .meta-box-sortables .postbox > .handlediv');
					if (metaBoxSortableHandles && (metaBoxSortableHandles.length > 0)) {
						for (var i = 0; i < metaBoxSortableHandles.length; i++) {
							initMetaBoxSortableHandle(metaBoxSortableHandles[i]);
						}
					}
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
					initAll();
					initAllMetaBoxSortables();
					initAllMetaBoxSortableHandles();
					initAllScreenOptions();
				});

			})(jQuery);

		</script>

	<?php }

}