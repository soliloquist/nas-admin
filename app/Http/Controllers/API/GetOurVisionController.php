<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Setting;
use App\Models\Team;

class GetOurVisionController extends Controller
{
    public function __invoke()
    {
        $setting = Setting::all();

        $video = $setting->firstWhere('key', 'vision_video_url');

        $enVision = $setting->firstWhere('key', 'vision_intro_en');
        $jpVision = $setting->firstWhere('key', 'vision_intro_jp');
        $cnVision = $setting->firstWhere('key', 'vision_intro_cn');

        $teams = Team::with('members.specialty')->get()->map(function($team) {
            return [
                'id' => $team->id,
                'department' => $team->title,
                'member' => $team->members()->where('members.enabled', 1)->get()->map(function($member) {
                    $image = $member->getFirstMedia();
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'title' => $member->title,
                        'type' => $member->specialty->color,
                        'image' => [
                            'url' => $image ? $image->getUrl() : null,
                            'width' => $image ? $image->getCustomProperty('width') : null,
                            'height' => $image ? $image->getCustomProperty('height') : null
                        ]
                    ];
                })
            ];
        });

        $clients = Client::where('enabled', 1)->take(10)->get()->map(function($c) {
            $image = $c->getFirstMedia();
            return [
                'id' => $c->id,
                'image' => [
                    'url' => $image->getUrl(),
                    'width' => $image->getCustomProperty('width'),
                    'height' => $image->getCustomProperty('height')
                ]
            ];
        });


        return response()->json([
            'result' => true,
            'en' => [
                'intro' => $enVision
            ],
            'cn' => [
                'intro' => $cnVision
            ],
            'jp' => [
                'intro' => $jpVision
            ],
            'video' => $video->value,
            'team' => $teams,
            'client' => $clients,
        ]);
    }
}
