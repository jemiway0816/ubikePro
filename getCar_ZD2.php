
// getCar_ZD2

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

$display_sna = ['捷運中正紀念堂站(6號出口)','柳鄉公園','立法院台北會館','貴陽博愛路口','聯合醫院中興院區','捷運小南門站(1號出口)',
                '延平南路133巷口','開封西寧路口','太原廣場','大同16號廣場','南門國中','重慶長安路口','寶慶博愛路口','國家圖書館',
                '介壽公園','中華漢口街口','中華路一段21巷口','臺北市立大學(博愛校區)','捷運臺大醫院站(1號出口)','弘道國中',
                '臺北市第一女子高級中學','長沙公園','貓公園(中興橋頭)','西本願寺廣場','中華峨眉街口','中華桂林路口',
                '臺北市電影主題公園(康定路)','臺北市電影主題公園(峨眉街)','忠孝西重慶南路口','聯合醫院和平院區','捷運北門站(3號出口)',
                '承德鄭州路口(市民高架下)','陳天來故居','捷運臺北車站(M2出口)','永樂市場','圓環站','捷運小南門站(2號出口)',
                '中華貴陽街口','中山堂','捷運西門站(2號出口)','法務部','捷運臺大醫院站(4號出口)','捷運西門站(5號出口)',
                '捷運西門站(3號出口)','華西公園','老松國小','峨眉停車場','大稻埕碼頭','龍山國中','洛陽停車場','桂林昆明街口',
                '萬華266號綠地'];

$display_red = ['永樂市場','大稻埕碼頭','老松國小','桂林昆明街口','捷運小南門站(2號出口)'];

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
     echo '<tr><th>ZD2 站名</th><th>車量</th><th>空柱</th></tr>';

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
