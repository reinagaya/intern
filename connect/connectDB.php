<?php

// 接続に必要な引数を定義
// ホストネーム，ユーザー名，パスワード，データベース
define('Host', "localhost");
define('User', "root");
define('Passwd', "pcgz505dx");
define('DBname', "products");

// 接続時のオブジェクト用変数
$link;

// 接続状態を確認するための変数
$isConnected = false;

function connect() {

    // すでに接続されているときは抜ける
    if (!$GLOBALS["isConnected"]) {
        // 接続
        $GLOBALS['link'] = mysqli_connect(Host, User, Passwd, DBname);
    } else {
        print "接続済み" . "<br>";
        return;
    }
    
    // 接続に失敗したら，エラーメッセージを表示
    if (!$GLOBALS['link']) {
        print "データベース接続失敗" . "<br>";
        print "errno: " . mysqli_connect_errno() . "<br>";
        print "error: " . mysqli_connect_error() . "<br>";
        exit;
    }
    
    // 接続成功
    $GLOBALS["isConnected"] = true;
    print "データベース接続成功" . "<br>";
}

function cut() {

    // 接続されている場合のみ切断処理をする
    if ($GLOBALS["isConnected"]) {

        // 切断，mysqli_closeの戻り値を反転させてisConnectedに格納
        $GLOBALS["isConnected"] = (mysqli_close($GLOBALS["link"]) == true ? false : true);

        // 切断できたか確認
        if (!$GLOBALS["isConnected"]) {
            print "データベース切断成功" . "<br>";
        } else {
            print "データベース接続失敗" . "<br>";
        }

    } else {
        print "接続されていない" . "<br>";
    }
}
 
?>