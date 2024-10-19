<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $functionName = $_POST['functionName'];

    if ($functionName == 'func1') {
        func1();
    } elseif ($functionName == 'func2') {
        func2();
    } elseif ($functionName == 'func3') {
        func3();
    } elseif ($functionName == 'func4') {
        func4();
    } 

}

function func1() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['永安公園','西安市民活動中心','雙十萬板路口','新北市藝文中心','永豐公園活動中心','振義里公園',
                    '捷運江子翠站(6號出口)','縣民民生路口','音樂公園','稚匯公園(華江三路)','華江公園','華江一華江六路口(仰真社區)',
                    '環河西華江六路口(翠亨村社區)','華江二華江一路口(帝國花園廣場社區)','華江五華江一路口(帝國花園廣場社區)',
                    '華江一華江二路口(吾界社區)','捷運新埔站(5號出口)','捷運新埔站(2號出口)','捷運新埔站(4號出口)',
                    '捷運江子翠站(3號出口)','華江一華江五路口(雙江翠社區)','埤墘公園','光復高中','莊敬公園','莒光國小',
                    '時光公園','江翠國小','仁化文新路口','文化路二段182巷1弄','萬板文聖街口','潤泰社區','板橋中山公園',
                    '溪頭公園','華江一華江九路口','民生中山路口','華江九華江一路口(匯翠社區)','新北市藝文中心(文化路二段124巷)',
                    '埔墘國小','華江一華江二路口(江匯Life社區)','石雕公園','光復國小','江翠國中','江翠國中活動中心地下停車場',
                    '三民翠華街口','民生路二段/文化路一段286巷口','松柏街15巷口','捷運江子翠站(1號出口)','捷運江子翠站(2號出口)',
                    '捷運江子翠站(4號出口)','三民永豐街口','中山路二段416巷38弄口','萬板高架橋下停車場','縣民大道三段270巷口',
                    '八德公園','文聖國小(松柏街50巷)','懷石公園','華江橋自行車牽引道','港嘴活動中心','縣民富山街口','文化懷德街口'];

    $display_red = [];

    $display_blue = ['捷運新埔站(2號出口)','捷運新埔站(4號出口)','捷運新埔站(5號出口)','捷運江子翠站(3號出口)',
                     '捷運江子翠站(2號出口)','捷運江子翠站(4號出口)','捷運江子翠站(6號出口)','捷運江子翠站(1號出口)'   ];

    // 检查是否成功获取数据
    if ($data) {

        $CarArray = array();

        for ($i = 0; $i < 200; $i++) {
            // 在每一行宣告一個包含3個元素的子陣列
            $CarArray[$i] = array("", 0, 0);
        }

        // 输出表头
        echo '<table border="1" style="font-size: 20px;">';
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

}

function func2() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['板橋國中','文德國小(公館街)','板橋第二運動場(皇翔建設)','玫瑰公園','環河公園','健華新城社區',
                    '環河西大漢街口','捷運板橋站(3號出口)','捷運板橋站(1號出口)','永翠藝文街口(大禾社區)',
                    '永翠藝文街口(柏克萊公園社區)','藝文二永翠路口(青峰社區)','中正新月二街口(富江翠社區)',
                    '中山國中','板橋國民運動中心','板橋四維公園','四維公園地下停車場','新海長江路口',
                    '板橋戶政事務所','板橋車站','國光公園','藝文藝文二街口(大悅社區)','新月二綠堤街口',
                    '板橋435藝文特區','府中立體停車場','板橋國小','捷運新埔民生站','捷運新埔站(1號出口)',
                    '板橋果菜批發市場','民生長江路口','林本源園邸','聯合醫院板橋院區','國光里(國光路)',
                    '環河西新月一街口(新月天地社區)','香社一藝文街口(歡喜市社區)','夢奇地公園(文化路一段)',
                    '中正路183巷','黃石中繼市場','文化路一段212巷口','湳仔溝抽水站','文丘公園','板橋車站(新站路)',
                    '新海抽水站停車場','聖若望平面停車場','板橋435藝文特區(環河西路)','介壽街/文化路一段188巷9弄口',
                    '南雅西路二段145巷','捷運環狀線板橋站(5號出口)','文德新海路口','板橋公車站'];

    $display_red = [];

    $display_blue = ['捷運新埔站(1號出口)','捷運環狀線板橋站(5號出口)','捷運板橋站(3號出口)','捷運板橋站(1號出口)',
                     '捷運新埔民生站'];

    // 检查是否成功获取数据
    if ($data) {

        $CarArray = array();

        for ($i = 0; $i < 200; $i++) {
            // 在每一行宣告一個包含3個元素的子陣列
            $CarArray[$i] = array("", 0, 0);
        }

        // 输出表头
        echo '<table border="1" style="font-size: 20px;">';
        echo '<tr><th>ZO2 站名</th><th>車量</th><th>空柱</th></tr>';

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
}

function func3() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['湳雅觀光夜市(津渡橋)','重慶國小','四川忠孝路口','國慶路149巷口','信義公園市民活動中心',
                    '華福市民活動中心','壽德新村','捷運亞東醫院站(2號出口)','四川遠東路口','華德公園',
                    '浮洲合宜住宅(合安一合宜路口)','浮洲合宜住宅(合安一路)','新北市立圖書館總館','馥華公園',
                    '浮洲合宜住宅(樂群路)','廣福公園','浮洲合宜住宅(合宜一路)','大觀國中','大明街20巷19弄口',
                    '信義和平路口','僑中二街92巷口','浮洲運動公園','中山國小地下停車場','南雅公園','板橋信義公園',
                    '板橋仁愛公園','浮洲火車站','大觀路二段19巷','三抱竹','臺灣藝術大學','信義路163巷口',
                    '大觀路二段265巷3弄口','力行新村','湳仔二橋','湳雅夜市停車場','大觀段平面停車場',
                    '五權公園地下停車場','華德公園平面停車場'];

    $display_red = [];

    $display_blue = ['捷運亞東醫院站(2號出口)'];

    // 检查是否成功获取数据
    if ($data) {

        $CarArray = array();

        for ($i = 0; $i < 210; $i++) {
            // 在每一行宣告一個包含3個元素的子陣列
            $CarArray[$i] = array("", 0, 0);
        }

        // 输出表头
        echo '<table border="1" style="font-size: 20px;">';
        echo '<tr><th>ZO3 站名</th><th>車量</th><th>空柱</th></tr>';

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

        // Ubike API的站点信息URL
        $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=1&size=210';

        // 发送HTTP请求获取JSON数据
        $json_data = file_get_contents($ubike_api_url);

        // 解析JSON数据
        $data = json_decode($json_data, true);

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
}

function func4() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['新北市政府(新府路)','新北市政府(新站路)','板橋福德公園','中華電信學院','漢生東路193巷口',
                    '板橋地政事務所','捷運府中站(1號出口)','縣民民族路口','海山高中','新府區運路口','海山高中(漢生東路)',
                    '後埔國小','縣民漢生東路口(西北側)','國光街圓環小公園','後埔國小(實踐路/重慶路155巷口)','德光莒光路口',
                    '德光國光街口','民德立體停車場','板橋第一運動場','中和自強公園','華福公園','國泰街111巷口',
                    '忠孝國中','捷運板新站','板橋和平公園','民生公園','縣民漢生東路口','板橋重慶公園',
                    '板新中山路一段口','新民民族路口','長安街251巷','縣民觀光街口','捷運府中站(3號出口)','民德路口',
                    '中山路二段90巷','莒光路136巷口','重慶路89巷','忠孝國中地下停車場','民族路225巷','府中汽車停車場'];

    $display_red = [];

    $display_blue = ['捷運府中站(1號出口)','捷運板新站','捷運府中站(3號出口)'];

    // 检查是否成功获取数据
    if ($data) {

        $CarArray = array();

        for ($i = 0; $i < 210; $i++) {
            // 在每一行宣告一個包含3個元素的子陣列
            $CarArray[$i] = array("", 0, 0);
        }

        // 输出表头
        echo '<table border="1" style="font-size: 20px;">';
        echo '<tr><th>ZO4 站名</th><th>車量</th><th>空柱</th></tr>';

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

        // Ubike API的站点信息URL
        $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=1&size=210';

        // 发送HTTP请求获取JSON数据
        $json_data = file_get_contents($ubike_api_url);

        // 解析JSON数据
        $data = json_decode($json_data, true);

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

}

?>