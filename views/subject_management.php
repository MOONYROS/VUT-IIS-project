<?php
require "../common.php";
make_header("tvorba predmetu");
?>

<h2>
   Vytvořit předmět
</h2>

<form action="../controllers/create_subject.php" method="post">
    <label for="nazev">Nazev</label>
    <input type="text" name="nazev" id="nazev"><br>

    <label for="zkratka">Zkratka</label>
    <input type="text" name="zkratka" id="zkratka"><br>

    <label for="anotace">Anotace</label>
    <textarea name="anotace" id="anotace"></textarea><br>

    <label for="pocet_kreditu">Pocet kreditu</label>
    <input type="number" name="pocet_kreditu" id="pocet_kreditu"><br>

    <label for="typ_ukonceni">Role</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" selected>zapocet</option>
        <option value="klza" selected>kl zapocet</option>
        <option value="zk">zkouska</option>
        <option value="zazk">zapocet zkouska</option>
    </select><br>

    <input type="submit" value="Vytvorit predmet">
</form>


<h2>
   Správa předmětů
</h2>

<p>
    <?php 
    require "../services/subject_service.php";
    $servis = new subjectService();
    $zkratky = $servis->getSubjectIDs();
    $zkratkyList = explode(', ', $zkratky);
    foreach($zkratkyList as $tmp) {
        echo '<a href="subject.php?clickedZkratka=' . urlencode($tmp) . '">' . $tmp . '</a>, ';
    }
    ?>
</p>