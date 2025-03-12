<?php

$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$filtered = array (
    'title' => mysqli_real_escape_string($conn,$_POST['title']),
    'content' => mysqli_real_escape_string($conn,$_POST['content']),
    'ninkname' => mysqli_real_escape_string($conn,$_POST['ninkname']),
    'uid' => mysqli_real_escape_string($conn,$_POST['uid'])

);
$newImage='';
if($_FILES['image']['name']){
    $imageFullName = strtolower($_FILES['image']['name']);
    $imageNameSlice = explode(".",$imageFullName);
    $imageName = $imageNameSlice[0];
    $imageType = $imageNameSlice[1];
    $image_type = array('jpg','jpeg','gif','png');
    if(array_search($imageType,$image_type) === false){  ?>
        <script>alert('.jpg, .jpeg, .gif, .png 확장자만 가능합니다.'); 
            history.back();
            </script>
        <?php
        errMsg('jpg, jpeg, gif, png 확장자만 가능합니다.');?>
        
<?php   }
    $dates = date("mdhis",time());
    $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
    $dir = "image/";
    move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
    chmod($dir.$newImage,0777);
 }

$sql = "
    INSERT INTO board
    (name,title, content, date,uid,image)
    VALUE(
    '{$filtered['ninkname']}',
    '{$filtered['title']}',
    '{$filtered['content']}',
    NOW(),
    '{$filtered['uid']}',
    '{$newImage}'
)";
$result = mysqli_query($conn,$sql);
$id = mysqli_insert_id($conn);

if ($result === false) {
    echo '문제가생김';
    echo mysqli_error($conn);
} else { ?> 
    <script>location.href="read.php?id=<?=$id?>";
    </script>
<?php
} ?>


