<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$leaderboardFile = 'leaderboard.txt';
$hasScore = false;
$message = "Click Start to Begin the Game.";

if (file_exists($leaderboardFile)) {
    $leaderboardData = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($leaderboardData as $entry) {
        list($user, $score) = explode(',', $entry);
        if ($user === $_SESSION['username'] && (int)$score > 0) {
            $hasScore = true;
            $message = "Wanna Improve ?? Start Again !!";
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Menu - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    .button-container { 
        display: flex; 
        justify-content: center; 
        gap: 20px; 
        margin-top: 25px; 
    }
    .button { 
        text-decoration: none; 
        width: 200px;
        padding: 15px 0;
        font-weight: bold; 
        font-size: 1.1rem; 
        border-radius: 50px; 
        text-align: center;
        transition: background-color 0.3s ease, transform 0.3s ease; 
    }

    .button.animate { 
        background: linear-gradient(135deg, #203a43, #2c5364); 
        color: #fff; 
        border: 2px solid #00d1b2; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    }
    .button.animate:hover { 
        background: #00d1b2; 
        color: #333; 
        transform: translateY(-5px); 
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); 
    }
</style>
</head>
<body>
    <img src="images/logo.png" class="logo" alt="Logo">
    <a href="logout.php" class="button animate logout">Logout</a>
    <div class="container">
        <h1 class="title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p><?php echo $message; ?></p>
        <div class="button-container">
            <a href="leaderboard.php" class="button animate">Leaderboard</a>
            <a href="game.php" class="button animate">Start Game</a>
        </div>
    </div>
</body>
</html>
