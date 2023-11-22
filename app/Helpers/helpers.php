<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Config;
use Illuminate\Support\Str;

class Helper
{
    public static function applClasses()
    {
        // Demo
        $fullURL = request()->fullurl();
        // if (App()->environment() === 'production') {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-' . $i);
        //         if ($contains === true) {
        //             $data = config('custom.' . 'demo-' . $i);
        //         }
        //     }
        // } else {
            $data = config('custom.custom');
        // }
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if (App()->environment() === 'production') {
            for ($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if ($contains === true) {
                    $demo = 'demo-' . $i;
                }
            }
        }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function getIcons()
    {
        return [
            ['key'=>'fas fa-ban','value'=>'&#xf05e; fa-ban'],
            ['key'=>'fas fa-bug','value'=>'&#xf188; fa-bug'],
            ['key'=>'fas fa-dungeon','value'=>'&#xf6d9; fa-dungeon'],
            ['key'=>'far fa-eye','value'=>'&#xf06e; fa-eye'],
            ['key'=>'far fa-eye-slash','value'=>'&#xf070; fa-eye-slash'],
            ['key'=>'fas fa-file-signature','value'=>'&#xf573; fa-file-signature'],
            ['key'=>'fas fa-id-fingerprint','value'=>'&#xf577; fa-id-fingerprint'],
            ['key'=>'far fa-id-badge','value'=>'&#xf2c1; fa-id-badge'],
            ['key'=>'fas fa-id-badge','value'=>'&#xf2c1; fa-id-badge'],
            ['key'=>'far fa-id-card','value'=>'&#xf2c2; fa-id-card'],
            ['key'=>'fas fa-key','value'=>'&#xf084; fa-key'],
            ['key'=>'fas  fa-lock','value'=>'&#xf023; fa-lock'],
            ['key'=>'fas fa-unlock','value'=>'&#xf09c; fa-unlock'],
            ['key'=>'fas fa-user-secret','value'=>'&#xf21b; fa-user-secret '],
            ['key'=>'fa-undo','value'=>'&#xf0e2; fa-undo'],
            ['key'=>'fa-universal-access','value'=>'&#xf29a; fa-universal-access'],
            ['key'=>'fa-university','value'=>'&#xf19c; fa-university'],
            ['key'=>'fa-unlink','value'=>'&#xf127; fa-unlink'],
            ['key'=>'fa-unlock','value'=>'&#xf09c; fa-unlock '],
            ['key'=>'fa-unlock-alt','value'=>'&#xf13e; fa-unlock-alt'],
            ['key'=>'fa-unsorted','value'=>'&#xf0dc; fa-unsorted'],
            ['key'=>'fa-upload','value'=>'&#xf093; fa-upload '],
            ['key'=>'fa-usb','value'=>'&#xf287; fa-usb '],
            ['key'=>'fa-usd','value'=>'&#xf155; fa-usd'],
            ['key'=>'fa-user','value'=>'&#xf007; fa-user'],
            ['key'=>'fa-user-circle','value'=>'&#xf2bd; fa-user-circle'],
            ['key'=>'fa-user-circle-o','value'=>'&#xf2be; fa-user-circle-o'],
            ['key'=>'fa-user-md','value'=>'&#xf0f0; fa-user-md'],
            ['key'=>'fa-user-o','value'=>'&#xf2c0; fa-user-o'],
            ['key'=>'fa-user-plus','value'=>'&#xf234; fa-user-plus'],
            ['key'=>'fa-user-secret','value'=>'&#xf21b; fa-user-secret'],
            ['key'=>'fa-user-times','value'=>'&#xf235; fa-user-times'],
            ['key'=>'fa-users','value'=>'&#xf0c0; fa-users'],
            ['key'=>'fa-vcard','value'=>'&#xf2bb; fa-vcard'],
            ['key'=>'fa-vcard-o','value'=>'&#xf2bc; fa-vcard-o'],
            ['key'=>'fa-venus','value'=>'&#xf221; fa-venus'],
            ['key'=>'fa-venus-double','value'=>'&#xf226; fa-venus-double '],
            ['key'=>'fa-venus-mars','value'=>'&#xf228; fa-venus-mars'],
            ['key'=>'fa-viacoin','value'=>'&#xf237; fa-viacoin'],
            ['key'=>'fa-viadeo','value'=>'&#xf2a9; fa-viadeo'],
            ['key'=>'fa-viadeo-square','value'=>'&#xf2aa; fa-viadeo-square'],
            ['key'=>'fa-video-camera','value'=>'&#xf03d; fa-video-camera'],
            ['key'=>'fa-vimeo','value'=>'&#xf27d; fa-vimeo'],
            ['key'=>'fa-vimeo-square','value'=>'&#xf194; fa-vimeo-square'],
            ['key'=>'fa-vine','value'=>'&#xf1ca; fa-vine'],
            ['key'=>'fa-vk','value'=>'&#xf189; fa-vk'],
            ['key'=>'fa-volume-control-phone','value'=>'&#xf2a0; fa-volume-control-phone'],
            ['key'=>'fa-volume-down','value'=>'&#xf027; fa-volume-down'],
            ['key'=>'fa-volume-off','value'=>'&#xf026; fa-volume-off'],
            ['key'=>'fa-volume-up','value'=>'&#xf028; fa-volume-up '],
            ['key'=>'fa-warning','value'=>'&#xf071; fa-warning'],
            ['key'=>'fa-wechat','value'=>'&#xf1d7; fa-wechat '],
            ['key'=>'fa-weibo','value'=>'&#xf18a; fa-weibo'],
            ['key'=>'fa-weixin','value'=>'&#xf1d7; fa-weixin'],
            ['key'=>'fa-whatsapp','value'=>'&#xf232; fa-whatsapp'],
            ['key'=>'fa-wheelchair','value'=>'&#xf193; fa-wheelchair'],
            ['key'=>'fa-wheelchair-alt','value'=>'&#xf29b; fa-wheelchair-alt'],
            ['key'=>'fa-wifi','value'=>'&#xf1eb; fa-wifi'],
        ];
    }

}
