<?php

class My_Favorite_Director_Widget extends WP_Widget
{
    function __construct()
    {
        $widget_details = array(
            'classname' => 'my-favorite-director-widget',
            'description' => 'Display movies from your favorite director.'
        );
        parent::__construct( 'my-favorite-director', 'My Favorite Director', $widget_details );
    }
    function form( $instance ) {
        $title = ( empty( $instance['title'] ) ) ? '' : $instance['title'];
        ?>

        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php
    }
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
    function widget( $args, $instance ) {
        $response = wp_remote_get( 'http://netflixroulette.net/api/api.php?director=Martin%20Scorsese', $args );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        if( empty( $data ) ) {
            return;
        }
        echo $args['before_widget'];
        if( !empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
        }
        echo "<ul>";
        foreach( $data as $movie ) {
            echo "<li>" . $movie['show_title'] . "</li>";
        }
        echo "</ul>";
        echo $args['after_widget'];
    }
}