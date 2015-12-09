<?php
/**
 * Plugin Name: Color Thievery
 * Plugin URI: https://github.com/woodwardtw/color_thief
 * Description: Lets you pull the 4 dominant colors from images using the [colorthief url="http://yoursite.com/theimg.jpg"] shortcode. Defaults to 100% and 20px height but you can override in the shortcode. 
 * Version: .7
 * Author: Tom Woodward
 * Author URI: http://bionicteaching.com
 * License: GPL2
 */
 
 /*   2015 Tom Woodward   (email : bionicteaching@gmail.com)
 
 	This program is free software; you can redistribute it and/or modify
 	it under the terms of the GNU General Public License, version 2, as 
 	published by the Free Software Foundation.
 
 	This program is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 	GNU General Public License for more details.
 
 	You should have received a copy of the GNU General Public License
 	along with this program; if not, write to the Free Software
 	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
//[colorthief url"YourIMGURL" width="" height=""]
 
function colorthief_shortcode($atts, $content=null) {
    $a = shortcode_atts( array(
         'url' => '',
         'width' => '100%',
         'height' => '20px',
    ), $atts);
    $unique = substr($a['url'],-8,-4); 
    //$unique = rand(4,12);
	return '
    <img class="cthief" id="theimage'.$unique.'" src="'. $a['url'] .'" />
<div class="stolencolors">
      <div class="ct_color" id="mydiv_' . $unique . '_a" style="width:'. $a['width'] . ';height:' . $a['height'] . ';"></div>
      <div class="ct_color" id="mydiv_' . $unique . '_b" style="width:'. $a['width'] . ';height:' . $a['height'] . ';"></div>
      <div class="ct_color" id="mydiv_' . $unique . '_c" style="width:'. $a['width'] . ';height:' . $a['height'] . ';"></div>
      <div class="ct_color" id="mydiv_' . $unique . '_d" style="width:'. $a['width'] . ';height:' . $a['height'] . ';"></div>
</div>
  <script type="text/javascript">

    jQuery(document).ready(function() {
      //Make sure image is loaded before running.
      colorChange();
 function colorChange(){
      var $myImage = jQuery("#theimage' . $unique . '");
      var colorThief = new ColorThief();
      
      var cp = colorThief.getPalette('.'$myImage[0], 4, 5'.');
      
      jQuery("#mydiv_' . $unique . '_a").css("background-color", "rgb("+cp[0][0]+","+cp[0][1]+","+cp[0][2]+")");
      jQuery("#mydiv_' . $unique . '_b").css("background-color", "rgb("+cp[1][0]+","+cp[1][1]+","+cp[1][2]+")");
      jQuery("#mydiv_' . $unique . '_c").css("background-color", "rgb("+cp[2][0]+","+cp[2][1]+","+cp[2][2]+")");
      jQuery("#mydiv_' . $unique . '_d").css("background-color", "rgb("+cp[3][0]+","+cp[3][1]+","+cp[3][2]+")");
    }

    });


  </script>';
}
add_shortcode( 'colorthief', 'colorthief_shortcode' );

function colorthief_scripts() {
    wp_register_script( 'color_thief', 
                       plugins_url( '/js/color-thief.min.js', __FILE__ ),
                       array(),
                       'scriptversion 1.5.8', 
                       true);
  
//enque scripts
    wp_enqueue_script('color_thief');

 
 
}
add_action( 'wp_enqueue_scripts', 'colorthief_scripts' );