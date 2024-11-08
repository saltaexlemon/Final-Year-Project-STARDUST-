<?php
include("../Config/Database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, reason) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $reason);

    if ($stmt->execute()) {
        echo "<script> 
                alert ('Thank you for reaching out! Your message has been received.');
                window.location.href = 'home.php';
                
                </script>";
    } else {
        echo "<p>There was an error submitting your form. Please try again later.</p>";
        error_log("Contact form error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
