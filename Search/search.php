<?php

// DBとの接続用
require_once("./../connect/connectDB.php");

// データが送られてきたか判定
// 送られてきたデータがname以外，またはGETにデータがなければexit
if (!isset($_POST["name"]) || $_POST == "") {
  print "データがありません。";
  exit;
}

// DBに接続
connect();

// 送られた文字列を含む商品を取得
$query = "select * from " . package . " where json_extract(item, '$.name') like '%" . $_POST["name"] . "%'";
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

// 取得した各商品のデータを連想配列に代入
while($arr_item = mysqli_fetch_assoc($result)) {
    // jsonを連想配列に変換
    $data = json_decode($arr_item["item"], true);

    // 商品情報を表示
    print $data["name"]."<br>";
    print $data["price"]."<br>";
    print "<IMG SRC = ".$data["photo"].">"."<br>";
    print $data["text"]."<br>";

    // 変更と削除用のボタンを表示
    print "<input type = 'button' onClick = 'location.href=\"./../Change/changeItem.html\"' value='更新'>";
    print "<input type = 'button' onClick = 'location.href=\"./../Delete/deleteItem.php\"' value='削除'><br>";
    print "<br>";
}
 
?>