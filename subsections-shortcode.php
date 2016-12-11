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
	function subsection_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'category' => 'about',
			),
			$query_pages_with_category = array(
				'post-type'	=> 'page',
				'order'		=> 'ASC',
				'orderby'	=> 'menu_order',
				'taxonomy'	=> 'category',
				'field'		=> 'slug',
				'term'		=> $atts->category;
			)
			$category_pages = new WP_QUERY($query_pages_with_category);
	?>
	<ul>
	<?php
			foreach (category_pages as category_page)
			{
				?><li><?php echo $category_page->post_title; ?></li>
		<?php
			}
		?>
	</ul>
		);

	}
	add_shortcode( 'subsection', 'subsection_shortcode' );
}
add_action('init', 'subsection_shortcode_init');
?>
