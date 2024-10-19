
// getCar_ZD1

<?php

// Ubike API的站点信息URL
$ubike_api_url = 'https://tcgbusfs.blob.core.windows.net/dotapp/youbike/v2/youbike_immediate.json';

// 发送HTTP请求获取JSON数据
$json_data = file_get_contents($ubike_api_url);

// 解析JSON数据
$data = json_decode($json_data, true);

/*
$display_sna = ['捷運新埔站(1號出口)','捷運新埔站(2號出口)','民生路二段/文化路一段286巷口','捷運新埔站(4號出口)','捷運新埔站(5號出口)',
                '捷運江子翠站(1號出口)','捷運江子翠站(2號出口)','捷運江子翠站(3號出口)','捷運江子翠站(4號出口)' , '捷運江子翠站(6號出口)',
                '文化路二段182巷1弄','松柏街15巷口','振義里公園','三民翠華街口','三民永豐街口','永豐公園活動中心','埔墘國小','民生中山路口',
                '中山路二段90巷','西安市民活動中心','埤墘公園','八德公園','莊敬公園','華江公園','板橋中山公園','新北市藝文中心',
                '新北市藝文中心(文化路二段124巷)','莒光國小','縣民富山街口','縣民大道三段270巷口','永安公園','音樂公園','懷石公園',
                '萬板文聖街口','雙十萬板路口','江翠國小','光復國小','光復高中','潤泰社區','中山路二段416巷38弄口','石雕公園','江翠國中',
                '文聖國小(松柏街50巷)','仁化文新路口','時光公園','溪頭公園','稚匯公園(華江三路)','華江一華江九路口','華江九華江一路口(匯翠社區)',
                '華江一華江五路口(雙江翠社區)','華江一華江六路口(仰真社區)','環河西華江六路口(翠亨村社區)','華江一華江二路口(江匯Life社區)',
                '華江一華江二路口(吾界社區)','華江二華江一路口(帝國花園廣場社區)','華江五華江一路口(帝國花園廣場社區)','華江橋自行車牽引道',
                '文化懷德街口','萬板高架橋下停車場','縣民民生路口','港嘴活動中心'];

$display_red = ['埤墘公園' , '永安公園' , '莒光國小' , '捷運新埔站(2號出口)' , '捷運新埔站(4號出口)' , '音樂公園' , '捷運江子翠站(3號出口)' ,
                '永豐公園活動中心' , '振義里公園' , '民生中山路口' , '埔墘國小' , '萬板文聖街口' , '光復國小' , '三民翠華街口' ];

$display_blue = ['捷運新埔站(1號出口)','中山路二段90巷'];
*/

$display_sna = ['青年公園3號出口','中華南海路口','雙園國中地下停車場','青年公園4號出口','綠堤公園(西北側)','龍山國小','古亭智慧圖書館',
                '植物園','國興中華路口','國興青年路口','青年公園棒球場','青年路152巷口','長泰街52巷口','祥安水岸景觀大廈','德昌街125巷口',
                '艋舺大道146巷口','忠德公園','中華路二段409巷口','南機場夜市(中華路二段)','南海和平路口西南側','莒光和平路口','莒光大埔街口',
                '龍興里活動中心','青年公園籃球場','復華花園新城','莒光郵局','東園國小','雙園國中','長順區民活動中心','華江八號公園',
                '環河南雙園街口','糖廍文化園區','兩棵樹公園','萬華青年公宅','捷運龍山寺站(1號出口)','萬華火車站','捷運龍山寺站(3號出口)',
                '萬大國小(萬大路344巷口)','長順街60巷口','莒光社會住宅','富民路145巷口','萬華國中_1','水源青年路口','艋舺雙園街口',
                '永昌公園','錦德公園','西園艋舺路口','華江國小','德昌寶興街口(西北角)','寶興長泰街口(西南角)','萬大路486巷口','古亭國中',
                '國興水源路口','青年公園高爾夫球場','新和國小','莒光立體停車場','華中疏散門','環河南和平西路口','華江污水廠','華江高中',
                '環南綜合市場','大理高中','萬大路493巷','萬華火車站(D2廣場)','德昌街10巷口','西園公園','綠堤社區公園','長順艋舺大道口',
                '捷運龍山寺站(1號出口)_1','艋舺西藏路口','和平西路二段190巷口','萬大路424巷口','龍口市場','大理高中(西藏路)',
                '萬青街186號','南海路112巷口'];

$display_red = ['植物園','大理高中','大理高中(西藏路)','華江高中'];

$display_blue = [''];


// 检查是否成功获取数据
if ($data) {

    $CarArray = array();

    for ($i = 0; $i < 200; $i++) {
        // 在每一行宣告一個包含3個元素的子陣列
        $CarArray[$i] = array("", 0, 0);
    }

     // 输出表头
     echo '<table border="1" style="font-size: 48px;">';
     echo '<tr><th>ZD1 站名</th><th>車量</th><th>空柱</th></tr>';

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
                    $CarArray[$i][1] = $station_data['available_rent_bikes'];
                    $CarArray[$i][2] = $station_data['available_return_bikes'];
                    break;
                }    
            } 
        }
     }

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
