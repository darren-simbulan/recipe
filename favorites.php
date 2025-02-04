<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

$user_id = $_SESSION["user_id"];


$sql = "SELECT recipes.* FROM favorites 
        JOIN recipes ON favorites.recipe_id = recipes.id 
        WHERE favorites.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Recipes</title>
</head>
<body>
    <h1>Favorite Recipes</h1>

    <div class="recipe-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="recipe-card">
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="200">
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p>Category: <?= htmlspecialchars($row['category']) ?></p>
                <a href="recipe.php?id=<?= $row['id'] ?>">View Recipe</a>

               
                <form action="remove_favorite.php" method="POST">
                    <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                    <button type="submit">❌ Remove from Favorites</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
