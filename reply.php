<?php

$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$filtered = array (
    'uid' => mysqli_real_escape_string($conn,$_POST['uid']),
    'content' => mysqli_real_escape_string($conn,$_POST['content']),
    'nickname' => mysqli_real_escape_string($conn,$_POST['nickname']),
    'id' => mysqli_real_escape_string($conn,$_POST['id'])

);

$sql = "
    INSERT INTO reply
    (writer_id,writer_name, content, date,board_id)
    VALUE(
    '{$filtered['uid']}',
    '{$filtered['nickname']}',
    '{$filtered['content']}',
    NOW(),
    '{$filtered['id']}'
)";
$result = mysqli_query($conn,$sql);

if ($result === false) {
    echo '문제가생김';
    echo mysqli_error($conn);
} else { ?> 
    <script>location.href="read.php?id=<?=$filtered['id']?>";
    </script>
<?php
} ?>