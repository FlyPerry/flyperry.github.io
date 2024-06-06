<?php

require_once('libwebtopay/WebToPay.php');

function getSelfUrl(): string
{
    $url = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'));

    if (isset($_SERVER['HTTPS']) === true) {
        $url .= ($_SERVER['HTTPS'] === 'on') ? 's' : '';
    }

    $url .= '://' . $_SERVER['HTTP_HOST'];

    if (isset($_SERVER['SERVER_PORT']) === true && $_SERVER['SERVER_PORT'] !== '80') {
        $url .= ':' . $_SERVER['SERVER_PORT'];
    }

    $url .= dirname($_SERVER['SCRIPT_NAME']);

    return $url;
}

