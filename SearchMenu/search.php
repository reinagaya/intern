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
}

// DBに接続
connect();

// 送られた文字列を含む商品を取得
$query = "select * from " . package . " where json_extract(item, '$.name') like '%" . $_GET["name"] . "%'";
$result = mysqli_query($link, $query);

// 取得されたデータの数
$count = mysqli_affected_rows($link);

// 接続を切る
cut();

if (!$result) {  
    // 取得が失敗したらエラーメッセージを表示
    print "データの取得に失敗しました。";
    exit;
}

if ($count === 0) {
    // セットが返ってこなかったら，該当する商品はない
    print "指定された文字列を含む商品はありません。";
    exit;
}

// 取得した各商品のid
$ids;

// 取得した各商品のデータを連想配列に代入
while($arr_item = mysqli_fetch_assoc($result)) {
    // idを保存しておく
    $ids[] = $arr_item["id"];

    // jsonを連想配列に変換
    $data = json_decode($arr_item["item"], true);

    // 商品情報を表示
    print $data["name"]."<br>";
    print $data["price"]."<br>";
    print "<IMG SRC = ".$data["photo"].">"."<br>";
    print $data["text"]."<br>";
    print "<br>";
}
 
?>