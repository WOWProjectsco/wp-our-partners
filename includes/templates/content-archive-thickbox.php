<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage WOWProjects_Our_Partners
 * @since 1.3.0
 **/
?>

<!--
// lighbox with all the content that shows on click
-->
<?php add_thickbox(); ?>
<div id="lighbox-partner-<?php the_ID(); ?>" style="display:none;">
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
	<?php the_content(); ?>
	<div class="entry-post-meta">
        <?php
        $custom_website = get_post_meta($post->ID, 'custom_website', true);
        $custom_email = get_post_meta($post->ID, 'custom_email', true);
        if($custom_website):
            echo "<span>" . __('Website:',  'our-partners-by-wowdevshop') . " <a href='" . $custom_website . "' target='_blank'>" . $custom_website . "</a></span><br>";
        endif;
        if($custom_email) :

            echo "<span>" . __('Email:', 'our-partners-by-wowdevshop') . " <a href='mailto:" . $custom_email. "' target='_blank'>" . $custom_email . "</a></span><br>";
        endif; ?>
	</div>
</div>
