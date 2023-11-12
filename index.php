<?php
    require "common.php";

    make_header("login");
?>

<form action="register_user.php" method="post">
    <label for="jmeno">Jmeno</label>
    <input type="text" name="jmeno" id="jmeno"><br>

    <label for="prijmeni">Prijmeni</label>
    <input type="text" name="prijmeni" id="prijmeni"><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email"><br>

<!--    <label for="heslo">Password</label>-->
<!--    <input type="password" name="heslo" id="heslo"><br>-->

    <label for="telefon">Telefon</label>
    <input type="tel" id="telefon" name="telefon"><br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="stud" selected>Student</option>
        <option value="vyuc">Vyucujici</option>
        <option value="rozv">Rozvrhar</option>
        <option value="gara">Garant</option>
    </select><br>

    <input type="submit" value="Create new user">
</form>

<?php
    make_footer();
?>
