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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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
        .recipe-card button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        .recipe-card button:hover {
            background-color: #c82333;
        }
        .btn-logout {
    background-color: #dc3545; 
    padding: 10px 15px;
    border-radius: 5px;
    color: white;
    text-align: center;
    transition: background-color 0.3s;
}

.btn-logout:hover {
    background-color: #c82333;
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
        <h2>Favorite Recipes</h2>
        <div class="recipe-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recipe-card">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    <div class="details">
                        <h2><?= htmlspecialchars($row['title']) ?></h2>
                        <p>Category: <?= htmlspecialchars($row['category']) ?></p>
                        <a href="recipe.php?id=<?= $row['id'] ?>">View Recipe</a>
                        <form action="remove_favorite.php" method="POST" style="display:inline;">
                            <input type="hidden" name="recipe_id" value="<?= $row['id'] ?>">
                            <button type="submit">❌ Remove</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
