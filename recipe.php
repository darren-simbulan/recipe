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

if (!isset($_GET['id']) || empty($_GET['id'])) {

    die("Error: No recipe ID provided.");

}

$recipe_id = $_GET['id'];

$sql = "SELECT recipes.*, users.username FROM recipes 

        JOIN users ON recipes.user_id = users.id 

        WHERE recipes.id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $recipe_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    die("Error: Recipe not found.");

}

$recipe = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($recipe['title']) ?></title>

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

            padding: 15px;

            text-align: center;

        }

        .nav {

            background-color: #333;

            overflow: hidden;

            padding: 10px;

            text-align: center;

        }

        .nav a {

            color: white;

            padding: 10px 20px;

            text-decoration: none;

            display: inline-block;

        }

        .nav a:hover {

            background-color: #ddd;

            color: black;

        }

        .container {

            max-width: 800px;

            margin: 20px auto;

            padding: 20px;

            background: white;

            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);

            border-radius: 10px;

            text-align: center;

        }

        .recipe-img {

            width: 100%;

            max-height: 300px;

            object-fit: cover;

            border-radius: 10px;

        }

        .recipe-details {

            text-align: left;

            margin-top: 20px;

        }

        .recipe-details h2 {

            color: #4CAF50;

        }

        .recipe-details p {

            font-size: 16px;

        }

        .back-btn {

            display: inline-block;

            margin-top: 20px;

            padding: 10px 20px;

            background-color: #4CAF50;

            color: white;

            text-decoration: none;

            border-radius: 5px;

        }

        .back-btn:hover {

            background-color: #45a049;

        }

    </style>

</head>

<body>

    <div class="header">

        <h1>Recipe Management System</h1>

    </div>

    <div class="nav">

        <a href="dashboard.php">Home</a>

        <a href="index.php">View Recipes</a>

        <a href="add_recipe.php">Add Recipe</a>

        <a href="favorites.php">Favorite Recipes</a>

        <a href="logout.php">Logout</a>

    </div>

    <div class="container">

        <h2><?= htmlspecialchars($recipe['title']) ?></h2>

        <p><strong>Submitted by:</strong> <?= htmlspecialchars($recipe['username']) ?></p>

        <p><strong>Category:</strong> <?= htmlspecialchars($recipe['category']) ?></p>

        <?php if ($recipe['image']): ?>

            <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="recipe-img">

        <?php endif; ?>

        

        <div class="recipe-details">

            <h2>Ingredients</h2>

            <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>

            <h2>Instructions</h2>

            <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

        </div>

        <a href="index.php" class="back-btn">⬅ Back to Recipes</a>

    </div>

</body>

</html>

<?php

$stmt->close();

$conn->close();

?>
