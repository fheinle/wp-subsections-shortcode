<?php
/* Subsection navigation shortcode
 * Will provide list of posts with a given category
 * (C) 2016 Florian Heinle <launchpad@planet-tiax.de>
 * License: GPLv2
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
