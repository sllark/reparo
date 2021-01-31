<?php
//





//{ ["access_token"]=> string(70) "1000.e2fcae57b5aa7b9b3c7b13cd4e2a5ca4.9dbbd10492b7b85ce58aa3b88bc71f1b" ["refresh_token"]=> string(70) "1000.e4e56197080e3334a6b5f1bbd28be435.b2da8bb4aa419a24dc1d5b738d33adb2" ["api_domain"]=> string(24) "https://www.zohoapis.com" ["token_type"]=> string(6) "Bearer" ["expires_in"]=> int(3600) }

    function generate_refresh_token(){


        $post=[
            'code'=>'1000.d6cf86f27c648f3bdc5cd7bfbeb8f608.469bd9a86ff06303cc113f6c8009e3cc',
            'redirect_uri'=>'http://example.com/callback',
            'client_id'=>'1000.X7HOIH45Q6R8VCEZU8F6I727WJDPKJ',
            'client_secret'=>'55f0772ecba0ed3ad48e6805a0c57aa3a035e07ff6',
            'grant_type'=>'authorization_code'
        ];



        $curl_pointer = curl_init();
        $url = "https://accounts.zoho.com/oauth/v2/token";

        $curl_options = array();
        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_POST] = 1;
        $curl_options[CURLOPT_POSTFIELDS] = http_build_query($post);
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_SSL_VERIFYPEER] = 0;
        $curl_options[CURLOPT_HTTPHEADER]=array('Content-Type: application/x-www-form-urlencoded');

        curl_setopt_array($curl_pointer, $curl_options);



        $response=curl_exec($curl_pointer);
        $response=json_decode($response);
        var_dump($response);


    }
