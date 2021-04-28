<?php

namespace App\Foundation\ShortLinks;

use App\Foundation\ShortLinks\Contracts\iShortLink;

class ShortLinkManager
{
    /**
     * @param iShortLink $iShortLink
     * @param string $url
     * @return bool
     */
    public function short(iShortLink $iShortLink, string $url){
        return $iShortLink->short($url);
    }

    /**
     * @param \App\Foundation\ShortLinks\Contracts\iShortLink $iShortLink
     * @return array
     */
    public function index(iShortLink $iShortLink){
        return $iShortLink->index();
    }
}