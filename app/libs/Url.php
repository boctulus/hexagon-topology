<?php

namespace simplerest\libs;

class Url {

    static function http_protocol(){
        /*
        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
            $protocol = 'https:';
        } else {
            $protocol = 'http:';
        }
        */

        $config = Factory::config();
        
        if ($config['HTTPS'] == 1 || strtolower($config['HTTPS']) == 'on'){
            $protocol = 'https:';
        } else {
            $protocol = 'http:';
        }

        return $protocol;
    }

    /**
     * url_check - complement for parse_url
     *
     * @param  string $url
     *
     * @return bool
     */
    static function url_check(string $url){
        $sym = null;
    
        $len = strlen($url);
        for ($i=0; $i<$len; $i++){
            if ($url[$i] == '?'){
                if ($sym == '?' || $sym == '&')
                    return false;
    
                $sym = '?';
            }elseif ($url[$i] == '&'){
                if ($sym === null)
                    return false;
    
                $sym = '&';
            } 
        }
        return true;
    }

    static function is_postman(){
		return (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'PostmanRuntime') !== false);	
	}

    static function consume_endpoint($url, $http_verb, Array $data = null, $api_key = null, $failonerror = false, $options = null)
    {   
        $data = json_encode($data);
            
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $http_verb,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "X-API-KEY: ". $api_key,
                'Content-Type: application/json',
                "Content-Length: ". strlen($data),
                "cache-control: no-cache"
            ),
        );

        if (!empty($options)){
            $opt = $opt + $options;
        }

        $curl = curl_init();
        curl_setopt_array($curl, $opt);
    
        /*
            No parece haber solución más sencilla que des-habilitar chequeo de SSL
            
            https://cheapsslsecurity.com/blog/ssl-certificate-problem-unable-to-get-local-issuer-certificate/
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    
        /*
            Generar excepcion si algo sale mal
        */
        curl_setopt($curl, CURLOPT_FAILONERROR, $failonerror);
    
        /*
            TIMEOUT
        */
    
        // Tell cURL that it should only spend X seconds
        // trying to connect to the URL in question.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
    
        // A given cURL operation should only take
        // X seconds max.
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    
        $response = curl_exec($curl);
    
        //echo $response;
        
        $err_nro = curl_errno($curl);
        $err_msg = curl_error($curl);	
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
        /*
        if ($err_nro) {
            throw new \Exception("$err_msg ($http_code)");
        }
    
        if ($http_code >= 300){
            throw new \Exception("Unexpected http code ($http_code)");
        }
        */
    
        curl_close($curl);     
    
        return json_decode($response, true);
    }
    
}

