<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <div class="contact-container">
        <a href="../../index.php" class="go-back">← Go Back</a>
        <h1>Contact Us</h1>
        <p class="subtext">We’d love to hear from you! Fill out the form below and we’ll get back to you as soon as possible.</p>
        
        <form action="submit_contact.php" method="POST">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Send Message</button>
        </form>

        <p class="contact-info">Or reach us at <a href="mailto:oleksandrstanov8@gmail.com">oleksandrstanov8@gmail.com</a></p>
    </div>
</body>
</html>
