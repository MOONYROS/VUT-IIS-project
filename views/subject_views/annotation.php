<?php

require_once "../../common.php";
require_once "../../services/subject_service.php";

$subjectId = $_GET["zkratka"];
make_header("Anotace {$subjectId}");
$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($subjectId);
$teachers = $subjectService->getSubjectTeachers($subjectId);
?>

<h1><?= $subjectId ?></h1>
<h3> Název</h3>
<p> <?= $infoArray["nazev"] ?> </p>
<h3> Anotace</h3>
<p> <?= $infoArray["anotace"] ?> </p>
<h3> Počet kreditů</h3>
<p> <?= $infoArray["pocet_kreditu"] ?> </p>
<h3> Typ ukončení</h3>
<p> <?= $infoArray["typ_ukonceni"] ?> </p>
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

<?php make_footer(); ?>
