<?php

namespace App\Services;

class UrlService
{
    public function getYoutubeIdFromUrl($url = null)
    {
        if (!$url) return null;
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);

        return $params['v'];
    }
}
