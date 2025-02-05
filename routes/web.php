<?php

use Illuminate\Support\Facades\Route;

if (! defined('DEFAULT_VERSION')) {
    define('DEFAULT_VERSION', '8.x');
}

if (! defined('SHOW_VAPOR')) {
    define('SHOW_VAPOR', random_int(1, 2) === 1);
}

if (! defined('SHOW_PROMO')) {
    $int = random_int(1, 3);

    if ($int === 1) {
        define('SHOW_PROMO', 'FORGE');
    } elseif ($int === 2) {
        define('SHOW_PROMO', 'VAPOR');
    } elseif ($int === 3) {
        define('SHOW_PROMO', 'PARTNERS');
    }
}

if (! function_exists('get_github_bio')) {
    /**
     * Gets the bio of passed github username.
     * 
     * @param  string  $username
     * @return string
     */
    function get_github_bio($username): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/users/' . $username);
        curl_setopt($ch, CURLOPT_USERAGENT, request()->header('User-Agent'));
        $result=curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        return $data['bio'];
    }
}


Route::get('docs', 'DocsController@showRootPage');

Route::get('docs/6.0/{page?}', function ($page = null) {
    $page = $page ?: 'installation';
    $page = $page == '8.x' ? 'installation' : $page;

    return redirect(trim('/docs/8.x/'.$page, '/'), 301);
});

Route::get('docs/{version}/{page?}', 'DocsController@show')->name('docs.version');

Route::get('partners', function () {
    return redirect('https://partners.laravel.com');
});

Route::get('/partner/ideil', function () {
    return redirect('https://partners.laravel.com/partners/ideil', 301);
});

Route::get('/partner/curotec', function () {
    return redirect('https://partners.laravel.com/partners/curotec', 301);
});

Route::get('partner/{partner}', function ($partner) {
    return redirect('https://partners.laravel.com/partners/'.$partner, 301);
});

Route::get('/', function () {
    return view('marketing');
});

Route::get('team', function () {
    return view('team', [
        'team' => [
            [
                'name' => 'Taylor Otwell',
                'github_username' => 'taylorotwell',
                'twitter_username' => 'taylorotwell',
                'location' => 'Arkansas, United States',
            ], [
                'name' => 'Mohamed Said',
                'github_username' => 'themsaid',
                'twitter_username' => 'themsaid',
                'location' => 'Cairo, Egypt',
            ], [
                'name' => 'Dries Vints',
                'github_username' => 'driesvints',
                'twitter_username' => 'driesvints',
                'location' => 'Antwerp, Belgium',
            ], [
                'name' => 'James Brooks',
                'github_username' => 'jbrooksuk',
                'twitter_username' => 'jbrooksuk',
                'location' => 'Staffordshire, United Kingdom',
            ], [
                'name' => 'Nuno Maduro',
                'github_username' => 'nunomaduro',
                'twitter_username' => 'enunomaduro',
                'location' => 'Leiria, Portugal',
            ], [
                'name' => 'Mior Muhammad Zaki Mior Khairuddin',
                'github_username' => 'crynobone',
                'twitter_username' => 'crynobone',
                'location' => 'Selangor, Malaysia',
            ], [
                'name' => 'Claudio Dekker',
                'github_username' => 'claudiodekker',
                'twitter_username' => 'claudiodekker',
                'location' => 'Amsterdam, The Netherlands',
            ],
        ]
    ]);
});
