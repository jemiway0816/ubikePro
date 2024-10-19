
<?php

// Ubike API的站点信息URL
$ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=205';

// 发送HTTP请求获取JSON数据
$json_data = file_get_contents($ubike_api_url);

// 解析JSON数据
$data = json_decode($json_data, true);

// 检查是否成功获取数据
if ($data) {

/*
    $display_org = [27,33,38,48,49,56,57,72,77,78,84,86,87,117];
    $display_indices = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];

    for ($i = 0; $i<13; $i++) {
        $display_indices[$i] = $display_org[$i] + 11;
    }
*/

    $display_sna = ['埤墘公園','永安公園','莒光國小','捷運新埔站(2號出口)','捷運新埔站(4號出口)','音樂公園','捷運江子翠站(3號出口)'
    , '永豐公園活動中心','振義里公園','民生中山路口','埔墘國小','萬板文聖街口','光復國小','三民翠華街口'];

    // 建立與 MySQL 連接
    $host = "127.0.0.1";
    $user = "ubikeDB";
    $password = "1qaz@wsx";
    $db = "ubikeDB";

    $conn=mysqli_connect($host, $user,$password) or die("資料庫連線錯誤！");
    //指定連線的資料庫
    mysqli_select_db($conn,$db);
    //指定資料庫使用的編碼
    mysqli_query($conn,"SET NAMES utf8");

    // 取得現在的時間
    $currentDateTime = date('Y-m-d H:i:s');

    echo "現在時間" . $currentDateTime;

    // 遍历每个站点
    $row_index = 1;
    foreach ($data as $station_id => $station_data) {

        // 截取站点名称前11个字符
        $stationName = substr($station_data['sna'], 11);

        // 检查是否为需要显示的站点
        if (in_array($stationName, $display_sna)) {

            $bikeNum = $station_data['sbi'];        
            $stepNum = $station_data['bemp'];

            // 執行 SQL 查詢，將現在的時間寫入到 MySQL 的 datetime 欄位
            $sql = "INSERT INTO ubikeFlow (dateTime,stationName,stepNum,bikeNum) VALUES ('$currentDateTime','$stationName',$stepNum,$bikeNum)";

            //準備insert指令
            // $insertSQL = sprintf("insert into student(no,name,gender,picture,phone,address,email,myclass) values('%s','%s',%d,'%s','%s','%s','%s','%s')",$_GET['no'],$_GET['name'],$_GET['gender'],$_GET['picture'],$_GET['phone'],$_GET['address'],$_GET['email'],$_GET['myclass']);

            //執行update指令
            $result=mysqli_query($conn,$sql) or die(mysqli_error());
        }
        $row_index++;
    }
    //關閉資料庫連結
    mysqli_close($conn);
}
?>
