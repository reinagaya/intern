<!DOCTYPE html>
<html>
  <head>
    <meta  charset="UTF-8">
    <title>変更完了</title>
  </head>
<?php

// DBとの接続用
require_once("./../Connect/connectDB.php");

// データが送られてきたか判定
// GETにデータがなければexit
if (empty($_POST)) {
    print "データがありません。<br>";
    exit;
} else {
    // カウンター
    $counter = 0;

    // POSTに要素がいくつ入っているかカウント
    foreach($_POST as $key => $value) {
        if (strlen($value) != 0) $counter++;
    }

    if (isset($_FILES)) $counter++;

    // 要素が不足していたらexit
    if ($counter < 5) {
        print "データが不足しています。<br>";
        exit;
    }
}

// 送られてきた画像ファイルをローカルに保存する
$fn;
if (empty($_FILES)) {
    $ima = $_FILES["photo"];
    print $ima["name"];
    $fn = "./../photos/" . $ima["name"];
    move_uploaded_file($ima["tmp_name"], $fn);
} else {
    // 変更されていない場合は元のデータを移す
    $fn = $_POST["photo"];
}

// 送られてきたデータを連想配列に格納
$data = array("name" => $_POST["name"],
              "price" => $_POST["price"],
              "photo" => $fn,
              "text" => $_POST["text"]);

// 確認用に表示
print $_POST["shop"]."<br>";
print $data["name"]."<br>";
print $data["price"]."円<br>";
print "<IMG SRC = ".$fn." width='200'>"."<br>";
print $data["text"]."<br>";
print "です。<br>";

// 配列をjsonに変換 文字コードをUTF-8に設定
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

// DBに接続
connect();

// 送られたidの商品を書き換える
$query = "update " . package . " set item = '" . $json_data . "', shop = '". $_POST["shop"] ."' where id = ". $_POST["id"];
$result = mysqli_query($link, $query);

// 変更されたデータの数
$count = mysqli_affected_rows($link);

// 接続を切る
cut();

if (!$result) {  
    // 変更が失敗したらエラーメッセージを表示
    print "データの変更に失敗しました。<br>";
    exit;
}

if ($count === 0) {
    // 変更した行数が0なら，変更はない
    print "指定された商品はすでに変更されているか，存在しません。<br>";
} else {
    print "データを変更しました。<br>";
}

?>
<input type = "button" onClick = "location.href='./../index.php'" value="戻る">
</body>
</html>
