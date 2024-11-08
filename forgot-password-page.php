<?php
include("navigation.php");
include("../Config/Database.php");

use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

$success = '';
$failed = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset_token = bin2hex(random_bytes(16));
        $token_expiry = date("U") + 1800;

        // Store reset token and expiry in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $reset_token, $token_expiry, $email);
        $stmt->execute();

        // Set up the email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dxrshx101@gmail.com';
        $mail->Password = 'rjvt ngsf xono ezbh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dxrshx101@gmail.com', 'Stardust Toy Cottage');
        $mail->addAddress($email);

        $reset_link = "http://localhost/stardust/stardust/reset-password-page.php?token=" . urlencode($reset_token);
        $mail->isHTML(true);
        $mail->Subject = 'Reset your password at Stardust Toy Cottage!';
        $mail->Body = "Click <a href='$reset_link'>here</a> to reset your password.";

        // Send the email
        if ($mail->send()) {
            $success = "A password reset link has been sent to your email.";
        } else {
            $failed = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $failed = "Email not found!";
    }
}
?>

<!-- HTML Form -->
<link rel="stylesheet" href="./styles/forgot_password.css">

<body>
    <div style="margin: auto; text-align: center;">
        <div class="f-container">
            <form action="forgot-password-page.php" method="POST" class="register-form">
                <h2 style="color:#ECC182;">Forgot Password</h2>
                <p class="f-text" style="color:#DB7373">Enter your email to receive a reset link.</p>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Request Reset Link</button>

                <?php if (!empty($success)) { ?>
                    <p style="color: green;"><?= $success; ?></p>
                <?php } elseif (!empty($failed)) { ?>
                    <p style="color: red;"><?= $failed; ?></p>
                <?php } ?>

                <p><a style="text-decoration: none; padding:5px 10px; display:block; color:black;" href="login.php">to login</a></p>
            </form>
        </div>
    </div>
</body>

</html>