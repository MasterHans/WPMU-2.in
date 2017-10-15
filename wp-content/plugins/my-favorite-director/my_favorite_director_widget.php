<?php

$config = array(
    'provider' => 'themoviedb',
    'providers' => array(
        'themoviedb' => array(
            'api_key' => 'cd64539dd19283cdcc637f2ccddcd45-us6'
        ),
    )
);


class My_Favorite_Director_Widget extends WP_Widget
{
    function __construct()
    {

        $widget_details = array(
            'classname' => 'my-favorite-director-widget',
            'description' => 'Display movies from your favorite director.'
        );
        parent::__construct('my-favorite-director', 'My Favorite Director', $widget_details);
    }

    function form($instance)
    {
        $title = (empty($instance['title'])) ? '' : $instance['title'];
        ?>

        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>

        <?php
    }

    function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    function widget($args, $instance)
    {
//        $args['headers'] = array(
//                'X-Mashape-Key' => 'etYSfbd72amshpc1fBuGa5I5CTmfp1pcXaZjsnNw5S6J50TQ9S',
//                'Accept' => 'application/json'
//            );

        $response = wp_remote_get('https://anapioficeandfire.com/api/houses', $args);

//        var_dump($response);
        $data = json_decode(wp_remote_retrieve_body($response), true);
        var_dump($data);
        if (empty($data)) {
            return;
        }
        echo $args['before_widget'];
        echo '<h1>TESTTTT</h1>';
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
        }
        echo "<ul>";
        foreach ($data as $movie) {
            echo "<li>" . $movie['show_title'] . "</li>";
        }
        echo "</ul>";
        echo $args['after_widget'];
    }
}