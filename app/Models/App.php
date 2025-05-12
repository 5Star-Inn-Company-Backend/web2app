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
//        'link_handling' => '{
//            "internalVsExternalLinks": {
//                "active": true,
//                "items": [
//                    {
//                        "id": 1,
//                        "label": "Non-web links",
//                        "regex": "^(?!https?://).*",
//                        "mode": "external"
//                    },
//                    {
//                        "id": 2,
//                        "label": "Facebook",
//                        "regex": "https?://([-\\w]+\\.)*facebook\\.com.*",
//                        "mode": "appbrowser"
//                    },
//                    {
//                        "id": 3,
//                        "label": "Twitter",
//                        "regex": "https?://([-\\w]+\\.)*twitter\\.com/.*",
//                        "mode": "appbrowser"
//                    },
//                    {
//                        "id": 4,
//                        "label": "Instagram",
//                        "regex": "https?://([-\\w]+\\.)*instagram\\.com/.*",
//                        "mode": "external"
//                    },
//                    {
//                        "id": 5,
//                        "label": "Google Maps",
//                        "regex": "https?://maps\\.google\\.com.*",
//                        "mode": "external"
//                    },
//                    {
//                        "id": 6,
//                        "label": "Google Maps Search",
//                        "regex": "https?://([-\\w]+\\.)*google\\.com/maps/search/.*",
//                        "mode": "external"
//                    },
//                    {
//                        "id": 7,
//                        "label": "LinkedIn",
//                        "regex": "https?://([-\\w]+\\.)*linkedin\\.com/.*",
//                        "mode": "external"
//                    },
//                    {
//                        "id": 8,
//                        "label": "All Other Links",
//                        "regex": ".*",
//                        "mode": "internal"
//                    }
//                ],
//                "itemsDefault": [
//                    {
//                        "mode": "external",
//                        "label": "Non-web links",
//                        "pagesToTrigger": "custom",
//                        "regex": "^(?!https?://).*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "Facebook",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://([-\\w]+\\.)*facebook\\.com.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "Twitter/X",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://([\\-\\w]+\\.)*(twitter|x)\\.com/.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "Instagram",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://([-\\w]+\\.)*instagram\\.com/.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "Google Maps",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://maps\\.google\\.com.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "Google Maps Search",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://([-\\w]+\\.)*google\\.com/maps/search/.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "LinkedIn",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://([-\\w]+\\.)*linkedin\\.com/.*"
//                    },
//                    {
//                        "mode": "internal",
//                        "label": "Microsoft Login",
//                        "pagesToTrigger": "custom",
//                        "regex": "https?://login\\.microsoftonline\\.com.*"
//                    },
//                    {
//                        "mode": "appbrowser",
//                        "label": "All Other Links",
//                        "pagesToTrigger": "all",
//                        "regex": ".*"
//                    }
//                ]
//            },
//            "universalLinks": [],
//            "enableAndroidApplinks": false,
//            "androidApplinksCertHash": "6A:BE:8D:D0:DB:37:2B:66:CC:EC:A6:1F:8E:75:4C:71:DE:D5:86:5E:CF:FE:8F:F4:70:C3:82:D9:95:5E:FF:63",
//            "urlSchemeProtocol": ""
//        }',
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
        }',
        'website_overide'=>'{
            "customUserAgent": {
                "ios": "web2app",
                "android": "web2app"
            },
            "css": {
                "android": "https://s3.amazonaws.com/gonativeio/app_files/rywqmn/custom_css_1743674200244.css",
                "ios": "https://s3.amazonaws.com/gonativeio/app_files/rywqmn/custom_css_1743674200244.css"
            },
            "script": {
                "ios": "https://s3.amazonaws.com/gonativeio/app_files/rywqmn/ios_custom_js_1743674200240.js",
                "android": "https://s3.amazonaws.com/gonativeio/app_files/rywqmn/android_custom_js_1743674200252.js"
            }
        }',
        'permission'=>'{
            "appTrackingTransparency": {
                "ios": false
            },
            "locationServices": {
                "android": false
            },
            "webRtc": {
                "android": {
                    "cameraActive": false,
                    "microphoneActive": false
                }
            },
            "downloadsDirectory": {
                "android": "internal"
            },
            "backgroundAudio": {
                "ios": true
            },
            "camera": {
                "ios": {
                    "description": ""
                }
            },
            "microphone": {
                "ios": {
                    "description": ""
                }
            }
        }',
        'navigation'=>'{
            "topNavigationBar": {
                "enable": {
                    "ios": {
                        "active": true
                    },
                    "android": {
                        "active": true
                    }
                },
                "styling": {
                    "ios": {
                        "defaultDisplay": "text",
                        "imageType": "appIcon",
                        "newImage": "assets/defaults/app-icon-placeholder.png",
                        "newImageDark": "assets/defaults/app-icon-placeholder.png",
                        "textColor": "#333333",
                        "textColorDark": "#adc5dc",
                        "tintColor": "#f8f8f8",
                        "tintColorDark": "#333333"
                    },
                    "android": {
                        "backgroundColor": "#FFFFFF",
                        "backgroundColorDark": "#333333",
                        "defaultDisplay": "text",
                        "imageType": "appIcon",
                        "newImage": "assets/defaults/app-icon-placeholder.png",
                        "newImageDark": "assets/defaults/app-icon-placeholder.png",
                        "textColor": "#1A100B",
                        "textColorDark": "#FFFFFF"
                    }
                },
                "customIcons": {
                    "actions": [
                        {
                            "id": "2",
                            "items": [
                                {
                                    "icon": "fas fa-rotate-right",
                                    "label": "Refresh",
                                    "system": "refresh",
                                    "url": ""
                                },
                                {
                                    "icon": "fas fa-share-square",
                                    "label": "Share",
                                    "system": "share",
                                    "url": ""
                                },
                                {
                                    "icon": "fas fa-magnifying-glass",
                                    "label": "GSearch",
                                    "system": "url",
                                    "url": "https://google.com"
                                }
                            ]
                        }
                    ],
                    "available": [
                        {
                            "icon": "fas fa-rotate-right",
                            "label": "",
                            "system": "refresh",
                            "url": "",
                            "name": "Refresh"
                        },
                        {
                            "icon": "fas fa-share-square",
                            "label": "Share",
                            "system": "share",
                            "url": "",
                            "name": "Share"
                        },
                        {
                            "icon": "fas fa-magnifying-glass",
                            "label": "GSearch",
                            "system": "url",
                            "url": "https://google.com",
                            "name": "url"
                        }
                    ],
                    "actionSelection": [],
                    "active": true
                }
            },
            "sidebarNavigationBar": {
                "active": false,
                "styling": {
                    "ios": {
                        "backgroundColor": "#f8f8f8",
                        "backgroundColorDark": "#333333",
                        "sidebarFont": "Default",
                        "sidebarImage": "https://s3.amazonaws.com/gonativeio/images_generated/pkt29zhnu29u0_1694683672242.png",
                        "sidebarImageDark": "https://s3.amazonaws.com/gonativeio/images_generated/pkt29zhnu29u0_1694683672242.png",
                        "textColor": "#333333",
                        "textColorDark": "#adc5dc",
                        "type": "appIcon"
                    },
                    "android": {
                        "showAppName": true,
                        "showLogo": true,
                        "backgroundColor": "#FFFFFF",
                        "backgroundColorDark": "#333333",
                        "foregroundColor": "#1A100B",
                        "foregroundColorDark": "#FFFFFF",
                        "separatorColor": "#CCCCCC",
                        "separatorColorDark": "#666666",
                        "highlightColor": "#1A100B",
                        "highlightColorDark": "#FFFFFF"
                    }
                },
                "items": [
                    {
                        "url": "https://webhosting.5starcompany.com.ng/index.php",
                        "label": "",
                        "subLinks": [],
                        "icon": ""
                    },
                    {
                        "url": "https://webhosting.5starcompany.com.ng/#",
                        "label": "Store",
                        "subLinks": [],
                        "icon": "fas fa-store"
                    },
                    {
                        "url": "https://webhosting.5starcompany.com.ng/cart.php",
                        "label": "Browse all",
                        "subLinks": [],
                        "icon": "fas fa-store"
                    }
                ]
            },
            "bottomTabBar": {
                "active": false,
                "styling": {
                    "android": {
                        "backgroundColor": "#FFFFFF",
                        "backgroundColorDark": "#333333",
                        "textColor": "#949494",
                        "textColorDark": "#FFFFFF",
                        "indicatorColor": "#1A100B",
                        "indicatorColorDark": "#666666"
                    },
                    "ios": {
                        "tintColor": "#f8f8f8",
                        "tintColorDark": "#333333",
                        "inactiveColor": "#A1A1A1",
                        "inactiveColorDark": "#818181"
                    }
                },
                "tabMenus": [
                    {
                        "items": [
                            {
                                "icon": "fas fa-home",
                                "inactiveIcon": "far fa-home",
                                "label": "Home",
                                "url": "https://webhosting.5starcompany.com.ng/"
                            },
                            {
                                "label": "News",
                                "icon": "fas fa-newspaper",
                                "inactiveIcon": "far fa-newspaper",
                                "url": "https://webhosting.5starcompany.com.ng/news"
                            },
                            {
                                "label": "Directory",
                                "icon": "fas fa-address-book",
                                "inactiveIcon": "far fa-address-book",
                                "url": "https://webhosting.5starcompany.com.ng/directory"
                            },
                            {
                                "icon": "fas fa-anchor-circle-check",
                                "label": "Sammy",
                                "system": "javascript",
                                "url": "javascript:"
                            }
                        ],
                        "availableIcons":[
                            "fas fa-align-justify",
                            "fas fa-align-left",
                            "fas fa-anchor-circle-xmark",
                            "fas fa-angle-right",
                            "fas fa-ankh",
                            "fas fa-arrow-up-long",
                            "fas fa-asterisk",
                            "fas fa-hourglass",
                            "fas fa-house-lock",
                            "fas fa-home",
                            "fas fa-newspaper"
                        ]
                    }
                ]
            }
        }',
        'notification'=>'{
            "oneSignal": {
                "active": true,
                "autoRegister": true,
                "requiresUserPrivacyConsent": false,
                "showForegroundNotifications": true,
                "applicationId": "9a1b27aa-b8a2-4347-abb4-d6bc7c12af8c"
            },
            "notification_icon": {
                "android": ""
            },
            "notification_sound": []
        }',
        'plugin'=>'[
            {
                "id": "one_signal",
                "name": "OneSignal",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "social_login",
                "name": "Social Login",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "qr_scanner",
                "name": "QR / Barcode Scanner",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "g_firbase_analytics",
                "name": "Google Firebase Analytics",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "biometrics",
                "name": "Face ID/Touch ID Android Biometrics",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "inapp_purchases",
                "name": "In-App Purchases",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "app_review",
                "name": "App Review",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "share_into_app",
                "name": "Share into app",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "native_datastore",
                "name": "Native Datastore",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "background_location",
                "name": "Background Location",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "haptics",
                "name": "Haptics",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "native_media_player",
                "name": "Native Media Player",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "native_contacts",
                "name": "Native Contacts",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "document_scanner",
                "name": "Document Scanner",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "calendar",
                "name": "Calendar",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "nfc_scanner",
                "name": "NFC Tag Scanner",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "zoom",
                "name": "Zoom",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            },
            {
                "id": "konn3ct",
                "name": "Konn3ct",
                "isActive": false,
                "amount": "2000",
                "docLink": "https://web2app.5starcompany.com.ng"
            }
        ]',
        'build_setting'=>'{
        "appIdentifiers": {
            "ios": {
                "bundleId": "com.app"
            },
            "android": {
                "packageName": "com.app",
                "version":"1.0"
            }
        },
        "downloadLinks": {
            "androidLink": "https://gonativeio-apps.s3-accelerate.amazonaws.com/static/6502d230ea97c027fa3e9182/app-release.apk",
            "androidAppBundleLink": "https://gonativeio-apps.s3-accelerate.amazonaws.com/static/6502d230ea97c027fa3e9182/app-bundle.aab",
            "androidSource": "https://gonativeio-apps.s3-accelerate.amazonaws.com/static/6502d230ea97c027fa3e9182/android_source.tar.gz",
            "iosSource": "https://gonativeio-apps.s3-accelerate.amazonaws.com/static/6502d230ea97c027fa3e9181/ios_source.tar.gz",
            "iosLink": null
        },
        "androidLastBuiltDate": {
            "binary": "2025-04-04T23:38:24.037Z",
            "source": "2025-04-04T23:38:24.037Z"
        },
        "iosLastBuiltDate": {
            "binary": "2025-04-04T23:38:48.518Z",
            "source": "2025-04-04T23:38:48.518Z"
        },
        "androidLastBuiltBy": {
            "source": "Odejinmi Samuel",
            "sourceBuiltBySuperUser": false,
            "binary": "Odejinmi Samuel"
        },
        "iosLastBuiltBy": {
            "source": "Odejinmi Samuel",
            "sourceBuiltBySuperUser": false,
            "binary": "Odejinmi Samuel"
        },
        "androidReleaseSigningCertificate": {
            "sha1": null,
            "sha256": null,
            "hash": null
        },
        "google_service": {
            "android":"",
            "ios":""
        }
    }'
];
}
