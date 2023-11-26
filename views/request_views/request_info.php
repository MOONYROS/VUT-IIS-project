<?php
require_once "../../common.php";

make_header("Upravit žádost");
?>

<a class='direct_link' href='request_management.php'>Zpět k žádostem</a>

<script>
    let fields = ['zadost'];
</script>

<h1>
    Úprava žádosti <?= $_POST['zkratka'] ?>
</h1>

<form action="../../controllers/request_controllers/request_create.php" method="post" onsubmit="return validateForm(fields);">
    <input type="hidden" name="ID_Osoba" value="<?= $_SESSION['user_id'] ?>">
    <input type="hidden" name="zkratka" value="<?= $_POST['zkratka'] ?>">

    <label for="zadost">Text žádosti<?= requiredField(); ?></label>
    <textarea name="zadost" id="zadost"><?= $_POST['zadost'] ?></textarea>
    <br>

    <input type="submit" value="Upravit žádost">
</form>


<?php
make_footer();
?>
