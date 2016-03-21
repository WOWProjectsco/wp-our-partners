<?php
/**
 * Template Name: Partners
 *
 * Template for displaying the partners
 * @package WOWDevShop
 * @subpackage OurPartners
 * @since 1.1.0
 */
?>
<?php get_header(); ?>

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
				<div><h1><?php echo get_the_title($post); ?></h1></div>
				<?php the_content(); ?>
			</header><!-- .page-header -->
		<div class="widget widget_wowdevshop_our_partners">
			<div class="partners component partner_columns">
				<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					include( 'includes/templates/content-archive.php');

				// End the loop.
				endwhile; ?>
			</div>
		</div>

			<?php

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page'),
				'next_text'          => __( 'Next page'),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page') . ' </span>',
			) );

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
