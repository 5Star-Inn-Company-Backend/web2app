<?php

namespace App\Jobs;

use App\Models\App;
use App\Models\Build;
use App\Models\convert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StartAppBuildJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $reference;
    public function __construct($reference)
    {
        $this->reference=$reference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $reference=$this->reference;

        $app = App::where('private_link', $reference)->latest()->first();

        if (!$app) {
            echo "App not found";
            return;
        }

        $type="android";

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

        $app_config=base64_encode(json_encode($config));

        $input['reference_code']=$reference;
        $input['config']=$app_config;
        $packageName=strtolower($app->plan) == 'free' ? "com.web2app" : $packageName;
        $build=Build::create($input);
        $icon=data_get($app->branding, 'app_icon', 'https://web2app.5starcompany.com.ng/images/w2a.jpg');
        $app_version=data_get($app->build_setting, 'appIdentifiers.android.version', '1');
        $firebase="";
//            $firebase=base64_encode($conv->firebase);

        if($app->plan=="premium"){
            $appId=env('BUILD_APPID_PREMIUM');
            $workflowId=env('BUILD_WORKFLOWID_PREMIUM');
            $auth=env('BUILD_APIKEY_PREMIUM');
        }else{
            $appId=env('BUILD_APPID');
            $workflowId=env('BUILD_WORKFLOWID');
            $auth=env('BUILD_APIKEY');
        }
        $xcode_version=env('BUILD_XCODE_VERSION', "latest");
        $branch=env('BUILD_BRANCH', "main");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.codemagic.io/builds',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => '{
"appId": "'.$appId.'",
"workflowId": "'.$workflowId.'",
"branch": "'.$branch.'",
"environment": {
    "variables": {
        "APP_CONFIG": "'.$app_config.'",
        "APP_NAME": "'.$app->name.'",
        "APP_PACKAGE_NAME": "'.$packageName.'",
        "APP_REFERENCE": "'.$reference.'",
        "APP_LOGO": "'.$icon.'",
        "APP_VERSION": "'.$app_version.'",
        "APP_FIREBASE": "'.$firebase.'"
    },
    "groups": [
        "variable_group_1",
        "variable_group_2"
    ]
}
}',
            CURLOPT_HTTPHEADER => array(
                'x-auth-token: '.$auth,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        Log::info("Build Started: ".$reference." : ".$response);
//            echo $response;

//            dd($response);

//        {"buildId":"5fabc6414c483700143f4f92"}

        $resp=json_decode($response, true);

        $build->build_id=$resp['buildId'];
        $build->save();
    }

}
