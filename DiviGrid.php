<?php


function divi_grid( $atts, $content = null ) {
    ob_start();
	return apply_filters('the_content', '<div class="divi-grid">' . apply_filters('divi_grid_filter', $content) . '</div>');
}
add_shortcode( 'divi-grid', 'divi_grid' );

function divi_grid_filter( $content ) {
    $regExp="|\[divi-grid-(.*)\]|U";
    preg_match_all($regExp,$content,$tags,PREG_PATTERN_ORDER);  
    $stags = [];
    $rtags = [];
    for($i=0;$i<count($tags[0]);$i++){
        $stags[] = "[divi-grid-".$tags[1][$i]."]";
        $rtags[] = parser($tags[1][$i]);
    }
    $stagu=array("[/divi-grid-row]","[/divi-grid-col]");
    $replaceu=array("</div>","</div>");
    $html=str_replace($stags,$rtags,$content);
    $html=str_replace($stagu,$replaceu,$html);
    return $html;
}
function parser($tag){
    if($tag=='row'){
        return '<div class="divi-grid-row">';
    }
    else{
        $stag = explode(' ',$tag);
        $size = str_replace(['s="','"'],["",""],$stag[1]);
        return '<div class="divi-grid-col-'.$size.'">';
    }
    return "[]";
}
add_filter( 'divi_grid_filter', 'divi_grid_filter' );
