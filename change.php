<?php
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$sql = "SELECT * from board where id='{$_GET['id']}'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="./write.css?after1" />
<link rel='stylesheet' href='./home.css'>
</head>
<body>
<?php
    require_once('view/board_top.php');
    ?>

    <br>
    <div id="board_write">
        <h1>EPL 자유게시판</h1>
            <div id="write_area">
                <form action="change_ok.php" method="post"  enctype="multipart/form-data"> 
                    <div id="in_title">
                        <span style="font-size:20px;">제목</span>
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?=$row['title']?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    
                    <div class="wi_line"></div>
                    <div id="in_content">
                        <span style="font-size:20px;">내용</span>
                        <textarea name="content" id="ucontent" placeholder="내용" required><?=$row['content']?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
                    <input type="file"  name="image"/>.jpg .jpeg .gif .png 만 가능
                    <div class="bt_se">
                        <button type="submit">글 수정</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>