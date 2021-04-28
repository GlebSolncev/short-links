<?php

namespace App\Foundation\ShortLinks\DefaultShortLinks\Observers;

use App\Foundation\ShortLinks\DefaultShortLinks\Services\DefaultShortLinksService;
use Illuminate\Database\Eloquent\Model;

class ShortLinkObserver
{
    /**
     * @var DefaultShortLinksService
     */
    protected $shortLinkService;

    /**
     * ShortLinkObserver constructor.
     *
     * @param DefaultShortLinksService $shortLinkService
     */
    public function __construct(DefaultShortLinksService $shortLinkService)
    {
        $this->shortLinkService = $shortLinkService;
    }

    /**
     * @param Model $model
     */
    public function creating(Model $model)
    {
        $this->shortLinkService->checkThisLink($model->url);
        $this->shortLinkService->purgeCache();
    }

    /**
     * @param Model $model
     */
    public function updating(Model $model)
    {
        $this->shortLinkService->purgeCache();
    }
}