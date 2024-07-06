<?php 
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$uid = $_SESSION['uid'];
$nickname = $_SESSION['name'];

?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>축구 게시판</title>
<link rel="stylesheet" type="text/css" href="./style4.css?after6" />
<link rel='stylesheet' href='./home.css?after'>
</head>
<body>
<?php
    require_once('view/board_top.php');?>
    

    <div style = " float: left; padding:20px; border:1px solid #999999; border-radius: 10px 10px 10px 10px; background:white;margin-left:20px; margin-top:20px;">
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
    <div id="board_area"> 
    <h1>EPL 인기글</h1>
        <table class="list-table">
        <thead>
            <tr>
                <th width="70">번호</th>
                    <th width="500">제목</th>
                    <th width="120">글쓴이</th>
                    <th width="100">작성일</th>
                    <th width="100">조회수</th>
                    <th width="100">추천수</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT count(*) FROM board where good >= 5";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result);
                    $endpage = ceil($row['count(*)']/10);
                    $page = 1; 
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    }
                    $pagesect = ceil($page/5);  
                    $startpage = (($pagesect-1) * 5) + 1;
                    $startnum = ($page-1) * 10;
                    $sql = "SELECT * FROM board where good >= 5 order by date desc limit $startnum , 10";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){
                    $sqlr = "SELECT count(*) FROM reply where board_id = '{$row['id']}'";
                    $resultr = mysqli_query($conn,$sqlr);
                    $rowr = mysqli_fetch_array($resultr);
                    $title=$row["title"]; 
                    if(strlen($title)>80)
                    { 
                        $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                    }
                ?>
            <tbody>
                <tr>
                <td width="70"><?php echo $row['id']; ?></td>
                <td width="500"><a href="read.php?id=<?=$row['id']?>"><?php echo $title;?></a> <font color ="blue">[<?php echo $rowr['count(*)'];?>]</font></td>
                <td width="120"><?php echo $row['name']?></td>
                <td width="100"><?php echo date("m-d H:i", strtotime($row['date']))?></td>
                <td width="100"><?php echo $row['hit']; ?></td>
                <td width="100"><?php echo $row['good']; ?></td>
                </tr>
            </tbody>
            <?php } ?>
            </table>

            <div style="margin-top:20px; text-align:center;">
            <?php if($startpage != 1) { ?>
                <a href="public.php?page=<?=$startpage-1?>"><이전</a>
            <?php } ?>
        <?php 
                for($i = $startpage;$i < $startpage+5;$i++) { 
                    if ($i > $endpage) { break; }
                    
                    if ($i == $page) { ?>
                        <a style = "font-weight:900;" href="public.php?page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   } else { ?>
                        <a href="public.php?page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   }  ?>
        <?php
                } 
                ?>
        <?php   if($startpage+5 <= $endpage)  { ?>
                    <a href="public.php?page=<?=$startpage+5?>">다음></a>
        <?php   }?>
            </div>
