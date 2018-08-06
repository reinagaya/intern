<?php

// DBとの接続用
require_once("./../connect/connectDB.php");

// データが送られてきたか判定
// GETにデータがなければexit
if (empty($_GET)) {
    print "データがありません。";
    exit;
} else {
    // カウンター
    $counter = 0;

    // POSTに要素がいくつ入っているかカウント
    foreach($_POST as $value) {
        if (strlen($value) != 0) $counter++;
    }

    if (isset($_FILES)) $counter++;

    // 要素が不足していたらexit
    if ($counter < 4) {
        print "データが不足しています。";
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
print "です。";

// 配列をjsonに変換 文字コードをUTF-8に設定
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

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
    print "指定された商品はすでに変更されているか，存在しません。";
} else {
    print "データを変更しました。";
}

?>