<!DOCTYPE html>
<html>
  <head>
    <meta  charset="UTF-8">
    <title>削除完了</title>
  </head>
  <body>
<?php

// DBとの接続用
require_once("./../connect/connectDB.php");

// データが送られてきたか判定
// 送られてきたデータがid以外，またはGETにデータがなければexit
if (!isset($_POST["id"]) || empty($_POST)) {
  print "データがありません。<br>";
  exit;
}

// DBに接続
connect();

// 送られたidの商品を削除
$query = "delete from " . package . " where id = ". $_POST["id"];
$result = mysqli_query($link, $query);

// 削除されたデータの数
$count = mysqli_affected_rows($link);

// 接続を切る
cut();

if (!$result) {  
    // 削除が失敗したらエラーメッセージを表示
    print "データの削除に失敗しました。<br>";
    exit;
}

if ($count === 0) {
    // データがない場合は通知
    print "該当するデータはありません。<br>";
} else if ($count > 0) {
    print "データは削除されました。<br>";
}
 
?>
<input type = "button" onClick = "location.href='./../index.html'" value="戻る">
</body>
</html>