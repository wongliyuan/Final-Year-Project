<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>

    <header>
        <div class="container">
            <div class="logo-title">
                <img src="images/logo.png" class="logo">
                <span>Journaly</span>
            </div>
            <nav>
                <a href="index.php">Home</a>
                <a href="collections.php">Collections</a>
                <a href="contact-us.php">Contact</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>
    
    <section class="contact">
        <img src="images/contact.png" alt="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form action="https://formspree.io/f/xqkrvyov" method="POST">
                <div class="input-box">
                    <div class="input-field field">
                        <input type="text" name="Full Name" required placeholder="Full Name" id="name" class="item" autocomplete="off">
                        <div class="error-txt">Full Name cannot be blank</div>
                    </div>
                    <div class="input-field field">
                        <input type="text" name="Email Address" required placeholder="Email Address" id="email" class="item" autocomplete="off">
                        <div class="error-txt">Email address cannot be blank</div>
                    </div>
                </div>

                <div class="input-box">
                    <div class="input-field field">
                        <input type="text" name="Phone Number" required placeholder="Phone Number" id="phone" class="item" autocomplete="off">
                        <div class="error-txt">Phone number cannot be blank</div>
                    </div>
                    <div class="input-field field">
                        <input type="text" name="Subject" required placeholder="Subject" id="subject" class="item" autocomplete="off">
                        <div class="error-txt">Subject cannot be blank</div>
                    </div>
                </div>

                <div class="textarea-field field">
                    <textarea name="Message" required id="message" cols="30" rows="10" placeholder="Your Message" class="item" autocomplete="off"></textarea>
                    <div class="error-txt">Message cannot be blank</div>
                </div>

                <button type="submit">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© Copyright 2024 Journaly All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
