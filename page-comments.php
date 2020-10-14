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

            <?php $recent_comments = get_comments( array( 
                'number' => 10, // number of comments to retrieve.
                'status' => 'approve', // we only want approved comments.
                'post_status' => 'publish' // limit to published comments.
            ) );

            if ( $recent_comments ) {
                foreach ( (array) $recent_comments as $comment ) {
                    echo '<section class="news-post"><header><time>' . get_comment_date('n.j.y') . '</time><h5>' . $comment->comment_author . ' on <a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ). '</a>:</h5>' . $comment->comment_content . '</section>';
                    }
                }
            ?>



                <!--<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'maspops' ), 'after' => '</div>' ) ); ?>
                <?php pops_edit_bar(); ?>-->

        </article><!-- #content -->
        <?php get_sidebar(); ?>
    </div><!-- #primary -->


<?php get_footer(); ?>