<section class="recipe-grid-container">
    <?php
    $sql = "SELECT * FROM `recipes`
    WHERE Cook_time = '10 to 30 minutes' OR Cook_time = '30 minutes to 1 hour' 
    LIMIT 3;";
    $result = $sql_object->query($sql);

    // Check if there are any recipes in the result
    if ($result->num_rows > 0) {
        // Fetch and display the recipes
        while ($recipe = $result->fetch_assoc()) {

            $rec = $recipe['recipe_id'];

            //fetch any ratings the recipes may have
            $rate_sql = "SELECT * FROM ratings WHERE recipe_id = '$rec'";
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
    ?>
            <div class="small-card">
                <a href="Recipe_details.php?recipe_id=<?php echo $recipe['recipe_id']; ?>">
                    <img src="<?php echo $recipe['image_link'] ?>" alt="<?php echo $recipe['alt_text'] ?>" style="width:100%">
                </a>
                <div class="small-container">
                    <h3><?php echo $recipe['Name']; ?></h3>
                    <p><?php echo $recipe['Description']; ?></p>
                    <p><b>Preparation time:</b> <?php echo $recipe['Prep_time']; ?></p>
                    <p><b>Cooking time:</b> <?php echo $recipe['Cook_time']; ?></p>
                    <p><b>Average Rating:</b> <?php echo $av_rating; ?></p>
                    <a href="Recipe_details.php?recipe_id=<?php echo $recipe['recipe_id']; ?>">
                        <button class="details-button-white">View recipe for <?php echo $recipe['Name']; ?></button>
                    </a>
                    <?php
                    // Check if the user is logged in and show the "Save" or "Remove" button accordingly
                    if (isUserLoggedIn()) {
                        // Check if the recipe is saved or not and display the appropriate button
                        $isSaved = isRecipeSaved($_SESSION["user_id"], $recipe['recipe_id']);
                        if ($isSaved) {
                            echo "<button class='remove-button' data-recipe-id='" . $recipe['recipe_id'] . "'>Remove recipe</button>";
                        } else {
                            echo "<button class='save-button' data-recipe-id='" . $recipe['recipe_id'] . "'>Save recipe</button>";
                        }
                    } else {
                        echo "<p>Please <a href='login_page.php'>log in</a> to save this recipe.</p>";
                    }
                    ?>
                </div>
            </div>
        <?php
        }
    } else {
        echo "<p>No recipes found.</p>";
    }
    ?>
</section>