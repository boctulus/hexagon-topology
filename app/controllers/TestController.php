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

    function p1()
    {
        try {
            $res = Url::consume_endpoint('http://az.lan/api/v1/me', 'GET', null, '8ZfTPJB3VeCAAkea' );
            
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
            $res = Url::consume_endpoint('http://az.lan/api/v1/products', 'POST',[
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



}

