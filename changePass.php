<?php
    session_start();
    session_destroy();
    echo '<script type ="text/JavaScript">';  
    echo 'alert("Đổi mật khẩu thành công vui lòng đăng nhập lại!")';  
    echo '</script>'; 
    echo '<script type ="text/JavaScript">';
    echo 'window.location = "./index.php"';
    echo '</script>';
?>