<?php
//名前、本文のデータ取得
$name = $_POST["name"];
$text = $_POST["comment"];
//メソッド呼び出し
require_once('common.php');
// データベースに接続
$mysqli = dbConect();
try{
      // 投稿用のINSERT
      $sql = "INSERT INTO mybbs (name, bbstime, bbstext, bbsres) VALUES ('{$name}', NOW(), '{$text}', 0)";
      $res = $mysqli->query($sql);
      if(!$res){
          echo 'SQL実行エラー：' . $sql;
      }
}catch(PDOException $Exception){
      $mysqli->rollBack;
      print "エラー".$Exception->getMessage();
}

?>
