<head>
	<link rel="stylesheet" href="./lib/css/style.css">
    <link rel='stylesheet' href='./home.css'>
</head>
<body>
    <?php 
    require_once('view/board_top.php');?>
    <div style="position:relative; margin: 30px;">
        <h1>로그인</h1>
        <form action="login_ok.php" method="post" name="regiform" id="regist_form" class="form" onsubmit="return sendit()">
            <p>아이디<br>
                <input type="text" name="userid" id="userid" placeholder="ID" ></p>
            <p>비밀번호<br><input type="password" name="pwd" id="pwd" placeholder="Password"></p>
            <br>
            <p><input type="submit" value="로그인" class="signup_btn"></p>
            <p>아이디가 없으신가요?<a href="join.php">회원가입</a></p>
        </form>
    </div>
</body>