<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Update;
use App\Models\Work;
use Illuminate\Http\Request;

class MetaImageController extends Controller
{
    public function __invoke(Request $request)
    {
        $default = Setting::where('key', 'index_banner_md')->first();
        $imageZh = $imageEn = $imageJp = $default->getFirstMediaUrl();

        $route = substr($request->input('route'), 1);

        $array = explode('/', $route);

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $itemZh = $itemJp = $itemEn = null;

        switch ($array[0]) {

            case 'ourworks':

                if (isset($array[1])) {
                    $itemZh = Work::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemEn = Work::where('language_id', $en->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemJp = Work::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $array[1])->first();
                }

                break;

            case 'ourupdates':

                if (isset($array[1])) {
                    $itemZh = Update::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemEn = Update::where('language_id', $en->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemJp = Update::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $array[1])->first();
                }

                break;

            case 'ourbusiness':

                if (isset($array[1])) {
                    $itemZh = Business::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemEn = Business::where('language_id', $en->id)->where('enabled', 1)->where('slug', $array[1])->first();
                    $itemJp = Business::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $array[1])->first();
                }

                break;
        }

        if ($itemZh && $itemZh->getFirstMediaUrl()) $imageZh = $itemZh->getFirstMediaUrl();
        if ($itemEn && $itemEn->getFirstMediaUrl()) $imageEn = $itemEn->getFirstMediaUrl();
        if ($itemJp && $itemJp->getFirstMediaUrl()) $imageJp = $itemJp->getFirstMediaUrl();

        return response()->json([
            'result' => true,
            'en' => $imageEn,
            'cn' => $imageZh,
            'jp' => $imageJp
        ]);
    }
}
