<?php
/*
Plugin Name: My Favorite Director
Plugin URI: http://danielpataki.com
Description: A transient project that displays movies from a favorite director
Author: Daniel Pataki
Author URI: http://danielpataki.com
Version: 1.1.0
*/
include 'my_favorite_director_widget.php';

class My_Favorite_Director {
    function __construct() {
        add_action( 'widgets_init', array( $this, 'init_widget' ) );
    }
    function init_widget() {
        register_widget( 'My_Favorite_Director_Widget' );
    }
}
new My_Favorite_Director;