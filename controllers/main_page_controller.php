<?php

/**
 * @return string Main page navigation for admin.
 */
function loadAdmin(): string
{
    return '<ul>
        <li><a href="subject_views/subject_management_admin.php">Spravovat předměty</a></li>
        <li><a href="room_views/room_management.php">Spravovat místnosti</a></li>
        <li><a href="user_views/user_management.php">Spravovat uživatele</a></li>
        <li><a href="activity_views/activity_management.php">Vytvořit výukovou aktivitu</a></li>
        <li><a href="scheduler_views/schedule_activities.php">Zařazení aktivit</a></li>
    </ul>';
}

/**
 * @return string Main page navigation for student.
 */
function loadStudent(): string
{
    return '<ul>
        <li><a href="subject_views/subject_registration.php">Registrace předmětů</a></li>
        <li><a href=student_views/schedule.php?day=tyden">Zobrazit rozvrh</a></li>
    </ul>';
}

/**
 * @return string Main page navigation for teacher.
 */
function loadTeacher(): string
{
    return '<ul>
        <li><a href="subject_views/subject_management_teacher.php">Spravovat předměty</a></li>
        <li><a href="activity_views/activity_management.php">Zažádat o výukovou aktivitu</a></li>
        <li><a href="request_views/request_management.php">Moje žádosti na rozvrh</a></li>
        <li><a href="teacher_views/teacher_schedule.php?day=tyden">Zobrazit rozvrh</a></li>
    </ul>';
}

/**
 * @return string Main page navigation for scheduler.
 */
function loadRozv(): string
{
    return '<ul>
        <li><a href="scheduler_views/schedule_activities.php">Zařazení aktivit</a></li>
    </ul>';
}