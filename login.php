<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: menu.php"); // Redirect to menu if already logged in
    exit();
}

$error = ''; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $file = 'users.txt';

    // Check if the file exists and is not empty
    if (file_exists($file) && filesize($file) > 0) {
        $users = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $userFound = false;

        foreach ($users as $user) {
            // Attempt to split the user data; ensure correct format
            $userDetails = explode(',', $user);

            // Check that we have exactly three parts: username, email, hashed password
            if (count($userDetails) === 3) {
                list($storedUsername, $storedEmail, $storedHash) = $userDetails;

                // Match the provided username with stored username
                if ($username === $storedUsername) {
                    $userFound = true;

                    // Verify the password against the stored hash
                    if (password_verify($password, $storedHash)) {
                        $_SESSION['username'] = $username; // Set the session variable
                        header("Location: menu.php"); // Redirect on successful login
                        exit();
                    } else {
                        $error = "Invalid password. Please try again.";
                    }
                    break;
                }
            }
        }

        // If no matching username was found in the file
        if (!$userFound) {
            $error = "No account found with this username. Please register.";
        }
    } else {
        // If users.txt is missing or empty
        $error = "No users found. Please register.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="images/logo.png" class="logo" alt="Logo">
    <div class="container">
        <h1 class="title">Login</h1>
        <?php if ($error): ?>
            <p class='error'><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" class="button animate">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php" class="register">Register here</a></p>
    </div>
</body>
</html>
