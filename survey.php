<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');


if (!empty($_POST)) {
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $comment = $_POST['comment'];

  // DBへの接続準備
  $dsn = 'mysql:dbname=survey;host=localhost;charset=utf8';
  $user = 'root';
  $password = '1234';
  $options = array(
          // SQLの実行失敗時に例外をスロー
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          // デフォルトフェッチモードを連想配列形式に設定
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          // バッファードクエリを使う（一度に結果セットを全て取得し、サーバ負荷を軽減）
          // SELECTで得た結果に対してもCountメソッドを使えるようにする
          PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );

  // PDOオブジェクト生成（DB作成）
  $dbh = new PDO($dsn, $user, $password, $options);

  // SQL文（クエリー作成）
  $stmt = $dbh->prepare('INSERT INTO result(name, gender, height, weight, comment) VALUES (:name, :gender, :height, :weight, :comment)');

  // プレースホルダに値をセットし、SQL文を実行
  $stmt->execute(array(':name' => $name, ':gender' => $gender, ':height' => $height, ':weight' => $weight, ':comment' => $comment));

  header("Location:ok.html");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>アンケートページ</title>
    <link rel="stylesheet" type="text/css" href="css/survey-style.css">
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
  </head>
  <body>
    <?php require ('header.html'); ?>
    <form method="post" class="site-font site-width">
      <h1 class="title site-font">NAME</h1>
      <input type="text" name="name" placeholder="名前">
      <h1 class="title site-font">GENDER</h1>
      <input type="radio" name="gender" value="男" checked><span>男</span>
      <input type="radio" name="gender" value="女"><span>女</span>
      <h1 class="title site-font">HEIGHT</h1>
      <input type="text" name="height" placeholder="身長">
      <h1 class="title site-font">WEIGHT</h1>
      <input type="text" name="weight" placeholder="体重">
      <h1 class="title site-font">FREE COMMENT</h1>
      <textarea cols="100" rows="3" name="comment" placeholder="備考"></textarea>
      <input type="submit" name="submit" value="submit">
    </form>
    <?php require ('footer.html'); ?>
  </body>
</html>
