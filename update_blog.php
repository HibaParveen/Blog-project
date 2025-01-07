<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['title'])) {
    $title = $conn->real_escape_string($_GET['title']); 

    $sql = "SELECT * FROM blog WHERE blog_title = '$title'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        echo "Blog not found.";
        exit();
    }
} else {
    echo "No blog title provided for update.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $conn->real_escape_string($_POST['new_title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "UPDATE blog SET blog_title = '$newTitle', blog_content = '$content', updated_at = NOW() WHERE blog_title = '$title'";

    if ($conn->query($sql) === TRUE) {
        echo "Blog updated successfully.";
        header("Location: tables.php"); 
        exit();
    } else {
        echo "Error updating blog: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Blog</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Update Blog</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="new_title">Blog Title</label>
                <input type="text" id="new_title" name="new_title" class="form-control" value="<?php echo htmlspecialchars($blog['blog_title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" rows="5" required><?php echo htmlspecialchars($blog['blog_content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
