<?php

$conn = mysqli_connect('localhost', 'root','dkstks324','korea');

$sql = "
    DELETE FROM reply
        WHERE board_id = {$_GET['id']}
";
$result = mysqli_query($conn,$sql);


$sql = "
    DELETE FROM board
        WHERE id = {$_GET['id']}
";
$result = mysqli_query($conn,$sql);

if ($result === false) {
    echo '문제가생김';
    echo mysqli_error($conn);
} else { ?> 
    <script>location.href="../board";
    </script>
<?php
} ?>