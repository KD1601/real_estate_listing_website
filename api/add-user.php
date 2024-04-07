<?php
    require_once ('connection.php');
    echo '<script type ="text/JavaScript">';  
    echo 'alert("Qua duoc ben nay roi")';  
    echo '</script>';

    switch($_REQUEST['act']){
        case "form":
            include("index.php"); break;

    }

    if (!isset($_POST['nameT']) || !isset($_POST['emailT']) || !isset($_POST['passwordT'])) {
        die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
    }

    $name = $_POST['nameT'];
    $email = $_POST['emailT'];
    $password = $_POST['passwordT'];

    echo "$name";
    echo "$email";
    echo "$password";

    $sql = 'INSERT INTO users(name,email,password) VALUES(?,?,?)';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($name,$email,$password));
        echo json_encode(array('status' => true, 'data' => 'Thêm user thành công'));
        // header('Location: ../index.php');
    }
    catch(PDOException $ex){
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Email này đã được sử dụng cho 1 tài khoản khác vui lòng thử lại!")';  
        echo '</script>';  
        header('Location: ../index.php');
        // die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
    }



?>