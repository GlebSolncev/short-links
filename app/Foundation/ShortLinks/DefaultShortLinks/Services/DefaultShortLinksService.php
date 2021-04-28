<?php

namespace App\Foundation\ShortLinks\DefaultShortLinks\Services;

use App\Foundation\ShortLinks\Contracts\iShortLink;
use App\Foundation\ShortLinks\DefaultShortLinks\Repositories\DefaultShortLinkRepository;
use ErrorException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DefaultShortLinksService
 *
 * @package App\Foundation\ShortLinks\DefaultShortLinks\Services
 */
class DefaultShortLinksService implements iShortLink
{
    /**
     * @var DefaultShortLinkRepository $shortLinkRepository
     */
    protected $shortLinkRepository;

    /**
     * DefaultShortLinksService constructor.
     *
     * @param DefaultShortLinkRepository $shortLinkRepository
     */
    public function __construct(DefaultShortLinkRepository $shortLinkRepository)
    {
        $this->shortLinkRepository = $shortLinkRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function index(): Collection
    {
        if (!Cache::has("resources:short-links")) {
            Cache::put("resources:short-links",
                $this->shortLinkRepository->getWithWhere([], []),
                Carbon::now()->addDay()
            );
        }

        return Cache::get("resources:short-links");
    }

    /**
     * @return Collection
     */
    protected function all(): Collection
    {
        return $this->shortLinkRepository->getWithWhere([], []);
    }

    /**
     * @param string $link
     */
    public function store(string $link)
    {
        $uniqueEndpoint = true;
        while ($uniqueEndpoint) {
            $endpoint = Str::random(6);
            $uniqueEndpoint = $this->checkUniqueEndpoint($endpoint);
        }


        $model = $this->shortLinkRepository->insert([
            'url'      => $link,
            'endpoint' => $endpoint
        ]);

        request()->session()->flash('newLink', route('short-link.show', $model->endpoint));
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    public function redirect($endpoint)
    {
        $model = $this->shortLinkRepository->getWithWhereSingle([], [['endpoint', '=', $endpoint], ['active', '=', true]]);
        if (!$model) {
            throw new NotFoundHttpException('Not found');
        };
        $this->shortLinkRepository->update($model, ['count' => ++$model->count]);
        return $model->url;
    }

    /**
     * @param string $endpoint
     */
    public function setVisible(string $endpoint)
    {
        $model = $this->shortLinkRepository->getWithWhereSingle([], [['endpoint', '=', $endpoint]]);
        $model->active = !$model->active;

        $this->shortLinkRepository->update($model, ['active' => $model->active]);
    }

    /**
     * @param string $endpoint
     * @return void
     */
    public function delete(string $endpoint): void
    {
        $this->shortLinkRepository->deleteWhere([['endpoint', '=', $endpoint]]);

        $this->purgeCache();
    }

    /**
     * @param string $url
     * @throws ErrorException
     */
    public function checkThisLink(string $url){
        $baseUrl = url()->to('/');

        if(strpos($url, $baseUrl) !== false){
            throw new ErrorException("That is already a {$baseUrl} link", 400);
        }
    }

    /**
     * @return void
     */
    public function purgeCache(): void
    {
        Cache::forget('resources:short-links');
    }

    /**
     * @param string $endpoint
     * @return bool
     */
    protected function checkUniqueEndpoint(string $endpoint): bool
    {
        return $this->shortLinkRepository->getWithWhere([], [['endpoint', '=', $endpoint]])->isNotEmpty();
    }
}