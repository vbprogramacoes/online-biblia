<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Tutorial route
|--------------------------------------------------------------------------
*/

Route::get('/sitemap-index.xml', 'SitemapsController@index');
Route::get('/sitemap-{version}-{book}-compost-verses.xml', 'SitemapsController@compostversion');
Route::get('/sitemap-{version}.xml', 'SitemapsController@version');

/*
|--------------------------------------------------------------------------
| Index route
|--------------------------------------------------------------------------
*/
Route::get('/', 'HomeController@index');
//Route::get('child', 'HomeController@child');

/*
|--------------------------------------------------------------------------
| Index version
|--------------------------------------------------------------------------
|
| Route for version content
|
*/
Route::get('/{version}', 'HomeController@version');

/*
|--------------------------------------------------------------------------
| Index version
|--------------------------------------------------------------------------
|
| Route for books of the version
|
*/
Route::get('/{version}/{book}', 'BooksController@index');

/*
|--------------------------------------------------------------------------
| Index version
|--------------------------------------------------------------------------
|
| Route for books of the version
|
*/
Route::get('/{version}/{book}/{chapter}', 'ChapterController@index');


/*
|--------------------------------------------------------------------------
| Index version
|--------------------------------------------------------------------------
|
| Route for books of the version
|
*/
Route::get('/{version}/{book}/{chapter}/{verse}', 'VersesController@index');

/*
|--------------------------------------------------------------------------
| Index version
|--------------------------------------------------------------------------
|
| Route for books of the version
|
*/
Route::get('/{version}/{book}/{chapter}/{verse}/{versecompost}', 'VersesController@versescompost');

/*
|--------------------------------------------------------------------------
| Preview route
|--------------------------------------------------------------------------
|
| Route for prismic.io preview functionality
|
*/

Route::get('/preview', function (Request $request) {
    $token = $request->input('token');
    if (!isset($token)) {
        return abort(400, 'Bad Request');
    }
    $url = $request->attributes->get('api')->previewSession($token, $request->attributes->get('linkResolver'), '/');
    return response(null, 302)->header('Location', $url);
});


/*
|--------------------------------------------------------------------------
| Sitemap index
|--------------------------------------------------------------------------
*/

Route::get('/tutorial', function () {
    echo 'oi';exit;
    return view('tutorial');
});

/*
|--------------------------------------------------------------------------
| Sitemaps pages
|--------------------------------------------------------------------------
*/

Route::get('/tutorial', function () {
    return view('tutorial');
});

// Get page by UID
Route::get('/page/{uid}', function ($uid, Request $request) {
    // Query the API
    $document = $request->attributes->get('api')->getByUID('page', $uid);

    // Display the 404 page if no document is found
    if (!$document) {
        return view('404');
    }

    // Render the page
    return view('page', ['document' => $document]);
});

/*
|--------------------------------------------------------------------------
| 404 Page Not Found
|--------------------------------------------------------------------------
*/

Route::get('/{path}', function () {
    return view('404');
});

