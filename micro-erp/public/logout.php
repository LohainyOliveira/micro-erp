<?php
session_start();
session_unset();

session_destroy();
header("Location: ../index.php");

// Garante que nenhum outro código será executado após o redirecionamento
exit();
?>
