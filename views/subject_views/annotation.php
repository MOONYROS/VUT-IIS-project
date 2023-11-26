<?php

require_once "../../common.php";
require_once "../../services/subject_service.php";

$subjectId = $_GET["zkratka"];
make_header("Anotace {$subjectId}");
$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($subjectId);
if (!$infoArray) {
    $infoArray = $subjectService->getSubjectInfoNoGarant($subjectId);
    $infoArray["garant"] = "Předmět nemá garanta.";
}
$teachers = $subjectService->getSubjectTeachers($subjectId);
?>

<a class='direct_link' href='subject_registration.php'>Zpět k registracím předmětů</a>

<div class="group">
    <h1><?= $subjectId ?> (<?= $infoArray["nazev"] ?>)</h1>
    <p> <?= $infoArray["anotace"] ?> </p>
    <h3>Počet kreditů: <?= $infoArray["pocet_kreditu"] ?></h3>
    <h3>Typ ukončení: <?= $infoArray["typ_ukonceni"] ?></h3>
    <h3> Garant</h3>
    <p>
        <?php
        if (isset($infoArray["jmeno"])) echo "{$infoArray["jmeno"]} {$infoArray["prijmeni"]}";
        else echo $infoArray["garant"];
        ?>
    </p>
    <h3> Vyučující</h3>
    <?php
    $finalValue = "";
    if ($teachers) {
        foreach ($teachers as $teacher) {
            $finalValue = $finalValue . "{$teacher["jmeno"]} {$teacher["prijmeni"]}<br>";
        }
    }
    else {
        $finalValue .= "Předmět nemá žádné učitele.";
    }
    echo $finalValue;
    ?>
</div>

<?php
make_footer();
?>
