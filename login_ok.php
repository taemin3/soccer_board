<?php
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$filtered = array (
    'userid' => mysqli_real_escape_string($conn,$_POST['userid']),
    'pwd' => mysqli_real_escape_string($conn,$_POST['pwd'])

);

$sql = "SELECT * from members where uid='{$filtered['userid']}' and pwd= hex(aes_encrypt('{$filtered['pwd']}','a'))";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
if($row) {
    $_SESSION['name'] = $row['name'];
    $_SESSION['uid'] = $row['uid'];
    ?>
    <script>
        location.href="index.php";
    </script>
<?php 
}
else { ?>
    <script>alert('로그인 정보가 틀립니다.'); 
            history.back();</script>
<?php   
}
    
    
    
    ?>