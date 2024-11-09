<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="images/logo.png" class="logo" alt="Logo">
    <div class="container">
        <h1 class="title">Register</h1>
        <?php
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $file = 'users.txt';

            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
            } else {
                $userExists = false;
                $emailExists = false;

                if (file_exists($file)) {
                    $users = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach ($users as $user) {
                        list($savedUsername, $savedEmail) = explode(',', $user);
                        if ($username === $savedUsername) {
                            $userExists = true;
                            $error = "Username already taken.";
                            break;
                        }
                        if ($email === $savedEmail) {
                            $emailExists = true;
                            break;
                        }
                    }
                }

                if ($userExists) {
                    echo "<p class='error'>$error</p>";
                } elseif ($emailExists) {
                    header("Location: login.php?message=" . urlencode("You already have an account, login here."));
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $userData = "$username,$email,$hashedPassword" . PHP_EOL;
                    file_put_contents($file, $userData, FILE_APPEND);
                    header("Location: index.php?message=" . urlencode("User created successfully. Please login."));
                    exit();
                }
            }

            if ($error) {
                echo "<p class='error'>$error</p>";
            }
        }
        ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="button animate">Register</button>
        </form>
    </div>
</body>
</html>