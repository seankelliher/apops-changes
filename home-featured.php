<?php query_posts('posts_per_page=10&orderby=rand&post_type=pops_post'); ?>

<?php if (have_posts()) : ?>

<div class="home-section-featured">

    <?php while (have_posts()) : the_post(); ?>

        <article class="single-pops">

            <?php if (has_post_thumbnail()) : ?>

                <?php

                    $thumb_id = get_post_thumbnail_id( get_the_ID() );
                    $thumb_img = wp_get_attachment_image_src( $thumb_id, array(670,99999) );
                    $thumb_meta = get_post( $thumb_id );

                    //Get the first sentense of post content.
                    $paras = wpautop( get_the_content() );
                    $string = substr( $paras, 0, strpos( $paras, '.' ) + 1 );
                    $clean = strip_tags($string);

                ?>

                <div class="pops-image">

                  <figure>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'featured-pops' ); ?></a>
                  </figure>

                  <figcaption>
                    <?php echo $thumb_meta->post_excerpt; ?>
                  </figcaption>

                </div>

            <?php endif; ?>

        	<section class="featured-content">

        		<header class="post-header">

                    <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

    				<p><span class="meta-title"><?php typeOfSpace (); ?></span></p>

                    <p>Learn more about <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">this POPS</a>.</p>

                    <?php echo "<p>" . $clean . "</p>" ;?>

        		</header>

        	</section>

        </article>

    <?php endwhile; ?>

</div> <!--close .home-section-featured-->

<?php endif; ?>

<?php wp_reset_query(); ?>
