<?php
    //SQL接続する
    require_once('common.php');
    // DB処理
    $mysqli = dbConect();
    $sql = "SELECT * FROM mybbs ORDER BY id DESC";
    $result = $mysqli -> query($sql);
    //クエリー失敗
    if(!$result) {
     echo $mysqli->error;
    exit();
    }

    //連想配列で取得
    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $rows[] = $row;
    }
    //結果セットを解放
    $result->free();
    // DB接続を閉じる
    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <body>
  <div id="bodyBackground"></div>
  <div id="windows" class=""></div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My BBS</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Corben:700" rel="stylesheet">
 </head>
 <div id="bodyBackground"></div>
  <div id="windows" class=""></div>
    <header>
        <div class="headerLogo"><a href="index.php">MyBBS</a></div>
        <div class="headerRight">
            <div class="headerBtn"><button id="login-show" class="contributionBtn btn">投稿</button></div>
        </div>
    </header>

    <div class="titleArea">BBS</div>
    <?php
    define('MAX','2');

    $row_num = count($rows); // トータル件数
    $max_page = ceil($row_num / MAX); // トータルページ数
    $page_width = 2; // 表示するページ幅

    if(!isset($_GET['page_id']) || $_GET['page_id'] > $max_page ||
         !is_numeric($_GET['page_id'])){
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }

    $start_no = ($now - 1) * MAX;

    $disp_data = array_slice($rows, $start_no, MAX, true);

    foreach($disp_data as $row){
        require_once('common.php');
        //SQL接続
        $mysqli = dbConect();

        // DB処理
        $result_cnt = $mysqli -> query("SELECT * FROM rescomment WHERE oyaid = {$row['id']} ORDER BY resid DESC");
        //クエリー失敗
        if(!$result_cnt) {
         echo $mysqli->error;
        exit();
        }

        //レコード件数
        $row_count = $result_cnt->num_rows;

        //連想配列で取得
        $rows2 = array();
        while($row2 = $result_cnt->fetch_array(MYSQLI_ASSOC)){
            $rows2[] = $row2;
        }

        //結果セットを解放
        $result_cnt->free();

        // DB接続を閉じる
        $mysqli->close();
        ?>
    <div class="middleForm">
        <div class="backForm">名前  :  <?php echo $row['name'];?>
            <div class="timeText">
                投稿時間  :  <?php echo $row['bbstime'];?>
            </div>
        </div>
        <div class="bbsText">
            内容  :  <?php echo $row['bbstext'];?>
        </div>
        <div id="faq-list">
          <div class="faq-list-item">
                <div class="resBbs">返信内容
                    <?php if($row_count > 0) {
                        echo "<span>+</span>";
                    } else {
                        echo "";
                    } ?>
                    <div class="resCnt">返信件数  :  <?php echo $row_count;?>件</div>
                </div>
                <?php foreach($rows2 as $row2){?>
                <div class="answer">
                    <div class="backForm">
                        名前  :  <?php echo $row2['resname']; ?>
                        <div class="timeText">
                            投稿時間  :  <?php echo $row2['comtime'];?>
                        </div>
                    </div>
                    <div class="bbsText">
                        内容  :  <?php echo $row2['restext']; ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="reText">
            <form method="post">
                <div class="btn signup" name="resCount"><i class="fas fa-envelope  signup-show">返信</i><span class="postID" style="display: none"><?= $row['id'] ?></span></div>
            </form>
        </div>
    <?php
    }
     ?>
    </div>
        <div>
            <div class="pageId">Page.
                <?php
                //一つ前のページへ
                if($now > 1){ // リンクをつけるかの判定
                    echo '<a href=\'/konishi_bbs2/index.php?page_id='.($now - 1).'\')>前へ</a>'. '　';
                } else {
                    echo '　'.'前へ'. '　';
                }
                //間のページ表示
                for($i = 1; $i <= $max_page; $i++){
                    if ($i == $now) {
                        echo $now. '　';
                    } else {
                        echo '<a href=\'/konishi_bbs2/index.php?page_id='. $i. '\')>'. $i. '</a>'. '　';
                    }
                }
                //一つ後のページへ
                if($now < $max_page){ // リンクをつけるかの判定
                    echo '<a href=\'/konishi_bbs2/index.php?page_id='.($now + 1).'\')>次へ</a>'. '　';
                } else {
                    echo '　'.'次へ';
                }
                ?>
            </div>
        </div>

            <div class="signup-modal-wrapper"></div>
            <div id="login-modal" class="login-modal-wrapper">
              <div class="modal">
                  <div class="close-modal">
                      <i class="fa fa-2x fa-times"></i>
                  </div>
                <div id="login-form">
                  <h2>新規投稿</h2>
                  <form action="modalAjax.php" name="modal1" id="myForm" method="post">
                    <input name="name" maxlength='20' class="form-control" type="text" placeholder="名前(20文字まで)" value="">
                    <textarea name="comment" maxlength='140' class="form-control" type="text" placeholder="投稿内容(140字まで)" value=""></textarea>
                    <input type="hidden" name="hidden" value="">
                    <div id="submit" class="newtext">投稿する</div>
                  </form>
                </div>
              </div>
            </div>

            <div class="signup-modal-wrapper" id="signup-modal">
              <div class="modal">
                <div class="close-modal">
                  <i class="fa fa-2x fa-times"></i>
                </div>
                <div id="signup-form">
                  <h2>返信</h2>
                  <form action="modalAjax2.php" name="modal2" id="myForm2" method="post">
                    <input maxlength='20' name="rename" class="form-control" type="text" placeholder="名前(20文字まで)" value="">
                    <textarea maxlength='140' name="recom" class="form-control" type="text" placeholder="投稿内容(140字まで)" value=""></textarea>
                    <input type="hidden" id="hidden" name="idcnt" value="">
                    <div id="submit" class="resres">返信する</div>
                  </form>
                </div>
              </div>
            </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="index.js" type="text/javascript"></script>
  </body>
</html>
