<?php

/* Plugin Name: Shortcode Demo Plugin
  Plugin URI: http://www.andrewgrant.net.au/wordpress-shortcode-api-wrapper/
  Description: A demo of using teh shortcode class
  Version: 1.0
  Author: Andrew Grant
  Author URI: www.andrewgrant.net.au
 */
require_once 'Shortcode.php';

$defaultValues = array(name => "anonymous", age => "0", gender => "male");
$f = function($atts, $content) {
            $name = $atts[name];
            return "<div style='background-color:rgb(240,240,240);width:350px;border:solid 1px black;padding:10px;'><h3>Name is: $name</h3><h3>Content is: $content</h3></div>";
        };

$sc = new au\net\andrewgrant\Shortcode("yo");
$sc->setDefaults($defaultValues);
$sc->renderShortcode($f);
?>