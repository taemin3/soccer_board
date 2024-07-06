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
        <link rel='stylesheet' href='./match.css?after'> 
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
        <h2 style="display:inline">EPL 최근전적</h2>
        <h4 style="display:inline"> (최근 10경기)</h4>
        <table style="font-weight:600; font-size:18px; width:800px;">
            <thead>
            <tr>
                <th>경기날짜</th><th>HOME</th><th></th><th></th><th></th><th></th><th></th><th>AWAY</th>
            </tr>
            </thead>
            <body>
            <?php
            $sql = "SELECT * FROM match_schedule order by match_date desc limit 10";
            $result = mysqli_query($conn,$sql);
            $rank = 0;
            while($row = mysqli_fetch_array($result)){
                $filtered = array(
                    'match_date' => htmlspecialchars($row['match_date']),
                    'home' => htmlspecialchars($row['home']),
                    'away' => htmlspecialchars($row['away']),
                    'home_score' => htmlspecialchars($row['home_score']),
                    'away_score' => htmlspecialchars($row['away_score'])
                );

                $sqlh = "SELECT image FROM team where teamname='{$filtered['home']}'";
                $resulth = mysqli_query($conn,$sqlh);
                $rowh = mysqli_fetch_array($resulth);

                $sqla = "SELECT image FROM team where teamname='{$filtered['away']}'";
                $resulta = mysqli_query($conn,$sqla);
                $rowa = mysqli_fetch_array($resulta);
                
                
                
                $rank += 1;
                ?>
                
                    <td><?=$filtered['match_date']?></td>
                    <td><?=$filtered['home']?></td>
                    <td><img width="50px" height="50px" src="teamlogo/<?=$rowh['image']?>"></td>
                    <td><?=$filtered['home_score']?></td>
                    <td>:</td>
                    <td><?=$filtered['away_score']?></td>
                    <td><img width="50px" height="50px" src="teamlogo/<?=$rowa['image']?>"></td>
                    <td><?=$filtered['away']?></td>


                </tr>
            </tbody>
                <?php
            }
            ?>
        </table>  
        
        </div>   
            
    </body>
</html>