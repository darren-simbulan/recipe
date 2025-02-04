<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT recipes.*, users.username FROM recipes 
        JOIN users ON recipes.user_id = users.id
        ORDER BY recipes.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .header {
    background-color: #28a745;
    color: white;
    padding: 20px; 
    text-align: center;
    font-size: 24px;
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
            margin: 30px auto;
            padding: 20px;
            text-align: center;
        }
        .recipe-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-content: center;
        }
        .recipe-card {
            background: white;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: 0.3s;
            padding-bottom: 15px;
        }
        .recipe-card:hover {
            transform: scale(1.05);
        }
        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .recipe-card .details {
            padding: 15px;
        }
        .recipe-card h2 {
            font-size: 20px;
            margin: 10px 0;
        }
        .recipe-card p {
            font-size: 14px;
            color: #666;
        }
        .recipe-card a, .recipe-card button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .recipe-card a {
            background-color: #28a745;
            color: white;
        }
        .recipe-card a:hover {
            background-color: #218838;
        }
        .recipe-card .favorite-button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .recipe-card .favorite-button:hover {
            background-color: #0056b3;
        }
        .recipe-card .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 5px;
        }
        .recipe-card .delete-button:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function confirmDelete(recipeId) {
            if (confirm("Are you sure you want to delete this recipe?")) {
                window.location.href = "delete_recipe.php?id=" + recipeId;
            }
        }
    </script>
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
        <h2>Recipe List</h2>

        <form action="index.php" method="GET">
            <select name="category">
                <option value="">All Categories</option>
                <option value="Dessert">Dessert</option>
                <option value="Ulam">Ulam</option>
                <option value="Snacks">Snacks</option>
                <option value="Drinks">Drinks</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="recipe-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recipe-card">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    <div class="details">
                        <h2><?= htmlspecialchars($row['title']) ?></h2>
                        <p><strong>Submitted by:</strong> <?= htmlspecialchars($row['username']) ?></p>
                        <p>Category: <?= htmlspecialchars($row['category']) ?></p>
                        <a href="recipe.php?id=<?= $row['id'] ?>">View Recipe</a>

                        <form action="add_favorite.php" method="POST" style="display:inline;">
                            <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="favorite-button">❤️ Add to Favorites</button>
                        </form>

                        <?php if ($_SESSION['user_id'] == $row['user_id']): ?>
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="delete-button">🗑️ Delete</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
