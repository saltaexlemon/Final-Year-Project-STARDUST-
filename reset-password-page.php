<?php
include("navigation.php");
include("../Config/Database.php");

$success = '';
$failed = '';

if (isset($_GET['token'])) {
    $token = trim(urldecode($_GET['token']));

    // Check if token is valid and not expired
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND token_expiry >= ?");
    $currentTime = date("U");
    $stmt->bind_param("si", $token, $currentTime);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Check if the form has been submitted to update the password
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['new_password'];

            // Update password and clear the token
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?");
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();

            $success = "Password successfully reset! Return to login.";
        }
    } else {
        $failed = "The reset link is invalid or has expired.";
    }
} else {
    $failed = "Invalid request.";
}
?>

<!-- HTML Form -->
<link rel="stylesheet" href="./styles/forgot_password.css">

<body>
    <div style="margin: auto; text-align: center;">
        <div class="f-container">
            <form action="reset-password-page.php?token=<?= htmlspecialchars($token) ?>" method="POST" class="register-form">
                <h2 style="color:#ECC182;">Reset Password</h2>

                <?php if (!empty($failed)) { ?>
                    <p style="color: red;"><?= $failed; ?></p>
                <?php } elseif (!empty($success)) { ?>
                    <p style="color: green;"><?= $success; ?></p>
                <?php } else { ?>
                    <p class="f-text" style="color:#DB7373">Enter your new password.</p>
                    <input type="password" name="new_password" placeholder="New password" required>
                    <button type="submit">Reset Password</button>
                <?php } ?>

                <p><a style="text-decoration: none; padding:5px 10px; display:block; color:black;" href="login-page.php">to login</a></p>
            </form>
        </div>
    </div>
</body>

</html>