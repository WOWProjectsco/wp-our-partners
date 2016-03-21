
<?php
/**
 * The template part for displaying single posts
 *
 * @package WOWDevShop
 * @subpackage OurPartners
 **/
?>


				<article class="partner" id="partner-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<span class="sticky-post"><?php _e( 'Featured'); ?></span>
						<?php endif; ?>
						<figure>
							<?php

							if ( has_post_thumbnail()) {
							?>
								<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php the_post_thumbnail(); ?></a>
							<?php
							} else { ?>
								<img src="http://i1008.photobucket.com/albums/af208/XicoOfficial/WOWDevShop%20Websites/WordPress%20Plugins/Our%20Partners%20by%20WOWDevshop/partner_00_default_zpskfrxlpgd.png">
							<?php
							}
							?>
						</figure>
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

					</header><!-- .entry-header -->

					<?php the_excerpt(); ?>


					<footer class="entry-footer">
						<?php
							edit_post_link(
								sprintf(
									/* translators: %s: Name of current post */
									__( 'Edit<span class="screen-reader-text"> "%s"</span>'),
									get_the_title()
								),
								'<span class="edit-link">',
								'</span>'
							);
						?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->
