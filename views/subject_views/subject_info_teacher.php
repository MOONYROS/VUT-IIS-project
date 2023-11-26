<?php

require_once "../../controllers/subject_controllers/subject_load.php";
require_once "../../common.php";
require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

make_header("Úprava předmětu");

$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($_GET["zkratka"]);
?>

<a class='direct_link' href="subject_management_teacher.php">Zpět k předmětům</a>

<h1>
    Úprava předmětu <?= $infoArray['zkratka']; ?>
</h1>

<h2>
    Tabulka vyučujících
</h2>

<?php
$subjectService = new subjectService();
$subjectTeachers = $subjectService->getSubjectTeachers($infoArray["zkratka"]);
if (!$subjectTeachers) {
    // Shouldnt ever happen because there is always garant
    echo "<p>" . "K předmětu nejsou zařazeni žádní učitelé." . "</p>";
}
else { ?>
    <table>
        <tr>
            <th>Jméno</th>
            <th>Příjmení</th>
        </tr>
        <?php
        foreach ($subjectTeachers as $teacher) {
            echo "<tr>
                    <td>{$teacher["jmeno"]}</td>
                    <td>{$teacher["prijmeni"]}</td>
                    <td>
                        <form class='btnForm' method='post' action='../../controllers/subject_controllers/remove_teacher.php'>
                            <input type='hidden' name='teacherId' value='{$teacher["ID_Osoba"]}'>
                            <input type='hidden' name='subjectId' value='{$_GET["zkratka"]}'>                            
                            <button class='btnRemove' type='submit'>Odstranit učitele</button>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>
<?php } ?>


<h2> Přiřadit učitele do kurzu </h2>

<?php
$userService = new userService();
$teachers = $userService->getUsersByRole("vyuc");
if (!$teachers) {
    echo "<p>" . "Žádní učitelé nejsou k dispozici." . "</p>";
}
else { ?>
    <table>
        <tr>
            <th>Jméno</th>
            <th>Příjmení</th>
        </tr>
        <?php
        foreach ($teachers as $teacher) {
            if (!isTeacher($teacher["ID_Osoba"], $subjectTeachers)) {
                echo "<tr>
                    <td>{$teacher["jmeno"]}</td>
                    <td>{$teacher["prijmeni"]}</td>
                    <td>
                        <form class='btnForm' method='post' action='../../controllers/subject_controllers/add_teacher.php'>
                            <input type='hidden' name='teacherId' value='{$teacher["ID_Osoba"]}'>
                            <input type='hidden' name='subjectId' value='{$_GET["zkratka"]}'>
                            <button type='submit'>Přidat učitele</button>
                        </form>
                    </td>
                </tr>";
            }
        }
        ?>
    </table>
<?php } ?>

<p><?php if (isset($_GET["message"])) echo $_GET["message"]; ?></p>

<h2>
    Karta předmětu
</h2>

<div class="group">
    <h1><?= $_GET["zkratka"] ?> (<?= $infoArray["nazev"] ?>)</h1>
    <p> <?= $infoArray["anotace"] ?> </p>
    <h3>Počet kreditů: <?= $infoArray["pocet_kreditu"] ?></h3>
    <h3>Typ ukončení: <?= $infoArray["typ_ukonceni"] ?></h3>
    <h3> Garant</h3>
    <p> <?= "{$infoArray["jmeno"]} {$infoArray["prijmeni"]}" ?> </p>
    <h3> Vyučující</h3>
    <?php
    $finalValue = "";
    foreach ($subjectTeachers as $teacher) {
        $finalValue = $finalValue . "{$teacher["jmeno"]} {$teacher["prijmeni"]}<br>";
    }
    echo $finalValue;
    ?>
</div>

<?php
make_footer();
?>
