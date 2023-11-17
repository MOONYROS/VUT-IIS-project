<?php
    require "common.php";

    make_header("login");
?>

<h1>GigaWeb</h1>

<h2>Prihlaseni</h2>
<form action="controllers/login.php" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required><br>

    <label for="heslo">Heslo</label>
    <input type="password" name="heslo" id="heslo" required><br>

    <input type="submit" value="Přihlásit se">
</form>
<br>

<a href="views/anotations.php">Vstup bez prihlaseni</a>

<?php
    make_footer();
?>
