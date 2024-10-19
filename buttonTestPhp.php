<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $functionName = $_POST['functionName'];

    if ($functionName == 'func1') {
        func1();
    } elseif ($functionName == 'func2') {
        func2();
    } elseif ($functionName == 'func3') {
        func3();
    }
}

function func1() {
    // 這裡是你的PHP代碼邏輯
    echo "執行了 PHP 的 func1()";
}

function func2() {
    // 這裡是你的PHP代碼邏輯
    echo "執行了 PHP 的 func2()";
}

function func3() {
    // 這裡是你的PHP代碼邏輯
    echo "執行了 PHP 的 func3()";
}
?>