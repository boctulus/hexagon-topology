<?php

namespace simplerest\controllers;

use simplerest\core\Controller;
use simplerest\core\Model;
use simplerest\core\Request;
use simplerest\libs\Factory;
use simplerest\libs\Debug;
use simplerest\libs\DB;
use simplerest\libs\Utils;
use simplerest\libs\Strings;
use simplerest\libs\Arrays;
use simplerest\libs\Validator;
use simplerest\libs\Url;

class TestController extends Controller
{

    function p0()
    {
        try {
            $res = Url::consume_api('http://az.lan/api/v1/me', 'GET', null, '8ZfTPJB3VeCAAkea');
            
            if ($res['status_code'] != 200){
                dd("ERROR");
            }
            
            dd($res);
        } catch (\Exception $e){
            echo "Hubo un error: ". $e->getMessage();
        }       
    }

    function p1()
    {
        try {
            $res = Url::consume_api('http://az.lan/api/v1/me', 'GET', null, '8ZfTPJB3VeCAAkea', ['Content-Type' => 'text/plain'], [CURLOPT_ENCODING => 'gzip']);
            
            if ($res['status_code'] != 200){
                dd("ERROR");
            }
            
            dd($res);
        } catch (\Exception $e){
            echo "Hubo un error: ". $e->getMessage();
        }       
    }

    function p2()
    {
        try {
            $res = Url::consume_api('http://az.lan/api/v1/products', 'POST',[
                'name' => 'bocaditos Cabsha',
                'size' => '1L',
                'cost' => 8
            ],
            '8ZfTPJB3VeCAAkea');

            dd($res);
        
        } catch (\Exception $e){
            echo "Hubo un error: ". $e->getMessage();
        }       
    }

    function x(){
        $reg = [
            'id' => 3,
            'name' => 'crypto---uu.net',
            'sub' => 'www',
            'sub_type' => 'subdomain',
            'lang' => 'en',
            'country' => 'us',
            'registered_at' => NULL,
            'registrar' => 'NameCheap',
            'niche' => 'cryptos',
            'description' => 'sobre cryptos y otras yerbas malas',
            'keywords' => 'cryptos,cryptocurrencies,Musk',
            'server' => NULL,
            'api_key' => NULL,
            'cms' => 'WordPress',
            'adsense' => 'mabel',
            'alexa_rank' => 1000,
            'network_id' => 1,
            'created_at' => '2021-05-14'
        ];
        

        $cond_str = "name[contains]=crypto&name[notEndsWith]=.es";
     
        
        dd(Strings::filter($reg, $cond_str), 'OK');
    }



}

