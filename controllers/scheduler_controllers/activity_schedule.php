<?php

require_once "../../services/activity_service.php";

$xd = 0;

$requiredFields = array('mistnost', 'den', 'start', 'vyucujici', 'ID_Aktiv');
$toInsert = array();
$string = "";
foreach ($requiredFields as $field) {
    $toInsert[$field] = $_POST[$field];
}

$service = new activityService();

$activities = $service->getActivitiesDay($_POST["den"]);
$newActivity = $service->getActivityInfo($_POST["ID_Aktiv"]);

if ($newActivity["mistnost"] != null) {
    if ($_POST["start"] + $newActivity["delka"] > 22) {
        $message = urlencode("Výuková aktivita může nejpozději končit ve 22:00.");
        header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
        exit;
    }
    $message = $service->scheduleActivity($toInsert);
    $message = urlencode($message);
    header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
    exit;
}

foreach ($activities as $activity) {
    if ($_POST["mistnost"] != $activity["mistnost"]) {
        continue;
    }
    else if (!collidingWeeks($activity["opakovani"], $newActivity["opakovani"])) {
        continue;
    }

    if ($_POST["start"] + $newActivity["delka"] > 22) {
        $message = urlencode("Výuková aktivita může nejpozději končit ve 22:00.");
        header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
        exit;
    }
    else if (startIsInActivity($activity, $_POST["start"]) or endIsInActivity($activity, $_POST["start"] + $newActivity["delka"])) {
        $message = urlencode("Výuková aktivita se kryje s jinou.");
        header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
        exit;
    }
}

$message = $service->scheduleActivity($toInsert);
$message = urlencode($message);
header("Location: ../../views/scheduler_views/activity_scheduling.php?id={$_POST["ID_Aktiv"]}&message=$message");
exit;

/**
 * @brief Determines whether start of one activity is in another activity.
 *
 * @param array $activity Activity in which the collision is controlled.
 * @param int $start Start of new activity yet to be added to database.
 * @return bool
 */
function startIsInActivity(array $activity, int $start): bool
{
    $oldStop = $activity["start"] + $activity["delka"];
    return ($activity["start"] <= $start and $start < $oldStop);
}

/**
 * @brief Determines whether end of one activity is in another activity.
 *
 * @param array $activity Activity in which the collision is controlled.
 * @param int $end End of new activity yet to be added to database.
 * @return bool
 */
function endIsInActivity(array $activity, int $end): bool
{
    $oldStop = $activity["start"] + $activity["delka"];
    return ($activity["start"] < $end and $end <= $oldStop);
}

/**
 * @brief Checks if newly added activity has colliding weeks with $old, that has already been in database.
 *
 * @param string $old Activity from database.
 * @param string $new Activity to be inserted.
 * @return bool
 */
function collidingWeeks(string $old, string $new): bool
{
    $weekOptions = ["ST", "LT", "KT"];
    if (!in_array($new, $weekOptions) or !in_array($old, $weekOptions)) {
        return false;
    }
    if ($new == "KT" or $old == "KT") {
        return true;
    }
    return ($new == $old);
}