<?php
    session_start();
    
    for ($i = 1; ; $i++) {
        for ($j = 1; ; $j++) {
            $_SESSION["try".$j.$i] = $_POST["_try".$j.$i];
        }
    }

    header("Location: ../game.php");
    
?>