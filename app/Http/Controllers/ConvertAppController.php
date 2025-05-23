<?php

namespace App\Http\Controllers;

use App\Jobs\StartAppBuildJob;
use App\Models\App;
use App\Models\Build;
use App\Models\convert;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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

    public function fetchApp(string $private, string $type)
    {
        $app = App::where('private_link', $private)->latest()->first();

        if (!$app) {
            return response()->json([
                'error' => 'App not found',
                'status' => false,
            ]);
        }

        if (!in_array($type, ['android', 'ios'])) {
            return response()->json([
                'error' => 'Type not supported',
                'status' => false,
            ]);
        }

        $fullscreen = data_get($app->interface, "fullScreen.{$type}", false) ? 'true' : 'false';
        $enableAdvt = Str::lower(data_get($app->plan, '')) === 'free' ? 'true' : 'false';
        $menus = data_get($app->navigation, 'bottomTabBar.tabMenus.0.items', []);
        $enableMenu = 'true';
        $primaryColor = data_get($app->branding, "themeColors.{$type}.primaryColor", '#FFFFFF'); // Default to white if not found
        $packageName = data_get($app->build_setting, 'appIdentifiers.android.packageName', 'com.example.android'); // Default package name
        $bundleId = data_get($app->build_setting, 'appIdentifiers.ios.bundleId', 'com.example.ios'); // Default bundle ID

        $config = [
            'public' => [
                'appName' => $app->name,
                'initialUrl' => $app->url,
                'userAgent' => 'web2app',
                'primaryColor' => $primaryColor,
                'fullScreen' => $fullscreen,
                'forceScreenOrientation' => false,
                'enableAdvt' => $enableAdvt,
            ],
            'navigations' => [
                'tab' => [
                    'menus' => $menus,
                    'active' => $enableMenu,
                ],
                'drawer' => [
                    'items' => [
                        [
                            'label' => 'Sample Home',
                            'url' => 'https://trixwallet.com',
                            'icon' => 'fas fa-home',
                        ],
                        [
                            'label' => 'Sample About',
                            'url' => 'https://trixwallet.com/about',
                            'icon' => 'fas fa-user',
                        ],
                    ],
                    'active' => false,
                ],
                'androidPullToRefresh' => false,
                'iosPullToRefresh' => true,
                'navigationTitles' => [
                    'titles' => [
                        (object) [],
                    ],
                    'active' => false,
                ],
                'toolbarNavigation' => [
                    'items' => [
                        [
                            'system' => 'back',
                            'title' => 'Back',
                        ],
                        [
                            'system' => 'forward',
                            'title' => 'Forward',
                        ],
                        [
                            'system' => 'refresh',
                        ],
                    ],
                ],
                'androidShowRefreshButton' => false,
                'deepLinkDomains' => [
                    'domains' => [],
                    'enableAndroidApplinks' => false,
                ],
                'dynamicLink' => [
                    'enableDynamicLink' => true,
                    'uriPrefix' => 'https://web2app.page.link',
                    'linkPrefix' => 'https://web2app.app/link',
                    'android' => [
                        'enable' => true,
                        'packageName' => $packageName,
                        'minimumVersion' => '1',
                    ],
                    'ios' => [
                        'enable' => true,
                        'bundleId' => $bundleId,
                        'minimumVersion' => '1',
                    ],
                ],
            ],
            'styling' => [
                'transitionInteractiveDelayMax' => 0.2,
                'menuAnimationDuration' => 0.15,
                'androidShowSplash' => data_get($app->branding, 'splashScreen.android.showSplash', true),
                'disableAnimations' => false,
                'hideWebviewAlpha' => 0.5,
                'showActionBar' => true,
                'showNavigationBar' => true,
                'iosSidebarFont' => 'Default',
                'androidHideTitleInActionBar' => true,
                'navigationTitleImage' => true,
                'iosTheme' => 'default',
                'androidTheme' => 'light',
                'androidSidebarBackgroundColor' => '#FFFFFF',
                'androidSidebarForegroundColor' => '#1E496E',
                'androidActionBarBackgroundColor' => '#FFFFFF',
                'androidActionBarForegroundColor' => '#1E496E',
                'androidPullToRefreshColor' => '#1E496E',
                'androidAccentColor' => '#1E496E',
                'androidSidebarSeparatorColor' => '#CCCCCC',
                'androidTabBarBackgroundColor' => '#FFFFFF',
                'androidTabBarTextColor' => '#949494',
                'androidTabBarIndicatorColor' => '#1E496E',
                'androidStatusBarBackgroundColor' => '#5C5C5C',
                'iosTintColor' => '#1E496E',
                'iosTitleColor' => '#1E496E',
                'iosSidebarTextColor' => '#1E496E',
            ],
            'permissions' => [
                'usesGeolocation' => false,
                'androidDownloadToPublicStorage' => false,
                'enableWebRTC' => false,
            ],
            'performance' => [
                'webviewPools' => [
                    [
                        'urls' => [
                            [
                                'disown' => 'reload',
                            ],
                        ],
                    ],
                ],
            ],
            'services' => (object) [],
        ];

        return response()->json([
            'data' => $config,
            'error' => '',
            'status' => true,
        ]);
    }

    public function fetchPubApp(string $public)
    {
        $app = App::where('public_link', $public)->latest()->first();

        if (!$app) {
            return response()->json([
                'error' => 'App not found',
                'status' => false,
            ]);
        }

        $config = [
            'name' => $app->name,
            'url' => $app->url,
            'private_link' => $app->private_link,
            'public_link' => $app->public_link,
            'description' => $app->description,
            'plan' => $app->plan,
            'build_setting' => !empty($app->build_setting) ? $app->build_setting : null,
        ];

        return response()->json([
            'data' => $config,
            'error' => '',
            'status' => true,
        ]);
    }

    public function buidApp(string $private, string $type)
    {
        $app = App::where('private_link', $private)->latest()->first();

        if (!$app) {
            return response()->json([
                'error' => 'App not found',
                'status' => false,
            ]);
        }

        if (!in_array($type, ['android', 'ios'])) {
            return response()->json([
                'error' => 'Type not supported',
                'status' => false,
            ]);
        }

        StartAppBuildJob::dispatch($app->private_link);

        return response()->json([
            'message' => "Build Started Successfully",
            'error' => '',
            'status' => true,
        ]);
    }

    public function buidAppStatus(string $private, string $type)
    {
        $app = App::where('private_link', $private)->latest()->first();

        if (!$app) {
            return response()->json([
                'error' => 'App not found',
                'status' => false,
            ]);
        }

        if (!in_array($type, ['android', 'ios'])) {
            return response()->json([
                'error' => 'Type not supported',
                'status' => false,
            ]);
        }

        $build=Build::where('reference_code',$app->private_link)->latest()->first();



        if($app->plan=="premium"){
            $auth=env('BUILD_APIKEY_PREMIUM');
        }else{
            $auth=env('BUILD_APIKEY');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.codemagic.io/builds/'.$build->build_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'x-auth-token: '.$auth,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

//        echo $response;

//        {"buildId":"5fabc6414c483700143f4f92"}

        $resp=json_decode($response, true);

        $build_status=$resp['build']['status'];

        if($build_status=="finished"){
            $android = "";
            $aab = "";
            $ios = "";

            foreach ($resp['build']['artefacts'] as $artefact) {
                if ($artefact['type'] == "apk") {
                    $android = $artefact['url'];
                }

                if ($artefact['type'] == "aab") {
                    $aab = $artefact['url'];
                }

                if ($artefact['type'] == "app") {
                    $ios = $artefact['url'];
                }
            }


            // Access the app_settings attribute as an array
            $settings = $app->build_setting;

            // Check if build_setting and ios exist
            if (isset($settings['build_setting']) && isset($settings['build_setting']['downloadLinks'])) {
                // Update the bundleId
                $settings['downloadLinks']['androidLink'] = $android;
                $settings['downloadLinks']['androidAppBundleLink'] = $aab;
                $settings['downloadLinks']['iosSource'] = $ios;

                // Assign the modified array back to the attribute
                $app->build_setting = $settings;
                $app->save();
            }
        }


        try {
            return response()->json([
                'message' => $build_status,
                'error' => '',
                'status' => true,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => "Build not found",
                'error' => '',
                'status' => false,
            ]);
        }
    }
}
