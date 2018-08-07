<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>商品検索</title>
  </head>
  <body>
      <form action = "./Search/search.php" method = "post">
        <?php
          // データベースに接続
          require_once('./Connect/connectDB.php');

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
          print "店舗：<select name='shop'>";
          print "<option value='all'>すべての店舗</option>";
          while ($row = mysqli_fetch_row($result)) {
            // 各店舗をオプションに追加
            print "<option value=". $row[0] .">". $row[0] ."</option>";
          }

          print "</select><br>"
        ?>
        <!-- 商品名入力用text 何も入力しないとすべての商品が表示される -->
        <input type= "text" name = "name">
        <br>
        <input type = "submit" value = "検索">
        <br>
        <br>
        <!-- 登録ページに飛ぶボタン -->
        <input type = "button" onClick = "location.href='./Registration/inputRegistration.php'" value="登録">
    </form>
  </body>
</html>