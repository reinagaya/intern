<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>検索結果</title>
  </head>
  <body>
<?php

// DBとの接続用
require_once("./../Connect/connectDB.php");

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
if ($_POST["shop"] !== "all") {
  $query .= " and shop = '" . $_POST["shop"] . "'";
}
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
    print $arr_item["shop"]."<br>";
    print $data["name"]."<br>";
    print $data["price"]."円<br>";
    print "<IMG SRC = ".$data["photo"].">"."<br>";
    print $data["text"]."<br>";
    print "です。<br>";

    // 変更と削除用のボタンを表示
    // print "<input type = 'button' onClick = 'location.href=\"./../Change/changeItem.html\"' value='更新'>";
    print "<form action='./../Change/inputForm.php' method='POST'>";
    print "<input type='hidden' name='item' value='". $arr_item["item"] ."'>";
    print "<input type='hidden' name='id' value ='". $arr_item["id"] ."'><input type='submit' value='変更'>";
    print "</form>";

    print "<form action='./../Delete/deleteItem.php' method='POST'>";
    print "<input type='hidden' name='id' value ='". $arr_item["id"] ."'><input type='submit' value='削除'>";
    print "</form>";

    // print "<input type = 'button' onClick = 'location.href=\"./../Delete/deleteItem.php\"' value='削除'>";
    print "<br>";
}
 
?>
<input type = "button" onClick = "location.href='./../index.php'" value="戻る">
</body>
</html>