<div id="featured-items" class="home-section-items">

    <header class="featured-submission-bar">
        <h2 class="section-title">Featured Items</h2>
    </header>

    <?php $args = array(
        'post_type' => 'post',
        //'post_type' => 'featured-submission',
        'numberposts' => '3',
        'post_status' => 'publish',
        'tag' => 'featured-item',
    );

    $recent_posts = wp_get_recent_posts($args);?>

    <div class="featured-submission-content-item">

       <?php foreach( $recent_posts as $recent ){?>
            <article class="featured-submission-item">
                <?php echo
                    '<header>
                        <time>' . get_comment_date('n.j.y') . '</time>
                        <h2 class="title">' .  $recent["post_title"] . '</h2>     
                    </header>
                    <p>';
                ?>
                <?php if ( has_post_thumbnail($recent["ID"]) ) {
                    echo get_the_post_thumbnail($recent["ID"],'thumbnail', array( 'class' => 'alignleft' ) );
                };?>
                <?php echo get_the_excerpt($recent["ID"]) . ' <a href="' . get_permalink($recent["ID"]) . '">Read more</a></p>';
                 ?>
            </article>
            <?php
        }?>
    </div>

</div>