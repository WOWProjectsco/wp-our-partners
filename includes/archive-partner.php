<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
* @package WordPress
* @subpackage WowDevShop_Our_Partners
* @author XicoOfficial
* @since 1.1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$args = array(
			'posts_per_page' => 100,
			'post_type' => 'partner',
			'orderby' => 'menu_order',
			'order' => 'ASC'
			);
		query_posts($args );

		if ( have_posts() ) : ?>

			<header class="page-header">
				<div><h1><?php echo __('Our Partners', 'our-partners-by-wowdevshop') ?></h1></div>
			</header><!-- .page-header -->
		<div class="widget widget_wowdevshop_our_partners">
			<div class="partners component partner_columns">
				<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					include( 'templates/content-archive.php');

				// End the loop.
				endwhile; ?>
			</div>
		</div>

			<?php

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'our-partners-by-wowdevshop'),
				'next_text'          => __( 'Next page', 'our-partners-by-wowdevshop'),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'our-partners-by-wowdevshop') . ' </span>',
			) );

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
