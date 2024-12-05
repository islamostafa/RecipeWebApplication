<?php

//Creates or resumes a session via cookies
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
// Include the database connection file (MySQLi version)
$sql_var = require __DIR__ . "/database_connect.php";


// Function to establish a database connection
function connectToDatabase()
{
    $host = 'localhost';
    $dbname = 'recipe_login';
    $db_username = 'root';
    $db_password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
$pdo = connectToDatabase();



// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION["user_id"]);
}


if (isset($_SESSION["user_id"])) {

    $user = $_SESSION["user_id"];

    // Prepare the SQL statement to search for recipes matching the query
    $sql = "SELECT r.* FROM recipes r inner join saved_recipes s on r.recipe_id=s.recipe_id WHERE s.user_id = '$user'";
    $result = $pdo->query($sql);
    // $recipes = $result->fetch_assoc();
    $recipes = $result->fetchAll(PDO::FETCH_ASSOC);

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <title>Recipe Central | Explore our range of tasty recipes</title>
</head>

<body>

    <?php include 'primary-navigation.php'?>

<?php include 'secondary-navigation.php'?>

<?php include './Components/Back_button.html'?>

    <!-- Display the search results -->
    <section class="search-results">
        <?php if (isset($recipes) && !empty($recipes)) : ?>
            <?php foreach ($recipes as $recipe) : ?>
                <div class="recipe-full-page">
                    <h3><?php echo $recipe['Name']; ?></h3>
                    <img class="recipe-image" src="<?php echo $recipe['image_link'] ?>" alt="<?php echo $recipe['alt_text'] ?>">
                    <p><?php echo $recipe['Description']; ?></p>
                    <p><?php echo "<p><b>Preparation time:</b> " . $recipe['Prep_time'] . "</p>";?></p>
                    <p><?php echo "<p><b>Cooking time:</b> " . $recipe['Cook_time'] . "</p>";?></p>

                    <!-- Display the "Save" or "Remove" button with the recipe ID as a data attribute -->
                    <?php
                    // Check if the user is logged in
                    if (isUserLoggedIn()) {
                        // Check if the recipe is saved for the logged-in user
                        $isSaved = false;
                        if (isset($_SESSION["user_id"])) {
                            $userId = $_SESSION["user_id"];
                            $recipeId = $recipe['recipe_id'];

                            $sql = "SELECT COUNT(*) FROM saved_recipes WHERE user_id = ? AND recipe_id = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$userId, $recipeId]);
                            $isSaved = $stmt->fetchColumn() > 0;

                        }
                    }
                    ?>
                <?php
                $recipeLink = "Recipe_details.php?recipe_id=" . $recipe['recipe_id'];
                echo "<a href='" . $recipeLink . "'>";
                ?>
                <button class="details-button">View recipe for <?php echo $recipe['Name']; ?></button>
                </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No recipes Saved.</p>
        <?php endif; ?>
        </section>

    <?php include 'Footer.php'?>

    <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>
    <!-- Include the external script.js file -->
    <script src="script.js"></script>
</body>
</html>
