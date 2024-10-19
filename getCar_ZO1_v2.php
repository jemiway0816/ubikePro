
// getCar_ZO1_v2

<?php

// Ubike API的站点信息URL
$ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

// 发送HTTP请求获取JSON数据
$json_data = file_get_contents($ubike_api_url);

// 解析JSON数据
$data = json_decode($json_data, true);

/*
$display_sna_old = ['三民永豐街口' , '三民翠華街口' , '中山路二段416巷38弄口' , '仁化文新路口' , '光復國小' , '光復高中' , '八德公園' , '埔墘國小' , 
                '埤墘公園' , '振義里公園' , '捷運新埔站(2號出口)' , '捷運新埔站(4號出口)' , '捷運江子翠站(1號出口)' , '捷運江子翠站(2號出口)' , 
                '捷運江子翠站(4號出口)' , '捷運江子翠站(6號出口)' , '文化路二段182巷1弄' , '文聖國小(松柏街50巷)' , '新北市藝文中心' , 
                '新北市藝文中心(文化路二段124巷)' , '松柏街15巷口' , '板橋中山公園' , '民生中山路口' , '民生路二段/文化路一段286巷口' , 
                '永安公園' , '永豐公園活動中心' , '溪頭公園' , '石雕公園' , '稚匯公園(華江三路)' , '縣民大道三段270巷口' , '縣民民生路口' , 
                '莊敬公園' , '莒光國小' , '華江一華江九路口' , '華江九華江一路口(匯翠社區)' , '華江公園' , '萬板文聖街口' , '萬板高架橋下停車場' , 
                '西安市民活動中心' , '雙十萬板路口' , '音樂公園' , '懷石公園' , '捷運新埔站(5號出口)' , '捷運江子翠站(3號出口)' , '時光公園' , 
                '江翠國中' , '江翠國小' , '潤泰社區' , '環河西華江六路口(翠亨村社區)' , '華江一華江二路口(江匯Life社區)' , '華江一華江五路口(雙江翠社區)' , 
                '華江一華江六路口(仰真社區)' , '華江橋自行車牽引道' , '文化懷德街口' , '港嘴活動中心' , '縣民富山街口' , '華江一華江二路口(吾界社區)' , 
                '華江二華江一路口(帝國花園廣場社區)' , '華江五華江一路口(帝國花園廣場社區)' ];
*/

$display_sna = ['捷運新埔站(2號出口)','民生路二段/文化路一段286巷口','捷運新埔站(4號出口)','捷運新埔站(5號出口)',
                '捷運江子翠站(1號出口)','捷運江子翠站(2號出口)','捷運江子翠站(3號出口)','捷運江子翠站(4號出口)' , '捷運江子翠站(6號出口)',
                '文化路二段182巷1弄','松柏街15巷口','振義里公園','三民翠華街口','三民永豐街口','永豐公園活動中心','埔墘國小','民生中山路口',
                '西安市民活動中心','埤墘公園','八德公園','莊敬公園','華江公園','板橋中山公園','新北市藝文中心',
                '新北市藝文中心(文化路二段124巷)','莒光國小','縣民富山街口','縣民大道三段270巷口','民生縣民大道口(東南側)','永安公園','音樂公園','懷石公園',
                '萬板文聖街口','雙十萬板路口','江翠國小','光復國小','光復高中','潤泰社區','中山路二段416巷38弄口','石雕公園','江翠國中','江翠國中活動中心地下停車場',
                '文聖國小(松柏街50巷)','仁化文新路口','時光公園','溪頭公園','稚匯公園(華江三路)','華江一華江九路口','華江九華江一路口(匯翠社區)',
                '華江一華江五路口(雙江翠社區)','華江一華江六路口(仰真社區)','環河西華江六路口(翠亨村社區)','華江一華江二路口(江匯Life社區)',
                '華江一華江二路口(吾界社區)','華江二華江一路口(帝國花園廣場社區)','華江五華江一路口(帝國花園廣場社區)','華江橋自行車牽引道',
                '文化懷德街口','萬板高架橋下停車場','縣民民生路口','港嘴活動中心'];

$display_red = ['埤墘公園' , '永安公園' , '莒光國小' , '捷運新埔站(2號出口)' , '捷運新埔站(4號出口)' , '音樂公園' , '捷運江子翠站(3號出口)' ,
                '永豐公園活動中心' , '振義里公園' , '民生中山路口' , '埔墘國小' , '萬板文聖街口' , '光復國小' , '三民翠華街口' ];

$display_blue = ['捷運新埔站(1號出口)','中山路二段90巷'];

// 检查是否成功获取数据
if ($data) {

    $CarArray = array();

    $totleBikes = 0;
    $totleEmpty = 0;

    for ($i = 0; $i < 200; $i++) {
        // 在每一行宣告一個包含3個元素的子陣列
        $CarArray[$i] = array("", 0, 0);
    }

     // 输出表头
     echo '<table border="1" style="font-size: 48px;">';
     echo '<tr><th>ZO1 站名</th><th>車量</th><th>空柱</th></tr>';

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

                    $totleBikes = $totleBikes + $CarArray[$i][1];
                    $totleEmpty = $totleEmpty + $CarArray[$i][2];

                    break;
                }    
            } 
        }
     }

     echo '<tr><th>總車量 = ' . $totleBikes . ' , 總空柱 = ' . $totleEmpty . ' </th><th></th><th></th></tr>';

     // 顯示結果
     for ($i = 0; $i < count($display_sna); $i++) {

            // 检查是否为需要红色样式的站点
            if(in_array($CarArray[$i][0], $display_red)) {
                $row_style = 'style="color: red;"';
            } else if(in_array($CarArray[$i][0], $display_blue)) {
                $row_style = 'style="color: blue;"';
            } else {
                $row_style = '';
            }

            // $row_style = (in_array($CarArray[$i][0], $display_red)) ? 'style="color: red;"' : '';
 
            $car_style = ($CarArray[$i][1]==0) ? 'color: red;' : 'color: black;';
            $step_style = ($CarArray[$i][2]<=5) ? 'color: red;' : 'color: black;';

            // 输出表格行
            echo '<tr ' . $row_style . '>';
            // echo '<td style="text-align: center;">' . $row_index_in_array . '</td>';
            echo '<td>' . $CarArray[$i][0] . '</td>';

            echo '<td style="text-align: center;' . $car_style . '">' . $CarArray[$i][1] . '</td>';
            echo '<td style="text-align: center;' . $step_style . '">' . $CarArray[$i][2] . '</td>';

            // echo '<td style="text-align: center;">' . $CarArray[$i][1] . '</td>';
            // echo '<td style="text-align: center;">' . $CarArray[$i][2] . '</td>';
            echo '</tr>';

     }
 
     // 输出表格结束标签
     echo '</table>';
} else {
    echo '无法获取Ubike数据';
}

?>
