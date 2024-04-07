<?php
    require_once('./api/connection.php');
    if (isset($_POST["idPOST"])) {
        $id = $_POST["idPOST"];
        $sql = 'UPDATE houses SET status = '. "'".  'OK' ."'" .'WHERE id = '. "'" . $id ."'";
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute();
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Bài đăng đã được phê duyệt!")';
            echo '</script>';
            echo '<script type ="text/JavaScript">';
            echo 'window.location = "./admin.php"';
            echo '</script>';
        }
        catch(PDOException $ex){
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    } else if (isset($_POST["idDelete"])) {
        $id = $_POST["idDelete"];
        $sql = 'DELETE FROM houses WHERE id =' . "'" . $id ."'";
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute();
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Xóa bài đăng thành công!")';
            echo '</script>';
            echo '<script type ="text/JavaScript">';
            echo 'window.location = "./admin.php"';
            echo '</script>';
        }
        catch(PDOException $ex){
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
    
?>