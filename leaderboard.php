<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Load the leaderboard data
$leaderboardFile = 'leaderboard.txt';
$leaderboardData = [];

if (file_exists($leaderboardFile) && filesize($leaderboardFile) > 0) {
    $leaderboardData = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
    </style>
</head>
<body>

<a href="logout.php" class="button animate logout">Logout</a>
<img src="images/logo.png" class="logo" alt="Logo">
<div class="container">
    <h1>Leaderboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Earnings</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $scores = [];

            foreach ($leaderboardData as $entry) {
                list($username, $score) = explode(',', $entry);
                $scores[$username] = (int)$score; 
            }

            arsort($scores);
            $rank = 1;

            foreach ($scores as $username => $score) {
                echo "<tr>
                        <td>{$rank}</td>
                        <td>" . htmlspecialchars($username) . "</td>
                        <td>" . number_format($score) . "$</td>
                      </tr>";
                $rank++;
            }
            ?>
        </tbody>
    </table>
    <div class="button-container">
        <a href="menu.php" class="button animate">Back to Menu</a>
    </div>
</div>

<div class="confetti">
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
</div>
</body>
</html>