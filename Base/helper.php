<?php

function shapeSpace_add_var($url, $key, $value)
{

    $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
    $url = substr($url, 0, -1);

    if (strpos($url, '?') === false) {
        return ($url . '?' . $key . '=' . $value);
    } else {
        return ($url . '&' . $key . '=' . $value);
    }
}

function site_url($uri = ''){
    return BASE_URL . $uri;
}

function current_site_url($uri = '')
{
    return CURRENT_URL . $uri;
}
