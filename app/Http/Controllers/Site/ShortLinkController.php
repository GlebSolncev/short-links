<?php

namespace App\Http\Controllers\Site;

use App\Foundation\ShortLinks\Contracts\iShortLink;
use App\Foundation\ShortLinks\DefaultShortLinks\Requests\ShortLinkRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShortLinkController extends Controller
{
    /**
     * @var iShortLink
     */
    protected $shortLinkManager;

    /**
     * ShortLinkController constructor.
     */
    public function __construct(iShortLink $shortLinkManager)
    {
        $this->shortLinkManager = $shortLinkManager;
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('index', [
            'links' => $this->shortLinkManager->index()
        ]);
    }

    /**
     * @param \App\Foundation\ShortLinks\DefaultShortLinks\Requests\ShortLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShortLinkRequest $request)
    {
        $this->shortLinkManager->store($request->link);

        return redirect()->back();
    }

    /**
     * @param $endpoint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($endpoint)
    {
        $url = $this->shortLinkManager->redirect($endpoint);
        return redirect()->to($url);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $endpoint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $endpoint)
    {
        $this->shortLinkManager->setVisible($endpoint);

        return redirect()->back();
    }

    /**
     * @param $endpoint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($endpoint)
    {
        $this->shortLinkManager->delete($endpoint);

        return redirect()->back();
    }
}
