<?php
$hash = password_hash('vicecity1986', PASSWORD_BCRYPT, ['cost' => 4]);
echo $hash;
?>