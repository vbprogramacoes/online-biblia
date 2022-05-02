<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Category;

class SitemapsController extends Controller
{
    public function index() {
        
        $title = "Bíblia online Sitemap Index";
        return response()->view('sitemaps.index')->header('Content-Type', 'text/xml');
    }

    public function version(Request $request, $version = "") {
        
        return response()->view('sitemaps.versions.' . $version)->header('Content-Type', 'text/xml');
    }

    public function compostversion(Request $request, $version = "", $book = "") {
         
        return response()->view('sitemaps.compost_verses.' . $version . "_$book" . '_compost_verses')->header('Content-Type', 'text/xml');
    }

    public function consultar($api) {

        $bibleapiurl = config('bibleapi.url');
        $url = $bibleapiurl . $api;
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        
        return $result;
    }
}
