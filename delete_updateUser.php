<?php
    require_once('./api/connection.php');
    if (isset($_POST["emailUser"])) {
        $email = $_POST["emailUser"];
        $sql = 'DELETE FROM users WHERE email = '. "'" . $email ."'";
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute();
            // header("Location: admin.php");
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Xóa tài khoản thành công!")';
            echo '</script>';
            echo '<script type ="text/JavaScript">';
            echo 'window.location = "./admin.php"';
            echo '</script>';
        }
        catch(PDOException $ex){
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    } else if (isset($_POST["emailUserUpdate"])) {
        $email = $_POST["emailUserUpdate"];

        $sql = 'UPDATE `users` SET `password`= ? WHERE email = ? ';
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array('111111',$email));
            // header("Location: admin.php");
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Đặt lại mật khẩu thành công!")';
            echo '</script>';
            echo '<script type ="text/JavaScript">';
            echo 'window.location = "./admin.php"';
            echo '</script>';
        }
        catch(PDOException $ex){
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
