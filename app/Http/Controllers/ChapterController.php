<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function index(Request $request, $version_url = "", $book_url = "", $chapter_url = "" ) {
        
        $version_url_data = $this->consultar("version/$version_url");
        $versabbr   = strtoupper($version_url);
        $title = "Bíblia online {$version_url_data[0]->version} ($versabbr)";
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

        //GET THE VERSES OF THE CHAPTER
        $language = "portuguese";
        $chapter_api    = "verses/language/$language/version/$version_url/bookabbreviationurl/$book_url/chapter/$chapter_url";
        $chapter_data   = $this->consultar($chapter_api);
        //TRATAMENT OF THE DEFAULT DATA OF SITE
        $menu = array('home', 'bibles', 'seeallbibles');
        if (isset($chapter_data->message)) {
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

        $left_right = array('left' => array(), 'right' => array());
        foreach ($books_data['portuguese'] as $bookd) {
            if ($bookd->abbreviation_url == $book_url) {
                
                $left_right['left']['show']     = true;
                $left_right['right']['show']     = true;
                $left_url = ((int) $chapter_url ) - 1;
                $right_url = ((int) $chapter_url ) + 1;
                $left_right['left']['url']     = url("/$version_url/$book_url/$left_url");
                $left_right['right']['url']    = url("/$version_url/$book_url/$right_url");

                $left_content = "$bookd->book $left_url";
                $right_content = "$bookd->book $right_url";
                $left_right['left']['content']     = $left_content;
                $left_right['right']['content']    = $right_content;
                if ($chapter_url == 1) {

                    $left_right['left']['show']     = false;
                    unset($left_right['left']['url']);
                    unset($left_right['left']['content']);
                } elseif ($chapter_url == $bookd->chapters) {
                    
                    $left_right['right']['show']    = false;
                    unset($left_right['right']['url']);
                    unset($left_right['right']['content']);
                }
            }
        }

        //CRIANDO O CONTEUDO DA PAGINA
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
        foreach($books_data['portuguese'] as $bookd) {
            if ($bookd->abbreviation_url == $book_url) {
                $book_data = $bookd;
            }
        }
        $title              = "$book_data->book $chapter_url - $book_url $chapter_url";
        $h1                 = "$book_data->book $chapter_url";
        $meta_title         = "$book_data->book $chapter_url - $book_url $chapter_url";
        $meta_description   = "$book_data->book $chapter_url - $book_url $chapter_url. Cápitulos, versículos e versículos compostos para estudo e leitura";
        $canonical          = url("/$version_url/$book_url/$chapter_url");
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
            'left_right'        => $left_right,
            'chapter_data'      => $chapter_data,
            'version'           => ($version_url == "") ? config('data.version_default') : $version_url,
        );

        $data = $this->transformeToObject($arraytotransforme);
        $data->header = $this->getHeader($lang_bibles, $menu, $version_url);
        $data->footer = $this->getFooter($menu, $books_data, $version_url);
        return view('chapter', ['data' => $data]);
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
    
    private function transformeToObject($transformeToObject = array()) {

        return (object) $transformeToObject;
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
