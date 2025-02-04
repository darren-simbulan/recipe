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
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        .nav {
            background-color: #333;
            overflow: hidden;
        }
        .nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }
        .recipe-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .recipe-card {
            background: white;
            width: 300px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: left;
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
        .recipe-card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .recipe-card a:hover {
            background-color: #45a049;
        }
        .btn-logout {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            float: right;
        }
        .btn-logout:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Recipe Management System</h1>
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
            <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="200">
            <h2><?= htmlspecialchars($row['title']) ?></h2>
            <p><strong>Submitted by:</strong> <?= htmlspecialchars($row['username']) ?></p>
            <p>Category: <?= htmlspecialchars($row['category']) ?></p>
            <a href="recipe.php?id=<?= $row['id'] ?>">View Recipe</a>

           
            <form action="add_favorite.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                <button type="submit">❤️ Add to Favorites</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>


</body>
</html>

<?php $conn->close(); ?>
