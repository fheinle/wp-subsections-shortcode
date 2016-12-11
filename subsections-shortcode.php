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
				'category' => 'about',
				'picture_size' => 'ImageTextBox'
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

				$formatted_list_of_posts .= '<a class="ImageTextBox BackgroundColorLightGrey"' . get_the_post_link() . '">' . get_the_title() . '\n';
				if (has_post_thumbnail()) {
					$formatted_list_of_posts .= get_the_post_thumbnail($atts->picture_size) . '\n';
				}
				$formatted_list_of_posts .= '<table class="InternalTextBox"><tbody><tr><td colspan="2"><h3>' . get_the__title() . '</h3></td></tr>\n';
				if (has_excerpt()) {
					$formatted_list_of_posts .= '<tr><td class="ProfessionText">' . get_the_excerpt() . '</td></tr>\n';
				} /* TODO: Add custom symbol */
				$formatted_list_of_posts .= '</table>';
			}
		} else {
			$formatted_list_of_posts = "";
		}
		return $formatted_list_of_posts;
	}
	add_shortcode( 'subsection', 'subsection_shortcode' );
}
add_action('init', 'subsection_shortcode_init');
?>
