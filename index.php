<?php 
include 'config.php'; 

$sql = "SELECT id, title, author, type, cover_image FROM publications ORDER BY published_date DESC LIMIT 3";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journaly</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-title">
                <img src="images/logo.png" class="logo">
                <span>Journaly</span>
            </div>
            <nav>
                <a href="collections.php">Collections</a>
                <a href="contact-us.php">Contact</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>UNLOCKING KNOWLEDGE, ONE JOURNAL AT A TIME</h2>
            <p>Empower Your Research Journey with Journaly</p>
            <a href="login.php" class="get-started-button">Get Started</a>
        </div>
    </section>

    <section class="timeline">
    <div class="container">
        <h2>PUBLISHING TIMELINE</h2>
        <div class="timeline-items">
            <div class="timeline-item">
                <p>14 days</p>
                <p>Screening Time</p>
            </div>
            <div class="timeline-item">
                <p>189 days</p>
                <p>Review to Acceptance</p>
            </div>
            <div class="timeline-item">
                <p>30 days</p>
                <p>Acceptance to Publication</p>
            </div>
        </div>
    </div>
</section>

    <section class="latest-publication">
        <div class="container">
            <h2>LATEST PUBLICATION</h2>
            <div class="publication-items">
            <?php
                include 'config.php';

                $sql = "SELECT id,title, author, type, published_date FROM publications ORDER BY published_date DESC LIMIT 3";
                $result = $conn->query($sql);

                if ($result === false) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="publication-item">';
                            // echo '<img src="' . $row["cover_image"] . '" alt="' . $row["title"] . ' cover" class="cover-image">';
                            echo '<p>' . $row["title"] . '</p>';
                            echo '<p>' . $row["author"] . '</p>';
                            echo '<p>' . $row["type"] . '</p>';
                            echo '<p>' . $row["published_date"] . '</p>';
                            echo '<a href="publication-details.php?id=' . $row["id"] . '" class="read-more-button">Read More</a>';
                            echo '</div>';
                        }
                    } else {
                        echo "No publications found.";
                    }
                }
            ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© Copyright 2024 Journaly All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
