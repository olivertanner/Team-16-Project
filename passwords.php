<!-- PHP code to generate a new random password
Contributors - Ollie Tanner, Elie Jr Akobeto -->

<?php
function generatePasswordX() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $albetLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $albetLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); // array turned into a string
}
?>
