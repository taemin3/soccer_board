<?php
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');

$filtered = array (
    'decide_id' => mysqli_real_escape_string($conn,$_POST['decide_id']),
    'pwd' => mysqli_real_escape_string($conn,$_POST['pwd']),
    'ninkname' => mysqli_real_escape_string($conn,$_POST['ninkname'])

);

$hashed_pwd = password_hash($filtered['pwd'], PASSWORD_DEFAULT);
$sql = "
    INSERT INTO members
    (uid,pwd, name)
    VALUE(
        '{$filtered['decide_id']}',
        '{$hashed_pwd}',
        '{$filtered['ninkname']}'
    )
";
$result = mysqli_query($conn,$sql);



if ($result === false) {
    echo '문제가생김';
    echo mysqli_error($conn);
} else {
    header('Location: ../board');
}

?>