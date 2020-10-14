<?php
/**
 * Template Name: Comments Archive
 * Description: A page template to display all comments.
 *
 * @package WordPress
 *@subpackage maspops
 */

get_header(); 
the_post();
?>

    <div class="content-wrap with-sidebar row">
        <article id="content" role="article">
            <?php pops_edit_bar(); ?>
            <header>
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'maspops' ), 'after' => '</div>' ) ); ?>
                <?php pops_edit_bar(); ?>

        </article><!-- #content -->
        <?php get_sidebar(); ?>
    </div><!-- #primary -->


<?php get_footer(); ?>