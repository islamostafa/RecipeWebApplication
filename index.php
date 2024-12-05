<?php

//Creates or resumes a session via cookies
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
// Include the database connection file (MySQLi version)
require_once 'database_connect.php';

// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION["user_id"]);
}

// Handle the request to save a recipe
if (isset($_GET['action']) && $_GET['action'] === 'save_recipe') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipeId = $_GET['recipe_id'];

        // Insert the saved recipe into the database
        $sql = "INSERT INTO saved_recipes (user_id, recipe_id) VALUES ('$userId', '$recipeId')";
        if ($sql_object->query($sql) === TRUE) {
            echo "Recipe saved successfully!";
        } else {
            echo "Error saving recipe: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to save this recipe.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}

// Handle the request to remove a recipe from favorites
if (isset($_GET['action']) && $_GET['action'] === 'remove_recipe') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipeId = $_GET['recipe_id'];

        // Remove the recipe from the database
        $sql = "DELETE FROM saved_recipes WHERE user_id = '$userId' AND recipe_id = '$recipeId'";
        if ($sql_object->query($sql) === TRUE) {
            echo "Recipe removed successfully!";
        } else {
            echo "Error removing recipe: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to remove this recipe.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}

// Handle the request to add a rating to the database
if (isset($_GET['action']) && $_GET['action'] === 'save_rating') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipe_Id = $_GET['recipe_id'];
        $rate = $_GET['rating'];

        //query to insert rating to MySQL database
        $query = "INSERT into ratings (recipe_id, rating, user) VALUES ('$recipe_Id', '$rate', '$userId')";

        if ($sql_object->query($query) === TRUE) {
            echo "Rating added successfully!";
        } else {
            echo "Error adding rating: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to add this rating.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <link rel="icon" type="image/x-icon" href="./images/icons8-brezel-50.png">
    <title>Welcome to Recipe Central | All the taste in one place</title>
</head>

<body>

    <?php include 'primary-navigation.php'?>

    <div class="row">
        <div class="column left">
            <section class="Welcome">
                <h1>Welcome to Recipe Central</h1>
                <p>From family favorites to timeless classics. Store and explore 5+ recipes all from one place.</p>
                <!-- search box for finding the recipes -->
                <section class="search-bar">
                    <form action="search.php" method="GET">
                        <input type="text" name="search" placeholder="Search for recipes">
                        <button type="submit">Search</button>
                    </form>
                </section>
            </section>
            <section class="Login-signup">
                <!--Checks if session data is stored-->
                <?php if (isset($_SESSION["user_id"])) : ?>
                    <!--Allows the user to log out-->
                    <p><a href="logout.php">Log out</a></p>
                    <!--Gives the user links to log in or sign up-->
                        <?php else : ?>
                        <p>Please <a href="login_page.php">Log In</a> or <a href="signup_form.html">Sign Up</a> to rate recipes and view your saved recipes.</p>
                        <?php endif; ?>
                </div>
                </section>
            <div class="column right">
        </div>
    </div> 

    <?php include 'secondary-navigation.php'?>

    <section class="recipe-section-title">
        <h2>Check out our <span style="color: #c04242">team favourites</span></h2>
    </section>

<?php include 'Recipe-card.php'?>

<?php include 'Video_highlight.php'?>

    <section class="recipe-section-title">
        <h2>Cook in <span style="color: #c04242">an hour</span> or less</h2>
    </section>
    
    <?php include 'Quick_dishes.php'?>

    <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>

    <!-- Include the external script.js file -->
    <script src="script.js"></script>

    <?php include 'Footer.php'?>

</body>
</html>
