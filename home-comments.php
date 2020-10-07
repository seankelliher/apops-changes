<div class="home-section-news"> <!--home-section-comments-->
    
    <header class="news-header"> <!--comments-header-->
        <h2 class="section-title">Recent Comments</h2>
    </header>

            <?php $recent_comments = get_comments( array( 
                    'number' => 5, // number of comments to retrieve.
                    'status' => 'approve', // we only want approved comments.
                    'post_status' => 'publish' // limit to published comments.
                ) );

                if ( $recent_comments ) {
                    foreach ( (array) $recent_comments as $comment ) {
                        echo '<section class="news-post"><header><time>' . get_comment_date('n.j.y') . '</time><h5>' . $comment->comment_author . ' on <a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ). '</a>:</h5>' . $comment->comment_content . '</section>';
                        }
                    }
            ?>

    </section>

</div>