<?php
/**
 * WP Backstage Address Field
 *
 * @since       4.0.0
 * @package     WPBackstage
 * @subpackage  Includes/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Address Field
 *
 * @since 4.0.0
 */
class WP_Backstage_Address_Field extends WP_Backstage_Field {

	/**
	 * Tags
	 *
	 * @since 4.0.0
	 * @var array $tags An array of tags used to organize fields and add extra functionality.
	 */
	protected array $tags = array(
		'remove_label_for',
	);

	/**
	 * Schema
	 *
	 * @since 4.0.0
	 * @var array $schema The REST API schema definition.
	 */
	protected array $schema = array(
		'type'       => 'object',
		'properties' => array(
			'country'   => array(
				'type' => 'string',
			),
			'address_1' => array(
				'type' => 'string',
			),
			'address_2' => array(
				'type' => 'string',
			),
			'city'      => array(
				'type' => 'string',
			),
			'state'     => array(
				'type' => 'string',
			),
			'zip'       => array(
				'type' => 'string',
			),
		),
	);

	/**
	 * Default Address Values
	 *
	 * @since 0.0.1
	 * @var array  $default_address  An array of default address values.
	 */
	protected array $default_address = array(
		'country'   => 'US',
		'address_1' => '',
		'address_2' => '',
		'city'      => '',
		'state'     => 'AL',
		'zip'       => '',
	);

	/**
	 * Countries
	 *
	 * @since 4.0.0
	 * @var array $countries An array of countries as `$code => $label` pairs.
	 */
	protected $countries = array();

	/**
	 * Countries
	 *
	 * @since 4.0.0
	 * @var array $us_states An array of states as `$code => $label` pairs.
	 */
	protected $us_states = array();

	/**
	 * Construct
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		// Countries.
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
		// US States.
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

		parent::__construct();
	}

	/**
	 * Sanitize
	 *
	 * @since 4.0.0
	 * @param mixed $value The unsantized value.
	 * @return array The santizied value.
	 */
	public function sanitize( $value = null ) {
		$value = wp_parse_args( $value, $this->default_address );
		return array_map( 'sanitize_text_field', $value );
	}

	/**
	 * Inline Style
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_style(): void { ?>

		<style id="wp_backstage_address_field_style">

			.wp-backstage-address-field {
				display: block;
			}

			.wp-backstage-address-field__control {
				display: block;
			}

			.wp-backstage-address-field__control {
				margin-bottom: 4px;
			}

			.wp-backstage-address-field__control label {
				display: block;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
				font-size: 0.875em;
			}

			.wp-backstage-address-field__control select,
			.wp-backstage-address-field__control input {
				width: 100%;
				max-width: 100%;
				box-sizing: border-box;
			}

			#addtag .wp-backstage-address-field__control input,
			#edittag .wp-backstage-address-field__control input {
				max-width: 100%;
				width: 100%;
			}

			#addtag .wp-backstage-address-field__controls,
			#edittag .wp-backstage-address-field__controls {
				display: block;
				max-width: 95%;
			}

		</style>

	<?php }

	/**
	 * Inline Script
	 *
	 * @since 4.0.0
	 * @return void
	 */
	public function inline_script(): void { ?>

		<script id="wp_backstage_address_field_script">

			(function($) {

				function findParentAddress(element = null) {
					var parentNode = element.parentNode;
					while (parentNode instanceof HTMLElement && ! parentNode.classList.contains('wp-backstage-field--type-address')) {
						parentNode = parentNode.parentNode;
					}
					return parentNode instanceof HTMLElement ? parentNode : null;
				}

				function getAll(container = document) {
					return container.querySelectorAll('.wp-backstage-field--type-address');
				}

				function enableField(field = null) {
					const control = field.querySelector('input, select');
					control.removeAttribute('disabled');
					field.style.display = 'block';
				}

				function disableField(field = null) {
					const control = field.querySelector('input, select');
					control.setAttribute('disabled', true);
					field.style.display = 'none';
				}

				function getCountrySelect(address = null) {
					return address.querySelector('.wp-backstage-address-field__control--country select');
				}

				function getStateInputContainer(address = null) {
					return address.querySelector('.wp-backstage-address-field__control--state');
				}

				function getUSStateSelectContainer(address = null) {
					return address.querySelector('.wp-backstage-address-field__control--us-state');
				}

				function toggleByCountry(address = null) {
					const country = getCountry(address);
					const stateContainer = getStateInputContainer(address);
					const usStateContainer = getUSStateSelectContainer(address);
					if (country === 'US') {
						enableField(usStateContainer);
						disableField(stateContainer);
					} else {
						enableField(stateContainer);
						disableField(usStateContainer);
					}
				}

				function handleCountryChange(e = null) {
					const address = findParentAddress(e.target);
					toggleByCountry(address);
				}

				function init(address = null) {
					const countrySelect = getCountrySelect(address);
					countrySelect.addEventListener('change', handleCountryChange);
					toggleByCountry(address);
				}

				function initAll(container = document) {
					const addresses = getAll(container);
					addresses.forEach(function(address) {
						init(address);
					});
				}

				function destroy(address = null) {
					const countrySelect = getCountrySelect(address);
					const stateContainer = getStateInputContainer(address);
					const usStateContainer = getUSStateSelectContainer(address);
					countrySelect.removeEventListener('change', handleCountryChange);
					enableField(stateContainer);
					disableField(usStateContainer);
				}

				function destroyAll(container = document) {
					const addresses = getAll(container);
					addresses.forEach(function(address) {
						destroy(address);
					});
				}

				function resetAll(container = document) {
					const addresses = getAll(container);
					addresses.forEach(function(address) {
						reset(address);
					});
				}

				function getCountry(address = null) {
					const countrySelect = getCountrySelect(address);
					return countrySelect.value;
				}

				function reset(address = null) {
					toggleByCountry(address);
				}

				window.wpBackstage.fields.address = {
					initAll: initAll,
					init: init,
					resetAll: resetAll,
					reset: reset,
				};

			})(jQuery);

		</script>

	<?php }

	/**
	 * Render Column
	 *
	 * @since 4.0.0
	 * @param array $field An array of field arguments.
	 * @param mixed $value The field's value.
	 * @return void
	 */
	public function render_column( array $field = array(), $value = null ): void {
		$value   = is_array( $value ) ? $value : array();
		$address = array();

		if ( ! empty( $value['address_1'] ) ) {
			$address[] = $value['address_1'];
		}
		if ( ! empty( $value['address_2'] ) ) {
			$address[] = $value['address_2'];
		}
		if ( ! empty( $value['city'] ) ) {
			$address[] = $value['city'];
		}
		if ( ! empty( $value['state'] ) ) {
			$address[] = $value['state'];
		}
		if ( ! empty( $value['zip'] ) ) {
			$address[] = $value['zip'];
		}
		if ( ! empty( $value['country'] ) ) {
			$address[] = $value['country'];
		}

		$formatted = implode( ', ', array_map( 'esc_html', $address ) );
		$url       = sprintf( 'https://www.google.com/maps/place/%1$s', implode( ',+', array_map( 'rawurlencode', $address ) ) ); ?>

		<address>
			<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
				<i class="dashicons dashicons-location" aria-hidden="true" style="font-size:inherit;height:auto;width:auto;margin-top:-2px;margin-right:2px;vertical-align:middle;"></i>
				<span><?php echo esc_html( $formatted ); ?></span>
			</a>
		</address>

	<?php }

	/**
	 * Piece Name
	 *
	 * @since 4.0.0
	 * @param array  $field An array of field arguments.
	 * @param string $piece The address piece to reference.
	 */
	protected function piece_name( array $field = array(), string $piece = '' ) {
		printf(
			'%1$s[%2$s]',
			esc_attr( $field['name'] ),
			esc_attr( $piece )
		);
	}

	/**
	 * Render
	 *
	 * @param array $field An array of field arguments.
	 * @return void
	 */
	public function render( array $field = array() ): void {

		$values = wp_parse_args( $field['value'], $this->default_address ); ?>

		<span 
		class="<?php $this->root_class( $field, array( 'wp-backstage-address-field' ) ); ?>"
		id="<?php $this->element_id( $field, 'container' ); ?>"
		data-field-type="<?php echo esc_attr( $field['type'] ); ?>"
		data-field-id="<?php $this->element_id( $field ); ?>">

			<span 
			id="<?php $this->element_id( $field, 'controls' ); ?>"
			class="wp-backstage-address-field__controls">

				<span 
				id="<?php $this->element_id( $field, 'country_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--country">

					<label for="<?php $this->element_id( $field, 'country' ); ?>"><?php
						echo wp_kses( _x( 'Country', 'address field - country label', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<select
					id="<?php $this->element_id( $field, 'country' ); ?>"
					name="<?php $this->piece_name( $field, 'country' ); ?>"
					<?php $this->input_attrs( $field, array( 'id', 'name' ) ); ?>>

						<?php foreach ( $this->countries as $country_code => $country_label ) { ?>

							<option 
							value="<?php echo esc_attr( $country_code ); ?>"
							<?php selected( $country_code, $values['country'] ); ?>><?php
								echo esc_html( $country_label );
							?></option>

						<?php } ?>

					</select>

				</span>

				<span 
				id="<?php $this->element_id( $field, 'address_1_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--address-1">

					<label for="<?php $this->element_id( $field, 'address_1' ); ?>"><?php
						echo wp_kses( _x( 'Address', 'address field - line 1', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<input 
					type="text" 
					id="<?php $this->element_id( $field, 'address_1' ); ?>"
					name="<?php $this->piece_name( $field, 'address_1' ); ?>"
					value="<?php echo esc_attr( $values['address_1'] ); ?>"
					<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value' ) ); ?> />

				</span>

				<span 
				id="<?php $this->element_id( $field, 'address_2_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--address-2">

					<label for="<?php $this->element_id( $field, 'address_2' ); ?>"><?php
						echo wp_kses( _x( 'Address (Line 2)', 'address field - line 2', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<input 
					type="text" 
					id="<?php $this->element_id( $field, 'address_2' ); ?>"
					name="<?php $this->piece_name( $field, 'address_2' ); ?>"
					value="<?php echo esc_attr( $values['address_2'] ); ?>"
					<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value' ) ); ?> />

				</span>

				<span 
				id="<?php $this->element_id( $field, 'city_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--city">

					<label for="<?php $this->element_id( $field, 'city' ); ?>"><?php
						echo wp_kses( _x( 'City', 'address field - city', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<input 
					type="text" 
					id="<?php $this->element_id( $field, 'city' ); ?>"
					name="<?php $this->piece_name( $field, 'city' ); ?>"
					value="<?php echo esc_attr( $values['city'] ); ?>"
					<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value' ) ); ?> />

				</span>

				<span 
				id="<?php $this->element_id( $field, 'state_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--state">

					<label for="<?php $this->element_id( $field, 'state' ); ?>"><?php
						echo wp_kses( _x( 'State / Province / Region', 'address field - state input', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<input 
					type="text" 
					id="<?php $this->element_id( $field, 'state' ); ?>"
					name="<?php $this->piece_name( $field, 'state' ); ?>"
					value="<?php echo esc_attr( $values['state'] ); ?>"
					<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value' ) ); ?> />

				</span>

				<span 
				id="<?php $this->element_id( $field, 'us_state_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--us-state"
				style="display:none;">

					<label for="<?php $this->element_id( $field, 'us_state' ); ?>"><?php
						echo wp_kses( _x( 'State', 'address field - state select', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<select
					id="<?php $this->element_id( $field, 'us_state' ); ?>"
					name="<?php $this->piece_name( $field, 'state' ); ?>"
					<?php $this->input_attrs( $field, array( 'id', 'name' ) ); ?>>

						<?php foreach ( $this->us_states as $us_state_code => $us_state_name ) { ?>

							<option 
							value="<?php echo esc_attr( $us_state_code ); ?>"
							<?php selected( $us_state_code, $values['state'] ); ?>><?php
								echo esc_html( $us_state_name );
							?></option>

						<?php } ?>

					</select>

				</span>

				<span 
				id="<?php $this->element_id( $field, 'zip_container' ); ?>"
				class="wp-backstage-address-field__control wp-backstage-address-field__control--zip">

					<label for="<?php $this->element_id( $field, 'zip' ); ?>"><?php
						echo wp_kses( _x( 'Zip Code', 'address field - zip', 'wp_backstage' ), 'wp_backstage_field_label' );
					?></label>

					<input 
					type="tel" 
					id="<?php $this->element_id( $field, 'zip' ); ?>"
					name="<?php $this->piece_name( $field, 'zip' ); ?>"
					value="<?php echo esc_attr( $values['zip'] ); ?>"
					<?php $this->input_attrs( $field, array( 'type', 'id', 'name', 'value' ) ); ?> />

				</span>

			</span>

		</span>

	<?php }

}
