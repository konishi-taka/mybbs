//新規投稿モーダルの表示
$('#login-show').click(function(){
    $('#login-modal').fadeIn();
});

//返信投稿モーダルの表示
$('.signup-show').click(function(){
  $('#signup-modal').fadeIn();
  $data = $(this).next('.postID').text();
  $('#hidden').val([$data]);
});

//モーダルのクローズ
$('.close-modal').click(function(){
    $('#login-modal').fadeOut();
    $('#signup-modal').fadeOut();
});

//返信内容の表示
$('.faq-list-item').click(function(){
  var $answer = $(this).find('.answer');
  if($answer.hasClass('open')){
    $answer.removeClass('open');
    $answer.slideUp();
    $(this).find('span').text('+');
  } else {
    $answer.addClass('open');
    $answer.slideDown();
    $(this).find('span').text('-');
  }
});

$('.newtext').on('click',function(event){
    //未記入時のアラート表示
    event.preventDefault();
    if (document.modal1.name.value=="") {
      alert("投稿名を入力してください。");
      return;
    } else if (document.modal1.comment.value=="") {
      alert("本文を入力してください");
      return;
    }
    // 操作対象のフォーム要素を取得
    var $form = $(this);
    //投稿用ajaxの記述
    $.post("modalAjax.php", {
        name    : $("input[name=name]").val(),
        comment : $("textarea[name=comment]").val(),
        //hidden  : $("input[name=hidden]").val()
        timeout: 10000
    },
    function(result, textStatus, xhr) {
        $('#login-modal').fadeOut("slow").queue(function() {
          location.reload();
        });
    });
});

$('.resres').on('click',function(event){
    //未記入時のアラート表示
    event.preventDefault();
    if (document.modal2.rename.value=="") {
      alert("投稿名を入力してください。");
      return;
  } else if (document.modal2.recom.value=="") {
      alert("本文を入力してください");
      return;
    }
    // 操作対象のフォーム要素を取得
    var $form = $(this);
    //投稿用ajaxの記述
    $.post("modalAjax2.php", {
        rename    : $("input[name=rename]").val(),
        recom      : $("textarea[name=recom]").val(),
        idcnt  : $("input[name=idcnt]").val(),
        timeout: 10000
    },
    function(result, textStatus, xhr) {
        $('#signup-modal').fadeOut("slow").queue(function() {
          location.reload();
        });
    });
});
