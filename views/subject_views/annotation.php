<?php

require_once "../../common.php";
require_once "../../services/subject_service.php";

$subjectId = $_GET["zkratka"];
make_header("Anotace {$subjectId}");
$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($subjectId);
$teachers = $subjectService->getSubjectTeachers($subjectId);
?>

<?= toSelectedPage('/subject_views/subject_registration.php', 'Zpět k registracím předmětů') ?>

<div class="group">
    <h1><?= $subjectId ?> (<?= $infoArray["nazev"] ?>)</h1>
    <p> <?= $infoArray["anotace"] ?> </p>
    <h3>Počet kreditů: <?= $infoArray["pocet_kreditu"] ?></h3>
    <h3>Typ ukončení: <?= $infoArray["typ_ukonceni"] ?></h3>
    <h3> Garant</h3>
    <p> <?= "{$infoArray["jmeno"]} {$infoArray["prijmeni"]}" ?> </p>
    <h3> Vyučující</h3>
    <?php
    $finalValue = "";
    foreach ($teachers as $teacher) {
        $finalValue = $finalValue . "{$teacher["jmeno"]} {$teacher["prijmeni"]}<br>";
    }
    echo $finalValue;
    ?>
</div>

<?php make_footer(); ?>
