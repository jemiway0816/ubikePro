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
        echo '<table border="1" style="font-size: 24px;">';
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
}

function func2() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://data.ntpc.gov.tw/api/datasets/010e5b15-3823-4b20-b401-b1cf000550c5/json?page=3&size=210';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['捷運新埔站(1號出口)','捷運新埔站(2號出口)','民生路二段/文化路一段286巷口','捷運新埔站(4號出口)','捷運新埔站(5號出口)',
                    '捷運江子翠站(1號出口)','捷運江子翠站(2號出口)','捷運江子翠站(3號出口)','捷運江子翠站(4號出口)' , '捷運江子翠站(6號出口)',
                    '文化路二段182巷1弄','松柏街15巷口','振義里公園','三民翠華街口','三民永豐街口','永豐公園活動中心','埔墘國小','民生中山路口',
                    '中山路二段90巷','西安市民活動中心','埤墘公園','八德公園','莊敬公園','華江公園','板橋中山公園','新北市藝文中心',
                    '新北市藝文中心(文化路二段124巷)','莒光國小','縣民富山街口','縣民大道三段270巷口','永安公園','音樂公園','懷石公園',
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

function func3() {

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
 //       echo '</table>';
    } else {
        echo '无法获取Ubike数据';
    }

    //------------------------------------------------------------

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
 //       echo '<table border="1" style="font-size: 24px;">';
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
  //      echo '</table>';
    } else {
        echo '无法获取Ubike数据';
    }

    //-----------------------------------------------------------

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
  //      echo '<table border="1" style="font-size: 24px;">';
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

function func4() {

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://tcgbusfs.blob.core.windows.net/dotapp/youbike/v2/youbike_immediate.json';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

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
        echo '<table border="1" style="font-size: 20px;">';
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
//        echo '</table>';
    } else {
        echo '无法获取Ubike数据';
    }

//-------------------------------------------------------------

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://tcgbusfs.blob.core.windows.net/dotapp/youbike/v2/youbike_immediate.json';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

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
 //       echo '<table border="1" style="font-size: 24px;">';
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
 //       echo '</table>';
    } else {
        echo '无法获取Ubike数据';
    }

//----------------------------------------------------------------

    // Ubike API的站点信息URL
    $ubike_api_url = 'https://tcgbusfs.blob.core.windows.net/dotapp/youbike/v2/youbike_immediate.json';

    // 发送HTTP请求获取JSON数据
    $json_data = file_get_contents($ubike_api_url);

    // 解析JSON数据
    $data = json_decode($json_data, true);

    $display_sna = ['原臺北刑務所官舍','仁愛紹興街口(南側)','林森濟南路口(東北側)','仁愛金山路口(東南側)','青島杭州路口','仁愛紹興路口(北側)',
                    '愛國金山路口','南昌公園','和平重慶路口','螢橋公園','螢圃里小公園','林森仁愛路口','中正運動中心','孫立人將軍官邸',
                    '金華杭州南路口','螢橋國小','郵政博物館','捷運中正紀念堂站(2號出口)','金甌女中','捷運善導寺站(1號出口)',
                    '信義杭州路口','臺北市國父史蹟館(逸仙公園)','仁愛金山路口','杭州南路一段101巷口','中山青島路口','林森徐州路口',
                    '徐州杭州路口','文光公園','仁愛杭州路口','臺大醫院兒童醫院','仁愛林森路口','國家音樂廳','臺灣文學基地','濟南路二段8巷口',
                    '金杭公園','捷運古亭站(9號出口)','牯嶺公園','捷運古亭站(8號出口)','捷運古亭站(7號出口)','羅斯福路二段6巷口',
                    '捷運中正紀念堂站(3號出口)','捷運中正紀念堂站(4號出口)','捷運中正紀念堂站(5號出口)','羅斯福寧波東街口','重慶南詔安街口',
                    '泉州寧波西街口','金山信義路口','濟南紹興路口','捷運善導寺站(3號出口)','中山徐州路口','紹興徐州路口','捷運善導寺站(3號出口)(忠孝東路側)',
                    '林森北平路口','天津北平路口','詔安街37巷口','捷運善導寺站(5號出口)','牯嶺街95巷'];

    $display_red = ['愛國金山路口','孫立人將軍官邸','螢橋國小','和平重慶路口','牯嶺公園'];

    $display_blue = [''];


    // 检查是否成功获取数据
    if ($data) {

        $CarArray = array();

        for ($i = 0; $i < 200; $i++) {
            // 在每一行宣告一個包含3個元素的子陣列
            $CarArray[$i] = array("", 0, 0);
        }

        // 输出表头
  //      echo '<table border="1" style="font-size: 24px;">';
        echo '<tr><th>ZD3 站名</th><th>車量</th><th>空柱</th></tr>';

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

}

?>
