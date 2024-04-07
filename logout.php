<?php
    session_start();
    session_destroy();
    echo '<script type ="text/JavaScript">';
    echo 'window.location = "./index.php"';
    echo '</script>';
?>