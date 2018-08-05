<p>あなたの登録した商品は，
<br>
<?php

// データが送られてきたか判定
// GETにデータがなければexit
if (empty($_GET)) {
  print "配列が空です";
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
    print "データが不足しています";
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
print $data["text"];
  
?>
</p>