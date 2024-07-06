
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
    <h1>EPL 자유게시판</h1>
        <form style="margin-top:10px;" action="public.php?page=1" method="get" >
            <button style="font-size:15px;"class="button_blue" type="submit">인기글</button>
        </form>
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
                if(isset($_GET['target'])) {
                    $sql = "SELECT count(*) FROM board where {$_GET['target']} LIKE '%{$_GET['search']}%'";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result);
                    echo "검색 결과: ";
                    echo $row['count(*)'];
                    echo "개";
                    $endpage = ceil($row['count(*)']/10);
                    $page = 1; 
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    }
                    $pagesect = ceil($page/5);  
                    $startpage = (($pagesect-1) * 5) + 1;
                    $startnum = ($page-1) * 10;
                    $sql = "SELECT * FROM board where {$_GET['target']} LIKE '%{$_GET['search']}%' 
                    order by date desc limit $startnum , 10";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){
                    
                    $sqlr = "SELECT count(*) FROM reply where board_id = '{$row['id']}'";
                    $resultr = mysqli_query($conn,$sqlr);
                    $rowr = mysqli_fetch_array($resultr);
                    $title=$row["title"]; 
                    if(strlen($title)>80)
                    { 
                        $title=str_replace($row["title"],mb_substr($row["title"],0,30,"utf-8")."...",$row["title"]);
                    }
                    if ($_GET['target'] == 'title') {
                        $title = str_replace($_GET['search'], "<span style='background-color:yellow;'>".$_GET['search']."</span>",$title);
                    }
                    else if ($_GET['target'] == 'name') {
                        $row['name'] = str_replace($_GET['search'], "<span style='background-color:yellow;'>".$_GET['search']."</span>",$row['name']);
                    }
                        

                ?>
                <tbody>
                    <tr>
                    <td width="70"><?php echo $row['id']; ?></td>
                    <td width="500"><a href="read.php?id=<?=$row['id']?>"><?php echo $title?></a> <font color ="blue">[<?php echo $rowr['count(*)'];?>]</font></td>
                    <td width="120"><?php echo $row['name']?></td>
                    <td width="100"><?php echo date("m-d H:i", strtotime($row['date']))?></td>
                    <td width="100"><?php echo $row['hit']; ?></td>
                    <td width="100"><?php echo $row['good']; ?></td>
                    </tr>
                </tbody>
            <?php } ?>
            </table>
        <?php   } else {
                    $sql = "SELECT count(*) FROM board";
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
                    $sql = "SELECT * FROM board order by date desc limit $startnum , 10";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result)){
                    $sqlr = "SELECT count(*) FROM reply where board_id = '{$row['id']}'";
                    $resultr = mysqli_query($conn,$sqlr);
                    $rowr = mysqli_fetch_array($resultr);
                    $title=$row["title"]; 
                    if(strlen($title)>80)
                    { 
                        $title=str_replace($row["title"],mb_substr($row["title"],0,30,"utf-8")."...",$row["title"]);
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
            <?php
             }?>
                
            <div id="write_btn">
            <a href="./write.php"><button>글쓰기</button></a>
            </div> 
            <?php
            if(isset($_GET['target'])) { ?>
                <div style="margin-top:20px; text-align:center;">
            <?php if($startpage != 1) { ?>
                <a href="index.php?target=<?=$_GET['target']?>&search=<?=$_GET['search']?>&page=<?=$startpage-1?>"><이전</a>
            <?php } ?>
        <?php 
                for($i = $startpage;$i < $startpage+5;$i++) { 
                    if ($i > $endpage) { break; }
                    
                    if ($i == $page) { ?>
                        <a style = "font-weight:900;" href="index.php?target=<?=$_GET['target']?>&search=<?=$_GET['search']?>&page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   } else { ?>
                        <a href="index.php?target=<?=$_GET['target']?>&search=<?=$_GET['search']?>&page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   }  ?>
        <?php
                } 
                ?>
        <?php   if($startpage+5 <= $endpage)  { ?>
                    <a href="index.php?target=<?=$_GET['target']?>&search=<?=$_GET['search']?>&page=<?=$startpage+5?>">다음></a>
        <?php   }?>
            </div>
         
    <?php   } else {?>
        <div style="margin-top:20px; text-align:center;">
            <?php if($startpage != 1) { ?>
                <a href="index.php?page=<?=$startpage-1?>"><이전</a>
            <?php } ?>
        <?php 
                for($i = $startpage;$i < $startpage+5;$i++) { 
                    if ($i > $endpage) { break; }
                    
                    if ($i == $page) { ?>
                        <a style = "font-weight:900;" href="index.php?page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   } else { ?>
                        <a href="index.php?page=<?=$i?>">&nbsp;<?=$i?>&nbsp;</a>
            <?php   }  ?>
        <?php
                } 
                ?>
        <?php   if($startpage+5 <= $endpage)  { ?>
                    <a href="index.php?page=<?=$startpage+5?>">다음></a>
        <?php   }?>
            </div>

         
    <?php
            }
            
            ?>
            
        <br>
        <form style="text-align:center;" action="index.php" method="get">
        <select name="target">
            <option value="title">제목</option>
            <option value="content">내용</option>
            <option value="name">글쓴이</option>
        </select>
        <input type="text" name="search" size="30" required="required"/> <button>검색</button>
    </form>
    </div>
</body>
</html>