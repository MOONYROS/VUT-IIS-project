<?php

require_once "../../services/activity_service.php";

$xd = 0;

$requiredFields = array('mistnost', 'den', 'start', 'vyucujici', 'ID_Aktiv');
$toInsert = array();
$string = "";
foreach($requiredFields as $field) {
    $toInsert[$field] = $_POST[$field];
}

$service = new activityService();

$activities = $service->getActivitiesDay($_POST["den"]);
$newActivity = $service->getActivityInfo($_POST["ID_Aktiv"]);

if ($newActivity["mistnost"] != null) {
    $message = $service->scheduleActivity($toInsert);
    $message = urlencode($message);
    header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
    exit;
}

foreach ($activities as $activity) {
    if ($_POST["mistnost"] != $activity["mistnost"]) {
        continue;
    }
    if (!collidingWeeks($activity["opakovani"], $newActivity["opakovani"])) {
        continue;
    }

    if (startIsInActivity($activity, $_POST["start"]) or endIsInActivity($activity, $_POST["start"] + $newActivity["delka"])) {
        $message = urlencode("Výuková aktivita se kryje s jinou.");
        header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
        exit;
    }
}

$message = $service->scheduleActivity($toInsert);
$message = urlencode($message);
header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
exit;

function startIsInActivity($activity, $start): bool {
    $oldStop = $activity["start"] + $activity["delka"];
    return ($activity["start"] <= $start and $start < $oldStop);
}

function endIsInActivity($activity, $end): bool {
    $oldStop = $activity["start"] + $activity["delka"];
    return ($activity["start"] < $end and $end <= $oldStop);
}

function collidingWeeks($old, $new): bool {
    $weekOptions = ["ST", "LT", "KT"];
    if (!in_array($new, $weekOptions) or !in_array($old, $weekOptions)) {
        return false;
    }
    if ($new == "KT" or $old == "KT") {
        return true;
    }
    return ($new == $old);
}