<?php
/*
Plugin Name: OOP Subscription Form
Plugin URI: http://danielpataki.com
Description: An OOP based project for WPMU DEV
Author: Daniel Pataki
Author URI: http://danielpataki.com
Version: 1.0.0
*/
/**
 * How to use filter hook  'msf/form_fields'
 * add_filter( 'msf/form_fields', 'age_field_extension' );
 * function age_field_extension( $fields ) {
 * $fields[] = '<input type="text" placeholder="Age" name="age">';
 * return $fields;
 * }
 */
$config = array(
    'provider' => 'mailchimp',
    'providers' => array(
        'mailchimp' => array(
            'api_key' => 'cd64539dd19283cdcc637f2ccddcd45-us6'
        ),
        'madmimi' => array(
            'api_key' => 'JBJiwneJKNJBEhbfwbj2983hu43e'
        )
    )
);


class MySubscriptionForm
{
    var $providers;
    var $provider;

    function __construct($config)
    {
        $this->providers = $config['providers'];
        $this->provider = $config['provider'];
        add_filter('the_content', [$this, 'form']);
        add_action('wp_enqueue_scripts', [$this, 'assets']);
        add_action('wp_ajax_msf_form_submit', [$this, 'submissionHandler']);
        add_action('wp_ajax_nopriv_msf_form_submit', [$this, 'submissionHandler']);
    }

    function form($content)
    {
        if (!is_singular()) {
            return $content;
        }
        wp_enqueue_style('msf-style');

        $nonce_field = wp_nonce_field('msf_form_submit', 'msf_nonce', true, false);

        if (!empty($_GET['msf_success'])) {
            $msf_display = '<div class="msf-success">Thanks for subscribing</div>';
        } else {

            $defaults = array(
                'email' => '<input type="email" placeholder="Email" required="required" name="email">'
            );

            $msf_fields = apply_filters('msf/form_fields', $defaults);

            $msf_display = '
			<h4>Get Free Awesome!</h4>
		    <form method="post" class="msf-form" action="' . admin_url('admin-ajax.php') . '">
		            ' . implode("", $msf_fields) . '
		        <input type="submit" value="Subscribe Now">
				<input type="text" name="name">
				<input type="hidden" name="action" value="msf_form_submit">
		        ' . $nonce_field . '
		    </form>
		';
        }
        return $content . $msf_display;
    }


    function assets()
    {
        //css
        wp_register_style('msf-style', plugin_dir_url(__FILE__) . 'msf-styles.css');

        //js
        wp_register_script('msf_script_js', plugin_dir_url(__FILE__) . 'msf-script.js', array('jquery'), '1.0.2', true);
        wp_enqueue_script('msf_script_js');
    }


    function mailchimpHandler()
    {

        if (empty($_POST['name']) || !isset($_POST['msf_nonce']) || !wp_verify_nonce($_POST['msf_nonce'], 'msf_form_submit')
        ) {
            die();
        }

        wp_remote_post('https://us6.api.mailchimp.com/3.0/lists/bbcd6546db/members', array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('mywebsite' . ':' . $this->providers['mailchimp']['api_key']),
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'email_address' => $_POST['email'],
                'status' => 'subscribed'
            ))
        ));

        $url = add_query_arg('msf_success', 'true', $_SERVER['HTTP_REFERER']);
        wp_redirect($url);
        wp_die();

    }

    function submissionHandler() {

        if( method_exists($this, $this->provider . 'Handler' ) ) {
            call_user_func( array( $this, $this->provider . 'Handler' ) );
        }
        else {
            echo $this->provider . 'Handler does not exist' ;
        }
    }

}

new MySubscriptionForm($config);

