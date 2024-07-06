<?php 
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$uid = $_SESSION['uid'];
$nickname = $_SESSION['name'];

if(!$uid) { ?>
    <script>alert('로그인 후 이용해주세요.'); 
            history.back();</script>
<?php 
} else {
    $filtered = array (
        'bid' => mysqli_real_escape_string($conn,$_POST['bid'])
    );
    $sql1 = "SELECT * from good where board_id='{$filtered['bid']}' and uid='{$uid}'";
    $result1 = mysqli_query($conn,$sql1);
    $row = mysqli_fetch_array($result1);
    if($row) {
        var_dump($result1);?>
        <script>
            alert('이미 추천을 눌렀습니다.');
                history.back();
            </script>
    <?php
    }
    else if (!$row) {
        $sql = "INSERT into good (board_id, uid) VALUE ('{$filtered['bid']}','{$uid}')";
        $result = mysqli_query($conn,$sql);
        $sql = "UPDATE board SET good = good + 1 where id='{$filtered['bid']}'";
        $result = mysqli_query($conn,$sql);
    
        if($result) {?>
        
            <script>
                history.back();
            </script>
        <?php 
        }
        else { ?>
            
        <?php   
        }   
    }
}



    
    
?>

