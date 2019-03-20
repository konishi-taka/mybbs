<?php
//名前、本文のデータ取得
$name = $_POST["rename"];
$text = $_POST["recom"];
$reid = $_POST["idcnt"];
//メソッド呼び出し
require_once('common.php');
// データベースに接続
$mysqli = dbConect();
try{
      // 返信用のINSERT
      $sql = "INSERT INTO rescomment (resname, comtime, restext, oyaid) VALUES ('{$name}', NOW(), '{$text}', '{$reid}')";
      $res = $mysqli->query($sql);
      if(!$res){
          echo 'SQL実行エラー：' . $sql;
      }
}catch(PDOException $Exception){
      $mysqli->rollBack;
      print "エラー".$Exception->getMessage();
}

?>
