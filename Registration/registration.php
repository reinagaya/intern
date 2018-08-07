<!DOCTYPE html>
<html>
  <head>
    <meta  charset="UTF-8">
    <title>登録完了</title>
  </head>
  <body>
    あなたの登録した商品は，
<br>
<?php

// データベースに接続
require_once('./../connect/connectDB.php');

// データが送られてきたか判定
// POSTにデータがなければexit
if (empty($_POST)) {
  print "データがありません。<br>";
  exit;
} else {
  // カウンター
  $count = 0;

  // POSTに要素がいくつ入っているかカウント
  foreach($_POST as $value) {
    if (strlen($value) != 0) $count++;
  }

  if (isset($_FILES)) $count++;

  // 要素が不足していたらexit
  if ($count < 3) {
    print "データが不足しています。<br>";
    exit;
  }
}

// 送られてきた画像ファイルをローカルに保存する
$ima = $_FILES["photo"];
$fn = "./../photos/" . $ima["name"];
move_uploaded_file($ima["tmp_name"], $fn);

// 送られてきたデータを連想配列に格納
$data = array("name" => $_POST["name"],
              "price" => $_POST["price"],
              "photo" => $fn,
              "text" => $_POST["text"]);

// 確認用に表示
print $data["name"]."<br>";
print $data["price"]."<br>";
print "<IMG SRC = ".$fn.">"."<br>";
print $data["text"]."<br>";
print "です。<br>";

// 配列をjsonに変換 文字コードをUTF-8に設定
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

// DBに接続
connect();

// jsonデータをテーブルに挿入
$query = "insert into " . package . " set item = '$json_data'";
$result = mysqli_query($link, $query);

// 接続を切る
cut();

// 送信が失敗したらエラーメッセージを表示
if (!$result) {
  print "データの送信に失敗しました。<br>";
  exit;
}

?>
<input type = "button" onClick = "location.href='./../index.html'" value="戻る">
</body>
</html>