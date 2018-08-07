<!DOCTYPE html>
<html>
  <head>
    <meta  charset="UTF-8">
    <title>商品情報の変更</title>
  </head>
  <body>
      <!-- 画像ファイルを送るので，enctype = "multipart/form-data"を設定 -->
      <form action = "./changeItem.php" method = "post" enctype = "multipart/form-data">
<?php

// データが送られてきたか判定
// POSTにデータがなければexit
if (empty($_POST)) {
    print "データがありません。<br>";
    exit;
}

// jsonを連想配列に変換
$data = json_decode($_POST["item"], true);

// データベースに接続
require_once('./../Connect/connectDB.php');

// DBに接続
connect();

// データベースに存在する店舗を取得
$query = "select distinct shop from " . package;
$result = mysqli_query($link, $query);

// 接続を切る
cut();

// 取得が失敗したらエラーメッセージを表示
if (!$result) {
  print "データの取得に失敗しました。<br>";
  return;
}

// 店舗を指定するためのボックス
print "店舗　　<input type='text' name='shop' list='shop_name' placeholder='店舗のなまえを入力' autocomplete='off' required>";
print "<datalist id='shop_name'>";
while ($row = mysqli_fetch_row($result)) {
  // 各店舗をオプションに追加
  print "<option value=". $row[0] .">";
}
print "</datalist><br>";

// 各情報の書き換え
print "商品名　<input type='text' name='name' value=". $data["name"] ." required><br>";

// 写真は現在の画像を表示し，変更のない場合は元の値が渡される
print "<IMG SRC = ".$data["photo"].">"."<br>";
print "<input type='hidden' name='photo' value='". $data["photo"] ."'>";
print "画像　　<input type='file' name='photo'><br>";

print "値段　　<input type='number' name='price' value='". $data["price"] ."' required><br>";
print "<textarea name='text' rows='10' cols='40' maxlength='100'>". $data["text"] ."</textarea><br>";

print "<input type='hidden' name='id' value='". $_POST["id"] ."'><br>";

?>
            <input type = "button" onClick = "location.href='./../index.php'" value="戻る">
            <input type = "submit" value = "変更">
            <br>
        </form>
  </body>
</html>