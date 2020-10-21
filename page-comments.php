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

            <?php
                //Page variables.
                $page = (!empty($_GET['userp'])) ? $_GET['userp'] : 1;
                $per_page = 10;
                $offset = ( ($page -1) * $per_page);

                //Arguments for the comments.
                $args = array(
                    'status' => 'approve', //Comment is approved.
                    'post_status' => 'publish' //Post is published.
                );

                //Retrieve the comments.
                $all_comments = get_comments( $args );

                if ( $all_comments ) {
                    foreach ( (array) $all_comments as $comment ) {
                        echo '<section class="news-post"><header><time>' . get_comment_date('n.j.y') . '</time><h5>' . $comment->comment_author . ' on <a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ). '</a>:</h5>' . $comment->comment_content . '</section>';
                        }
                    }

                //Arguments for the "paginate_links".
                $page_args = array(
                    'base'         => get_permalink( get_the_ID() ). '%_%',
                    'format'       => add_query_arg(array('userp' => '%#%')),
                    'total'        => ceil($users->total_users / $per_page),
                    'current'      => $page,
                    'show_all'     => True,
                    'end_size'     => 2,
                    'mid_size'     => 2,
                    'prev_next'    => True,
                    'prev_text'    => __('« Previous'),
                    'next_text'    => __('Next »'),
                    'type'         => 'plain',
                );

                //Display the "paginate_links".
                echo paginate_links($page_args);
            ?>

        </article><!-- #content -->
        <?php get_sidebar(); ?>
    </div><!-- #primary -->


<?php get_footer(); ?>