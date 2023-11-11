<?php
    require "common.php";
    make_header("login");
?>

<form action="register_user.php" method="post">
    <label for="jmeno">Jmeno</label>
    <input type="text" name="jmeno" id="jmeno"><br>

    <label for="prijmeni">Prijmeni</label>
    <input type="text" name="prijmeni" id="prijmeni"><br>

    <label for="login">Login</label>
    <input type="text" name="login" id="login"><br>

    <label for="heslo">Password</label>
    <input type="password" name="heslo" id="heslo"><br>

    <label for="email">Email</label>
    <input type="text" name="email" id="email"><br>

    <label for="telefon">Telefon</label>
    <input type="text" id="telefon" name="telefon"><br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="student" selected>Student</option>
        <option value="vyucujici">Vyucujici</option>
        <option value="rozvhar">Rozvrhar</option>
        <option value="garant">Garant</option>
    </select><br>
    <input type="submit" value="Register">
</form>

<?php
    make_footer();
?>
