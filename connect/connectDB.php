<?php

// 接続に必要な引数を定義
// ホストネーム，ユーザー名，パスワード，データベース
define('Host', "localhost");
define('User', "root");
define('Passwd', "pcgz505dx");
define('DBname', "products");
 
// 接続
$link = mysqli_connect(Host, User, Passwd, DBname);
 
// 接続に失敗したら，エラーメッセージを表示
if (!$link) {
    print "データベース接続失敗" . PHP_EOL;
    print "errno: " . mysqli_connect_errno() . PHP_EOL;
    print "error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 
print 'データベース接続成功'.'<br>';
 
// 切断
mysqli_close($link);
print 'データベース切断成功'
 
?>