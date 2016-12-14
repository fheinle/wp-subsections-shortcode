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
				'category'			=> 'about',
				'picture_size'	=> 'ImageTextBox',
				'type'					=> 'content',
			),
			$atts,
			$tags
		);

		$args = array(
			'post_type'              => array( 'page' ),
			'category_name'          => $atts['category'],
			'nopaging'               => true,
			'order'                  => 'ASC',
			'orderby'                => 'menu_order',
		);

		$formatted_list_of_posts = '';
		$category_pages = get_posts($args);
		if ( $atts['category'] == 'Kurs' ) {
			$formatted_list_of_posts .= '<div class="MainFloatLeftDiv"><table><tbody>';
			foreach ( $category_pages as $page ) {
				setup_postdata( $page );
				$content = apply_filters('the_content', get_the_content($page));
				$thumb = get_the_post_thumbnail($page, 'ImageTextBox');
				$formatted_list_of_posts .= '<tr><td>' . $thumb . '</td>';
				$formatted_list_of_posts .= '<td><h3>' . get_the_title($page) . '</h3>' . $content . '</td></tr>';
			}
			$formatted_list_of_posts .= '<table class="InternalTextBox"><tbody><tr><td colspan="2"><h3>' . get_the_title($page) . '</h3></td></tr>';
			$formatted_list_of_posts .= '</tbody></table></div>';

			switch ($atts['type']) {
			case 'excerpt':
				$formatted_list_of_posts .= '<tr><td class="ProfessionText">' . get_the_excerpt($page) . '</td></tr>';
				break;
			case 'content':
				$content = apply_filters('the_content', get_the_content($page));
				$formatted_list_of_posts .= '<tr><td>' . $content . '</td></tr>';
				break;
			case 'link':
				$formatted_list_of_posts .= '<tr><td><a href="' . get_the_excerpt($page) . '">' . get_the_content($page) . '</td></tr>';
				break;
			} /* TODO: Add custom symbol */

			$formatted_list_of_posts .= '</table>';
			if ($atts['type'] == 'excerpt') {
				$formatted_list_of_posts .= '</a>';
			}
			$formatted_list_of_posts .= '</div>';
		}
		wp_reset_postdata();
		$formatted_list_of_posts .= '<div class="FloatClearDiv"></div>';
		return $formatted_list_of_posts;
	}
	add_shortcode( 'subsection', 'subsection_shortcode' );
}
add_action('init', 'subsection_shortcode_init');
?>
