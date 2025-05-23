<?php

namespace App\Actions;

use App\DataTransferObject\AppData;
use App\Models\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpsertAppAction
{
    public static function execute(AppData $appData, App $app):App
    {
    $app->name = $appData->name;
    $app->url = $appData->url;
    $app->description = $appData->description;
    $app->plan = $appData->plan;
    $app->branding = $appData->branding;
    $app->link_handling = $appData->link_handling;
    $app->interface = $appData->interface;
    $app->website_overide = $appData->website_overide;
    $app->permission = $appData->permission;
    $app->navigation = $appData->navigation;
    $app->notification = $appData->notification;
    $app->plugin = $appData->plugin;
    $app->build_setting = $appData->build_setting;
    $app->save();
    return $app;
    }
}
