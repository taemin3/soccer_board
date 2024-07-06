<?php

$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$filtered = array (
    'content' => mysqli_real_escape_string($conn,$_POST['content']),
    'rid' => mysqli_real_escape_string($conn,$_POST['rid']),
    'id' => mysqli_real_escape_string($conn,$_POST['id'])

);

$sql = "
    UPDATE reply
    SET
        content = '{$filtered['content']}'
    WHERE
        id = '{$filtered['rid']}'
";
$result = mysqli_query($conn,$sql);

if ($result === false) {
    echo '문제가생김';
    echo mysqli_error($conn);
} else { ?> 
    <script>location.href="read.php?id=<?=$filtered['id']?>";
    </script>
<?php
} ?>