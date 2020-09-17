<div class="home-section-comments"> <!--home-section-comments-->
    
    <header class="comments-header"> <!--comments-header-->
        <h2 class="section-title">Recent Comments</h2>
    </header>

            <?php $recent_comments = get_comments( array( 
                    'number' => 5, // number of comments to retrieve.
                    'status' => 'approve', // we only want approved comments.
                    'post_status' => 'publish' // limit to published comments.
                ) );

                if ( $recent_comments ) {
                    foreach ( (array) $recent_comments as $comment ) {
                        echo '<section class="comments-post">' . get_comment_author( $comment ) . ' on <a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a></section>';
                        }
                    }
            ?>

    </section>

</div>