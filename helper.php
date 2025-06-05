<?php
function siteUri($uri = "")
{
    return $_ENV["BASE_URL"] . $uri;
}

function niceDD($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function redirect($location = "")
{
    header("Location:" . siteUri($location));
}