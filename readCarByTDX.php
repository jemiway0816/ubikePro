<?php

$nowTime = date("H:i:s");

$file = '/share/Web/ubike/updateTime.txt';
//$file = 'updateTime.txt';

if (file_put_contents($file, $nowTime)) {
    echo " 寫入時間成功 ";
} else {
    echo " 寫入時間失敗 ";
}

// 獲取當前日期中的天數 (1 到 31)
$day = date('j');

// 判斷是否在前 15 天
if ($day <= 15) {

    // 取得 jemiway0816 的 Access Token
    $client_id = 'jemiway0816-90032ba6-ed9a-4970';
    $client_secret = '836f0faa-1523-4b1a-b599-c020dbfc8316';

} else {

    // 取得 jimlu0816 的 Access Token
    $client_id = 'jemiway0816-90032ba6-ed9a-4970';
    $client_secret = '836f0faa-1523-4b1a-b599-c020dbfc8316';

}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://tdx.transportdata.tw/auth/realms/TDXConnect/protocol/openid-connect/token');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials&client_id='.$client_id.'&client_secret='.$client_secret);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

$access_token = json_decode($result,1)['access_token'];

// 測試：取得新北市公車到站資料
$ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://tdx.transportdata.tw/api/advanced/v2/Bike/Availability/NearBy?%24select=StationID&%24filter=StationID%20eq%20%27500218067%27%20or%20StationID%20%20eq%20%27500218022%27%20or%20StationID%20%20eq%20%27500218033%27%20or%20StationID%20%20eq%20%27500218043%27%20or%20StationID%20%20eq%20%27500218044%27%20or%20StationID%20%20eq%20%27500218051%27%20or%20StationID%20%20eq%20%27500218052%27%20or%20StationID%20%20eq%20%27500218073%27%20or%20StationID%20%20eq%20%27500218079%27%20or%20StationID%20%20eq%20%27500218081%27%20or%20StationID%20%20eq%20%27500218082%27%20or%20StationID%20%20eq%20%27500218113%27&%24top=200&%24spatialFilter=nearby%2825.02221588101869%2C%20121.47726540433837%2C%201000%29&%24format=JSON');

// nearby(25.02221588101869, 121.47726540433837, 1000)
//curl_setopt($ch, CURLOPT_URL, 'https://tdx.transportdata.tw/api/advanced/v2/Bike/Availability/NearBy?%24top=200&%24spatialFilter=nearby%2825.02221588101869%2C%20121.47726540433837%2C%201000%29&%24format=JSON');
                                
// StationID ge '500218001' and StationID  le '500218200'
curl_setopt($ch, CURLOPT_URL, 'https://tdx.transportdata.tw/api/basic/v2/Bike/Availability/City/NewTaipei?%24select=StationID&%24filter=StationID%20ge%20%27500218001%27%20and%20StationID%20%20le%20%27500218200%27&%24top=200&%24format=JSON');


//curl_setopt($ch, CURLOPT_URL, 'https://tdx.transportdata.tw/api/basic/v2/Bus/EstimatedTimeOfArrival/City/NewTaipei?$top=10&$format=JSON');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('authorization: Bearer '.$access_token));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_ENCODING , 'gzip');//啟用gzip
$busEstimatedTime = curl_exec($ch);
curl_close($ch);

//print_r($busEstimatedTime);

// 將陣列轉換為 JSON 格式
//$jsonData = json_encode($busEstimatedTime, JSON_PRETTY_PRINT);

// 將 JSON 資料寫入到 jsonData.json 檔案
$file = '/share/Web/ubike/carData.json';
//$file = 'carData.json';

if (file_exists($file)) {
    // 檢查檔案是否存在
    if (unlink($file)) {
        echo "檔案刪除成功";

        if (file_put_contents($file, $busEstimatedTime)) {
            echo " , 新資料已成功寫入";
        } else {
            echo "寫入失敗";
        }

    } else {
        echo "無法刪除檔案 $file";
    }
} else {
    echo "檔案 $file 不存在";
}

?>
