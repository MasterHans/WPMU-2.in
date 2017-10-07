<?php
class Chirp {
    var $text;
    var $length;
    var $hashtags;
    var $chirp;

    function __construct( $text ) {
        $this->hashtag_base = 'http://chirp.chip/hastags/';
        $this->text = $text;
        $this->set_length();
    }

    function set_length() {
        $this->length = 200;
    }

    function set_hashtags() {
        preg_match_all("/S*#((?:\[[^\]]+\]|\S+))/", $this->text, $matches);
        $hashtags = array();
        foreach( $matches[1] as $key => $match ) {
            $hashtags['#' . $match] = "<a href='http://chirp.chip/hastags/" . $match . "/'>" . '#' . $match . "</a>";
        }
        $this->hashtags = $hashtags;
    }

    function get_chirp() {
        $chirp = substr( $this->text, 0, $this->length );
        if( !empty( $this->hashtags ) ) {
            $chirp = str_replace( array_keys( $this->hashtags )  , array_values(    $this->hashtags ), $chirp);
        }
        return $chirp;
    }

    function displayWithLinks (){
        $this->set_hashtags();
        echo $this->get_chirp();
    }

    function displayWithOutLinks (){
        echo $this->get_chirp();
    }

}


$chirp = new Chirp('This is a chirp with an #example hashtag created with code that is #procedural');

$chirp->displayWithOutLinks();
