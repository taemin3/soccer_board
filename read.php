<?php 
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$uid = $_SESSION['uid'];

$nickname = $_SESSION['name'];
$sql5 = "update board set hit=hit+1 where id='{$_GET['id']}'";
$result5 = mysqli_query($conn,$sql5);

?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>축구 게시판</title>
<link rel="stylesheet" type="text/css" href="./read1.css?after4" />
<link rel='stylesheet' href='./home.css?after'>
</head>
<body>
<?php
    require_once('view/board_top.php');?>
    <div style = "float: left; padding:20px; border:1px solid #999999; border-radius: 10px 10px 10px 10px; background:white; margin-left:20px; margin-top:20px;">
    <?php
    
    if($uid) {
        echo $nickname;
        echo "님 안녕하세요.";
    ?>  
        <form style="margin-top:20px;" action="logout.php" method="post" >
            <button class="button1" type="submit">로그아웃</button>
        </form>
    <?php } else  { ?>
        <form action="join.php" method="post" >
            <input type="submit" value="회원가입">  
        </form> 
        <form style="margin-top:20px;" action="login.php" method="post" >
            <input type="submit" value="로그인">
        </form>
    <?php }?>
    </div>
    <br>


    <div id="board_read">
    <?php
        $sql = "SELECT * from board where id = '{$_GET['id']}'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
    
    ?>
	<h2><?php echo $row['title']; ?></h2>
		<div id="user_info">
			<?php echo $row['name']; ?> <?php echo date("m-d H:i", strtotime($row['date'])); ?> 조회:<?php echo $row['hit']; ?>
				<div id="bo_line"></div>
			</div>
			<div id="bo_content">
				<?php 
                    echo nl2br("$row[content]");
                    if ($row['image']) {
                        echo "<br><br><img width=\"800px\" src='image/$row[image]'></img>";
                    } ?>

                    <div style="margin-top:50px; text-align:center;">
                        <form  action="good.php" method="POST">
                            <input type="hidden" name="bid" value="<?=$_GET['id']?>"></input>
                            <input type="image" src="good.png" width="50px">
                        </form>
                        <span style='color:blue; font-weight:800;'><?=$row['good']?></span>
                    </div>
			</div>
            
	<br><br>
	<div id="bo_ser">
		<ul>
			<li><a href="../board">[목록으로]</a></li>
            <?php if ($uid == $row['uid']) { ?>
                <li><a href="change.php?id=<?=$row['id']?>">[수정]</a></li>
                <li><a href="delete.php?id=<?=$row['id']?>" onClick="if(!confirm('삭제하시겠습니까?')) {return false;}">[삭제]</a></li>
    <?php   } ?>
		</ul>
	</div>
    <br>
    <br>
    <strong>댓글</strong>
    <div id="bo_line"></div>
    <?php    
        $sql1 = "SELECT * from reply where board_id = '{$_GET['id']}'";
        $result1 = mysqli_query($conn,$sql1);
        while($row1 = mysqli_fetch_array($result1)) { ?>
           <?=$row1['writer_name']?> <span style="font-size:13px"><?=date("m-d H:i", strtotime($row1['date']))?></span><br><br><?=$row1['content']?>
           <?php
           
           
           if($uid == $row1['writer_id']) { ?>
                <div id="bo_ser">
                    <ul>
                    <li><a href="read.php?id=<?=$row['id']?>&rid=<?=$row1['id']?>" >[수정]</a>
                    <li><a href="reply_delete.php?id=<?=$row1['id']?>&bid=<?=$row['id']?>" onClick="if(!confirm('삭제하시겠습니까?')) {return false;}">[삭제]</a>
                    </ul>
                    
                </div>
    <?php  }
           ?>
           <div id="re_line"></div>
<?php  }
    $label_submit = "댓글 작성";
    $form_action = 'reply.php';
    $replyctt = '';
    if(isset($_GET['rid'])) {
        $label_submit = "댓글 수정";
        $form_action = 'reply_change.php';
        $sql2 = "SELECT * from reply where id = '{$_GET['rid']}'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_array($result2);
        $replyctt = $row2['content'];
    }
    ?>
<?php if ($uid) { ?>
        <div style="margin-left:30px; margin-top:30px;">

            <form action="<?=$form_action?>" method="post">
                <textarea style="width:780px; height:70px;"name="content" placeholder="내용"required><?=$replyctt?></textarea>
                <input type="hidden" name="nickname" value="<?=$nickname?>"></input>
                <input type="hidden" name="rid" value="<?=$_GET['rid']?>"></input>
                <input type="hidden" name="uid" value="<?=$uid?>"></input>
                <input type="hidden" name="id" value="<?=$_GET['id']?>"></input>
                <button style = "margin-bottom:100px;"type="submit"><?=$label_submit?></button>
            </form>
        </div>
    <?php }  ?>
</div>  
    
</body>
</html>