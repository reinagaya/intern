<p>あなたの登録した商品は，
<br>
<?php
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