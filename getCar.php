<?php

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
        // 取出站名 
        $shortened_name = substr($station_data['sna'], 11);
        // 取出 ZO1 的站
        if (in_array($shortened_name, $display_sna)) { 
            // 依照站名排序    
            for ($i=0 ; $i<count($display_sna) ; $i++) {
                if ($shortened_name == $display_sna[$i]) {
                    $CarArray[$i][0] = $shortened_name;
                    $CarArray[$i][1] = $station_data['sbi'];
                    $CarArray[$i][2] = $station_data['bemp'];
                    break;
                }    
            } 
        }
     }

     // 输出表头
     echo '<table border="1" style="font-size: 64px;">';
     echo '<tr><th>站名</th><th>車量</th><th>空柱</th></tr>';

     // 顯示結果
     for ($i = 0; $i < count($display_sna); $i++) {

            // 输出表格行
            echo '<tr>';
            echo '<td>' . $CarArray[$i][0] . '</td>';
            echo '<td style="text-align: center;">' . $CarArray[$i][1] . '</td>';

            $row_style = ($CarArray[$i][2]<=5) ? 'color: red;' : '';

            echo '<td style="text-align: center;' . $row_style . '">' . $CarArray[$i][2] . '</td>';
            echo '</tr>';

     }

     // 输出表格结束标签
     echo '</table>';
} else {
    echo '无法获取Ubike数据';
}

?>
