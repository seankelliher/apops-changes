<?php
/**
 * @package WordPress
 * @subpackage maspops
 */
//
// There is a plugin, the last developer modified the source code to add extra comment fields
// Plugin in use is ExtendComment
//
// Comment images are attached using the CommentImages plugin.
//

if ( ! function_exists( 'maspops_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function maspops_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        $comment_type = get_comment_meta( $comment->comment_ID, 'comment-type', true );
        if ($comment_type == 'comment')
          $comment_type = '';
        switch ( $comment->comment_type ) :
                case '' :
                case 'comment' :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment <?php echo $comment_type;?>" role="article">
                        <header>
                                <div class="comment-author vcard">
                                        <?php echo get_avatar( $comment, 40 ); ?>
                                        <?php printf( __( '%s <span class="says">says:</span>', 'maspops' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                                </div><!-- .comment-author .vcard -->
                                <?php if ( $comment->comment_approved == '0' ) : ?>
                                        <em><?php _e( 'Your comment is awaiting moderation.', 'maspops' ); ?></em>
                                        <br />
                                <?php endif; ?>

                                <div class="comment-meta commentmetadata">
                                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
                                        <?php
                                                /* translators: 1: date, 2: time */
                                                printf( __( '%1$s at %2$s', 'maspops' ), get_comment_date(),  get_comment_time() ); ?>
                                        </time></a>
                                        <?php edit_comment_link( __( '(Edit)', 'maspops' ), ' ' );
                                        ?>
                                </div><!-- .comment-meta .commentmetadata -->
                        </header>

                        <div class="comment-body"><?php comment_text(); ?></div>

                        <footer class="reply">
                                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                        </footer><!-- .reply -->
                </article><!-- #comment-##  -->

        <?php
                        break;
                case 'pingback'  :
                case 'trackback' :
        ?>
        <li class="post pingback">
                <p><?php _e( 'Pingback:', 'maspops' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'maspops'), ' ' ); ?></p>
        <?php
                        break;
        endswitch;
}
endif; // ends check for maspops_comment()

?>

        <div id="comments">
        <?php if ( post_password_required() ) : ?>
                <div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'maspops' ); ?></div>
        </div><!-- .comments -->
        <?php return;
                endif;
        ?>

        <?php // You can start editing here -- including this comment! ?>

        <?php if ( have_comments() ) : ?>
                <h3 id="comments-title">
                        <?php
                            printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'maspops' ),
                                number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
                        ?>
                </h3>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav id="comment-nav-above" role="article">
                        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'maspops' ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'maspops' ) ); ?></div>
                </nav>
                <?php endif; // check for comment navigation ?>

                <ol class="commentlist">
                        <?php wp_list_comments( array( 'callback' => 'maspops_comment' ) ); ?>
                </ol>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav id="comment-nav-below" role="article">
                        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'maspops' ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'maspops' ) ); ?></div>
                </nav>
                <?php endif; // check for comment navigation ?>

        <?php else : // this is displayed if there are no comments so far ?>

                <?php if ( comments_open() ) : // If comments are open, but there are no comments ?>

                <?php else : // or, if we don't have comments:

                        /* If there are no comments and comments are closed,
                         * let's leave a little note, shall we?
                         * But only on posts! We don't really need the note on pages.
                         */
                        if ( ! comments_open() && ! is_page() ) :
                        ?>
                        <p class="nocomments"><?php // _e( 'Comments are closed.', 'maspops' ); ?></p>
                        <?php endif; // end ! comments_open() && ! is_page() ?>


                <?php endif; ?>

        <?php endif; ?>

        <?php comment_form( array( 'label_submit' => 'Submit' ) ); ?>

</div><!-- #comments -->