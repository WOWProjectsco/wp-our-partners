<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WOWDevShop
 * @subpackage OurPartners
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <?php the_post_thumbnail(); ?>

                <div class="entry-content">

                    <?php the_content(); ?>

                    <div class="entry-post-meta">
                    <?php
                        $custom_website = get_post_meta($post->ID, 'custom_website', true);
                        $custom_email = get_post_meta($post->ID, 'custom_email', true);
                        if($custom_website):
                    ?>
                            <span>Website: <a href="<?php echo $custom_website; ?>" target="_blank"><?php echo $custom_website; ?></a></span><br>
                        <?php
                        endif;
                        if($custom_email) : ?>
                            <span>Email: <a href="<?php echo 'mailto:' . $custom_email; ?>" target="_blank"><?php echo $custom_email; ?></a></span><br>
                        <?php endif; ?>
                        </div>

                        <?php
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:') . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page') . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );

                        if ( '' !== get_the_author_meta( 'description' ) ) {
                            get_template_part( 'template-parts/biography' );
                        }
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                        edit_post_link(
                            sprintf(
                                /* translators: %s: Name of current post */
                                __( 'Edit<span class="screen-reader-text"> "%s"</span>' ),
                                get_the_title()
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->

<?php

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            if ( is_singular( 'attachment' ) ) {
                // Parent post navigation.
                the_post_navigation( array(
                    'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
                ) );
            } elseif ( is_singular( 'partner' ) ) {
                // Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . 'Next' . '</span> ' .
                        '<span class="screen-reader-text">' . 'Next post:' . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . 'Previous' . '</span> ' .
                        '<span class="screen-reader-text">' . 'Previous post:' . '</span> ' .
                        '<span class="post-title">%title</span>',
                ) );
            }

            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
