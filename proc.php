<?php
// Cut text down to required length
function get_chirp_text($text)
{
    return substr($text, 0, 200);
}

// Parse hashtags from text
function get_hashtags($text)
{
    preg_match_all("/S*#((?:\[[^\]]+\]|\S+))/", $text, $matches);
    var_dump($matches);

    return $matches;
}

// Create the final chirp text
function create_chirp($text)
{
    $chirp_text = get_chirp_text($text);
    $hastags = get_hashtags($chirp_text);
    if (!empty($hastags[1])) {
        foreach ($hastags[1] as $key => $match) {
            $hastags[1][$key] = "<a href='http://chirp.chip/hastags/" . $match . "/'>" . '#' . $match . "</a>";
        }
        var_dump($hastags[0]);
        $chirp_text = str_replace($hastags[0], $hastags[1], $chirp_text);
    }

    return $chirp_text;
}

$text = 'This is a chirp with an #example hashtag created with code that is #procedural';
echo create_chirp($text);