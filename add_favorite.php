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
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$order = isset($_GET['order']) && $_GET['order'] === 'DESC' ? 'DESC' : 'ASC';

$allowed_sort_columns = ['title', 'category', 'date_added'];
if (!in_array($sort, $allowed_sort_columns)) {
    $sort = 'title';
}

$sql = "SELECT recipes.*, 
            (SELECT COUNT(*) FROM likes WHERE likes.recipe_id = recipes.id) AS like_count, 
            (SELECT COUNT(*) FROM likes WHERE likes.recipe_id = recipes.id AND likes.user_id = ?) AS user_liked 
        FROM favorites 
        JOIN recipes ON favorites.recipe_id = recipes.id 
        WHERE favorites.user_id = ? AND recipes.title LIKE ? 
        ORDER BY $sort $order";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $user_id, $search);
$stmt->execute();
$result = $stmt->get_result();

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_recipe'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $date_added = date('Y-m-d H:i:s');
    
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        $image = $image_path;
    }

    $insert_sql = "INSERT INTO recipes (title, category, ingredients, instructions, image, user_id, date_added) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sssssis", $title, $category, $ingredients, $instructions, $image, $user_id, $date_added);
    if ($insert_stmt->execute()) {
        $message = "Recipe added successfully!";
    } else {
        $message = "Error adding recipe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Recipes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .like-btn {
            background-color: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
        .liked {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">Recipe Management System</div>
    <div class="nav">
        <a href="welcome.php">Home</a>
        <a href="index.php">View Recipes</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="favorites.php">Favorite Recipes</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Favorite Recipes</h2>
        <p><?= $message ?></p>
        <div class="recipe-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recipe-card">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    <h2><?= htmlspecialchars($row['title']) ?></h2>
                    <p>Category: <?= htmlspecialchars($row['category']) ?></p>
                    <button class="like-btn <?= $row['user_liked'] ? 'liked' : '' ?>" data-id="<?= $row['id'] ?>">
                        ❤️ <span class="like-count"> <?= $row['like_count'] ?> </span>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script>
        $(document).on("click", ".like-btn", function() {
            var button = $(this);
            var recipeId = button.data("id");
            $.post("like_recipe.php", { recipe_id: recipeId }, function(response) {
                var data = JSON.parse(response);
                if (data.status === "liked") {
                    button.addClass("liked");
                } else {
                    button.removeClass("liked");
                }
                button.find(".like-count").text(data.like_count);
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
