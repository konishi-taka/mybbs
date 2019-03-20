<?php
//データベースへの接続
function dbConect(){
        $mysqli = new mysqli('localhost', 'ppf', 'ppfpart1234', 'konishi_bbs');;
        //SQL接続エラー処理
        if ($mysqli->connect_error) {
            echo $mysqli->connect_error;
            exit ();
        } else {
            $mysqli->set_charset ( "utf8" );
        }
        return $mysqli;
}

//データベースへの挿入
function dbInsert(){
    $mysqli = dbConect();
    if(isset($_POST["rename"], $_POST["recom"])){
      //名前が空のとき
      if($_POST["rename"] == ''){
        echo "名前を入力してください<br>";
      }else{
        $isName = $_POST["rename"];
      }
      // 内容が空のとき
      if($_POST["recom"] == ''){
          echo "本文を入力してください";
      }else{
          $isContent = $_POST["recom"];
      }
    }
    if(isset($isName, $isContent)){
      if($isName && $isContent){
        try{
          // INSERT文
          $sql = "INSERT INTO rescomment (resid,resname, comtime,restext) VALUES ()";
          $res = $mysqli->query($sql);
          if(!$res){
              echo 'SQL実行エラー：' . $sql;
          }
        }catch(PDOException $Exception){
          $mysqli->rollBack;
          print "エラー".$Exception->getMessage();
        }
        return $res;
        }
    }
}
?>
