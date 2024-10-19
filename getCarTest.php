<?php

/*
// Ubike API的站点信息URL
$ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=205';

// 发送HTTP请求获取JSON数据
$json_data = file_get_contents($ubike_api_url);

// 解析JSON数据
$data = json_decode($json_data, true);

$display_sna = [
                '埤墘公園',
                '莒光國小',
                '永安公園',
                '音樂公園',
                '懷石公園',
                '萬板文聖街口',
                '捷運江子翠站(3號出口)', 
                '捷運新埔站(2號出口)',
                '捷運新埔站(4號出口)',
                '振義里公園',
                '三民翠華街口',
                '永豐公園活動中心',
                '埔墘國小',
                '民生中山路口',    
                '光復國小'
                ];


// 检查是否成功获取数据
if ($data) {

    $CarArray = array();

    for ($i = 0; $i < 20; $i++) {
        // 在每一行宣告一個包含3個元素的子陣列
        $CarArray[$i] = array("", 0, 0);
    }

     // 遍历每个站点
     foreach ($data as $station_id => $station_data) {

        $shortened_no = $station_data['sno'];
        $shortened_name = substr($station_data['sna'], 11);

//        $dicArray .= "\"" . $shortened_no . "\"". " => " . "\"" .$shortened_name . "\"," . "\n";

        $dicArray .= "\"" . $shortened_no . "\",". "  //" . $shortened_name . "\n";
     }

     $file = 'dicArray.txt';
     if (file_put_contents($file, $dicArray)) {
         echo "資料已成功寫入 {$file}";
     } else {
         echo "寫入失敗";
     }
     
} else {
    echo '无法获取Ubike数据';
}
*/

$dicArray = date("H:i:s");

$file = 'updateTime.txt';
if (file_put_contents($file, $dicArray)) {
    echo "資料已成功寫入 {$file}";
} else {
    echo "寫入失敗";
}



?>
