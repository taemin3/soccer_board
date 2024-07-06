<?php
session_start();
error_reporting(1);
ini_set("display_errors",1);
$uid = $_SESSION['uid'];
$nickname = $_SESSION['name'];
if(!$uid) { ?>
    <script>alert('로그인 후 이용해주세요.'); 
            history.back();</script>
<?php
}

?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="./write.css?after1" />
<link rel='stylesheet' href='./home.css?after'>
</head>
<body>
<?php
    require_once('view/board_top.php');
    ?>
    <div style = " float: left; padding:20px; border:1px solid #999999; border-radius: 10px 10px 10px 10px; background:white;margin-left:20px; margin-top:20px;">
    <?php
    
    if($uid) {
        echo $nickname;
        echo "님 안녕하세요.";
    ?>  
        <form style="margin-top:20px;" action="logout.php" method="post" >
            <button class="button1" type="submit">로그아웃</button>
        </form>
    <?php } ?>
    
    </div>
    <br>
    <div id="board_write">
        <h1>EPL 자유게시판</h1>
            <div id="write_area">
                <form action="write_ok.php" method="post"  enctype="multipart/form-data">
                
                    <div id="in_title">
                        <span style="font-size:20px;">제목</span>
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <div id="in_content">
                        <span style="font-size:20px;">내용</span>
                        <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
                    </div>
                    <input type="hidden" name="ninkname" value="<?=$nickname?>"/>
                    <input type="hidden" name="uid" value="<?=$uid?>"/>
                    <input type="file"  name="image"/>.jpg .jpeg .gif .png 만 가능
                    <div class="bt_se">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>