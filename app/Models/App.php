<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class App extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'branding' => 'array',
        'link_handling' => 'array',
        'interface' => 'array',
        'website_overide' => 'array',
        'permission' => 'array',
        'navigation' => 'array',
        'notification' => 'array',
        'plugin' => 'array',
        'build_setting' => 'array',
    ];


    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $attributes = [
        'branding' => '{
            "app_icon": "",
            "icons": {
                "ios": "",
                "android": ""
            },
            "splashScreen": {
                "ios": {
                    "launchImages": "",
                    "launchImagesDark": "",
                    "showSplash": true,
                    "backgroundColor": "#FFFFFF",
                    "backgroundColorDark": "#000000"
                },
                "android": {
                    "launchImages": "",
                    "launchImagesDark": "",
                    "showSplash": true,
                    "backgroundColor": "#FFFFFF",
                    "backgroundColorDark": "#000000"
                }
            },
            "themeColors": {
                "ios": {
                    "primaryColor": "#007aff",
                    "primaryColorDark": "#adc5dc"
                },
                "android": {
                    "primaryColor": "#009688",
                    "primaryColorDark": "#80cbc4"
                }
            },
            "statusBar": {
                "ios": {
                    "style": "auto",
                    "overlay": false,
                    "blur": false,
                    "backgroundColor": "#ffffffff",
                    "backgroundColorDark": "#000000"
                },
                "android": {
                    "style": "auto",
                    "overlay": false,
                    "backgroundColor": "#5C5C5C",
                    "backgroundColorDark": "#333333"
                }
            }
        }',
        'link_handling' => '{
            "internalVsExternalLinks": {
                "active": true,
                "items": [
                    {
                        "id": 1,
                        "label": "Non-web links",
                        "regex": "^(?!https?://).*",
                        "mode": "external"
                    },
                    {
                        "id": 2,
                        "label": "Facebook",
                        "regex": "https?://([-\\w]+\\.)*facebook\\.com.*",
                        "mode": "appbrowser"
                    },
                    {
                        "id": 3,
                        "label": "Twitter",
                        "regex": "https?://([-\\w]+\\.)*twitter\\.com/.*",
                        "mode": "appbrowser"
                    },
                    {
                        "id": 4,
                        "label": "Instagram",
                        "regex": "https?://([-\\w]+\\.)*instagram\\.com/.*",
                        "mode": "external"
                    },
                    {
                        "id": 5,
                        "label": "Google Maps",
                        "regex": "https?://maps\\.google\\.com.*",
                        "mode": "external"
                    },
                    {
                        "id": 6,
                        "label": "Google Maps Search",
                        "regex": "https?://([-\\w]+\\.)*google\\.com/maps/search/.*",
                        "mode": "external"
                    },
                    {
                        "id": 7,
                        "label": "LinkedIn",
                        "regex": "https?://([-\\w]+\\.)*linkedin\\.com/.*",
                        "mode": "external"
                    },
                    {
                        "id": 8,
                        "label": "All Other Links",
                        "regex": ".*",
                        "mode": "internal"
                    }
                ],
                "itemsDefault": [
                    {
                        "mode": "external",
                        "label": "Non-web links",
                        "pagesToTrigger": "custom",
                        "regex": "^(?!https?://).*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "Facebook",
                        "pagesToTrigger": "custom",
                        "regex": "https?://([-\\w]+\\.)*facebook\\.com.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "Twitter/X",
                        "pagesToTrigger": "custom",
                        "regex": "https?://([\\-\\w]+\\.)*(twitter|x)\\.com/.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "Instagram",
                        "pagesToTrigger": "custom",
                        "regex": "https?://([-\\w]+\\.)*instagram\\.com/.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "Google Maps",
                        "pagesToTrigger": "custom",
                        "regex": "https?://maps\\.google\\.com.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "Google Maps Search",
                        "pagesToTrigger": "custom",
                        "regex": "https?://([-\\w]+\\.)*google\\.com/maps/search/.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "LinkedIn",
                        "pagesToTrigger": "custom",
                        "regex": "https?://([-\\w]+\\.)*linkedin\\.com/.*"
                    },
                    {
                        "mode": "internal",
                        "label": "Microsoft Login",
                        "pagesToTrigger": "custom",
                        "regex": "https?://login\\.microsoftonline\\.com.*"
                    },
                    {
                        "mode": "appbrowser",
                        "label": "All Other Links",
                        "pagesToTrigger": "all",
                        "regex": ".*"
                    }
                ]
            },
            "universalLinks": [],
            "enableAndroidApplinks": false,
            "androidApplinksCertHash": "6A:BE:8D:D0:DB:37:2B:66:CC:EC:A6:1F:8E:75:4C:71:DE:D5:86:5E:CF:FE:8F:F4:70:C3:82:D9:95:5E:FF:63",
            "urlSchemeProtocol": ""
        }',
        'interface' => '{
            "keepScreenOn": true,
            "fullScreen": {
                "ios": true,
                "android": true
            },
            "darkMode": {
                "ios": "dark",
                "android": "auto"
            },
            "screenOrientation": {
                "iphone": "auto",
                "ipad": "auto",
                "androidPhone": "auto",
                "androidTablet": "auto"
            },
            "nativePageTransitions": {
                "active": true,
                "alpha": 0.5
            },
            "spinner": {
                "android": {
                    "color": "#808080",
                    "colorDark": "#808080"
                },
                "ios": {
                    "color": "#808080",
                    "colorDark": "#808080"
                }
            },
            "pullToRefresh": {
                "ios": {
                    "active": true
                },
                "android": {
                    "active": false,
                    "iconColor": "#1A100B",
                    "iconColorDark": "#FFFFFF"
                }
            },
            "swipeGestures": {
                "value": true,
                "android": {
                    "backgroundColor": "#FFFFFF",
                    "backgroundColorDark": "#333333",
                    "activeColor": "#000000",
                    "activeColorDark": "#FFFFFF",
                    "inactiveColor": "#666666",
                    "inactiveColorDark": "#666666"
                }
            },
            "pinchToZoom": {
                "ios": false,
                "android": true
            }
        }'
];
}
