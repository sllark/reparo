<?php


function generate_access_token(){


    $post=[
        'refresh_token'=>'1000.e4e56197080e3334a6b5f1bbd28be435.b2da8bb4aa419a24dc1d5b738d33adb2',
        'client_id'=>'1000.X7HOIH45Q6R8VCEZU8F6I727WJDPKJ',
        'client_secret'=>'55f0772ecba0ed3ad48e6805a0c57aa3a035e07ff6',
        'grant_type'=>'refresh_token'
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
    $response=json_decode($response,true);
//        echo '<pre>';
//        print_r($response['access_token']);

    return $response['access_token'];

}

function insert_data($leadData){

    $token=generate_access_token();

    $postData=[
        'data'=>[
            $leadData
        ],
        "trigger"=> [
            "approval",
            "workflow",
            "blueprint"
        ]
    ];



    $curl_pointer = curl_init();
    $url = "https://www.zohoapis.com/crm/v2/Leads";

    $curl_options = array();
    $curl_options[CURLOPT_URL] = $url;
    $curl_options[CURLOPT_POST] = 1;
    $curl_options[CURLOPT_POSTFIELDS] = json_encode($postData);
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_SSL_VERIFYPEER] = 0;
    $curl_options[CURLOPT_HTTPHEADER]=array('Authorization: Zoho-oauthtoken '.$token,
        'Content-Type: application/x-www-form-urlencoded');

    curl_setopt_array($curl_pointer, $curl_options);

    $response=curl_exec($curl_pointer);
    $response=json_decode($response,true);
    echo '<pre>';
    print_r($response);

    //        return $response['access_token'];

}

function get_data(){

    $token=generate_access_token();


    $curl_pointer = curl_init();
    $url = "https://www.zohoapis.com/crm/v2/Leads";

    $curl_options = array();
    $curl_options[CURLOPT_URL] = $url;
    //    $curl_options[CURLOPT_POST] = 1;
    //    $curl_options[CURLOPT_POSTFIELDS] = json_encode($postData);
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_SSL_VERIFYPEER] = 0;
    $curl_options[CURLOPT_HTTPHEADER]=array('Authorization: Zoho-oauthtoken '.$token,
        'Content-Type: application/x-www-form-urlencoded');

    curl_setopt_array($curl_pointer, $curl_options);

    $response=curl_exec($curl_pointer);
    $response=json_decode($response,true);
//    echo '<pre>';
//    print_r($response['data']);

    //        return $response['access_token'];

}


//generate_refresh_token();
//insert_data();
//get_data();