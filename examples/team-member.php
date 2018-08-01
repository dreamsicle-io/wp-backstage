<?php

/**
 * WPCPT Init
 *
 * Initialize all custom post types in this
 * function, which is then called by the 
 * `after_setup_theme` hook. 
 */
function wpcpt_init_team_members() {

	WP_CPT::add( 'team_member', array(
		'menu_name'      => __( 'Team', 'wpcpt' ), 
		'singular_name'  => __( 'Team Member', 'wpcpt' ), 
		'plural_name'    => __( 'Team Members', 'wpcpt' ), 
		'description'    => __( 'The team at our wonderful company.', 'wpcpt' ), 
		'singular_base'  => 'team/member', 
		'archive_base'   => 'team', 
		'rest_base'      => 'team-members', 
		'group_meta_key' => 'wpcpt_team_member_meta',
		'meta_boxes'     => array(
			array(
				'id'          => 'wpcpt_team_member_socials', 
				'title'       => __( 'Team Member Socials', 'wpcpt' ), 
				'description' => __( 'These extra meta fields control the team members social links. <a href="#">Example Link</a>', 'wpcpt' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => array(
					array( 
						'type'        => 'url', 
						'name'        => 'wpcpt_team_member_fb_url', 
						'label'       => __( 'Facebook URL', 'wpcpt' ), 
						'description' => __( 'Enter a valid Facebook URL.', 'wpcpt' ), 
					),
					array( 
						'type'        => 'url', 
						'name'        => 'wpcpt_team_member_instagram_url', 
						'label'       => __( 'Instagram URL', 'wpcpt' ), 
						'description' => __( 'Enter a valid Instagram URL.', 'wpcpt' ), 
					),
				), 
			),
			array(
				'id'          => 'wpcpt_team_member_details', 
				'title'       => __( 'Team Member Details', 'wpcpt' ), 
				'description' => __( 'These extra meta fields control the team members extra information. <a href="#">Example Link</a>', 'wpcpt' ), 
				'context'     => 'normal', 
				'priority'    => 'high', 
				'fields'      => array(
					array( 
						'type'        => 'text', 
						'name'        => 'wpcpt_team_member_impressum', 
						'label'       => __( 'Impressum', 'wpcpt' ), 
						'description' => __( 'Enter a small blurb about this team member.', 'wpcpt' ), 
					),
				), 
			),
		), 
	) );

}

add_action( 'after_setup_theme', 'wpcpt_init_team_members', 10 );
