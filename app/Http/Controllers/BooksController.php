<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    public function index(Request $request, $version_url = "", $book = "") {
        
        $lang               = 'portuguese';
        $books_api          = "books/language/$lang";
        $consult            = $this->consultar($books_api);
        $versabbr           = strtoupper($version_url);
        $lang_bibles        = array();
        $languages          = $consult->header_footer->header->lang;
        $version_data       = array();
        foreach ($languages as $lang) {
            
            //VERSIONS BY LANGUAGE
            $language               = $lang->language;
            $versions_bibles        = array();
            $consult_versions       = $this->consultar("versions/language/$language");
            $lang_bibles[$language] = array();
            foreach($consult_versions->data as $ver) {
                
                $version_data = array('abb' => $ver->abbreviation, 'version' => $ver->version);
                array_push($lang_bibles[$language], $version_data);

                if (strtolower($ver->abbreviation) == strtolower($version_url)) {
                    $version_url_data = $ver;
                }
            }

            //BOOKS BY LANGUAGE
            $books_data[$language]  = $consult->header_footer->footer->books;
        }
        
        //GET THE BOOKS DATA
        $book_data = array();
        foreach ($books_data['portuguese'] as $b) {
            if ($b->abbreviation_url == $book) {
                $book_data = $b;
                break;
            }
        }
        $menu = array('home', 'bibles', 'seeallbibles');
        
        //CRIANDO OS DADOS DA PÁGINA
        if (isset($consult->message) || empty($book_data)) {
            $menu               = array('home', 'bibles', 'seeallbibles');
            $meta_language      = 'pt';
            $meta_charset       = 'utf-8';
            $meta_content_type  = 'utf-8';
            $meta_title         = __('messages.page_not_found');
            $meta_description   = __('messages.page_not_found');

            $arraytotransforme = array(
                'footer'            => '',
                'header'            => '',
                'meta_language'     => $meta_language,
                'meta_charset'      => $meta_charset,
                'meta_content_type' => $meta_content_type,
                'meta_title'        => $meta_title,
                'meta_description'  => $meta_description,
                'canonical'         => '',
                'title'             => __('messages.page_not_found'),
            );
            $data = $this->transformeToObject($arraytotransforme);
            $data->header = $this->getHeader($lang_bibles, $menu, $version_url);
            $data->footer = $this->getFooter($menu, $books_data, $version_url);
            return view('404', ['data' => $data]);
        }

        $menu               = array('home', 'bibles', 'seeallbibles');
        $meta_language      = 'pt';
        $meta_charset       = 'utf-8';
        $meta_content_type  = 'utf-8';
        
        $version_abb        = strtoupper($version_url_data->abbreviation);
        $version_ver        = $version_url_data->version;
        $url_data = url('');
        if (stripos($url_data, 'https://') !== false) {
            str_replace('https://', '', $url_data);
        } elseif(stripos($url_data, 'http://') !== false) {
            str_replace('http://', '', $url_data);
        }
        $title              = "$book_data->book - $version_abb - $version_ver - " . __('messages.onlinebible');
        $h1                 = "$book_data->book";
        $meta_title         = "$book_data->book - $version_abb - $version_ver - " . __('messages.onlinebible');
        $meta_description   = "$book_data->book - $version_abb - $version_ver. Cápitulos, versículos e versículos compostos para estudo e leitura";
        $canonical          = url("/$version_url/$book");
        $icon               = '';
        $arraytotransforme = array(
            'footer'            => '',
            'header'            => '',
            'meta_language'     => $meta_language,
            'meta_charset'      => $meta_charset,
            'meta_content_type' => $meta_content_type,
            'title'             => $title,
            'h1'                => $h1,
            'meta_title'        => $meta_title,
            'meta_description'  => $meta_description,
            'canonical'         => $canonical,
            'icon'              => $icon,
            'books_data'        => $books_data,
            'book_data'         => $book_data,
            'version'           => ($version_url == "") ? config('data.version_default') : $version_url,
        );

        $data = $this->transformeToObject($arraytotransforme);
        $data->header = $this->getHeader($lang_bibles, $menu, $version_url);
        $data->footer = $this->getFooter($menu, $books_data, $version_url);
        return view('book', ['data' => $data]);
    }

    private function getHeader($lang_bibles, $menu, $version = "") {
        
        $result = array(
            'lang_bibles'       => $lang_bibles,
            'menu'              => $menu,
            'version'           => ($version == "") ? config('data.version_default') : $version,
        );
        return (object) $result;
    }

    private function getFooter($menu, $books_data, $version = "") {

        $result = array(
            'books_data'        => $books_data,
            'menu'              => $menu,
            'version'           => ($version == "") ? config('data.version_default') : $version,
        );
        return (object) $result;
    }
    
    private function transformeToObject($arraytotransforme = array()) {

        return (object) $arraytotransforme;
    }
    
    private function consultar($api) {

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
