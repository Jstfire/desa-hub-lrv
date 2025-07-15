<?php

namespace App\View\Composers;

use App\Models\Desa;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterComposer
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function compose(View $view)
    {
        $footerSections = collect();
        $desaUri = $this->request->route('uri');

        if ($desaUri) {
            $desa = Desa::where('uri', $desaUri)->first();
            if ($desa) {
                $footerSections = Footer::where('desa_id', $desa->id)
                    ->where('is_active', true)
                    ->get()
                    ->keyBy('section');
            }
        }

        $view->with('footerSections', $footerSections);
    }
}
