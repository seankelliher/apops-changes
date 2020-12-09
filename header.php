<?php
/**
 * @package WordPress
 * @subpackage maspops
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<head>
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35413373-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />

<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  //bloginfo( 'name' );

  // Add the blog description for the home/front page.
  //$site_description = get_bloginfo( 'description', 'display' );
  //if ( $site_description && ( is_home() || is_front_page() ) )
    //echo " | $site_description";

  // Add a page number if necessary:
  //if ( $paged >= 2 || $page >= 2 )
    //echo ' | ' . sprintf( __( 'Page %s', 'maspops' ), max( $paged, $page ) );

  ?></title>



  <!--  Mobile Viewport Fix -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
  <link rel="icon" href="/favicon.png" />

  <meta name="apple-mobile-web-app-capable" content="yes" />

  <link rel="profile" href="http://gmpg.org/xfn/11" />

  <!--[if lt IE 9]>
  <link rel="stylesheet" href="/wp-content/themes/mas_pops/assets/css/style-ie.1380064388.css">
  <![endif]-->

  <!--[if (gt IE 8)|!(IE)]><!-->
  <link rel="stylesheet" href="/wp-content/themes/mas_pops/assets/css/style.1380064388.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/wp-content/themes/mas_pops/assets/css/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="/wp-content/themes/mas_pops/assets/css/custom.css?v5">
  <!--<![endif]-->

  <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <script type="text/javascript" src="https://apops.mas.org/wp-content/themes/mas_pops/assets/js/components/modernizr/modernizr.js"></script>

  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.6/slick.css"/>
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
  <div class="main-wrap">
    <header id="branding" role="banner" data-access="access">
      <a class="logo-wrap" href="<?php echo home_url( '/' ); ?>" title="Back to home" rel="home">
        <div>
          <span class="visuallyhidden"><?php bloginfo( 'name' ); ?></span>
          <h1>P<span>rivately</span> O<span>wned</span> P<span>ublic</span> S<span>pace</span></h1>
          <p><?php echo of_get_option( "banner_sub_text" ); ?></p>
        </div>
      </a>
      <div class="skip-link visuallyhidden"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'maspops' ); ?>"><?php _e( 'Skip to content', 'maspops' ); ?></a></div>
      <div class="partner-logos">
        <?php if( $partner_label = of( "partner_label" ) ): ?>
        <h5><?php echo $partner_label; ?></h5>
        <?php endif; ?>
          <a class="apops-logo" href="<?php echo of( "pops_link_url" ); ?>" title="<?php echo of( "pops_link_label" ); ?>"><?php echo of( "pops_link_label" ); ?></a>
          <a class="mas-logo" href='<?php echo of_get_option( "mas_link_url" ); ?>' title="<?php echo of_get_option("mas_link_label"); ?>"><?php echo of_get_option( "mas_link_label" ); ?></a>
      </div>
    </header><!-- #branding -->

    <nav id="access" role="article" class="main-nav">
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => false, 'container' => '' ) ); ?>
    </nav><!-- #access -->

    <div class="page-wrap">
