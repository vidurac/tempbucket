<?php
/**
 * utility theme Theme Customizer
 *
 * @package blogster_utility
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogster_utility_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'blogster_utility_customize_register' );
$custom_header = array(
	'default-image'          => '',
	'width'                  => 1000,
	'height'                 => 500,
	'flex-height'            => false,
	'flex-width'             => false,
	'uploads'                => true,
	'random-default'         => false,
	'header-text'            => true,
	'default-text-color'     => '',
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $custom_header );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogster_utility_customize_preview_js() {
	wp_enqueue_script( 'blogster_utility_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blogster_utility_customize_preview_js' );
function blogster_utility_theme_customizer( $wp_customize ) {

	$wp_customize->add_section( 'footer_settings_section', array(
		'title' => __( 'Footer Credit', 'blogster-utility' ),
	) );

	$wp_customize->add_setting( 'text_setting', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_textarea_field'
	) );

	$wp_customize->add_control( 'text_setting', array(
		'label'   => __( 'Footer Credit', 'blogster-utility' ),
		'section' => 'footer_settings_section',
		'type'    => 'textarea',
	) );        

}

add_action( 'customize_register', 'blogster_utility_theme_customizer' );
