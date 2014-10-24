<?php
function register_media_files(){

    //use the self hosted version
    wp_register_style( 'videojs-css', plugins_url( 'includes/media/video-js/video-js.css') );
    wp_enqueue_style ( 'videojs-css' );

    wp_register_script( 'videojs', plugins_url( 'includes/media/video-js/video.js') );
    wp_register_script( 'videojs-youtube', plugins_url( 'includes/media/video-js/youtube.js') );
    wp_register_script( 'videojs-vimeo', plugins_url( 'includes/media/video-js/vimeo.js') );
    wp_register_script( 'videojs-wavesurfer', plugins_url( 'includes/media/video-js/wavesurfer.js') );
}
add_action( 'wp_enqueue_scripts', 'register_media_files' );


/* Include the scripts before </body> */
function add_media_header(){

    wp_enqueue_script ( 'videojs' );
    wp_enqueue_script ( 'videojs-youtube' );

}

/*
function load_media(){

    videojs("media-player", {}, function(){
    // Player (this) is initialized and ready.
    });

    echo "<video id="media-player" class="video-js vjs-default-skin" data-setup="{}"></video>";
    echo "<audio id="media-player" class="video-js vjs-default-skin" data-setup="{}"></audio>";

}
*/

function getYoutubeid($videourl) {
    $url = $videourl;
    parse_str( parse_url( $url, PHP_URL_QUERY ), $url_vars );
    $videoid = $url_vars['v'];

    return $videoid;
}

function getYoutubeDuration($videoid) {

    $xml = simplexml_load_file('https://gdata.youtube.com/feeds/api/videos/' . $videoid . '?v=2');
    $result = $xml->xpath('//yt:duration[@seconds]');
    $total_seconds = (int) $result[0]->attributes()->seconds;
    $total_minutes = gmdate("H:i:s", $total_seconds);
    return $total_minutes;
}
