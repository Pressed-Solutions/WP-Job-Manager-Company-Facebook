<?php
/*
Plugin Name: WP Job Manager - Company Facebook
Plugin URI: https://github.com/pressedsolutions/wp-job-manager-company-facebook
Description: Adds a company Facebook URL field to the Job Data when posting a new job.
Version: 1.0.
Author: Andrew Minion
Author URI: http://andrewrminion.com
Requires at least: 3.8
Tested up to: 4.0

	Copyright: 2014 Andrew Minion
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds a company Facebook field
 */
add_filter( 'submit_job_form_fields', 'wpjbFB_add_facebook' );
function wpjbFB_add_facebook() {
    $fields['job']['company_facebook'] = array(
        'label' => __( 'Company Facebook', 'job_manager' ),
        'type' => 'text',
        'required' => false,
        'placeholder' => __( 'Full Facebook URL, e.g. "http://facebook.com/example-page"', 'job_manager' ),
        'priority' => 6
    );
    return $fields;
}
// save submitted info
add_action( 'job_manager_update_job_data', 'wpjbFB_add_facebook_save', 10, 2 );
function wpjbFB_add_facebook_save( $job_id, $values ) {
    update_post_meta( $job_id, '_company_facebook', $values['job']['company_facebook'] );
}
// add to admin metaboxes
add_filter( 'job_manager_job_listing_data_fields', 'wpjbFB_admin_add_facebook' );
function wpjbFB_admin_add_facebook( $fields ) {
    $fields['_company_facebook'] = array(
        'label' => __( 'Company Facebook', 'job_manager' ),
        'type' => 'text',
        'placeholder' => __( 'Full Facebook URL, e.g. "http://facebook.com/example-page"', 'job_manager' ),
        'description' => ''
        );
    return $fields;
}

/**
 * Display or retrieve the current company facebook link with optional content.
 *
 * @access public
 * @param mixed $id (default: null)
 * @return void
 */
function the_company_facebook( $before = '', $after = '', $echo = true, $post = null ) {
	$company_facebook = get_the_company_facebook( $post );

	if ( strlen( $company_facebook ) == 0 )
		return;

	$company_facebook = esc_attr( strip_tags( $company_facebook ) );
	$company_facebook = $before . '<a href="' . $company_facebook . '" class="company_facebook" target="_blank">Facebook</a>' . $after;

	if ( $echo )
		echo $company_facebook;
	else
		return $company_facebook;
}

/**
 * get_the_company_facebook function.
 *
 * @access public
 * @param int $post (default: 0)
 * @return void
 */
function get_the_company_facebook( $post = null ) {
	$post = get_post( $post );
	if ( $post->post_type !== 'job_listing' )
		return;

	$company_facebook = $post->_company_facebook;

	if ( strlen( $company_facebook ) == 0 )
		return;

	if ( strpos( $company_facebook, '@' ) === 0 )
		$company_facebook = substr( $company_facebook, 1 );

	return apply_filters( 'the_company_facebook', $company_facebook, $post );
}
