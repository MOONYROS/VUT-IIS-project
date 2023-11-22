<?php

function loadAdmin() {
    return '<ul>
        <li><a href="/views/subject_views/subject_management.php">Spravovat předměty</a></li>
        <li><a href="/views/room_views/room_management.php">Spravovat místnosti</a></li>
        <li><a href="/views/user_views/user_management.php">Spravovat uživatele</a></li>
        <li><a href="/views/activity_views/activity_management.php">Spravovat výukové aktitity</a></li>
        <li><a href="/views/subject_views/subject_registration.php">Registrace předmětů</a></li>
        <li><a href="/views/scheduler_views/schedule_activities.php">Zarazeni aktivit</a></li>
        <li><a href="/views/student_views/schedule.php?day=tyden">Zobrazit rozvrh</a></li>
    </ul>';
}

function loadStudent() {

}

function loadTeacher() {

}