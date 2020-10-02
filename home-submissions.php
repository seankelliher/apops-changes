<?php 
global $featuredData, $featuredType; 

// Reassigning for brevity.
$fd = $featuredData;
$ft = $featuredType;

query_posts( "post_type=featured-submission&posts_per_page=10&orderby=date&order=desc" ); ?>

<div id="featured-items" class="home-section-items">
    <header class="featured-submission-header">
        <h2 class="section-title"><?php echo of_get_option( 'featured-submission-heading' ); ?></h2>
        <!--<span class="type">from APOPS</span>-->
    </header>
    <div class="featured-submission-content" data-transition="slide" data-paginate data-autoplay data-interval="<?php echo of( 'carousel-timing' ); ?>">

    <?php while( have_posts() ): 
        the_post(); 
        $fd->the_meta();
        $ft->the_meta();
        if (pops_get_date( $fd->get_the_value( "date" ), "Y-m-d", "n.j.y" )):
            $date = pops_get_date( $fd->get_the_value( "date" ), "Y-m-d", "n.j.y" );
        endif;
    ?>
        <article class="featured-submission-item" data-type="<?php $ft->the_value( "types" ); ?>" data-type-label="<?php pops_submission_label( $ft->get_the_value( 'types' ) ); ?>">
            <header>
                <h2 class="title"><?php the_title(); ?></h2>
                <div class="meta">
                    <?php if( $fd->get_the_value( "author" ) ): ?>
                    Submitted by: <span class="author"><?php $fd->the_value("author"); ?></span>
                    <?php endif; ?>
                    <?php if( $date ): ?>
                    <time datetime="<?php $fd->the_value( "date" ); ?>"><?php echo $date; ?></time>
                    <?php endif; ?>
                </div>
            </header>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
    </div>
</div>