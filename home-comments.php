<div class="home-section-comments"> <!--home-section-news-->
    <header class="comments-header"> <!--news-header-->
        <h2 class="section-title"><?php echo of_get_option( "news-heading" ); ?></h2>
    </header>

    <ul id="recentcomments">

        <?php $recent_comments = get_comments( array( 
                'number' => 5, // number of comments to retrieve.
                'status' => 'approve', // we only want approved comments.
                'post_status' => 'publish' // limit to published comments.
            ) );

            if ( $recent_comments ) {
                foreach ( (array) $recent_comments as $comment ) {
                    echo '<li><a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a></li>';
                    }
                }
     </ul>
     
</div>