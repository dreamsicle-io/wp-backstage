<?php
/**
 * WP Backstage
 * 
 * @version     0.0.1
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage {

	/**
	 * Slug
	 * 
	 * @since 0.0.1
	 */
	public $slug = '';

	/**
	 * Errors
	 * 
	 * @since 0.0.1
	 */
	public $errors = array();

	/**
	 * Screen ID
	 * 
	 * @since 0.0.1
	 */
	public $screen_id = '';

	/**
	 * Has Media Uploader
	 * 
	 * @since 0.0.1
	 */
	public $has_media = false;

	/**
	 * Has Date
	 * 
	 * @since 0.0.1
	 */
	public $has_date = false;

	/**
	 * Has Color
	 * 
	 * @since 0.0.1
	 */
	public $has_color = false;
	/**
	 * Has Address
	 * 
	 * @since 0.0.1
	 */
	public $has_address = false;

	/**
	 * Code Editors
	 * 
	 * @since 0.0.1
	 */
	public $code_editors = array();

	/**
	 * Countries
	 * 
	 * @since 0.0.1
	 */
	public $countries = array();

	/**
	 * US States
	 * 
	 * @since 0.0.1
	 */
	public $us_states = array();

	/**
	 * Default Field Args
	 * 
	 * @since 0.0.1
	 */
	public $default_field_args = array(
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
	 * @since 0.0.1
	 */
	public $date_format = '';

	/**
	 * Default Option Args
	 * 
	 * @since 0.0.1
	 */
	public $default_option_args = array(
		'value'       => '', 
		'label'       => '', 
		'disabled'    => false,
	);

	/**
	 * Default Media Uploader Args
	 * 
	 * @since 0.0.1
	 */
	public $default_media_uploader_args = array(
		'multiple' => false, 
		'type'     => '', 
	);

	/**
	 * Default Date Args
	 * 
	 * @since 0.0.1
	 */
	public $default_date_args = array(
		'format' => 'yy-mm-dd', 
	);

	/**
	 * Default Color Args
	 * 
	 * @since 0.0.1
	 */
	public $default_color_args = array(
		'mode'     => '', 
		'palettes' => true, 
	);

	/**
	 * Default Code Args
	 * 
	 * @since 0.0.1
	 */
	public $default_code_args = array(
		'mime'      => 'text/html', 
		'max_width' => '100%', 
	);

	/**
	 * Default Color Args
	 * 
	 * @since 0.0.1
	 */
	public $default_address_args = array(
		'max_width' => '100%', 
	);

	/**
	 * Default Address values
	 * 
	 * @since 0.0.1
	 */
	public $default_address_values = array(
		'country'   => 'US', 
		'address_1' => '', 
		'address_2' => '', 
		'city'      => '', 
		'state'     => '', 
		'zip'       => '', 
	);

	public $remove_label_for_fields = array( 
		'radio', 
		'checkbox_set', 
		'time', 
		'address', 
	);

	public $non_regular_text_fields = array( 
		'number', 
		'textarea', 
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

	public $textarea_control_fields = array( 
		'textarea', 
		'code', 
	);

	/**
	 * KSES for P Tags
	 *
	 * @since 0.0.1
	 */
	public $kses_p = array(
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
	 * KSES for Label Tags
	 *
	 * @since 0.0.1
	 */
	public $kses_label = array(
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
	 * @since 0.0.1
	 */
	public $time_pieces = array();

	/**
	 * Global Code Settings
	 *
	 * @since 0.0.1
	 */
	public $global_code_settings = array( 
		'codemirror' => array(
			'lineWrapping' => false, 
		), 
	);

	public $nonce_key = '_wp_backstage_nonce';

	/**
	 * Construct
	 * 
	 * @since   0.0.1
	 * @param   string  $slug 
	 * @param   array   $args 
	 * @return  void 
	 */
	function __construct() {

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
		$this->code_editors = $this->get_fields_by( 'type', 'code' );

	}

	/**
	 * Has Errors
	 * 
	 * @since   0.0.1
	 * @return  boolean  Whether the instance has errors or not. 
	 */
	public function has_errors() {

		return is_array( $this->errors ) && ! empty( $this->errors );

	}

	/**
	 * Print Errors
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
	 * @since   0.0.1
	 * @return  boolean  If the match was successful or not. 
	 */
	public function is_screen( $key = '', $value = '' ) {

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

	}

	public function add_admin_head_style_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_head_style_action( $this->slug ) );
	}

	public function add_admin_footer_script_action() {
		
		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		do_action( $this->format_footer_script_action( $this->slug ) );
	}

	public function format_head_style_action( $slug = '' ) {
		$action = '';
		if ( ! empty( $slug ) ) {
			$action = sprintf( 
				'wp_backstage_%1$s_print_head_styles', 
				esc_attr( $slug ) 
			);
		}
		return $action;
	}

	public function format_footer_script_action( $slug = '' ) {
		$action = '';
		if ( ! empty( $slug ) ) {
			$action = sprintf( 
				'wp_backstage_%1$s_print_footer_scripts', 
				esc_attr( $slug ) 
			);
		}
		return $action;
	}

	public function format_field_action( $slug = '', $suffix = '' ) {
		$action = '';
		if ( ! empty( $slug ) ) {
			$action = sprintf( 
				'wp_backstage_%1$s_field%2$s', 
				$slug, 
				! empty( $suffix ) ? '_' . esc_attr( $suffix ) : '' 
			);
		}
		return $action;
	}

	public function format_column_content_filter( $slug ='', $column = '' ) {
		$filter = '';
		if ( ! empty( $slug ) && ! empty( $column ) ) {
			$filter = sprintf( 
				'wp_backstage_%1$s_%2$s_column_content', 
				esc_attr( $slug ), 
				esc_attr( $column ) 
			);
		}
		return $filter;
	}

	public function hook_inline_styles( $slug = '' ) {

		$actions = array();

		if ( ! empty( $slug ) && ! empty( $actions ) ) {
			foreach ( $actions as $action ) {
				add_action( $this->format_head_style_action( $slug ), array( $this, $action ), 10 );
			}
		}

	}

	public function hook_inline_scripts( $slug = '' ) {

		$actions = array(
			'inline_media_uploader_script', 
			'inline_date_picker_script', 
			'inline_color_picker_script', 
			'inline_code_editor_script', 
			'inline_address_script', 
		);

		if ( ! empty( $slug ) && ! empty( $actions ) ) {
			foreach ( $actions as $action ) {
				add_action( $this->format_footer_script_action( $slug ), array( $this, $action ), 10 );
			}
		}

	}

	/**
	 * Render nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
	 */
	public function render_edit_nonce() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
		}

		wp_nonce_field( 'edit', $this->nonce_key );

	}

	/**
	 * Render nonce
	 * 
	 * @since   0.0.1
	 * @return  string 
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
	 * @since   0.0.1
	 * @return  string 
	 */
	public function enqueue_admin_scripts() {

		if ( ! $this->is_screen( 'id', $this->screen_id ) ) {
			return;
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
			
			if ( ! wp_script_is( 'media-editor', 'enqueued' ) ) {
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
	 * Sanitize Field
	 * 
	 * @since   0.0.1
	 * @return  mixed  The sanitized value according to the field type. 
	 */
	public function sanitize_field( $field = array(), $value = null ) {

		switch ( $field['type'] ) {
			case 'text':
				$value = sanitize_text_field( $value );
				break;
			case 'textarea':
				$value = sanitize_textarea_field( $value );
				break;
			case 'code':
				$value = $value; // unsanitized
				break;
			case 'number':
				if ( $value !== '' ) {
					$value = floatval( $value );
				} else {
					$value = null;
				}
				break;
			case 'url':
				$value = esc_url( $value );
				break;
			case 'email':
				$value = sanitize_email( $value );
				break;
			case 'checkbox':
				$value = boolval( $value );
				break;
			case 'checkbox_set':
				$value = array_map( 'esc_attr', $value );
			case 'address':
				$value = array_map( 'esc_attr', $value );
				break;
			case 'time':
				$value = implode( ':', array_map( 'esc_attr', $value ) );
				break;
			case 'media':
				$args = wp_parse_args( $field['args'], $this->default_media_uploader_args );
				if ( $args['multiple'] ) {
					if ( ! empty( $value ) ) {
						$value = array_map( 'intval', explode( ',', $value ) );
					} else {
						$value = array();
					}
				} else {
					$value = intval( $value );
					if ( ! $value > 0 ) {
						$value = null;
					}
				}
				break;
			default:
				$value = esc_attr( $value );
				break;
		}

		return $value;

	}

	/**
	 * Get Fields
	 * 
	 * @since   0.0.1
	 * @return  array  
	 */
	public function get_fields() {

		return array();

	}

	/**
	 * Get Fields By
	 * 
	 * @since   0.0.1
	 * @return  array  the fields if found, or an empty array.
	 */
	public function get_fields_by( $key = '', $value = null, $number = 0 ) {

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
	 * @since   0.0.1
	 * @return  array  the first field if found, or null.
	 */
	public function get_field_by( $key = '', $value = null ) {

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
	 * @since   0.0.1
	 * @return  array  the first field if found, or null.
	 */
	public function render_field_by_type( $field = array() ) {

		if ( empty( $field ) ) {
			return;
		}

		switch ( $field['type'] ) {
			case 'textarea':
				$this->render_textarea( $field );
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
	 * Format Value by Field
	 * 
	 * @since   0.0.1
	 * @return  void
	 */
	public function format_field_value( $value = null, $field = array() ) {

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
	 * @since   0.0.1
	 * @return  array  The filtered columns. 
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
				foreach ( $columns_to_remove as $removed ) {
					if ( isset( $columns[$removed] ) ) {
						$removed_columns[$removed] = $columns[$removed];
						unset( $columns[$removed] );
					}
				}

				foreach ( $fields as $field ) {
					if ( $field['has_column'] ) {
						$columns[$field['name']] = $field['label'];
					}
				}

				// reset stored removed columns
				foreach ( $columns_to_remove as $removed ) {
					if ( isset( $removed_columns[$removed] ) ) {
						$columns[$removed] = $removed_columns[$removed];
					}
				}

			}

		}

		return $columns;

	}

	/**
	 * Manage Sortable Columns
	 * 
	 * @since   0.0.1
	 * @return  array  The filtered sortable columns. 
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
	 * @since   0.0.1
	 * @return  string  The imploded, escaped, formatted attributes.
	 */
	public function format_attrs( $attrs = array() ) {

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
	 * @since   0.0.1
	 * @return  void
	 */
	public function get_option_labels( $field = array(), $post_id = 0 ) {
		
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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_input( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_date( $field = array() ) {

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
				size="10"
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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_time_options( $number = 0, $selected = '' ) {

		if ( ! $number > 0 ) {
			return;
		}

		for ($i = 0; $i < $number; $i++) {
			$option = esc_attr( $i );
			var_dump( count_chars( $option ) );
			if ( strlen( $option ) === 1 ) {
				$option = '0' . $option;
			}
			printf( '<option value="%1$s" %2$s>%1$s</option>', esc_attr( $option ), selected( $option, $selected ) );
		}

	}

	/**
	 * Render Time
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_time( $field = array() ) {

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
					$select_id = sprintf( '%1$s_%2$s', $id, $piece_key ); ?>

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

							$this->render_time_options( $piece['number_options'], $value_pieces[$i] );

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_color( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_checkbox( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_textarea( $field = array() ) {

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
	 * Render Code
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_code( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_select( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_radio( $field = array() ) {

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
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_checkbox_set( $field = array() ) {

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

	public function get_media_uploader_label( $template = '', $field = array() ) {

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
	 * @since   0.0.1 
	 * @param   string  $attachment_id 
	 * @param   string  $type           `template` or `clone`.
	 * @param   string  $args           media uploader field args.
	 * @return  void
	 */
	public function render_media_uploader_thumbnail( $attachment_id = 0, $type = 'clone', $args = array() ) {

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
	 * Render Checkbox Set
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_media_uploader( $field = array() ) {

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
	 * Render Input
	 * 
	 * @since   0.0.1
	 * @return  void 
	 */
	public function render_address( $field = array() ) {

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
	 * Inline Media Uploader Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_media_uploader_script() {

		if ( ! $this->has_media ) {
			return;
		} ?>

		<script type="text/javascript">

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

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Datepicker Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_date_picker_script() {

		if ( ! $this->has_date ) {
			return;
		} ?>

		<script type="text/javascript">

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

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Colorpicker Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_color_picker_script() {

		if ( ! $this->has_color ) {
			return;
		} ?>

		<script type="text/javascript">

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

					function isArray (value = null) {
						return value && (typeof value === 'object') && (value.constructor === Array);
					}
					function handleLabelClick(e) {
						e.preventDefault();
						resultButton = colorPicker.querySelector('.wp-color-result');
						if (resultButton) {
							resultButton.focus();
						}
					}

					if (isArray(palettes)) {
						palettes = palettes.split(',');
					} else {
						palettes = (palettes !== 'false');
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

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Code Editor Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_code_editor_script() {

		if ( empty( $this->code_editors ) ) {
			return;
		} ?>

		<script type="text/javascript">

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

				function initAll() {
					const codeEditors = document.querySelectorAll('[data-code-editor-id]');
					if (codeEditors && (codeEditors.length > 0)) {
						for (var i = 0; i < codeEditors.length; i++) {
							init(codeEditors[i]);
						}
					}
				}

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

	/**
	 * Inline Address Script
	 * 
	 * @since   0.0.1
	 * @return  void  
	 */
	public function inline_address_script() {

		if ( ! $this->has_address ) {
			return;
		} ?>

		<script type="text/javascript">

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

				document.addEventListener('DOMContentLoaded', initAll);

			})(jQuery);

		</script>

	<?php }

}