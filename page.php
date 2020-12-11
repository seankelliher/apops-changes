<?php
/**
 * @package WordPress
 * @subpackage maspops
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
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'maspops' ), 'after' => '</div>' ) ); ?>
				<?php pops_edit_bar(); ?>

		</article><!-- #content -->
		
        <?php 
            if ( is_page( '10284' ) ) { 
                get_sidebar( 'news' );
            }
            if ( is_page( '5796' ) ) { 
                get_sidebar( 'comments' );
            }
            if ( is_page( '5809' ) ) { 
                get_sidebar( 'news' );
            }
            if ( is_page( '5895' ) ) { 
                get_sidebar( 'comments' );
            }
            if ( is_page( '5801' ) ) { 
                get_sidebar( 'news' );
            }
            if ( is_page( '2422' ) ) { 
                get_sidebar( 'news' );
            }
        ?>

        <!--What Are POPS? - 10284-->
        <!--Our Mission - 5796-->
        <!--Our People - 5809-->
        <!--Our Organization - 5895-->
        <!--Our Website - 5801-->
        <!--Our Contact - 2422-->

	</div><!-- #primary -->


<?php get_footer(); ?>