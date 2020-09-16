<?php
/**
 * Template Name: Home Page Template
 * Description: A page template with a map
 *
 * @package WordPress
 *@subpackage maspops
 */

get_header(); ?>

          
  <div class="row">

    <div class="home-right">
    <?php get_template_part( "content/home", "participate" ); ?>
    <?php get_template_part( "content/home", "news" ); ?>
    <?php get_template_part( "content/home", "comments" ); ?>
    </div>
    <div class="home-left">
    <?php get_template_part( "content/home", "featured" ); ?>
    <?php get_template_part( "content/home", "submissions" ); ?>
    </div>
    

  </div>

      


<?php get_footer(); ?>