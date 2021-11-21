<?php

namespace App\Services;

use App\Models\Block;

class BlockService
{
    public function getContent(Block $block)
    {
        switch ($block->type) {
            case 'text':
                $content = str_replace('<div>', '<p>', $block->content);
                $content = str_replace('</div>', '</p>', $content);
                return $content;
                break;

            case 'photo':
                return $this->getPhoto($block);
                break;

            case 'album':
                return $this->getAlbum($block);
                break;
        }
    }

    public function getPhoto(Block $block)
    {
        $result = [];

        $images = $block->getMedia();

        $i = 1;
        foreach ($images as $image) {
            $result[] = [
                'id' => $i,
                'url' => $image->getUrl(),
                'description' => $image->getCustomProperty('caption'),
                'width' => $image->getCustomProperty('width'),
                'height' => $image->getCustomProperty('height'),
            ];

            $i ++;
        }

        return $result;
    }

    public function getAlbum(Block $block)
    {
        $result = [];

        $images = $block->getMedia();

        $i = 1;
        foreach ($images as $image) {
            $result[] = [
                'id' => $i,
                'url' => $image->getUrl(),
                'width' => $image->getCustomProperty('width'),
                'height' => $image->getCustomProperty('height'),
            ];

            $i ++;
        }

        return $result;
    }
}
