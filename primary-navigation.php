<nav class="top-menu-navigation">
    <ul>
        <li>
            <section class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="search" placeholder="Spaghetti Bolognese...">
                    <button type="submit">Search</button>
                </form>
            </section>
        </li>
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php?search=">Browse Recipes</a></li>
        <?php if (isset($_SESSION["user_id"])) : ?>
            <li><a href="logout.php">Log out</a></li>
        <?php else : ?>
            <li><a href="login_page.php">Log In</a></li>
            <li><a href="signup_form.html">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>
