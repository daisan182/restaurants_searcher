<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

# 初期設定
$KEYID = "05ff7735f4bdc62a";
$HIT_PER_PAGE = 100;
$PREF = "Z011";
$FREEWORD = '渋谷';
$HIT_PER_PAGE = $argv[1];
$TOTAL_COUNT = $argv[2];
$FORMAT = "json";

$PARAMS = ["key"=> $KEYID, "count"=>$TOTAL_COUNT, "large_area"=>$PREF, "keyword"=>$FREEWORD, "format"=>$FORMAT];

function write_data_to_csv($params, $HIT_PER_PAGE=20){
    
    $restaurants_header =["名称","営業日","住所","アクセス"];
    $client = new Client();
    try{
        $json_res = $client->request('GET', "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/", ['query' => $params])->getBody();
    }catch(Exception $e){
        return print("エラーが発生しました。APIのURLを確認してください。");
    }
    $response = json_decode($json_res,true);
    
    if(isset($response["results"]["error"])){
        return(print("エラーが発生しました。APIのパラメータを確認してください。"));
    }
    
    foreach($response["results"]["shop"] as $restaurant){
        $rest_info = [$restaurant["name"],$restaurant["open"],$restaurant["address"],$restaurant["access"]];
        $restaurants_data[] = $rest_info;
    }
    $chunk_restaurants = array_chunk($restaurants_data, $HIT_PER_PAGE);
    print_r($chunk_restaurants);

    foreach ($chunk_restaurants as $key => $restaurants){
        $handle = fopen("restaurants_list_$key.csv", "wb");
        
        // CSVのヘッダーを出力
        fputcsv($handle, $restaurants_header);

        // CSVの中身を出力
        foreach ($restaurants as $values){
            fputcsv($handle, $values);
        }
        
        fclose($handle);
    }
}

write_data_to_csv($PARAMS, $HIT_PER_PAGE);

?>
