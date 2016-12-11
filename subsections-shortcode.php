<?php
/*
Plugin Name: Subsections Shortcode
Plugin URI: https://github.com/wp-subsections shortcode
Description: Retrieve all pages with a given category
Version: 1.0
Author: Florian Heinle
Author URI: https://www.florianheinle.de
License: GPL2
*/

function subsection_shortcode_init()
{
	function subsection_shortcode($atts = [], $content = null, $tag = '') {
		$atts = array_change_key_case((array)$atts, CASE_LOWER);
		$atts = shortcode_atts(
			array(
				'category' => 'about'
			),
			$atts,
			$tags
		);
		$args = array(
			'post_type'              => array( 'page' ),
			'category_name'          => $atts->category,
			'nopaging'               => true,
			'order'                  => 'ASC',
			'orderby'                => 'menu_order',
		);
		$category_pages = new WP_QUERY($args);
		if ($category_pages->have_posts()) {
			$formatted_list_of_posts = "<ul>\n";
			while ($category_pages->have_posts()) {
				$category_pages->the_post();
				$formatted_list_of_posts = $formatted_list_of_posts . "<li>Titel:" . get_the_title() . "</li>\n";
			}
			$formatted_list_of_posts = $formatted_list_of_posts . "</ul>\n";

		} else {
			$formatted_list_of_posts = "";
		}
		return $formatted_list_of_posts;
	}
	add_shortcode( 'subsection', 'subsection_shortcode' );
}
add_action('init', 'subsection_shortcode_init');
?>
