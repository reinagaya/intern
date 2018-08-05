<p>あなたの登録した商品は，
<br>
<?php

// データベースに接続
require_once('./../connect/connectDB.php');

define('package', "shop1");

// データが送られてきたか判定
// GETにデータがなければexit
if (empty($_GET)) {
  print "データがありません。";
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
    print "データが不足しています。";
    exit;
  }
}

// 送られてきたデータを連想配列に格納
$data = array("name" => $_GET["name"],
              "price" => $_GET["price"],
              "photo" => $_GET["photo"],
              "text" => $_GET["text"]);

// 確認用に表示
print $data["name"]."<br>";
print $data["price"]."<br>";
print "<IMG SRC = ".$data["photo"].">"."<br>";
print $data["text"]."<br>";
print "です。";

// 配列をjsonに変換
$json_data = json_encode($data);

// DBに接続
connect();

// jsonデータをテーブルに挿入
$query = "insert into " . package . " set item = '$json_data'";
$result = mysqli_query($link, $query);

// 接続を切る
cut();

// 送信が失敗したらエラーメッセージを表示
if (!$result) {
  print "データの送信に失敗しました。";
  exit;
}

?>
</p>