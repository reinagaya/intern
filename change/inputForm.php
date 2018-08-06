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
    print "データがありません。";
    exit;
}

// jsonを連想配列に変換
$data = json_decode($_POST["item"], true);

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
            <input type = "submit" value = "変更">
            <br>
        </form>
  </body>
</html>