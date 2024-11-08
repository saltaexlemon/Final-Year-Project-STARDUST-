<?php
include("navigation.php");
?>

<link rel="stylesheet" href="./styles/contact.css">

<div class="contact-container">
    <img style="margin-bottom: 10px; height:525px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" src="assets/getintouch.png" />

    <div class="contact-card">
        <h2>For More Inquiry or Feedbacks</h2>
        <p> Whatever the occasion, Stardust Toy Cottage has it. Fill up the form and tell us your preference to create something unique for your loved ones.</p>
        </p>
        <form action="contact_logic.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="reason">Reason for Contact:</label>
                <textarea id="reason" name="reason" rows="4" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

</div>