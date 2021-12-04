<?php

namespace App\Services;

class UrlService
{
    public function getYoutubeIdFromUrl($url = null)
    {
        if (!$url) return null;
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);

        if (!isset($params['v']) && !$params['v']) return null;

        return $params['v'];
    }
}
