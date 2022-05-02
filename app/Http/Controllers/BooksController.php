<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    public function index(Request $request, $version_url = "") {
        
        $version_url_data = $this->consultar("version/$version_url");
        $versabbr   = strtoupper($version_url);
        $languages = $this->consultar('languages');
        $lang_bibles = array();
        $countallversions = 0;
        foreach ($languages as $language) {
            
            $lang               = $language->language;
            $lang_bibles[$lang] = array();
            $versions_bibles    = $this->consultar("versions/language/$lang");
            $books_api          = "books/language/$lang";
            $books_data[$lang]  = $this->consultar($books_api);
            foreach($versions_bibles as $version) {
                
                $version_data = array('abb' => $version->abbreviation, 'version' => $version->version);
                array_push($lang_bibles[$lang], $version_data);
                $countallversions++;
            }
        }
        
        //CRIANDO OS DADOS DA PÁGINA
        if (isset($version_url_data->message)) {
            $menu = array('home', 'bibles', 'seeallbibles');
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
        $meta_language      = 'pt';
        $meta_charset       = 'utf-8';
        $meta_content_type  = 'utf-8';
        $menu = array('home', 'bibles', 'seeallbibles');
        $version_abb = strtoupper($version_url_data[0]->abbreviation);
        $version_ver = $version_url_data[0]->version;
        $title              = __('messages.onlinebible') . " $version_abb - $version_ver";
        $h1                 = __('messages.onlinebible') . " $version_abb - $version_ver";
        $meta_title         = __('messages.onlinebible') . " $version_abb - $version_ver";
        $meta_description   = "Versão $version_abb - $version_ver. Cápitulos, versículos e versículos compostos para estudo e leitura";
        $canonical          = url("/$version_url/livros");
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
            'version'           => ($version_url == "") ? config('data.version_default') : $version_url,
        );

        $data = $this->transformeToObject($arraytotransforme);
        $data->header = $this->getHeader($lang_bibles, $menu, $version_url);
        $data->footer = $this->getFooter($menu, $books_data, $version_url);
        
        return view('books', ['data' => $data]);
    }

    public function book(Request $request, $version_url = "", $book = "") {
        
        $version_url_data = $this->consultar("version/$version_url");
        $versabbr   = strtoupper($version_url);
        $languages = $this->consultar('languages');
        $lang_bibles = array();
        $countallversions = 0;
        foreach ($languages as $language) {
            
            $lang               = $language->language;
            $lang_bibles[$lang] = array();
            $versions_bibles    = $this->consultar("versions/language/$lang");
            $books_api          = "books/language/$lang";
            $books_data[$lang]  = $this->consultar($books_api);
            foreach($versions_bibles as $version) {
                
                $version_data = array('abb' => $version->abbreviation, 'version' => $version->version);
                array_push($lang_bibles[$lang], $version_data);
                $countallversions++;
            }
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
        if (isset($version_url_data->message) || empty($book_data)) {
            $menu = array('home', 'bibles', 'seeallbibles');
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
        $meta_language      = 'pt';
        $meta_charset       = 'utf-8';
        $meta_content_type  = 'utf-8';
        $menu = array('home', 'bibles', 'seeallbibles');
        $version_abb = strtoupper($version_url_data[0]->abbreviation);
        $version_ver = $version_url_data[0]->version;
        $url_data = url('');
        if (stripos($url_data, 'https://') !== false) {
            str_replace('https://', '', $url_data);
        } elseif(stripos($url_data, 'http://') !== false) {
            str_replace('http://', '', $url_data);
        }
        $title              = "$book_data->book - $version_abb - $version_ver";
        $h1                 = "$book_data->book";
        $meta_title         = "$book_data->book - $version_abb - $version_ver";
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
