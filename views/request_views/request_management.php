<?php
require_once "../../common.php";
require_once "../../services/subject_service.php";

$subjectService = new subjectService();
$subjects = $subjectService->getTeachedSubjects($_SESSION['user_id']);

make_header("Sprava zadosti");

?>

<?= toMainPage(); ?>

<script>
    let fields = ['zadost'];
</script>

<h1>
    Moje žádosti na rozvrh
</h1>

<?php
if ($subjects == null) {
    echo '<p>Nevyučujete žádné předměty.</p>';
}
else {
    echo '<h2>Vytvořit novou žádost</h2>
          <form action="../../controllers/request_controllers/request_create.php" method="post" onsubmit="return validateForm(fields);">
            <input type="hidden" name="ID_Osoba" value="' . $_SESSION['user_id'] . '">

            <label for="zkratka">Předmět</label>
            <select name="zkratka" id="zkratka">';
            foreach ($subjects as $subject) {
                echo '<option value="' . $subject['zkratka'] . '">' . $subject['zkratka'] . '</option>';
            }
            echo '</select>
            </br>
            
            <label for="zadost">Text žádosti</label>
            <textarea name="zadost" id="zadost"></textarea>
            </br>
            
            <input type="submit" value="Vytvořit žádost">
          </form>';
}

if (isset($_GET['message'])) {
    echo '<p>' . $_GET['message'] . '</p>';
}

if ($subjects != null) {
    echo '<h2>Moje žádosti</h2>';
}
?>

<?php
foreach ($subjects as $subject) {
    if ($subject['zadost'] != null) {
        echo '<div class="group"><h3>' . $subject['zkratka'] . '</h3>' .
            '<p>' . $subject['zadost'] . '</p>
            <form method="post" action="../../controllers/request_controllers/request_delete.php">
                <input type="hidden" name="ID_Osoba" id="ID_Osoba" value="'. $_SESSION['user_id'] .'">
                <input type="hidden" name="zkratka" id="zkratka" value="'. $subject['zkratka'] .'">
                <input type="submit" value="Odstranit žádost" class="btnRemove2">
            </form>
            <form method="post" action="request_info.php">
                <input type="hidden" name="zkratka" id="zkratka" value="'. $subject['zkratka'] .'">
                <input type="hidden" name="zadost" id="zadost" value="'. $subject['zadost'] .'">
                <input type="submit" value="Upravit žádost">
            </form></div>';
    }
}
?>

<?php
make_footer();
?>
