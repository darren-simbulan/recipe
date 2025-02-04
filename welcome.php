<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_recipes = "SELECT * FROM recipes ORDER BY created_at DESC";
$result_recipes = $conn->query($sql_recipes);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $recipe_id = $_POST['recipe_id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $sql_insert_comment = "INSERT INTO comments (recipe_id, user_id, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert_comment);
    $stmt->bind_param("iis", $recipe_id, $user_id, $comment);
    $stmt->execute();
    $stmt->close();

    header("Location: welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 24px ;
            text-align: center;
        }
        .nav {
            background-color: #343a40;
            overflow: hidden;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        .nav a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            transition: 0.3s;
        }
        .nav a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .btn-logout {
            background-color: #dc3545;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }
        .recipe-card {
            background: white;
            width: 800px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: left;
            padding-bottom: 20px;
        }
        .recipe-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .recipe-card .details {
            padding: 15px;
        }
        .comments-section {
            margin-top: 10px;
            text-align: left;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .comment-card {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 5px;
            border-left: 5px solid #4CAF50;
        }
        .comment-card .username {
            font-weight: bold;
            color: #4CAF50;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .comment-form textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .comment-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="header">
        Recipe Management System
    </div>

    <div class="nav">
        <a href="welcome.php">Home</a>
        <a href="index.php">View Recipes</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="favorites.php">Favorite Recipes</a>
        <a href="about.php">About Us</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>🍽️ All Recipes</h2>

        <?php while ($recipe = $result_recipes->fetch_assoc()): ?>
            <div class="recipe-card">
                <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>">
                <div class="details">
                    <h2><?= htmlspecialchars($recipe['title']) ?></h2>
                    <p>Category: <?= htmlspecialchars($recipe['category']) ?></p>
                
                </div>

                <div class="comments-section">
                    <h3>💬 Comments</h3>

                    <?php
                    $sql_comments = "SELECT comments.*, users.username FROM comments 
                                     JOIN users ON comments.user_id = users.id
                                     WHERE comments.recipe_id = ? 
                                     ORDER BY comments.created_at DESC";
                    $stmt_comments = $conn->prepare($sql_comments);
                    $stmt_comments->bind_param("i", $recipe['id']);
                    $stmt_comments->execute();
                    $result_comments = $stmt_comments->get_result();
                    
                    while ($comment = $result_comments->fetch_assoc()):
                    ?>
                        <div class="comment-card">
                            <p class="username"><?= htmlspecialchars($comment['username']) ?>:</p>
                            <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>

                            <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                                <form method="POST" action="delete_comment.php">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <button type="submit" class="delete-button">🗑️ Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                    <?php $stmt_comments->close(); ?>

                    <form method="POST" class="comment-form">
                        <textarea name="comment" placeholder="Add a comment..." required></textarea><br>
                        <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
                        <button type="submit">Post Comment</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
