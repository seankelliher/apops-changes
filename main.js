/**
 * Main Application Configuration
 *
 * Here's where it all starts.
 * The RequireJS paths, shims and dependencies are specified.
 *
 * We then, launch the main module, which will request our site modules to run our sites initialization code.
 *
 */ 
requirejs.config({
  

  // Where are things located? 
  // Note: we're starting from the assets/js directory, since that's where the main.js file lives. 
  paths : {
    
    // jQuery Library
    "jquery" : "components/jquery/jquery",
    
    // Helpers
    "utils" : "helpers/utils",
    "apops.$" : "helpers/apops",
    "apops.ui" : "helpers/apops.ui",
    
    // Plugins
    "plugins.lazyload"  : "plugins/lazyload",
    "plugins.magnific"  : "plugins/magnific-popup",
    "plugins.carousel"  : "plugins/responsive-carousel",
    "plugins.sticky"    : "plugins/sticky-float",
    "plugins.expander"  : "plugins/jquery.expander",
      

    // Modules
    "apops.ui.module"               : "modules/apops.module.base",
    "apops.ui.accordion"            : "modules/apops.module.accordion",
    "apops.ui.commenttypes"         : "modules/apops.module.comment-types",
    "apops.ui.dropdown"             : "modules/apops.module.dropdown",
    "apops.ui.featuredsubmission"   : "modules/apops.module.featured-submission",
    "apops.ui.infieldlabel"         : "modules/apops.module.infield-label",
    "apops.ui.mobiletoggle"         : "modules/apops.module.mobile-toggle",
    "apops.ui.participate"          : "modules/apops.module.participate",
    "apops.ui.togglebar"            : "modules/apops.module.toggle-bar",
    "apops.ui.readmore"             : "modules/apops.module.readmore",


    // Apops Plugin Interfaces
    "apops.plugin.accordion"            : "plugins/apops.plugin.accordion",
    "apops.plugin.commenttypes"         : "plugins/apops.plugin.comment-types",
    "apops.plugin.dropdown"             : "plugins/apops.plugin.dropdown",
    "apops.plugin.featuredsubmission"   : "plugins/apops.plugin.featured-submission",
    "apops.plugin.infieldlabel"         : "plugins/apops.plugin.infield-label",
    "apops.plugin.mobiletoggle"         : "plugins/apops.plugin.mobile-toggle",
    "apops.plugin.participate"          : "plugins/apops.plugin.participate",
    "apops.plugin.togglebar"            : "plugins/apops.plugin.toggle-bar",
    "apops.plugin.readmore"             : "plugins/apops.plugin.readmore"

  },
  
  //
  // Shim any js resource that isn't configured to use AMD, ex. define( 'foo', fn(){} );
  //
  shim : {
    "plugins.lazyload" : ["jquery"],
    "plugins.magnific" : ["jquery"],
    "plugins.carousel" : ["jquery"],
    "plugins.sticky"   : ["jquery"],
    "plugins.expander" : ["jquery"]
  }

});

// Begin our application code.
define( [ "app" ], function( app ) {
    // Execute our app init function.
    app.init();
});




