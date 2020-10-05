jQuery(document).ready(function($){
  $('#respond #reply-title').text('Comment');

    // Initialize slick on homepage POPS listings.
    $('.home-section-featured').slick({
    slide: 'article.single-pops',
    dots: false,
    fade: true,
    arrows: true,
    adaptiveHeight: false,
    autoplay: true,
    pauseOnHover: true,
    autoplaySpeed: 7000
    });

    
    // Initialize slick on homepage featured items carousel.
    $('.featured-submission-content').slick({
    slide: 'article.featured-submission-item',
    dots: false,
    fade: true,
    arrows: true,
    adaptiveHeight: false,
    autoplay: true,
    pauseOnHover: false,
    autoplaySpeed: 7000
    });

    // Add a "pause" button to the header of the featured items.
    $('.featured-submission-header').append('<a class="play-pause" href="#"><i class="fa fa-pause"></i></a>');

    // Add slick methods to pause/play button.
    $('.play-pause').click(function(event){
    event.preventDefault();
    if ($('.featured-submission-content').hasClass('paused')) {
      $(this).find('i').removeClass('fa-play').addClass('fa-pause');
      $('.featured-submission-content').removeClass('paused').addClass('playing');
      $('.featured-submission-content').slick('slickPlay');
    }
    else {
      $(this).find('i').removeClass('fa-pause').addClass('fa-play');
      $('.featured-submission-content').removeClass('playing').addClass('paused');
      $('.featured-submission-content').slick('slickPause');
    }
    });

    // If the current featured item slide has a video, pause it when the
    // carousel moves to the next slide.
    $('.featured-submission-content').on('beforeChange', function(event, slick, currentSlide, nextSlide){
    if ($('.featured-submission-content .featured-submission-item:eq(' + currentSlide + ') iframe').length) {
      $('.featured-submission-content .featured-submission-item:eq(' + currentSlide + ') iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
    }
    });

    // Initialize slick on single POPS entry page image gallery.
    $('#single-pops .pops-gallery').slick({
    slide: '.gallery-image',
    fade: true,
    adaptiveHeight: false,
    dots: true,
    customPaging: function(slider, i) {
      // this example would render "tabs" with titles
      return '<span class="tab"><img src="' + $(slider.$slides[i]).find('img').attr('src') + '" /></span>';
    },
    });

    $('.comment .reply .comment-reply-link').click(function(event){
    event.preventDefault();
    var respondBox = $('#respond').html();
    var replyParent = $(this).parent();

    replyParent.append('<div class="respond"></div>');
    replyParent.find('.respond').append(respondBox);
    // $('#respond').appentTo('.comment .respond');
    });

    $('.page-template-page-templatespage-find-php #content').removeClass('show-listings').addClass('.show-map');

    $('#tab-map').addClass('active');

    $('#thumbnails-toggle li a').click(function(event){
    event.preventDefault();

    setTimeout(function() {
      google.maps.event.trigger(map, 'resize');
    }, 500);


    var thisClass = $(this).attr('data-value');
    $('#content').removeClass(function (index, css) {
        return (css.match (/(^|\s)show-\S+/g) || []).join(' ');
    }).removeClass(function (index, css) {
        return (css.match (/(^|\s)hide-\S+/g) || []).join(' ');
    }).addClass(thisClass);

    $('#thumbnails-toggle li a.active').removeClass('active');
    $(this).addClass('active');

    });

});

//You Tube API  - START
//If video playing or paused, simulate click on featured items play/pause button

var tag = document.createElement('script');

tag.id = 'iframe-demo';
tag.src = 'https://www.youtube.com/iframe_api';

var firstScriptTag = document.getElementsByTagName('script')[0];

firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('existing-iframe-example', {
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

function pausePlayButton(playerStatus) {

    if (playerStatus == 1 || playerStatus == 2) {
        //status 1 is playing. status 2 is paused.

        var playPauseButton = document.getElementsByClassName("play-pause")[0];
        playPauseButton.click();
    }
} 
  
function onPlayerStateChange(event) {
    pausePlayButton(event.data);
}

//You Tube API  - FINISH


