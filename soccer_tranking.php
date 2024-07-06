<?php
session_start();
error_reporting(1);
ini_set("display_errors",1);
$conn = mysqli_connect('localhost', 'root','dkstks324','korea');
$uid = $_SESSION['uid'];
$nickname = $_SESSION['name'];

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel='stylesheet' href='./trank.css?after'> 
        <link rel='stylesheet' href='./home.css?after'>
        <title>축구리그 관리</title>
    </head>
    <body>
    <?php
    require_once('view/board_top.php');
    ?>
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
    
        <div style=" margin-left:400px; margin-top:30px;">
        <h2>팀 순위</h2>
        <table style="font-weight:600; font-size:18px; width:800px;">
            <thead>
            <tr>
                <th>순위</th><th></th><th>구단명</th><th>경기수</th><th>승</th><th>무</th><th>패</th><th>승점</th>
            </tr>
            </thead>
            <body>
            <?php
            $sql = "SELECT * FROM team order by point desc";
            $result = mysqli_query($conn,$sql);
            $rank = 0;
            while($row = mysqli_fetch_array($result)){
                $filtered = array(
                    'teamname' => htmlspecialchars($row['teamname']),
                    'win' => htmlspecialchars($row['win']),
                    'draw' => htmlspecialchars($row['draw']),
                    'lose' => htmlspecialchars($row['lose']) ,
                    'match_num' => htmlspecialchars($row['match_num']),
                    'point' => htmlspecialchars($row['point']),
                    'id' => htmlspecialchars($row['id']),
                    'image' => htmlspecialchars($row['image'])
                );
                $timage = "<img width=\"50px\" height=\"50px\" src='teamlogo/$row[image]'>";
                $tlist = "<font style=\"margin-bottom:10px;\"color =\"#5778ff\">{$filtered['teamname']}</font>";
                $rank += 1;
                ?>
                
                    <td><?=$rank?></td>
                    <td><?=$timage?></td>
                    <td><?=$tlist?></td>
                    <td><?=$filtered['match_num']?></td>
                    <td><?=$filtered['win']?></td>
                    <td><?=$filtered['draw']?></td>
                    <td><?=$filtered['lose']?></td>
                    <td><?=$filtered['point']?></td>

                </tr>
            </tbody>
                <?php
            }
            ?>
        </table>  
        
        </div>   
             
    </body>
</html>