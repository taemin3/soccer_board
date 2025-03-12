<?php
session_start();
error_reporting(1);
ini_set("display_errors", 1);


$uid = $_SESSION['uid'] ?? null;
$nickname = $_SESSION['name'] ?? null;

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    foreach ($env as $key => $value) {
        putenv("$key=$value");  
    }
}
$apiKey = getenv('API_KEY'); 
$apiUrl = "https://api.football-data.org/v4/competitions/PL/matches?status=FINISHED";

$options = [
    "http" => [
        "header" => "X-Auth-Token: $apiKey"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);
$data = json_decode($response, true);


$matches = isset($data['matches']) ? array_reverse($data['matches']) : []; 
$matches = array_slice($matches, 0, 10);
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

<?php require_once('view/board_top.php'); ?>

<div style="float: left; padding:20px; border:1px solid #999999; border-radius: 10px; background:white; margin-left:20px; margin-top:20px;">
    <?php if ($uid): ?>
        <p><?= htmlspecialchars($nickname) ?>님 안녕하세요.</p>
        <form style="margin-top:20px;" action="logout.php" method="post">
            <button class="button1" type="submit">로그아웃</button>
        </form>
    <?php else: ?>
        <form action="join.php" method="post">
            <input type="submit" value="회원가입">
        </form>
        <form style="margin-top:20px;" action="login.php" method="post">
            <input type="submit" value="로그인">
        </form>
    <?php endif; ?>
</div>

<div style="margin-left:400px; margin-top:30px;">
    <h2 style="display:inline">EPL 최근 전적</h2>
    <h4 style="display:inline"> (최근 10경기)</h4>
    <table style="font-weight:600; font-size:18px; width:800px;">
        <thead>
            <tr>
                <th>경기 날짜</th><th>HOME</th><th></th><th>점수</th><th></th><th>AWAY</th><th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $match): ?>
                <tr>
                    <td><?= date("Y-m-d", strtotime($match['utcDate'])) ?></td>
                    <td><?= htmlspecialchars($match['homeTeam']['name']) ?></td>
                    <td>
                        <img width='50px' height='50px' 
                             src='<?= htmlspecialchars($match['homeTeam']['crest']) ?>' 
                             alt='<?= htmlspecialchars($match['homeTeam']['name']) ?> 로고'>
                    </td>
                    <td><?= htmlspecialchars($match['score']['fullTime']['home']) ?> : <?= htmlspecialchars($match['score']['fullTime']['away']) ?></td>
                    <td>
                        <img width='50px' height='50px' 
                             src='<?= htmlspecialchars($match['awayTeam']['crest']) ?>' 
                             alt='<?= htmlspecialchars($match['awayTeam']['name']) ?> 로고'>
                    </td>
                    <td><?= htmlspecialchars($match['awayTeam']['name']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">EPL 경기 데이터를 불러올 수 없습니다.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>