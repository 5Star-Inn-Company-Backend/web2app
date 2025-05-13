<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\convert;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConvertAppController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        convert::updateOrCreate([
            "url" => $request->url,
            "email" => $request->email
        ]);
    }

    public function fetchApp($private, $type)
    {

        $app = App::where('private_link', $private)->latest()->first();

        if (!$app) {
            return response()->json([
                'error' => 'App not found',
                'status' => false
            ]);
        }

        if (!in_array($type, ['android', 'ios'])) {
            return response()->json([
                'error' => 'Type not supported',
                'status' => false
            ]);
        }

        $fullscreen = $app->interface['fullScreen'][$type];
        $enableAdvt = strtolower($app->plan) == 'free' ? "true" : "false";

        $menus = $app->navigation['bottomTabBar']['tabMenus'][0]['items'];
        $enableMenu = "true";


        $config = '{
              "public": {
                "appName": "' . $app->name . '",
                "initialUrl": "' . $app->url . '",
                "userAgent": "web2app",
                "primaryColor": "' . $app->branding['themeColors'][$type]['primaryColor'] . '",
                "fullScreen": ' . $fullscreen . ',
                "forceScreenOrientation": false,
                "enableAdvt": ' . $enableAdvt . '
              },
              "navigations": {
                "tab": {
                  "menus": ' . json_encode($menus) . ',
                  "active": ' . $enableMenu . '
                },
                "drawer": {
                  "items": [
                    {
                      "label": "Sample Home",
                      "url": "https://trixwallet.com",
                      "icon": "fas fa-home"
                    },
                    {
                      "label": "Sample About",
                      "url": "https://trixwallet.com/about",
                      "icon": "fas fa-user"
                    }
                  ],
                  "active": false
                },
                "androidPullToRefresh": false,
                "iosPullToRefresh": true,
                "navigationTitles": {
                  "titles": [
                    {}
                  ],
                  "active": false
                },
                "toolbarNavigation": {
                  "items": [
                    {
                      "system": "back",
                      "title": "Back"
                    },
                    {
                      "system": "forward",
                      "title": "Forward"
                    },
                    {
                      "system": "refresh"
                    }
                  ]
                },
                "androidShowRefreshButton": false,
                "deepLinkDomains": {
                  "domains": [],
                  "enableAndroidApplinks": false
                },
                "dynamicLink": {
                  "enableDynamicLink": true,
                  "uriPrefix": "https://web2app.page.link",
                  "linkPrefix": "https://web2app.app/link",
                  "android" : {
                    "enable": true,
                    "packageName": "' . $app->build_setting['appIdentifiers']['android']['packageName'] . '",
                    "minimumVersion": "1"
                  },
                  "ios" : {
                    "enable": true,
                    "bundleId": "' . $app->build_setting['appIdentifiers']['ios']['bundleId'] . '",
                    "minimumVersion": "1"
                  }
                }
              },
              "styling": {
                "transitionInteractiveDelayMax": 0.2,
                "menuAnimationDuration": 0.15,
                "androidShowSplash": true,
                "disableAnimations": false,
                "hideWebviewAlpha": 0.5,
                "showActionBar": true,
                "showNavigationBar": true,
                "iosSidebarFont": "Default",
                "androidHideTitleInActionBar": true,
                "navigationTitleImage": true,
                "iosTheme": "default",
                "androidTheme": "light",
                "androidSidebarBackgroundColor": "#FFFFFF",
                "androidSidebarForegroundColor": "#1E496E",
                "androidActionBarBackgroundColor": "#FFFFFF",
                "androidActionBarForegroundColor": "#1E496E",
                "androidPullToRefreshColor": "#1E496E",
                "androidAccentColor": "#1E496E",
                "androidSidebarSeparatorColor": "#CCCCCC",
                "androidTabBarBackgroundColor": "#FFFFFF",
                "androidTabBarTextColor": "#949494",
                "androidTabBarIndicatorColor": "#1E496E",
                "androidStatusBarBackgroundColor": "#5C5C5C",
                "iosTintColor": "#1E496E",
                "iosTitleColor": "#1E496E",
                "iosSidebarTextColor": "#1E496E"
              },
              "permissions": {
                "usesGeolocation": false,
                "androidDownloadToPublicStorage": false,
                "enableWebRTC": false
              },
              "performance": {
                "webviewPools": [
                  {
                    "urls": [
                      {
                        "disown": "reload"
                      }
                    ]
                  }
                ]
              },
              "services": {
              }
            }';

        return response()->json([
            'data' => json_decode($config),
            'error' => '',
            'status' => true
        ]);

    }
}
