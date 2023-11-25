<?php
    require_once "common.php";

    make_header("login");
?>

<script>
    let fields = ['email', 'heslo'];
</script>

<h1>GigaWeb</h1>

<h2>Prihlaseni</h2>
<form action="controllers/login.php" method="post" onsubmit="return validateForm(fields);">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?php if (isset($_GET["email"])) echo $_GET["email"];?>" required><br>

    <label for="heslo">Heslo</label>
    <input type="password" name="heslo" id="heslo" required><br>

    <input type="submit" value="Přihlásit se">
</form>
<br>

<p>
    <?php
    if (isset($_GET["error"]) && isset($_GET["message"])) {
        echo $_GET["message"];
    }
    ?>
</p>

<a href="views/anotations.php" class='direct_link' id="unsigned">Vstoupit bez přihlášení</a>

<?php
    make_footer();
?>
