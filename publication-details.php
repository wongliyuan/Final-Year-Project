<?php
include 'config.php';

// Check if the publication ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $publication_id = $_GET['id'];

    // Retrieve publication details from the database
    $sql = "SELECT title, author, type, content, cover_image, published_date FROM publications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    $stmt->bind_param("i", $publication_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $publication = $result->fetch_assoc();
    } else {
        echo "Publication not found.";
        exit;
    }
} else {
    echo "Invalid publication ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($publication['title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/publication.css">
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
                <a href="#">Collections</a>
                <a href="#">Contact</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <section class="publication-details">
        <div class="container">
            <h1><?php echo htmlspecialchars($publication['title']); ?></h1>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($publication['author']); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($publication['type']); ?></p>
            <p><strong>Published Date:</strong> <?php echo htmlspecialchars($publication['published_date']); ?></p>
            <!-- <img src="<?php echo htmlspecialchars($publication['cover_image']); ?>" alt="<?php echo htmlspecialchars($publication['title']); ?> cover" class="cover-image"> -->
            <div class="content">
                <p><strong>Content:</strong>
                <?php echo nl2br(htmlspecialchars($publication['content'])); ?>
                </p>
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
