<?php

//Creates or resumes a session via cookies
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$sql_var = require __DIR__ . "/database_connect.php";


// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION["user_id"]);
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
    <title>
        <?php
        if (isset($_GET['recipe_id'])) {
            $recipe_id = $_GET['recipe_id'];
            // Retrieve the recipe name from the database based on the provided recipe_id
            require_once 'database_connect.php';
            $sql = "SELECT Name FROM recipes WHERE recipe_id = $recipe_id";
            $result = $sql_object->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['Name'];
            } else {
                echo "Recipe Not Found";
            }
        } else {
            echo "Recipe Page";
        }
        ?>
    </title>
    
</head>
<body>
<div class="recipe-container">

    <?php include 'primary-navigation.php'?>

    <section class="recipe-details">
        <?php

        require_once 'database_connect.php';

        // Check if a recipe ID is provided in the URL
        if (isset($_GET['recipe_id'])) {
            $recipe_id = $_GET['recipe_id'];

            //fetch any ratings the recipes may have
            $rate_sql = "SELECT * FROM ratings WHERE recipe_id = '$recipe_id'";
            $rate = $sql_object->query($rate_sql);
            $rate_result = $rate->fetch_assoc();
            
            if ($rate->num_rows > 0) {
                if ($rate->num_rows > 1) {
                    //get the average of the ratings
                    $av_sql = "SELECT ROUND(AVG(rating), 1) AS rate_av FROM ratings";
                    $av_sql_result = $sql_object->query($av_sql);
                    $av = $av_sql_result->fetch_assoc();
                    $av_rating = $av['rate_av'] . '/5';
                } else {
                    $av_rating = $rate_result['rating'] . '/5';
                }
            } else {
                $av_rating = "No ratings yet";
            } 
            

            // Query the database to fetch the recipe information for the provided recipe ID
            $sql = "SELECT r.recipe_id, r.Name, r.Description AS RecipeDescription, r.Rating, r.Prep_time, r.Cook_time, r.image_link, r.alt_text, GROUP_CONCAT(ri.Ingredient SEPARATOR ', ') AS Ingredients, rs.Step_number, rs.Description AS StepDescription
            FROM recipes r
            LEFT JOIN recipe_ingredients ri ON r.recipe_id = ri.recipe_id
            LEFT JOIN recipe_steps rs ON r.recipe_id = rs.recipe_id
            WHERE r.recipe_id = $recipe_id
            GROUP BY r.recipe_id, rs.Step_number
            ORDER BY rs.Step_number";

            $result = $sql_object->query($sql);

            if ($result->num_rows > 0) {
                $recipe = $result->fetch_assoc();
                ?>
                <img class="recipe-image" src="<?php echo $recipe['image_link'] ?>" alt="<?php echo $recipe['alt_text'] ?>">
                <h1><?php echo $recipe['Name']; ?></h1>
                <h2>Rating: <?php echo $av_rating; ?></h2>
                <?php 


                if (isUserLoggedIn()) {

                    //Radio buttons for rating system
                    echo "<div class='rating'>";
                    echo "<div class='star-icon'>";
                    echo "<input type='radio' name='rating' id='rating' value='1'>";
                    echo "<label for=rating class='star'>1</label>";
                    echo "<input type='radio' name='rating' id='rating' value='2'>";
                    echo "<label for=rating class='star'>2</label>";
                    echo "<input type='radio' name='rating' id='rating' value='3'>";
                    echo "<label for=rating class='star'>3</label>";
                    echo "<input type='radio' name='rating' id='rating' value='4'>";
                    echo "<label for=rating class='star'>4</label>";
                    echo "<input type='radio' name='rating' id='rating' value='5'>";
                    echo "<label for=rating class='star'>5</label>";
                    //check if the recipe has been rated by the user
                    $isRated = isRatingSaved($_SESSION["user_id"], $recipe['recipe_id']);

                    //if rated a message will appear. Otherwise a button will appear to rate
                    if ($isRated) {
                        echo "<p>You have submitted a rating for this recipe</p>";
                    } else {
                        echo "<button class='save-rating' id=recipe value='" . $recipe['recipe_id'] . "' data-rating-id='" . $recipe['recipe_id'] . "'>Rate</button>";
                    }

                }
                
                ?>
                <p><b>Preparation time:</b> <?php echo $recipe['Prep_time']; ?></p>
                <p><b>Cooking time:</b> <?php echo $recipe['Cook_time']; ?></p>

                <?php
                // Check if the recipe has any ingredients and display them
                if (isset($recipe['Ingredients'])) {
                    $recipe_ingredients = explode(', ', $recipe['Ingredients']);
                    ?>
                    <section class="ingredients-section">
                        <h3>Ingredients:</h3>
                        <ul>
                            <?php
                            foreach ($recipe_ingredients as $ingredientItem) {
                                echo "<li>$ingredientItem</li>";
                            }
                            ?>
                        </ul>
                    </section>
                <?php } else {
                    echo "<p>No ingredients available for this recipe.</p>";
                } ?>

<section class="steps-section">
<?php
// Check if the recipe has any steps and display them
if (isset($recipe['Step_number']) && isset($recipe['StepDescription'])) {
    ?>
    <h3>Steps:</h3>
    <ol>
        <?php foreach ($result as $step) {
            echo "<li>" . $step['StepDescription'] . "</li>";
        } ?>
    </ol>
<?php } else {
    echo "<p>No steps available for this recipe.</p>";
} ?>
</section>

                <?php
                // Check if the user is logged in and show the "Save" or "Remove" button accordingly
                if (isUserLoggedIn()) {
                    $isSaved = isRecipeSaved($_SESSION["user_id"], $recipe['recipe_id']);
                    ?>
                    <div class="save-remove-buttons">
                        <?php if ($isSaved) : ?>
                            <button class="remove-button" data-recipe-id="<?php echo $recipe['recipe_id']; ?>">Remove</button>
                        <?php else : ?>
                            <button class="save-button" data-recipe-id="<?php echo $recipe['recipe_id']; ?>">Save</button>
                        <?php endif; ?>
                    </div>
                <?php } else {
                    echo "<p>Please <a href='login_page.php'>log in</a> to save this recipe.</p>";
                } ?>
                <?php
            } else {
                echo "<p>Recipe not found.</p>";
            }
        } else {
            echo "<p>No recipe ID provided.</p>";
        }
        ?>
    </section>
</div>
    <?php include 'Footer.php'?>


        <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>

    <!-- Include the external script.js file -->
    <script src="script.js"></script>
</body>
</html>
