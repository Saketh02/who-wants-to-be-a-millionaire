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
