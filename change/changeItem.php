<?php

// DBとの接続用
require_once("./../connect/connectDB.php");

// パッケージ名
define('package', "shop1");

// データが送られてきたか判定
// GETにデータがなければexit
if (empty($_GET)) {
    print "配列が空です";
    exit;
} else {
    // カウンター
    $count = 0;

    // GETに要素がいくつ入っているかカウント
    foreach($_GET as $value) {
        if (isset($value)) {
            $count++;
        }
    }

    // 要素が不足していたらexit
    if ($count < 4) {
        print "データが不足しています";
        exit;
    }
}

// 送られてきたデータを連想配列に格納
$data = array("name" => $_GET["name"],
              "price" => $_GET["price"],
              "photo" => $_GET["photo"],
              "text" => $_GET["text"]);

// 配列をjsonに変換
$json_data = json_encode($data);

// DBに接続
connect();

// 送られたidの商品を書き換える
$query = "update " . package . " set item = '" . $json_data . "' where id = ". $_GET["id"];
$result = mysqli_query($link, $query);

// 変更されたデータの数
$count = mysqli_affected_rows($link);

// 接続を切る
cut();

if (!$result) {  
    // 変更が失敗したらエラーメッセージを表示
    print "データの変更に失敗しました。";
    exit;
}

if ($count === 0) {
    // 変更した行数が0なら，変更はない
    print "指定された商品はすでに変更されています。";
} else {
    print "データを変更しました。";
}

?>