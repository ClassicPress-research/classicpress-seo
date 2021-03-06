<?php
/**
 * The taxonomies settings.
 *
 * @package    Classic_SEO
 * @subpackage Classic_SEO\Settings
 */

use Classic_SEO\Helper;

$taxonomy     = $tab['taxonomy'];
$taxonomy_obj = get_taxonomy( $taxonomy );
$name         = $taxonomy_obj->labels->singular_name;

$metabox_default = 'off';
$custom_default  = 'off';

if ( 'category' === $taxonomy ) {
	$metabox_default = 'on';
	$custom_default  = 'off';
} elseif ( 'post_tag' === $taxonomy ) {
	$metabox_default = 'off';
	$custom_default  = 'on';
} elseif ( 'post_format' === $taxonomy ) {
	$custom_default = 'on';
}

$cmb->add_field([
	'id'              => 'cpseo_tax_' . $taxonomy . '_title',
	'type'            => 'text',
	/* translators: taxonomy name */
	'name'            => sprintf( esc_html__( '%s Archive Titles', 'cpseo' ), $name ),
	/* translators: taxonomy name */
	'desc'            => sprintf( esc_html__( 'Title tag for %s archives', 'cpseo' ), $name ),
	'classes'         => 'cpseo-supports-variables cpseo-title',
	'default'         => '%term% Archives %page% %sep% %sitename%',
	'sanitization_cb' => [ '\Classic_SEO\CMB2', 'sanitize_textfield' ],
	'attributes'      => [ 'data-exclude-variables' => 'seo_title,seo_description' ],
]);

$cmb->add_field([
	'id'              => 'cpseo_tax_' . $taxonomy . '_description',
	'type'            => 'textarea_small',
	/* translators: taxonomy name */
	'name'            => sprintf( esc_html__( '%s Archive Descriptions', 'cpseo' ), $name ),
	/* translators: taxonomy name */
	'desc'            => sprintf( esc_html__( 'Description for %s archives', 'cpseo' ), $name ),
	'classes'         => 'cpseo-supports-variables cpseo-description',
	'attributes'      => [
		'class'             => 'cmb2-textarea-small wp-exclude-emoji',
		'data-gramm_editor' => 'false',
		'data-exclude-variables' => 'seo_title,seo_description',
	],
	'sanitization_cb' => true,
]);

$cmb->add_field([
	'id'      => 'cpseo_tax_' . $taxonomy . '_custom_robots',
	'type'    => 'switch',
	/* translators: taxonomy name */
	'name'    => sprintf( esc_html__( '%s Archives Robots Meta', 'cpseo' ), $name ),
	/* translators: taxonomy name */
	'desc'    => sprintf( wp_kses_post( __( 'Select custom robots meta, such as <code>nofollow</code>, <code>noarchive</code>, etc. for %s archive pages. Otherwise the default meta will be used, as set in the Global Meta tab.', 'cpseo' ) ), strtolower( $name ) ),
	'options' => [
		'off' => esc_html__( 'Default', 'cpseo' ),
		'on'  => esc_html__( 'Custom', 'cpseo' ),
	],
	'default' => $custom_default,
]);

$cmb->add_field([
	'id'                => 'cpseo_tax_' . $taxonomy . '_robots',
	'type'              => 'multicheck',
	/* translators: taxonomy name */
	'name'              => sprintf( esc_html__( '%s Archives Robots Meta', 'cpseo' ), $name ),
	'desc'              => esc_html__( 'Custom values for robots meta tag on homepage.', 'cpseo' ),
	'options'           => Helper::choices_robots(),
	'select_all_button' => false,
	'dep'               => [ [ 'cpseo_tax_' . $taxonomy . '_custom_robots', 'on' ] ],
]);

$cmb->add_field([
	'id'              => 'cpseo_tax_' . $taxonomy . '_advanced_robots',
	'type'            => 'advanced_robots',
	/* translators: taxonomy name */
	'name'            => sprintf( esc_html__( '%s Archives Advanced Robots Meta', 'cpseo' ), $name ),
	'sanitization_cb' => [ '\Classic_SEO\CMB2', 'sanitize_advanced_robots' ],
	'dep'             => [ [ 'cpseo_tax_' . $taxonomy . '_custom_robots', 'on' ] ],
]);

$cmb->add_field([
	'id'      => 'cpseo_tax_' . $taxonomy . '_add_meta_box',
	'type'    => 'switch',
	'name'    => esc_html__( 'Add SEO Meta Box', 'cpseo' ),
	'desc'    => esc_html__( 'Add the SEO Meta Box for the term editor screen to customize SEO options for individual terms in this taxonomy.', 'cpseo' ),
	'default' => $metabox_default,
]);

$cmb->add_field([
	'id'      => 'cpseo_remove_' . $taxonomy . '_snippet_data',
	'type'    => 'switch',
	'name'    => esc_html__( 'Remove Snippet Data', 'cpseo' ),
	/* translators: taxonomy name */
	'desc'    => sprintf( esc_html__( 'Remove schema data from %s.', 'cpseo' ), $name ),
	'default' => ( in_array( $taxonomy, [ 'product_cat', 'product_tag' ], true ) ) ? 'on' : 'off',
]);

if ( 'post_format' === $taxonomy ) {
	$cmb->remove_field( 'cpseo_tax_' . $taxonomy . '_add_meta_box' );
	$cmb->remove_field( 'cpseo_remove_' . $taxonomy . '_snippet_data' );
}
