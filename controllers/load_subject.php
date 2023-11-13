<?php
require "../services/subject_service.php";

function loadSubject() {
    if (isset($_GET['clickedZkratka'])) {
        $clickedZkratka = $_GET['clickedZkratka'];
        $subjectService = new subjectService();
        $subjectInfo = $subjectService->getSubjectInfo($clickedZkratka);
        if ($subjectInfo == null) {
            echo "Nejsou informace o předmětu: $clickedZkratka";
            return;
        }
        $toPrint = "";
        foreach ($subjectInfo as $columnName => $item) {
            $toPrint = $toPrint . "$columnName: " . $item . "</br>";
        }
        echo $toPrint;
    }
    else {
        echo "No zkratka clicked.";
    }
}

