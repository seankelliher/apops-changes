<div id="featured-items" class="home-section-items">

    <header class="featured-submission-bar">
        <h2 class="section-title">Featured Items</h2>
    </header>

    <?php $args = array(
        'post_type' => 'post',
        //'post_type' => 'featured-submission',
        'numberposts' => '4',
        'post_status' => 'publish',
        'tag' => 'featured-item',
    );

    $recent_posts = wp_get_recent_posts($args);?>

    <!--To add date to Featured Items, add below line inside <header>.-->
    <!--'<time>' . get_the_date('n.j.y', $recent["ID"]) . '</time>-->

    <div class="featured-submission-content-item">

       <?php foreach( $recent_posts as $recent ){?>
            <article class="featured-submission-item">
                <?php echo
                    '<header>
                        <h2 class="title">' .  $recent["post_title"] . '</h2>     
                    </header>';
                ?>
                <?php if ( has_post_thumbnail($recent["ID"]) ) {
                    echo get_the_post_thumbnail($recent["ID"],'thumbnail', array( 'class' => 'alignleft' ) ) . '<p>';
                };?>
                <?php echo get_the_excerpt($recent["ID"]) . '<span class="h5-like"> <a href="' . get_permalink($recent["ID"]) . '">read more</a></span></p>';
                 ?>
            </article>
            <?php
        }?>
    </div>

</div>