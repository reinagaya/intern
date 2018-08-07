<!DOCTYPE html>
<html>
  <head>
    <meta  charset="UTF-8">
    <title>商品登録</title>
  </head>
  <body>
      <!-- 画像ファイルを送るので，enctype = "multipart/form-data"を設定 -->
      <form action = "./registration.php" method = "post" enctype = "multipart/form-data">
        <!-- 情報を入力 説明文以外は入力必須 -->
        <?php
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
        ?>
        商品名　<input type = "text" name = "name" required><br>
        画像　　<input type = "file" name = "photo" required><br>
        値段　　<input type = "number" name = "price" required><br>
        <!-- 説明文を入れるためのtextarea 100文字まで -->
        <textarea name = "text" rows = "10" cols = "40" maxlength = "100" placeholder = "説明文"></textarea><br>
        <br>
        <input type = "button" onClick = "location.href='./../index.php'" value="戻る">
        <input type = "submit" value = "登録">
        <br>
    </form>
  </body>
</html>