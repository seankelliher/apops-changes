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

                    //Get the post content.
                    $paras = wpautop( get_the_content() );

                    //Get part between 0 and 200.
                    $string = substr( $paras, 0, 200 );

                    //Strip the html tags.
                    $clean = strip_tags($string);

                    //Divide $string into two parts.
                    $stringPart1a = substr( $clean, 0, 150 );
                    $stringPart2a = substr( $clean, 150, 180 );

                    //In second string, extract part between 0 and "first space".
                    $stringPart2b = substr( $stringPart2a, 0, strpos( $stringPart2a, " " ));

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

                    <p><?php echo $stringPart1a . $stringPart2b ;?>...<a href="<?php the_permalink(); ?>" ?>continued</a>.</p>

        		</header>

        	</section>

        </article>

    <?php endwhile; ?>

</div> <!--close .home-section-featured-->

<?php endif; ?>

<?php wp_reset_query(); ?>
