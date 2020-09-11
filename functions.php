<?php
/**
 * @package WordPress
 * @subpackage maspops
 */

/** === Template Functions === */

/**
 * Wrapper function for of_get_option - an options framework function
 * @param String $id
 * @return Object/String
 */
function of( $id ) {
  return of_get_option( $id );
}

function mas_pops_iframe_api( $html ) {
    if ( false !== strpos( $html, 'youtube' ) ) {
        $html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1', $html );
    }
    return $html;
}
add_filter( 'oembed_result', 'mas_pops_iframe_api', 10, 1 );

/**
 * Custom settings page for global options.
 */

function theme_settings_page() {
    ?>
        <div class="wrap">
        <h1>APOPS Options</h1>
      <br />
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("apops-options");
                submit_button();
            ?>
        </form>
        </div>
    <?php
}

function add_theme_menu_item() {
  add_menu_page("APOPS Options", "APOPS Options", "manage_options", "apops-options", "theme_settings_page", null, 99);
}
add_action("admin_menu", "add_theme_menu_item");

function display_updated_date_element() { ?>
  <input type="text" style="width: 50%;" name="pops_updated_date" id="pops_updated_date" value="<?php echo get_option('pops_updated_date'); ?>" />
  <p>Enter text above to display in the right sidebar of each POPS profile.<br />For example: <strong>"The above information is current as of June 24, 2015."</strong></p>

<?php }

function display_theme_panel_fields() {
    add_settings_section("section", "POPS Settings", null, "apops-options");

    add_settings_field("pops_updated_date", "POPS Updated Text", "display_updated_date_element", "apops-options", "section");

  register_setting("section", "pops_updated_date");
}

add_action("admin_init", "display_theme_panel_fields");

/**
 * Action Handler for: wp_enqueue_scripts
 * Registers:
 * Google maps localized script
 * Google Map api
 * pops_map script
 */
function apops_register_scripts() {

  if( is_page_template( "page-templates/page-find.php" ) || is_singular( "pops_post" ) ) {

    $small = get_stylesheet_directory_uri() . "/assets/img/png/map/map-icon-small.png";
    $large = get_stylesheet_directory_uri() . "/assets/img/png/map/map-icon-large.png";
    $shadow = get_stylesheet_directory_uri() . "/assets/img/png/map/map-icon-large-shadow.png";

    $markers = array( "small" => $small, "large" => $large, "shadow" => $shadow );
    $single = is_singular( "pops_post" ) ? get_permalink() : false;


    $map = array( "single" => $single, "markers" => $markers, "filtered" => false );


    wp_enqueue_script( 'gmaps', "//maps.googleapis.com/maps/api/js?key=AIzaSyB6kILhxOQbf0B79YGbxSHoJ5QOofZhG2E&sensor=true", array(), null, false );

    wp_localize_script( 'gmaps', 'pops_map', $map );

    //wp_enqueue_script( 'pops_map', get_asset( "/assets/js/popsmap.js" ), array( 'gmaps' ), null, true );
    wp_enqueue_script( 'pops_map', "https://apops.mas.org/wp-content/themes/mas_pops/assets/js/popsmap.js", array( 'gmaps' ), null, true );
  }

}

/**
 * Gets the asset path and determines which one to load based on file extension.
 * @param string $filename
 * @return string
 */
function get_asset( $filename ) {

  $path = "";
  $base_url = get_stylesheet_directory_uri();
  $filetype = wp_check_filetype($filename);

  switch ( $filetype['ext'] ) {
    case "css":
      $path = $base_url . "/assets/css/" . $filename;
      break;
    case "js":
      $path = $base_url . "/assets/js/" . $filename;
      break;
    default:
      $path = $base_url . $filename;
      break;
  }

  return $path;
}

/**
 * Filter handler for: excerpt_length
 * @return Integer
 */
function custom_excerpt_length( $length ) {
  return 20;
}

/**
 * Filter handler for: excerpt_more
 * @return String
 */
function new_excerpt_more( $more ) {
  return ''; //<a class="read-more" href="'. get_permalink( get_the_ID() ) . '">learn more</a>';
}

/**
 * Filter Handler for: the_content
 * img unautop, Courtesy of Interconnectit
 * Removes p tags FROM images and replaces with figure element
 * http://interconnectit.com/2175/how-to-remove-p-tags-FROM-images-in-wordpress/
 */
function img_unautop($content) {
    $content = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $content );
    return $content;
}

/**
 * Filter Handler for: img_caption_shortcode
 * Customized the output of caption, you can remove the filter to restore back to the WP default output.
 * Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/
 * @param String $output
 * @param Array $attr
 * @param String $content
 * @return String
 */
function apops_cleaner_caption( $output, $attr, $content ) {

  /* We're not worried abut captions in feeds, so just return the output here. */
  if ( is_feed() )
    return $output;

  /* Set up the default arguments. */
  $defaults = array(
    'id' => '',
    'align' => 'alignnone',
    'width' => '',
    'caption' => ''
  );

  /* Merge the defaults with user input. */
  $attr = shortcode_atts( $defaults, $attr );

  /* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
  if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
    return $content;

  /* Set up the attributes for the caption <div>. */
  $attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';

  /* Open the caption <div>. */
  $output = '<figure' . $attributes .'>';

  /* Allow shortcodes for the content the caption was created for. */
  $output .= do_shortcode( $content );

  /* Append the caption text. */
  $output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

  /* Close the caption </div>. */
  $output .= '</figure>';

  /* Return the formatted, clean caption. */
  return $output;
}

/**
 * This theme uses wp_nav_menus() for the header and footer menus.
 */
register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'maspops' ),
        'footer' => __( 'Footer Menu', 'maspops' )
) );

/**
 * Filter handler for: the_generator
 * Hide WordPress Version.
 * Hide the version of WordPress you're running FROM source and RSS feed
 * Want to JUST remove it FROM the source? Try: remove_action('wp_head', 'wp_generator');
 */
function pops_remove_version() {return '';}

/**
 * Action Handler for: widgets_init
 * This function removes the comment inline css
 */
function remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

/**
 * Action Handler for: init
 * Initializes Theme Option variables
 */
function pops_theme_init() {
  /**
   * Add default posts and comments RSS feed links to head
   */
  add_theme_support( 'automatic-feed-links' );
  /**
   * Add editor styles
   */
  add_editor_style( "assets/css/editor-styles.css" );
  /**
   * This theme uses post thumbnails
   */
  add_theme_support( 'post-thumbnails' );
  /**
   * Additional Image Sizes
   */

  // Home Featured Pops
  add_image_size( 'featured-pops', 640, 640 );

  // Site plan thumbnails that show up in the sidebar.
  add_image_size( 'site-plan-thumb', 300, 300, true );
  /**
   * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
   */
  //add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );

  /**
 * Register widgetized area and update sidebar with default widgets
 */
  register_sidebar( array (
          'name' => __( 'Default Sidebar', 'maspops' ),
          'id' => 'sidebar',
          'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
          'after_widget' => "</aside>",
          'before_title' => '<h4 class="widget-title">',
          'after_title' => '</h4>',
  ) );
}

/**
 * Action Handler for: admin_init
 * Remove meta boxes FROM Post and Page Screens
 */
function customize_meta_boxes() {
   /* These remove meta boxes FROM POSTS */
  //remove_post_type_support("post","excerpt"); //Remove Excerpt Support
  //remove_post_type_support("post","author"); //Remove Author Support
  //remove_post_type_support("post","revisions"); //Remove Revision Support
  //remove_post_type_support("post","comments"); //Remove Comments Support
  //remove_post_type_support("post","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("post","editor"); //Remove Editor Support
  remove_post_type_support("post","custom-fields"); //Remove custom-fields Support
  //remove_post_type_support("post","title"); //Remove Title Support

  remove_post_type_support("pops_post","custom-fields"); //Remove custom-fields Support

  /* These remove meta boxes FROM PAGES */
  //remove_post_type_support("page","revisions"); //Remove Revision Support
  //remove_post_type_support("page","comments"); //Remove Comments Support
  //remove_post_type_support("page","author"); //Remove Author Support
  //remove_post_type_support("page","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("page","custom-fields"); //Remove custom-fields Support
}

/*
 * Action handler for: wp_dashboard_setup
 * Remove senseless dashboard widgets for non-admins. (Un)Comment or delete as you wish.
 */
function remove_dashboard_widgets() {
        global $wp_meta_boxes;

        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Plugins widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPress Blog widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Other WordPress News widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Press widget

        //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Right Now widget
        //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links widget
        //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Recent Drafts widget
        //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Recent Comments widget
}


/**
 * Action Handler for: admin_menu
 * Hide Menu Items.
 */
function pops_configure_menu_page(){
        remove_menu_page("link-manager.php"); //Hide Links
        //remove_menu_page("edit-comments.php"); //Hide Comments
        remove_menu_page("tools.php"); //Hide Tools
}

/**
 * Wrapper function, calls edit_post_link menu
 */
function pops_edit_bar() {
  edit_post_link( __( 'Edit', 'pops' ), '<div class="toolbar edit-bar">', '</div>' );
}

/** === End Template Functions === */

/** === Comment Form Functions === **/

/**
 * Filter handler for comment_form 'field' paramter
 * Renders out author and email fields
 * @return array
 */
function get_pops_comment_form_fields() {

  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );

  return array(

    'author' =>
      '<p class="comment-form-author"><label for="author" class="hidden">' . __( 'Name', 'pops' ) . '</label> ' .
      '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
      '" size="30"' . $aria_req . ' placeholder="' . __( 'Name', 'pops' ) . '" />' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',

    'email' =>
      '<p class="comment-form-email"><label for="email" class="hidden">' . __( 'Email', 'pops' ) . '</label> ' .
      '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" size="30"' . $aria_req . ' placeholder="' . __( 'Email Address', 'pops' ) . '" />' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>'
  );

}

/**
 * Filter handler for comment_form 'comment_field' paramter
 * Renders out the textarea and notes for the comment field
 * @return String
 */
function get_pops_comment_field() {
  return '<p class="comment-notes">*Required. Your name will be published. Your email address will not be published.</p><p class="comment-form-comment"><label for="comment" class="hidden">' . _x( 'Comment', 'noun' ) .
    '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Have a pithy comment about a POPS? Submit it!">' .
    '</textarea></p>';
}

/**
 * Comment Form Parameters
 * These are parameters for the comment_form function
 * @return Array
 */
function pops_comment_form_params() {
  return array(
    'label_submit' => __( 'Submit', 'pops' ),
    'title_reply' => __( 'Participate', 'pops' ),
    'comment_notes_before' => '',
    'comment_notes_after' => '',
    'comment_field' => get_pops_comment_field(),
    'fields' => get_pops_comment_form_fields()

  );
}

/**
 * Filter handler for: comment_form_default_fields
 * Unsets the url form field on  pops-comment form
 */
function pops_cleanup_comment_fields( $fields ) {

  if( is_singular( 'pops_post' ) ) {
    unset( $fields['url'] );
  }
  return $fields;
}

/**
 * Action Handler for: comment_form_top
 * Add's comment fields div wrapper
 */
function pops_comment_form_before() {
  echo "<div class='comment-fields'>";
}
/**
 * Action Handler for: comment_form
 * Closes comment fields div wrapper
 */
function pops_comment_form_after() {
  echo "</div>";
}

/** === END Comment Form Functions === **/

/** === Pops Post Functions === **/

/**
 * get_date
 * Returns date with proper formatted string value
 * @return string
 */
function pops_get_date( $the_date, $FROM = 'Ymd', $to = 'm.d.y' ) {

  $date_format = "";

  if( $the_date ) {
    $date = DateTime::createFROMFormat( $FROM, $the_date );
    $date_format = $date->format( $to );
  }

  return $date_format;
}

/** === End Pops Post Functions === **/

/** === Featured Submission Function === */

/**
 * Action handler for: extendcomment_types
 * This removes the announcmeent comment type FROM the ExtendComments plugin.
 * We no longer support announcements
 */
function manage_comment_types( $types ) {

  unset( $types['announcement'] );

  return $types;
}

/**
 * Filter Handler for: extendcomment_listitems
 * Builds the comment tabs based on the available submission types
 * @param Array $items
 * @param Array $submission_types
 */
function pops_add_list_items( $items, $submission_types ) {

  // Clear the items array
  $items = array();

  // Re-build the submission types list items
  foreach( $submission_types as $id => $item ) {
   $items[] = sprintf( '<li><label for="type-comment" class="comment-tab pops-%1$s" data-type="%1$s" data-placeholder="%3$s">%2$s</label></li>', $id, $item, htmlspecialchars( of( "$id-placeholder" ), ENT_QUOTES ) );
  }

  // Return them to the filter callee (ExtendComment plugin in mu-plugins)
  return $items;
}

/**
 * Internal helper method returns key value pair of submission types and labels
 * This is primarily used for the featured items section
 * @return Array
 */
function pops_get_submission_types() {
  return array(
    "Write" => "write",
    "Comment" => "comment",
    "(Re)Design" => "redesign",
    "Problem" => "problem",
    "Photograph" => "photo",
    "Miscellaneous" => ""
  );
}

/**
 * Returns text for featured item type
 * @param String $type
 * @return String
 */
function pops_get_submission_label( $type ) {
    $types = pops_get_submission_types();

    $label = array_search( $type, $types );

    return $label ? $label : "Miscellaneous";
}

/**
 * Echo's featured item label
 */
function pops_submission_label( $type ) {
    _e( pops_get_submission_label( $type ), 'pops' );
}

function pops_post_messages( $messages ) {
  global $post_ID, $post_type;

  // Pull the label registered with the post type
  $post_obj = get_post_type_object($post_type);
  $post_label = $post_obj->labels->singular_name;

  // Remove preview links for featured submission post type
  if ( 'featured-submission' === $post_type ) {
    $messages[$post_type] = array(
       0 => '', // Unused. Messages start at index 1.
       1 => sprintf( __('%s updated.'), $post_label ),
       2 => __('Custom field updated.'),
       3 => __('Custom field deleted.'),
       4 => sprintf( __('%s updated.'), $post_label ),
      /* translators: %s: date and time of the revision */
       5 => isset($_GET['revision']) ? sprintf( __('%s restored to revision FROM %s'), $post_label, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
       6 => sprintf( __('%s published.'), $post_label ),
       7 => sprintf( __('%s saved.'), $post_label ),
       8 => sprintf( __('%s submitted.'), $post_label ),
       9 => sprintf( __('%s scheduled for: <strong>%2$s</strong>.'), $post_label,
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
      10 => sprintf( __('%s draft updated.'), $post_label ),
    );
  } elseif ( 'attachment' !== $post_type ) {
    // Otherwise use the regular post messages (copied FROM core), but replace "post" with the post type label
    // (except for media attachments)
    $messages[$post_type] = array(
       0 => '', // Unused. Messages start at index 1.
       1 => sprintf( __('%s updated. <a href="%s">View %1$s</a>'), $post_label, esc_url( get_permalink($post_ID) ) ),
       2 => __('Custom field updated.'),
       3 => __('Custom field deleted.'),
       4 => sprintf( __('%s updated.'), $post_label ),
      /* translators: %s: date and time of the revision */
       5 => isset($_GET['revision']) ? sprintf( __('%s restored to revision FROM %s'), $post_label, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
       6 => sprintf( __('%s published. <a href="%s">View %1$s</a>'), $post_label, esc_url( get_permalink($post_ID) ) ),
       7 => sprintf( __('%s saved.'), $post_label ),
       8 => sprintf( __('%s submitted. <a target="_blank" href="%s">Preview %1$s</a>'), $post_label, esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
       9 => sprintf( __('%s scheduled for: <strong>%2$s</strong>. <a target="_blank" href="%3$s">Preview %1$s</a>'), $post_label,
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
      10 => sprintf( __('%s draft updated. <a target="_blank" href="%s">Preview %1$s</a>'), $post_label, esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );
  }

  return $messages;
}

/** === End Featured Submission Functions === **/

/** === Participate Section === */

/**
 * get_participate
 * Retrieves the Participate data FROM the options table
 *
 * @return array
 */
function get_participate() {

  $participate = get_option( "apops_participate" );

  if( !is_array( $participate ) )
    $participate = array();

  return $participate;

}

/**
 * Returns participate item html
 * @param string $id
 * @param array $participate collection of participate items
 * @return string
 */
function participate_item( $id, $participate ) {

  $html = "";
   if( isset( $participate[ $id ] ) ) {

      $item = $participate[ $id ];
      $title = isset( $item[ "title" ] ) ? sprintf( '<h4>%1$s</h4>', $item[ "title" ] ) : "";

      $html = sprintf( '<%1$s class="item participate-item pops-%2$s" data-item="%2$s" data-panel="%2$s-panel">%3$s</%1$s>', "div", $id, $title );
  }
  echo $html;
}

/**
 * Returns html for participate content
 * @param string $id
 * @param array $participate Collection of participate sections
 * @return string
 */
function participate_content( $id, $participate ) {

   $html = "";
   if( isset( $participate[ $id ] ) ) {

      $item = $participate[ $id ];
      $title = isset( $item[ "title" ] ) ? sprintf( '<header><h4>%1$s</h4></header>', $item[ "title" ] ) : "";
      $content = apply_filters( 'the_content', $item[ "editor_content" ] );
      $participateUrl = sprintf( '<p><a href="%1$s" class="%2$s">Get Started Now</a></p>', get_permalink( 2033 ), "get-started-icon" );

      $html = sprintf( '<%1$s class="panel pops-%2$s">%3$s %4$s %5$s</%1$s>', "article", $id, $title, $content, $participateUrl );
  }
  echo $html;
}

/** === End Participate Section === */

/** === Find A Pops Template Functions === */

/**
 * Array Filter Handler
 * Returns true if location slug matches manhattan slugs
 * @param object $loc
 * @return bool
 */
function filter_manhattan( $loc ) {
  return in_array( $loc->slug, array( "1-downtown", "2-west-village", "3-clinton", "4-central-midtown", "5-east-midtown", "6-upper-east-side", "7-upper-west-side" ) );
}

/**
 * Array Filter Handler
 * Returns true if location slug does not match manhattan slugs
 * @param object $loc
 * @return bool
 */
function filter_other_hoods( $loc ) {
  return !in_array( $loc->slug, array( "1-downtown", "2-west-village", "3-clinton", "4-central-midtown", "5-east-midtown", "6-upper-east-side", "7-upper-west-side" ) );
}

/**
 * Get's Neighborhoods by group
 *
 * @return Array $hoods
 */
function get_neighborhoods() {

  $hoods = get_transient( "hoods" );

  if( !$hoods ) {

    $neighborhoods = get_terms( 'pops_neighborhoods', 'orderby=slug' );

    $hoods = array(
        array( "title" => "Manhattan", "hoods" => array_filter( $neighborhoods, "filter_manhattan" ) ),
        array( "title" => "", "hoods" => array_filter( $neighborhoods, "filter_other_hoods" ) )
    );

    set_transient( "hoods", $hoods );
  }
  return $hoods;
}

/**
 * Returns amenity collection
 * @return Array $amenities
 */
function get_the_amenities() {

  global $wpdb, $post;

  $results = $wpdb->get_results( "SELECT amenity, comments FROM jJOi2QWP94_required_amenities WHERE dcp_record = '{$post->post_name}' ORDER BY amenity;" );

  $amenities = array();

  if( !$results ) {
    return false;
  }

  foreach( $results as $amenity ) {

    if ( empty( $amenity->amenity ) || $amenity->amenity === 'None' ) {
      continue;
    }

    if ( empty( $amenity->comments ) ) {
      $amenity->comments = 'Yes';
    }

    $amenities[] = $amenity;
  }
  return $amenities;
}

/**
 * Wraps span elements around search result word.
 * @param String $word
 * @return String
 */
function pops_search_result_item( $word ) {
  return "<span>$word</span>";
}

/**
 * Filters currently searched amenities
 * @param Array $amenities
 * @return Array
 */
function get_searched_amenities( $amenities ) {

    $filtered = array_filter( $amenities, create_function( '$var', 'return $var["value"] === "on";') );
    $searched = array();

    foreach( $filtered as $key => $amenity ) {
      $searched[] = "{$amenity[ 'title' ]}";
    }
    return $searched;
}

/**
 * Retrieves JSON array of pops entries.
 * Called while looping through pops queried entries
 * NOTE: RE-DO For Phase II
 * @return JSON
 */
function get_json_pops() {
  global $post;

  $points = array();

  while ( have_posts() ) : the_post();
    $lat = get_post_meta($post->ID, 'lat');
    $lng = get_post_meta($post->ID, 'lng');

    if (!$lat or !$lng)
      continue;

  $point = Array("lat"=> $lat,
                 "lng"=> $lng,
                 "title"=> get_the_title(),
                 "permalink" => get_permalink()
                 );
  $points[] = $point;
  endwhile;

  return json_encode($points);
}

/**
 * Get Detail label FROM Options
 * @param String $type
 * @return String
 */
function pops_get_detail_label( $type ) {
  return of( "$type-label" );
}

/**
 * Get Detail data FROM Options
 * @param String $type
 * @return String
 */
function pops_get_detail_data( $type ) {
  return of( "$type-tooltip" );
}

/**
 * Returns key value pair of Detail id and Label
 * @return Array
 */
function pops_get_available_details() {

  return array(
    "space_type" => "type of space",
    "req_size" => "required size",
    "inventory_public_space_location" => "space location",
    "inventory_year_completed" => "year completed",
    "inventory_principal_public_space_designer" => "space designer",
    "inventory_building_architect" => "building architect",
    "inventory_building_owner" => "building owner",
    "inventory_building_manager" => "building manager",
    "disabled" => "access for disabled",
    "req_hours" => "required hours"
  );
}

/*Sidebar Single Pops - Site Plans*/
/*NOTE: For this to work, site plans must have the file name "siteplan-post_name". For example "siteplan-m040009"*/
function sitePlan () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $placeholder = "https://apops.mas.org/wp-content/uploads/2018/12/no-siteplan-placeholder.png";

    $results = $wpdb->get_row("SELECT guid FROM jJOi2QWP94_posts WHERE post_name = 'siteplan-$pname' AND post_type = 'attachment';");
        if ($results->guid === NULL) {
            echo $placeholder;
        } else {
            echo $results->guid;
        }  
}

/*Sidebar Single Pops - Type of Space*/
function typeOfSpace () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $out = Array ();
    
    $results = $wpdb->get_results("SELECT description FROM jJOi2QWP94_dcp_public_space_detail WHERE fk_pops_detail = '$pname';");

    foreach ($results as $result) {
        //echo "" . $result->description . ", ";
        $out[] = $result->description;
        $comma_separated = implode(", ", $out);
    }
    echo $comma_separated;
}

/*Sidebar Single Pops - Required Size*/
function requiredSize () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $out = Array ();
    
    $results = $wpdb->get_results("SELECT description, size_required FROM jJOi2QWP94_dcp_public_space_detail WHERE fk_pops_detail = '$pname';");

    foreach ($results as $result) {
        $english_format_number = number_format($result->size_required);
        $out[] = $result->description . ": " . $english_format_number . " sf";
        $comma_separated = implode(", ", $out);
    }
    echo $comma_separated;
}

/*Sidebar Single Pops - Building Location*/
function buildingLocation () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT building_location FROM jJOi2QWP94_dcp_building_detail WHERE fk_pops_detail = '$pname';");

    echo $results->building_location;
}

/*Sidebar Single Pops - Building Name*/
function buildingName () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT building_name FROM jJOi2QWP94_dcp_building_detail WHERE fk_pops_detail = '$pname';");

    if ($results->building_name !== "none") {
        echo $results->building_name;
    }
}

/*Sidebar Single Pops - Year Completed*/
function yearCompleted () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT year_completed FROM jJOi2QWP94_dcp_building_detail WHERE fk_pops_detail = '$pname';");

    echo $results->year_completed;
}

/*Sidebar Single Pops - Space Designer*/
function spaceDesigner () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT name FROM jJOi2QWP94_dcp_associated_parties WHERE type_of_party = 'Principal Public Space Designer' AND fk_pops_detail = '$pname';");

    echo $results->name;
}

/*Sidebar Single Pops - Building Architect */
function buildingArchitect () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT name FROM jJOi2QWP94_dcp_associated_parties WHERE type_of_party = 'Building Architect' AND fk_pops_detail = '$pname';");

    echo $results->name;
}

/*Sidebar Single Pops - Building Owner*/
function buildingOwner () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $out01 = Array ();
    $out02 = Array ();
    $out03 = Array ();
    $out04 = Array ();
    $out05 = Array ();
    $out06 = Array ();
    $out07 = Array ();
    $out08 = Array ();
    $out09 = Array ();

    $results = $wpdb->get_results("SELECT name, care_of, house_number, street_name, unit_number, city, the_state, zip, phone, email FROM jJOi2QWP94_dcp_associated_parties WHERE type_of_party = 'Owner' AND fk_pops_detail = '$pname';");

    foreach ($results as $result) {       
        $out01[] = $result->name;
        $out02[] = $result->care_of;
        $out03[] = $result->house_number . " " . $result->street_name;
        $out04[] = $result->unit_number;
        $out05[] = $result->city;
            if ($result->the_state === "32") {
                $out06[] = "NY";
            } else {
                $out06[] = "";
            }
        $out07[] = $result->zip;
        $out08[] = $result->phone;
        $out09[] = $result->email;
        $result = array_merge($out01, $out02, $out03, $out04, $out05, $out06, $out07, $out08, $out09);
        $comma_separated = implode(", ", array_filter($result));
        }
        echo $comma_separated;
}

/*Sidebar Single Pops - Managing Agent*/
function managingAgent () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $out01 = Array ();
    $out02 = Array ();
    $out03 = Array ();
    $out04 = Array ();
    $out05 = Array ();
    $out06 = Array ();
    $out07 = Array ();
    $out08 = Array ();
    $out09 = Array ();

    $results = $wpdb->get_results("SELECT name, care_of, house_number, street_name, unit_number, city, the_state, zip, phone, email FROM jJOi2QWP94_dcp_associated_parties WHERE type_of_party = 'Managing Agent' AND fk_pops_detail = '$pname';");

    foreach ($results as $result) {       
        $out01[] = $result->name;
        $out02[] = $result->care_of;
        $out03[] = $result->house_number . " " . $result->street_name;
        $out04[] = $result->unit_number;
        $out05[] = $result->city;
            if ($result->the_state === "32") {
                $out06[] = "NY";
            } else {
                $out06[] = "";
            }
        $out07[] = $result->zip;
        $out08[] = $result->phone;
        $out09[] = $result->email;
        $result = array_merge($out01, $out02, $out03, $out04, $out05, $out06, $out07, $out08, $out09);
        $comma_separated = implode(", ", array_filter($result));
    }
        echo $comma_separated;
}

/*Sidebar Single Pops - Access For Disabled*/
function accessForDisabled () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT physically_disabled FROM jJOi2QWP94_dcp_pops_detail WHERE pk_psr_number = '$pname';");

    echo $results->physically_disabled;
}

/*Sidebar Single Pops - Hours of Access*/
function hoursOfAccess () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_results("SELECT t1.required_description, t1.comments, t2.description FROM jJOi2QWP94_dcp_required t1 INNER JOIN jJOi2QWP94_dcp_public_space_detail t2 ON t1.fk_public_space_detail = t2.pk_public_space_detail WHERE t1.fk_pops_detail = '$pname' AND t1.type_required = 'Access' ORDER BY t2.description ASC;");

    foreach ($results as $result) {

        if ($result->required_description === "Restricted Hours") {
            if ($result->comments === "") {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->description . ":</strong> " . $result->required_description . "</li>";
            } else {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->description . ":</strong> " . $result->comments . "</li>";
            }
        } elseif ($result->required_description === "24 Hours") {
            if ($result->comments === "") {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->description . ":</strong> " . $result->required_description . "</li>";
            } else {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->description . ":</strong> " . $result->required_description . ", " . $result->comments . "</li>";
            }
        }
    }
}

/*Sidebar Single Pops - Closing for Events*/
function closingForEvents () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_row("SELECT required_description, comments FROM jJOi2QWP94_dcp_required WHERE fk_pops_detail = '$pname' AND required_description = 'Closing for Events';");

    if (empty($results)) {
        echo "<li class='detail accordion-item'>This POPS does not close for events.</li>";
    } else {
        echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $results->required_description . ":</strong> " . $results->comments . "</li>";
    }
}

/*Sidebar Single Pops - Required Amenities*/
function requiredAmenitiesVertical () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_results("SELECT t1.required_description, t1.comments, t2.description FROM jJOi2QWP94_dcp_required t1 INNER JOIN jJOi2QWP94_dcp_public_space_detail t2 ON t1.fk_public_space_detail = t2.pk_public_space_detail WHERE t1.fk_pops_detail = '$pname' AND t1.type_required = 'Required Amenities' ORDER BY t1.required_description ASC, t2.description ASC;");

    foreach ($results as $result) {

        if ($result->required_description === "None") {
            echo "<li class='detail accordion-item'>No required amenities: " . $result->description . "</li>";
        } elseif ($result->comments === "") {
            echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->required_description . "</strong>, " . $result->description . "</li>";
        } else {
            echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->required_description . "</strong>, " . $result->description . ": " . $result->comments . "</li>";
        }
    }
}

/*Sidebar Single Pops - Permitted Amenities*/
function permittedAmenitiesVertical () {
    global $wpdb, $post;
    $pname = $post->post_name;

    $results = $wpdb->get_results("SELECT t1.required_description, t1.comments, t2.description FROM jJOi2QWP94_dcp_required t1 INNER JOIN jJOi2QWP94_dcp_public_space_detail t2 ON t1.fk_public_space_detail = t2.pk_public_space_detail WHERE t1.fk_pops_detail = '$pname' AND t1.type_required = 'Permitted Amenities' ORDER BY t1.required_description ASC, t2.description ASC;");

    if (count($results) > 0) {

        foreach ($results as $result) {

            if ($result->comments === "") {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->required_description . "</strong>, " . $result->description . "</li>";
            } elseif ($result->comments !== "") {
                echo "<li class='detail accordion-item'><strong class='accordion-trigger'>" . $result->required_description . "</strong>, " . $result->description . ": " . $result->comments . "</li>";
            }
        }

    } else {
        echo "<li class='detail accordion-item'>" . "No permitted amenities" . "</li>";
    }           
}

/*Home-Featured - Required Amenities*/
/*function requiredAmenitiesHorizontal () {
    global $wpdb, $post;
    $pname = $post->post_name;
    $out = Array ();
    
    $results = $wpdb->get_results("SELECT required_description FROM jJOi2QWP94_dcp_required WHERE fk_pops_detail = '$pname' AND type_required = 'Required Amenities';");

    foreach ($results as $result) {

            if ($result->required_description === "Other Permitted") {
                $out[] = "";
            } else if ($result->required_description === "Other Required") {
                $out[] = "";
            } else {
                $out[] = $result->required_description;
            }
        $comma_separated = implode(", ", array_filter($out));
    }
    echo $comma_separated;
}*/

/**
 * Return Neighborhood for current dcp record
 * @param String $dcp_rec
 * @return String
 */
function get_neighborhood($dcp_rec) {
  $dcp_num = (int) $dcp_rec;
  if (substr($dcp_rec, 0, 1)=='b')
    return 'Brooklyn';
  elseif (substr($dcp_rec, 0, 1)=='q')
    return 'Queens';
  elseif ($dcp_num >= 100 and $dcp_num < 200)
    return 'Downtown';
  elseif ($dcp_num >= 200 and $dcp_num < 300)
    return 'West Village';
  elseif ($dcp_num >= 400 and $dcp_num < 500)
    return 'Clinton';
  elseif (($dcp_num >= 500 and $dcp_num < 600) or ($dcp_num >= 5100 and $dcp_num <= 5110))
    return 'Central Midtown';
  elseif ($dcp_num >= 600 and $dcp_num < 700)
    return 'East Midtown';
  elseif ($dcp_num >= 700 and $dcp_num < 800)
    return 'Upper West Side';
  elseif (($dcp_num >= 800 and $dcp_num < 900) or in_array($dcp_num, array(8100, 1100)))
    return 'Upper East Side';
  else
    return '';
}

/** === End Find A Pops Template Functions === */

/**
 * Bulk updaet of post taxonomies for neighborhoods.
 * NOTE: This looks like it was run when the site was first developed.
 * Stupidly called in footer.php file. It's currently commented out.
 * Neighborhoods are tags inside of WP.
 * Also a redo for Phase II.
 */
// function populate_neighborhoods() {
//   global $wpdb;
//   $pops = $wpdb->get_results(
//           "
//       SELECT ID, post_name FROM jJOi2QWP94_posts WHERE post_type = 'pops_post';
//         "
//   );

//   foreach ( $pops as $pop ) {
//     $hoods = wp_get_post_terms($pop->ID, 'pops_neighborhoods');
//     if (count($hoods) > 0) {
//       continue;
//     }
//     wp_set_post_terms($pop->ID, get_neighborhood($pop->post_name), 'pops_neighborhoods');
//   }
// }

/** === Filters and Hooks **/

// Filters - Remove

// Get outta my Wordpress codez dangit!
remove_filter( 'the_content',               'capital_P_dangit' );
// Get outta my Wordpress codez dangit!
remove_filter( 'the_title',                 'capital_P_dangit' );
// Get outta my Wordpress codez dangit!
remove_filter( 'comment_text',              'capital_P_dangit' );

// Might be necessary if you or other people on this site use
//remove_action('wp_head', 'rsd_link'); remote editors.

// Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links', 2);

// Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'feed_links_extra', 3);

// Displays relations link for site index
//remove_action('wp_head', 'index_rel_link');

// Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'wlwmanifest_link');

// Start link
//remove_action('wp_head', 'start_post_rel_link', 10, 0);

// Prev link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0);

// Display relational links for the posts adjacent to the current post.
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Filters - Register
add_filter( 'comment_form_default_fields',  'pops_cleanup_comment_fields' );
add_filter( 'extendcomment_types',          'manage_comment_types' );
add_filter( 'excerpt_length',               'custom_excerpt_length', 999 );
add_filter( 'excerpt_more',                 'new_excerpt_more' );
add_filter( 'the_generator',                'pops_remove_version');
add_filter( 'the_content',                  'img_unautop', 30 );
add_filter( 'img_caption_shortcode',        'apops_cleaner_caption', 10, 3 );
add_filter( 'post_updated_messages',        'pops_post_messages' );
add_filter( 'extendcomment_listitems',      'pops_add_list_items', 0, 2 );

// Actions - Register
add_action( 'init',                         'pops_theme_init' );
add_action( 'admin_init',                    'customize_meta_boxes');

add_action( 'comment_form_top',             'pops_comment_form_before' );
add_action( 'comment_form',                 'pops_comment_form_after' );

add_action( 'wp_enqueue_scripts',           'apops_register_scripts' );

add_action( 'widgets_init',                 'remove_recent_comments_style' );

// Actions - Conditional
if (!current_user_can('manage_options')) {
    add_action( 'wp_dashboard_setup',       'remove_dashboard_widgets' );
    add_action( 'admin_menu',               'pops_configure_menu_page' ); //While we're add it, let's configure the menu options as well
}

// Register Main Classes
require_once( "main/init.php" );

// Create function which allows more tags within comments
add_filter('preprocess_comment', 'apops_check_new_comment');
function apops_check_new_comment($commentdata){

  $commentdata['comment_content'] = preg_replace("/<iframe(.*?)>(.*)<\/iframe>/", "$2", $commentdata['comment_content']);// or str_replace
  return $commentdata;
}

add_filter('preprocess_comment','fa_allow_tags_in_comments');
function fa_allow_tags_in_comments($data) {
    global $allowedtags;
    $allowedtags['span'] = array('style'=>array());
    $allowedtags['p'] = array();
  $allowedtags['iframe'] = array(
    'width' => array(),
    'height' => array(),
    'src' => array(),
    'frameborder' => array(),
    'allowfullscreen' => array()
  );
    return $data;
}
