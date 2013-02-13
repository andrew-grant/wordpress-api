<?php

/*
  Plugin Name: Shortcode Example 6
  Plugin URI: http://example.com/
  Description: Enables [url] and [b] shortcodes in comments
  Version: 1.0
  Author: Ozh
  Author URI: http://wrox.com/
 */

// Hook into "comment_text" to process comment content

add_filter("comment_text ", "boj_sc6_comments");

// This function processes comment content
function boj_sc6_comments($comment) {

    // Save registered shortcodes:
    global $shortcode_tags;
    $original = $shortcode_tags;

    // Unregister all shortcodes:
    remove_all_shortcodes();

    // Register new shortcodes:
    add_shortcode("url ", "boj_sc6_comments_url");
    add_shortcode("b ", "boj_sc6_comments_bold");
    add_shortcode("strong ", "boj_sc6_comments_bold");

    // Strip all HTML tags from comments:
    $comment = wp_strip_all_tags($comment);

    // Process comment content with these shortcodes:
    $comment = do_shortcode($comment);

    // Unregister comment shortcodes, restore normal shortcodes
    $shortcode_tags = $original;

    // Return comment:
    return $comment;
}

// the [b] or [strong] to  < strong > callback

function boj_sc6_comments_bold($attr, $text) {
    return " < strong > " . do_shortcode( $text ) . " < /strong > ";
}

// the [url] to  < a >  callback
function boj_sc6_comments_url($attr, $text) {
    $text = esc_url($text);
    return " < a href = \"$text\"> $text < /a > ";
}
?>