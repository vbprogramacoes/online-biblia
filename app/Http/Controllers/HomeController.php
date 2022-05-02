<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        
        
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

        //GET THE DAILYVERSES
        $dailyverses = $this->getDailyVerses($books_data['portuguese']);
        
        //CRIANDO OS DADOS DA PÁGINA
        $meta_language      = 'pt';
        $meta_charset       = 'utf-8';
        $meta_content_type  = 'utf-8';
        $title              = __('messages.onlinebible');
        $meta_title         = __('messages.onlinebible');
        $meta_description   = "Diversas versões da bíblia. Cápitulos, versículos e versículos compostos para estudo e leitura em diversas versões da bíblia";
        $canonical          = url('');
        $icon               = '';
        $arraytotransforme = array(
            'footer'            => '',
            'header'            => '',
            'meta_language'     => $meta_language,
            'meta_charset'      => $meta_charset,
            'meta_content_type' => $meta_content_type,
            'title'             => $title,
            'meta_title'        => $meta_title,
            'meta_description'  => $meta_description,
            'canonical'         => $canonical,
            'icon'              => $icon,
            'lang_bibles'       => $lang_bibles,
            'dailyverses'       => $dailyverses,
            'countallversions'  => $countallversions,
        );
        $data = $this->transformeToObject($arraytotransforme);

        //CRIANDO OS MENUS
        $menu = array('home', 'bibles', 'seeallbibles');
        $data->header = $this->getHeader($lang_bibles, $menu);
        $data->footer = $this->getFooter($menu, $books_data);
        return view('home', ['data' => $data]);
    }

    /**
     * Return the content for the $version var
     * 
     * @var request Object
     * @var version String
     */
    public function version(Request $request, $version = '') {
        
        //FIRSTLY WE ARE LOOKING FOR THE VERSION DATA
        
        $languages          = $this->consultar('languages');
        $lang_bibles        = array();
        $countallversions   = 0;
        $lang               = 'portuguese';
        $versions_bibles    = $this->consultar("versions/language/$lang");
        $books_api          = "books/language/$lang";
        $books_data[$lang]  = $this->consultar($books_api);
        $lang_bibles[$lang] = array();
        foreach ($versions_bibles as $v) {
            
            $vd = array('abb' => $v->abbreviation, 'version' => $v->version);
            array_push($lang_bibles[$lang], $vd);
            $countallversions++;
        }
        
        //GET THE DAILYVERSES
        $menu = array('home', 'bibles', 'seeallbibles');
        $api_version  = "version/$version";
        $version_data = $this->consultar($api_version);
        if (isset($version_data->message)) {
            $title = "Versículo deste livro não existe.";
            $data = $this->transformeToObject($title);
            $data->header = $this->getHeader($lang_bibles, $menu, $version);
            $data->footer = $this->getFooter($menu, $books_data, $version);
            return view('404', ['data' => $data]);
        }
        
        $dailyverses = $this->getDailyVerses($books_data[$lang], $lang, $version);
        
        //CRIANDO OS DADOS DA PÁGINA
        $meta_language      = 'pt';
        $meta_charset       = 'utf-8';
        $meta_content_type  = 'utf-8';
        $title              = __('messages.onlinebible') . " {$version_data[0]->abbreviation} - {$version_data[0]->version}";
        $h1                 = __('messages.onlinebible') . " {$version_data[0]->abbreviation} - {$version_data[0]->version}";
        $meta_title         = __('messages.onlinebible') . " {$version_data[0]->abbreviation} - {$version_data[0]->version}";
        $meta_description   = "Versão {$version_data[0]->abbreviation} - {$version_data[0]->version}. Cápitulos, versículos e versículos compostos para estudo e leitura";
        $canonical          = url("/$version");
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
            'lang_bibles'       => $lang_bibles,
            'dailyverses'       => $dailyverses,
            'countallversions'  => $countallversions,
        );
        $data = $this->transformeToObject($arraytotransforme);
        $data->header = $this->getHeader($lang_bibles, $menu, $version);
        $data->footer = $this->getFooter($menu, $books_data, $version);
        
        return view('versions', ['data' => $data]);
    }

    /**
     * Get the content of the daily verses
     *
     * @var books_data array
     * @var language string
     * @var version string
     */
    public function getDailyVerses($books_data = array(), $language = "", $version = "") {

        $dvs        = DB::table('dailyverses')->where('today', true)->get();

        if ($language == "") {

            $language   = 'portuguese';
        }
       
        if ($version == "") {

            $version = config('data.version_default');
        }

        $result     = array();
        foreach($dvs as $dv) {
            
            $book_name = "";
            foreach ($books_data as $book) {

                if ($book->abbreviation_url == $dv->book) {

                    $book_name = $book->book;
                }
            }
            if (stripos($dv->verses, '-') !== false) {

                $verses         = explode('-', $dv->verses);
                $verse          = $verses[0];
                $compost_verse  = $verses[1];
                $api = 'verses/language/{language}/version/{version}/bookabbreviationurl/{book_abreviation_url}/chapter/{chapter}/verse/{verse}/compost_verse/{compost_verse}';
                $api = str_replace('{verse}', $verse, $api);
                $api = str_replace('{compost_verse}', $compost_verse, $api);
            } else {

                $api = 'verses/language/{language}/version/{version}/bookabbreviationurl/{book_abreviation_url}/chapter/{chapter}/verse/{verse}';
                $api = str_replace('{verse}', $dv->verses, $api);
            }

            $api = str_replace('{language}', $language, $api);
            $api = str_replace('{version}', $version, $api);
            $api = str_replace('{book_abreviation_url}', $dv->book, $api);
            $api = str_replace('{chapter}', $dv->chapter, $api);
            
            $res_api = $this->consultar($api);
            
            $vs_api = array();
            
            foreach($res_api as $rapi) {
                
                $v_api['version']   = $version;
                $v_api['book']      = $dv->book;
                $v_api['book_name'] = $book_name;
                $v_api['chapter']   = $dv->chapter;
                $v_api['num']       = $rapi->num;
                $v_api['content']   = $rapi->content;
                $vs_api[] = $v_api;
                unset($v_api);
            }
            
            $result[] = $vs_api;
        }
        
        return $result;
    }


    public function getHeader($lang_bibles, $menu, $version = "") {

        $result = array(
            'lang_bibles'       => $lang_bibles,
            'menu'              => $menu,
            'version'           => ($version == "") ? config('data.version_default') : $version,
        );
        return (object) $result;
    }

    public function getFooter($menu, $books_data, $version = "") {

        $result = array(
            'books_data'        => $books_data,
            'menu'              => $menu,
            'version'           => ($version == "") ? config('data.version_default') : $version,
        );
        return (object) $result;
    }
    
    public function transformeToObject($transformeToObject = array()) {
        
        return (object) $transformeToObject;
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
