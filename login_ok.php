<?php
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root', 'dkstks324', 'korea');

if (!$conn) {
    die("데이터베이스 연결 실패: " . mysqli_connect_error());
}


$filtered = array(
    'userid' => isset($_POST['userid']) ? mysqli_real_escape_string($conn, $_POST['userid']) : '',
    'pwd' => isset($_POST['pwd']) ? $_POST['pwd'] : ''
);


$sql = "SELECT uid, pwd, name FROM members WHERE uid = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $filtered['userid']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $uid, $hashed_pwd, $name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);


if ($hashed_pwd && password_verify($filtered['pwd'], $hashed_pwd)) {
    $_SESSION['name'] = $name;
    $_SESSION['uid'] = $uid;

    echo "<script>location.href='index.php';</script>";
    exit; 
} else {
    echo "<script>alert('아이디 또는 비밀번호가 올바르지 않습니다.'); history.back();</script>";
    exit;
}

mysqli_close($conn);
?>