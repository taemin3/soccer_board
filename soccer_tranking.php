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
$apiUrl = "https://api.football-data.org/v4/competitions/PL/standings"; 

$options = [
    "http" => [
        "header" => "X-Auth-Token: $apiKey"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);
$data = json_decode($response, true);


$teams = isset($data['standings'][0]['table']) ? $data['standings'][0]['table'] : [];
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
    <h2>팀 순위</h2>
    <table style="font-weight:600; font-size:18px; width:800px;">
        <thead>
            <tr>
                <th>순위</th><th></th><th>구단명</th><th>경기수</th><th>승</th><th>무</th><th>패</th><th>승점</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($teams)): ?>
            <?php foreach ($teams as $team): ?>
                <tr>
                    <td><?= htmlspecialchars($team['position']) ?></td>
                    <td>
                        <img width="50px" height="50px" 
                             src="<?= htmlspecialchars($team['team']['crest']) ?>" 
                             alt="<?= htmlspecialchars($team['team']['name']) ?> 로고">
                    </td>
                    <td><?= htmlspecialchars($team['team']['name']) ?></td>
                    <td><?= htmlspecialchars($team['playedGames']) ?></td>
                    <td><?= htmlspecialchars($team['won']) ?></td>
                    <td><?= htmlspecialchars($team['draw']) ?></td>
                    <td><?= htmlspecialchars($team['lost']) ?></td>
                    <td><?= htmlspecialchars($team['points']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">EPL 팀 순위를 불러올 수 없습니다.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>