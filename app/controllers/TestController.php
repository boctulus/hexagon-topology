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
            'name' => 'crypto-shit-coins.com',
            'sub' => 'www',
            'sub_type' => 'subdomain',
            'lang' => 'en',
            'country' => NULL,
            'registered_at' => NULL,
            'registrar' => 'NameCheap',
            'niche' => 'cryptos',
            'description' => 'orientado a cryptos y otras yerbas',
            'keywords' => 'cryptos,cryptocurrencies,Musk',
            'server' => NULL,
            'api_key' => NULL,
            'cms' => '',
            'adsense' => 'mabel',
            'alexa_rank' => 1000,
            'network_id' => 1,
            'created_at' => '2021-05-14'
        ];
        
        $cond_str = "adsense=mabel&server=null!&cms=&alexa_rank[lteq]=1000&network_id[eq]=1&lang[neq]=de&name[contains]=crypto&name[endsWith]=.co&created_at[between]=2019-01-01,2021-12-31&id[notBetween]=100,500&sub[in]=w3,www&niche[notIn]=DOGE,SHIBA&registrar=DonWeb,NameCheap&server=";

        parse_str($cond_str, $conditions);
        
    
        $ok = true;
        foreach($conditions as $field => $cond)
        {
            if (!is_array($cond)){                
                if ($cond == 'null!' && $reg[$field] === null){                   
                    continue;
                }

                if (strpos($cond, ',') === false){
                    if ($reg[$field] == $cond){
                        continue;
                    }
                } else {
                    $vals = explode(',', $cond);
                    if (in_array($reg[$field], $vals)){
                        continue;
                    }
                }  
                
                $ok = false;
        
            } else {
                // some operators
        
                foreach($cond as $op => $val)
                {

                    if (strpos($val, ',') === false)
                    {
                        switch ($op) {
                            case 'eq':
                                if ($reg[$field] == $val){                                    
                                    continue 2;
                                }
                                break;
                            case 'neq':
                                if ($reg[$field] != $val){                
                                    continue 2;
                                }
                                break;	
                            case 'gt':
                                if ($reg[$field] > $val){                           
                                    continue 2;
                                }
                                break;	
                            case 'lt':
                                if ($reg[$field] < $val){                             
                                    continue 2;
                                }
                                break;
                            case 'gteq':
                                if ($reg[$field] >= $val){
                                    $ok = true;
                                    continue 2;
                                }
                                break;	
                            case 'lteq':
                                if ($reg[$field] <= $val){                     
                                    continue 2;
                                }
                                break;	
                            case 'contains':
                                if (Strings::contains($val, $reg[$field])){                           
                                    continue 2;
                                }
                                break;    
                            case 'notContains':
                                if (!Strings::contains($val, $reg[$field])){                  ;
                                    continue 2;
                                }
                                break; 
                            case 'startsWith':
                                if (Strings::startsWith($val, $reg[$field])){                           
                                    continue 2;
                                }
                                break; 
                            case 'notStartsWith':
                                if (!Strings::startsWith($val, $reg[$field])){               
                                    continue 2;
                                }
                                break; 
                            case 'endsWith':             
                                if (Strings::endsWith($val, $reg[$field])){                 
                                    continue 2;
                                }
                                break;      
                            case 'notEndsWith':
                                if (!Strings::endsWith($val, $reg[$field])){                           
                                    continue 2;
                                }
                                break;    
                        
                            default:
                                throw new \InvalidArgumentException("Operator '$op' is unknown", 1);
                                break;
                        }

                    } else {
                        // operadores con valores que deben ser interpretados como arrays
                        $vals = explode(',', $val);

                        switch ($op) {
                            case 'between':
                                if (count($vals)>2){
                                    throw new \InvalidArgumentException("Operator between accepts only two arguments");
                                }

                                if ($reg[$field] >= $vals[0] && $reg[$field] <= $vals[1]){
                                    continue 2;
                                }
                                break;
                            case 'notBetween':
                                if (count($vals)>2){
                                    throw new \InvalidArgumentException("Operator between accepts only two arguments");
                                }

                                if ($reg[$field] < $vals[0] || $reg[$field] > $vals[1]){
                                    continue 2;
                                }
                                break;
                            case 'in':                            
                                if (in_array($reg[$field], $vals)){
                                    continue 2;
                                }
                                break;
                            case 'notIn':                            
                                if (!in_array($reg[$field], $vals)){
                                    continue 2;
                                }
                                break;    
                            default:
                                throw new \InvalidArgumentException("Operator '$op' is unknown", 1);
                                break;    
                        }

                    }
                    $ok = false;

                }
    
                
            }

            if (!$ok){
                break;
            }
        
        } 
        
        dd($ok, 'OK');
    }



}

