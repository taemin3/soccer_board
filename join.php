<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>축구 게시판</title>

    <link rel='stylesheet' href='./home.css'>
    <script>
    function checkid(){
        var userid = document.getElementById("userid").value;
        if(userid)  
        {
            url = "dup.php?uid="+userid;
            window.open(url,"chkid","width=400,height=200");
        } else {
            alert("아이디를 입력하세요.");
        }
    }
    function decide(){
        document.getElementById("decide").innerHTML = "<span style='color:blue;'>사용가능한 ID</span>";
        document.getElementById("decide_id").value = document.getElementById("userid").value;
        document.getElementById("userid").disabled = true;
        document.getElementById("signup_btn").disabled = false;
        document.getElementById("check_button").value = "다른 ID로 변경";
        document.getElementById("check_button").setAttribute("onclick", "change()");
    }
    function change(){
        document.getElementById("decide").innerHTML = "<span style='color:red;'>ID 중복 검사 미실시</span>";
        document.getElementById("userid").disabled = false;
        document.getElementById("userid").value = "";
        document.getElementById("signup_btn").disabled = true;
        document.getElementById("check_button").value = "ID 중복 검사";
        document.getElementById("check_button").setAttribute("onclick", "checkid()");
    }
    </script>
</head>
<body>
<?php
    require_once('view/board_top.php');?>
    <div style="position:relative; margin: 30px;">
        <h1>회원가입</h1>
        <form action="join_ok.php" method="post" name="regiform" id="regist_form" class="form" onsubmit="return sendit()">
            <p>아이디<br>
                <input type="text" name="userid" id="userid" placeholder="ID" required>
                <input type="hidden" name="decide_id" id="decide_id">
                <input type="button" id="check_button" value="ID 중복 검사" onclick="checkid();">
                <span id="decide" style='color:red;'>ID 중복 검사 미실시</span></p>
                비밀번호<br>
            <input type="password" name="pwd" id="pwd" placeholder="Password" required >
            <br>
            
            닉네임<br>
            <input type="text" name="ninkname" id="ninkname" placeholder="Nickname" required>
            <br><br>
            <input type="submit" value="회원가입" id="signup_btn" disabled=true>
            <p>이미 가입하셨나요? <a href="login.php">로그인</a></p>
        </form>
    </div>
</body>