<?php 
    session_start();
    $signInSuccess = '';
    $check = 0;
    require_once('./api/connection.php');
    // Xử lý đăng ký
    if(isset($_POST["dangky"])) {
        if(isset($_POST["email"])) {
            $email = $_POST["email"];
            $sql = 'SELECT email FROM users';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
                // echo json_encode(array('status' => true, 'data' => 'Thêm user thành công'));
                // header('Location: ../index.php');
            }
            catch(PDOException $ex){
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                 
            }
            // header('Location: ../index.php');
            // die(json_encode(array('status' => false, 'data' => $ex->getMessage())));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($row["email"] == $email) {
                    $check = 1;
                    echo '<script type ="text/JavaScript">';  
                    echo 'alert("Email này đã được sử dụng cho 1 tài khoản khác vui lòng thử lại!")';  
                    echo '</script>'; 
                    break;
                }
            }
            if ($check == 0) {
                if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
                    die(json_encode(array('status' => false, 'data' => 'Parameters not valid')));
                }
            
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sql = 'INSERT INTO users(name,email,password) VALUES(?,?,?)';

                try{
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute(array($name,$email,$password));
                    echo '<script type ="text/JavaScript">';  
                    echo 'alert("Đăng ký tài khoản thành công!")';  
                    echo '</script>'; 
                    // echo json_encode(array('status' => true, 'data' => 'Thêm user thành công'));
                    // header('Location: ../index.php');
                }
                catch(PDOException $ex){
                    // header('Location: ../index.php');
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
                
            }
        }
    }
    // End xử lý đăng ký

    // Xử lý đăng nhập
    $checkSignIn = 0;
    $nameUser = "";
    if (isset($_POST["signIn"])) {
        if (isset($_POST["emailDN"]) && isset($_POST["passDN"])) {
            $emailDN = $_POST["emailDN"];
            $passDN = $_POST["passDN"];

            

            $sql = 'SELECT * FROM users';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            }
            catch(PDOException $ex){
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                 
            }
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($row["email"] == $emailDN && $row["password"] == $passDN){
                    if ($_POST["emailDN"] == 'admin@gmail.com') {
                        header("Location: admin.php");
                    }
                    $checkSignIn = 1;
                    $nameUser = $row["name"];
                    $signInSuccess = $row["name"];
                    $_SESSION["login"] = $row["name"];
                    echo '<script type ="text/JavaScript">';  
                    echo 'alert("Đăng nhập thành công")';  
                    echo '</script>'; 
                    break;
                }
            }
            if ($checkSignIn == 0) {
                echo '<script type ="text/JavaScript">';  
                echo 'alert("Sai tên hoặc mật khẩu")';  
                echo '</script>';
            }
        }
    }
    // End xử lý đăng nhập

    // Xử lý đổi mật khẩu
    if(isset($_POST["doimatkhau"])) {
        
        $emailDMK = $_POST["emailDMK"];
        $passDMK = $_POST["passwordDMK"];

        $sql = 'UPDATE `users` SET `password`= ? WHERE `email` = ?';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array($passDMK,$emailDMK));
                header("Location: changePass.php");
            }
            catch(PDOException $ex){
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                 
            }
    }
    // End xử lý đổi mật khẩu
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhapho.com</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/alliedhomes-logo.png">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/formDK.css">
    <link rel="stylesheet" href="./assets/css/formDN.css">
    <link rel="stylesheet" href="./assets/css/formDMK.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/bb1da7a09c.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

    <!-- Form đăng tin -->
    
    <!-- End form đăng tin -->

    <!-- Show infHouse -->
    <?php
        

        if(isset($_POST["infHouseId"]) && isset($_POST["infHouseName"]) && isset($_POST["img1"])
        && isset($_POST["img2"]) && isset($_POST["img3"]) && isset($_POST["owner"]) && isset($_POST["phoneContact"])) {
            $img1 = $_POST["img1"];
            $img2 = $_POST["img2"];
            $img3 = $_POST["img3"];

            echo '<script>
            $(document).ready(function () {
                showInf.style.display = "block"
              });
            </script>';
            $title = $_POST["infHouseName"];
            $id = $_POST["infHouseId"];
        }
    ?>
    <div id="showInf">
        <div class="container top d-flex justify-content-between ">
            <div id="carouselExampleIndicators" class="mt16 carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img <?php echo "src=\"./assets/images/house/$img1\"" ?> class="d-block image" alt="imageHouse">
                    </div>
                    <div class="carousel-item">
                    <img <?php echo "src=\"./assets/images/house/$img2\"" ?> class="d-block image" alt="imageHouse">
                    </div>
                    <div class="carousel-item">
                    <img <?php echo "src=\"./assets/images/house/$img3\"" ?> class="d-block image" alt="imageHouse">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="contact__owner d-flex flex-column">
                <div class="cardOwner card" style="width: 18rem;">
                    <img id="avatar" src="./assets/images/user.png" class="card-img-top mt16" alt="avatar">
                    <span id="uploadBy">Được đăng bởi</span>
                    <div class="card-body">
                        <h5 id="nameUpload" class="card-title"><?php echo $_POST["owner"] ?></h5>
                        <button id="btnCallOwner" class="call btn btn-primary flex-grow-1" >
                        <img id="phone" src="./assets/images/telephone.png" alt="phone">
                        <span class="callNow">Liên hệ ngay</span>
                        <span class="phoneNumber"><?php echo $_POST["phoneContact"] ?></span>
                    </div>
                    <button onclick="window.print();" class="btn btn-primary" id="print-btn">In thông tin</button>

                </div>
            </div>
        </div>
        <div class="body container">
            <h3 class="mt16"><?php echo $_POST["infHouseName"] ?></h3>
            <?php
                $sql = 'SELECT * FROM houses WHERE id = '. "'".$id."'";

                try{
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute();
                }
                catch(PDOException $ex){
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
        
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class=\"priceArea d-flex\">";
                    echo "<div id=\"priceArea__p \">";
                    echo "<span class=\"howMuch mr98\">Mức giá</span><br>";
                    echo "<span id=\"much\">$row[price]</span>";
                    echo "</div>";
                    echo "<div id=\"priceArea__a\">";
                    echo "<span class=\"howMuch mr98\">Diện tích</span><br>";
                    echo "<span id=\"many\">$row[areas]</span>";
                    echo "</div>";
                    echo "<div id=\"numBed\">";
                    echo "<span class=\"howMuch mr98\">Số phòng ngủ</span><br>";
                    echo "<span class =\"ml42\" id=\"beds\">$row[bedrooms]</span>";
                    echo "</div>";
                    echo "<div id=\"numBath\">";
                    echo "<span class=\"howMuch mr98\">Số phòng ngủ</span><br>";
                    echo "<span class =\"ml42\" id=\"baths\">$row[bathrooms]</span>";
                    echo "</div>";
                    echo "</div>";
                    echo "<span>$row[description]</span>";
                }
            ?>
            
        </div>
    </div>
    <!-- End show inf house -->

    <!-- Project house -->
        <div class="container" id="project-house">
            <?php
                if(isset($_GET["project-house"])) {
                    echo '<script>
                    $(document).ready(function(){
                        handleBlur();
                    });
                    </script>';
                    $sql = 'SELECT * FROM project_houses WHERE id = '.'"'.$_GET["project-house"].'"';
                    try{
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute();
                    }
                    catch(PDOException $ex){
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<h3 class=\"title__project\">$row[name]</h3>";
                        echo "<i id=\"closes2\" class=\"fa-solid fa-square-xmark\"></i>";
                        echo "<h4 class=\"overall\">TỔNG QUAN DỰ ÁN</h4>";
                        echo "<span class=\"project-house__des\">";
                        echo "Tên dự án: $row[description] <br>";
                        echo "</span> <br>";
                        echo "<img src=\"./assets/images/project_house/$row[image]\" alt=\"image\">";
                        echo "<h4 class=\"overall\">VỊ TRÍ DỰ ÁN</h4>";
                        echo "<span class=\"project-house__location\"> $row[location] ";
                        echo "</span> <br> <br>";
                    }
                }
            ?>
        </div>
    <!-- End project house -->

    <!-- Form Dang ky -->
        <section id="formDK" class="formDK">
            <div class="container h-100">
                <div class="col-lg-12 col-xl-11 w-100">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-2">
                            <i id="closes" class="fa-solid fa-square-xmark"></i>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng ký</p>

                                    <form id="test" class="mx-1 mx-md-4" action="" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="name" placeholder="Nhập tên" type="text" id="name"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="email" placeholder="Nhập email" type="email" id="email"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="password" placeholder="Nhập mật khẩu" type="password" id="pwd"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input placeholder="Nhập lại mật khẩu" type="password" id="pwd2"
                                                    class="form-control" />

                                            </div>
                                        </div>

                                        <div class="checkbox-agree form-check d-flex justify-content-center mb-3">
                                            <input id="checkbox-agree" class="form-check-input me-2" type="checkbox"
                                                value="" id="agree" name="agree" />
                                            <label class="form-check-label" for="agree">
                                                Tôi đồng ý với các <a href="about.html" target="_blank">Điều khoản và dịch vụ</a>
                                            </label>
                                        </div>

                                        <span class="error" id="messageError"></span>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 mt-1">
                                            <input  value="Đăng ký" name="dangky" type="submit" id="btnSubmit" class="btn btn-primary btn-lg"></input>
                                        </div>


                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="./assets/images/draw1.webp"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--End Form Dang ky -->

    <!-- Form Dang Nhap -->
        <section id="formDN" class="formDN">
            <div class="container h-100 px-0">
                <!-- <div class="row d-flex justify-content-center align-items-center h-100"> -->
                <div class="col-lg-12 col-xl-11 w-100">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div id="card__body" class="card-body p-md-5">
                            <i id="close" class="fa-solid fa-square-xmark"></i>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p id="hi" class="mb-0">Xin chào bạn</p>
                                    <p id="signInText" class=" h1 fw-bold mb-4 mx-1 mx-md-4 mt-2">Đăng nhập để tiếp
                                        tục</p>

                                    <form class="mx-1 mx-md-4" action="" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="emailDN" placeholder="Nhập email" type="email" id="userEmail"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="passDN" placeholder="Nhập mật khẩu" type="password" id="userPwd"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="checkbox-agree form-check d-flex justify-content-end mb-2">
                                            <a href="#">Quên mật khẩu?</a>
                                        </div>

                                        <span class="error" id="messageErrors"></span>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 mt-1">
                                            <input value="Đăng nhập" name="signIn" type="submit" id="signIn" class="btn btn-primary btn-lg" ></input>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="./assets/images/draw1.webp"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </section>
    <!-- End Form Dang Nhap -->

    <!-- Form doi mat khau -->
    <section id="DMK" class="DMK">
            <div class="container h-100">
                <div class="col-lg-12 col-xl-11 w-100">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <i id="closes1" class="fa-solid fa-square-xmark"></i>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đổi mật khẩu</p>

                                    <form id="formDMK" class="mx-1 mx-md-4" action="" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="emailDMK" placeholder="Nhập email" type="email" id="emailDMK"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="passwordDMK" placeholder="Nhập mật khẩu mới" type="password" id="passwordDMK"
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input placeholder="Nhập lại mật khẩu" type="password" id="passwordDMK2"
                                                    class="form-control" />

                                            </div>
                                        </div>

                                        <span class="error" id="messageError2"></span>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 mt-1">
                                            <input  value="Đổi mật khẩu" name="doimatkhau" type="submit" id="bntDMK" class="btn btn-primary btn-lg"></input>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="./assets/images/draw1.webp"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- End form doi mat khau -->
    <div id="blur__screen"></div>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarExample01" aria-controls="navbarExample01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="Nav">
                    <img id="logo-header" src="./assets/images/logo.png" alt="Logo">
                    <ul id="ul__header"  class="w-100 navbar-nav me-auto mb-2 mb-lg-0 justify-content-end header-link">
                        <?php if (isset($_SESSION["login"])) {
                            echo "<li style=\"margin-left: 36px !important;\" id=\"headerHello\" class=\"nav-item mx-3\">";
                            echo "<span style=\"font-weight: bold; line-height: 2.45rem;\" id=\"userName\">Xin chào $_SESSION[login]</span>";
                            echo "<div id=\"dropdown\" class=\"flex-column \">";
                            echo "<a id=\"changePass\" href=\"#\">Đổi mật khẩu</a>";
                            echo "<a id=\"signOut\" href=\"logout.php\">Đăng xuất</a>";
                            echo "</div>";
                            echo "</li>";
                        }
                        ?>
                        <li id="headerSignIn"
                            <?php 
                                if (isset($_SESSION["login"])) {
                                    echo "style=\"display: none;\"";
                                }
                            ?> 
                        class="nav-item mx-3">
                            <a class="nav-link child-ul first-child-ul" aria-current="page" href="#" >Đăng nhập </a>
                        </li>
                        <li id="headerSignUp" class="nav-item mx-3 me-5" 
                        <?php 
                                if (isset($_SESSION["login"])) {
                                    echo "style=\"display: none;\"";
                                }
                            ?>
                        >
                            <a class="nav-link child-ul "
                             href="#" >
                            Đăng ký</a>
                        </li>
                        <li class="nav-item upload-info " style="margin-top: 20px;"
                            <?php 
                                if ($checkSignIn == 1) {
                                    echo "style=\"margin-left: 0px !important;\" \"margin-top: 16px;\"";
                                }
                            ?>
                        >
                            <a id="post" class="nav-link last-child-ul" style="margin-bottom: 12px;" 
                            <?php 
                                if ($checkSignIn == 1) {
                                    echo "style=\"height: 40px; padding-top: 12px; margin-bottom: 0px;\"";
                                }
                                if (isset($_SESSION["login"])) {
                                    echo "onclick=\"logged()\"";
                                } else {
                                    echo "onclick=\"notLog()\"";
                                }
                            ?>
                            href="#" >
                             Đăng tin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar -->

        <!-- Background image -->
        <div class="p-5 bg-image" style="
            background-image: url('./assets/images/bg.jpg');
            height: 400px;
            margin-top: 58px;
          ">
            <div class="mask" style="background-color: rgba(70, 66, 66, 0.6);">
                <form action="" method="POST">
                    <div class="mask1 d-flex flex-column justify-content-start  h-100">
                        <ul id="search-box" class="d-flex">
                            <li value="buyHouse" class="changeBg"  id="buyHouse"><a  href="#">Mua nhà đất</a></li>
                            <li value="rentHouse" class="bgWhite" id="rentHouse"><a  href="#">Cho thuê nhà đất</a></li>
                        </ul>
                        <div class="filter">
                            <div class="input d-flex">
                                <select name="category" id="category">
                                    <option  value="" disabled selected hidden> Loại nhà phố</option>
                                    <option value="lienke"> Nhà phố liền kề</option>
                                    <option value="thuongmai">Nhà phố thương mại </option>
                                    <option value="xanh">Nhà phố xanh</option>
                                    <option value="sanvuon">Nhà phố sân vườn</option>
                                </select>
                                <div class="inputText w-100 d-flex">
                                    <input name="inputText__name" class="w-100 flex-grow-1" id="inputText__name" type="text" placeholder="Nhập tên dự án" >
                                    <input id="btnSearch" name="btnSearch" class="btn btn-danger" type="submit"
                                    <?php
                                        if((!isset($_POST["category"]) && isset($_POST["inputText__name"]) == ' ')|| isset($_POST["location"]) 
                                        && !isset($_POST["rent"]) 
                                        && !isset($_POST["area"]) 
                                        && !isset($_POST["bedrooms"])
                                        && !isset($_POST["toilet"])) {
                                            echo 'disabled';
                                        } else if(isset($_POST["category"]) && isset($_POST["inputText__name"])) {
                                            echo 'enabled';
                                        }
                                    ?> 
                                    value="Tìm kiếm">
                                </div>
                            </div>
                            <span id="requireFill" 
                            <?php if(!isset($_POST["category"]) && isset($_POST["btnSearch"])){
                                echo 'style="display: block;"';
                            }?>>Vui lòng chọn loại nhà phố</span>
                            <div class="filter__infomation d-flex justify-content-between">
                                <select class="selected flex-grow-1" name="location" id="selectLocation">
                                    <option value="" disabled selected hidden>Trên toàn quốc</option>
                                    <?php
                                    // render danh sach cac tinh
                                        $sql = 'SELECT * FROM provinces';
                                        try{
                                            $stmt = $dbCon->prepare($sql);
                                            $stmt->execute();
                                        }
                                        catch(PDOException $ex){
                                            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                                        }
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value=\"$row[name]\">$row[name]</option>";
                                        }
                                    ?>
                                    <!-- End render danh sach cac tinh -->
                                </select>
                                <select class="selected-price selected flex-grow-1" name="rent" id="rent">
                                    <option value="" disabled selected hidden>Mức giá</option>
                                    <option value="allPrice" >Tất cả mức giá</option>
                                    <option value="<500" >Dưới 500 triệu</option>
                                    <option value="500-800" >500 - 800 triệu</option>
                                    <option value="800-1" >800 - 1 tỷ</option>
                                    <option value="1-2" >1 - 2 tỷ</option>
                                    <option value="2-3" >2 - 3 tỷ</option>
                                    <option value="3-5" >3 - 5 tỷ</option>
                                    <option value="5-7" >5 - 7 tỷ</option>
                                    <option value="7-10" >7 - 10 tỷ</option>
                                    <option value="10-20" >10 - 20 tỷ</option>
                                    <option value="20-30" >20 - 30 tỷ</option>
                                    <option value="30-40" >30 - 40 tỷ</option>
                                    <option value="40-60" >40 - 60 tỷ</option>
                                    <option value=">60" >Trên 60 tỷ</option>
                                    <option value="~" >Thỏa thuận</option>
                                </select>
                                <select class="selected-area selected flex-grow-1" name="area" id="area">
                                    <option value="" disabled selected hidden>Diện tích</option>
                                    <option value="allArea" >Tất cả diện tích</option>
                                    <option value="<30" >Dưới 30 m²</option>
                                    <option value="30-50" >30 - 50 m²</option>
                                    <option value="50-80" >50 - 80 m²</option>
                                    <option value="80-100" >80 - 100 m²</option>
                                    <option value="100-150" >100 - 150 m²</option>
                                    <option value="150-200" >150 - 200 m²</option>
                                    <option value="250-300" >250 - 300 m²</option>
                                    <option value="300-500" >300 - 500 m²</option>
                                    <option value=">500" >Trên 500 m²</option>
                                </select>
                                <select class="selected-bedroom selected flex-grow-1" name="bedrooms" id="bedrooms">
                                    <option value="" disabled selected hidden>Số phòng ngủ</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                </select>
                                <select class="selected-toilet selected flex-grow-1" name="toilet" id="toilet">
                                    <option value="" disabled selected hidden>Số nhà WC</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                </select>
                                <div class="refresh">
                                    <img id="refresh__img" src="./assets/images/refresh.png" alt="refresh">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Background image -->

    </header>
    
    <!-- render product -->
    <div id="contentBody" class="container content d-flex">

        <div class="container mt-3">
            <?php 
                if (isset($_GET["value"])) {
                    $sql = 'SELECT * FROM houses Where status = '.'"'.'OK'.'"' . ' AND ' .'type ='.'"'.$_GET["value"].'"';
                } else if(isset($_POST["btnSearch"])) {
                    if(isset($_POST["category"])
                    || (isset($_POST["inputText__name"]) && ($_POST["inputText__name"] != '')) 
                    || isset($_POST["location"]) 
                    || isset($_POST["rent"]) 
                    || isset($_POST["area"]) 
                    || isset($_POST["bedrooms"])
                    || isset($_POST["toilet"])) {
                        $where = ' ';
                        $category = ' ';
                        $and = ' ';
                        $inputText__name = ' ';
                        $location = ' ';
                        $rentt = ' ';
                        $area = ' ';
                        $bedrooms = ' ';
                        $toilet = ' ';
                        
                        if(isset($_POST["category"])) {
                            $and = ' AND ';
                            $category = ' type = '."'".$_POST["category"]."'";
                            $where = 'WHERE';
                        }

                        if(isset($_POST["inputText__name"])) {
                            
                            $inputText__name = $and. ' title LIKE '.'"%'.$_POST["inputText__name"].'%"';
                        }

                        if(isset($_POST["location"])) {
                            $location = $and. ' location LIKE ' .'"%'.$_POST["location"].'%"';
                        }

                        if(isset($_POST["rent"])) {
                            // $rent = 'price > 0';
                            switch ($_POST["rent"]) {
                                case "<500":
                                    $rent = 'price < 0.5';
                                    break;
                                case "500-800":
                                    $rent = 'price >= 0.5 and price <= 0.8';
                                    break;
                                case "800-1":
                                    $rent = 'price >= 0.8 and price <= 1';
                                    break;
                                case "1-2":
                                    $rent = 'price >= 1 and price <= 2';
                                    break;
                                case "2-3":
                                    $rent = 'price >= 2 and price <= 3';
                                    break;
                                case "3-5":
                                    $rent = 'price >= 3 and price <= 5';
                                    break;
                                case "5-7":
                                    $rent = 'price >= 5 and price <= 7';
                                    break;
                                case "7-10":
                                    $rent = 'price >= 7 and price <= 10';
                                    break;
                                case "10-20":
                                    $rent = 'price >= 10 and price <= 20';
                                    break;
                                case "20-30":
                                    $rent = 'price >= 20 and price <= 30';
                                    break;
                                case "30-40":
                                    $rent = 'price >= 30 and price <= 40';
                                    break;
                                case "40-60":
                                    $rent = 'price >= 40 and price <= 60';
                                    break;
                                case "60":
                                    $rent = 'price >= 60';
                                    break;
                                case "~":
                                    $rent = 'price = ' ."'".'thoa thuan' ."'";
                                    break;
                                default:
                                    $rent = 'price > 0';
                            }
                            $rentt = $and. $rent;
                        }

                        if(isset($_POST["area"])) {
                            $area = 'areas > 0';
                            switch ($_POST["area"]) {
                                case "<30":
                                $area = 'areas < 30';
                                    break;
                                case "30-50":
                                $area = 'areas >= 30 and areas <= 50';
                                    break;
                                case "50-80":
                                $area = 'areas >= 50 and areas <= 80';
                                    break;
                                case "80-100":
                                $area = 'areas >= 80 and areas <= 100';
                                    break;
                                case "100-150":
                                $area = 'areas >= 100 and areas <= 150';
                                    break;
                                case "150-200":
                                $area = 'areas >= 150 and areas <= 200';
                                    break;
                                case "250-300":
                                $area = 'areas >= 250 and areas <= 300';
                                    break;
                                case "300-500":
                                $area = 'areas >= 300 and areas <= 500';
                                    break;
                                case ">500":
                                $area = 'areas >= 500 ';
                                    break;
                                default:
                                $area = 'areas > 0';
                            }
                            $area = $and.$area;
                        }

                        if(isset($_POST["bedrooms"])) {
                            $bedrooms = $and. 'bedrooms = ' .$_POST["bedrooms"];
                        }

                        if(isset($_POST["toilet"])) {
                            $toilet = $and. 'bathrooms = '.$_POST["toilet"];
                        }
                        $sql = 'SELECT * FROM houses '.$where .$category .$inputText__name .$location .$rentt .$area .$bedrooms .$toilet;
                        if (!isset($_POST["category"])) {
                            $sql = 'SELECT * FROM houses WHERE type = "none"';
                        }
                    } else {
                        $sql = 'SELECT * FROM houses WHERE type = "none"';
                    }
                } else {
                    $sql = 'SELECT * FROM houses WHERE status = '.'"'.'OK'.'"'. ' ORDER BY id DESC ' ;
                }
                try{
                    $conn = mysqli_connect('localhost', 'root', '');
                    if (!$conn) {
                        die("Connection failed" . mysqli_connect_error());
                    } else {
                        mysqli_select_db($conn, 'cnpm');
                    }

                    //define total number of results you want per page  
                    $results_per_page = 5;

                    //find the total number of results stored in the database  
                    $result = mysqli_query($conn, $sql);
                    $number_of_result = mysqli_num_rows($result);

                    //determine the total number of pages available  
                    $number_of_page = ceil($number_of_result / $results_per_page);

                    //determine which page number visitor is currently on  
                    if (!isset($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }

                    //determine the sql LIMIT starting number for the results on the displaying page  
                    $page_first_result = ($page - 1) * $results_per_page;

                    //retrieve the selected results from database   
                    $query = $sql." LIMIT " . $page_first_result . ',' . $results_per_page;
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($result)) {
                        echo "<div onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                        , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")' 
                        class=\"tagHouse card d-flex flex-row\" style=\"width: 50rem;\">";
                        echo "<div class=\"images d-flex flex-column\">";
                        echo "<img src=\"./assets/images/house/$row[image1]\"alt=\"hinh1\" style=\"height: 190px; width:160px;\">";
                        echo "<div class=\"images__small d-flex mt-1\">";
                        echo "<img src=\"./assets/images/house/$row[image2]\" alt=\"hinh2\" style=\"height: 85px; width:80px;\"> ";
                        echo "<img src=\"./assets/images/house/$row[image3]\" alt=\"hinh3\" style=\"height: 85px; width:80px;\">";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class=\"inf w-100\">";
                        echo "<h4 class=\"name-house\">$row[title]</h4>";
                        echo "<div class=\"inf__main d-flex\">";
                        echo "<span class=\"price mt4\">$row[price]</span>";
                        echo "<span class=\"s ml-26 mt4\">$row[areas]</span>";
                        echo "<span class=\"numBedroom ml-26\">$row[bedrooms] <img src=\"./assets/images/bedroom.png\" alt=\"bedroom\"></span>";
                        echo "<span class=\"numToilet ml-26\">$row[bathrooms] <img src=\"./assets/images/bathtub.png\" alt=\"bathroom\"></span>";
                        echo "</div>";
                        echo "<span class=\"location\"><i>$row[location]</i></span> <br>";
                        echo "<div class=\"description mt-2\">$row[description]";
                        echo "</div>";
                        echo "<div class=\"contact d-flex mt-3\">";
                        echo "<div class=\"uploadBy flex-grow-1\">";
                        echo "Người đăng: <span id=\"byName\">$row[owner]</span> <br>";
                        echo "Ngày đăng: $row[date]";
                        echo "</div>";
                        echo "<button id=\"btnCall\" class=\"call btn btn-primary flex-grow-1\" >";
                        echo "<img id=\"phone\" src=\"./assets/images/telephone.png\" alt=\"phone\">";
                        echo "<span class=\"callNow\">Liên hệ ngay</span>";
                        echo "<span class=\"phoneNumber\">$row[phone]</span>";
                        echo "</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
            
                    echo '<nav aria-label="Page navigation example">';
                    echo '<ul class="pagination">';
                    echo '<li class="page-item">';
                    echo '<a class="page-link" href="index.php?page=' . ($page - 1) . '" aria-label="Previous">';
                    echo '<span aria-hidden="true">&laquo;</span>';
                    echo '</a>';
                    echo '</li>';
                    for ($page = 1; $page <= $number_of_page; $page++) {
                        echo '<li class="page-item"><a class="page-link" href = "index.php?page=' . $page . '">' .  $page . ' </a></li>';
                    }
                    echo '<li class="page-item">';
                    $pageNow = 1;
                    if (isset($_GET["page"])) {
                        $pageNow = $_GET["page"];
                    }
                    echo '<a class="page-link" href="index.php?page=' . ($pageNow + 1) . '" aria-label="Next">';
                    echo '<span aria-hidden="true">&raquo;</span>';
                    echo '</a>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</nav>';
                }
                catch(PDOException $ex){
                    die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                }
            ?>
            <!-- End render product -->
        </div> 

        <!-- Trigger submit form-->

        <form id="triggerForm" style="display: none;" action="" method="POST">
            <input type="text" name="infHouseId" id="infHouseId" value="">
            <input type="text" name="infHouseName" id="infHouseName" value="">
            <input type="text" name="img1" id="img1" value="">
            <input type="text" name="img2" id="img2" value="">
            <input type="text" name="img3" id="img3" value="">
            <input type="text" name="owner" id="owner" value="">
            <input type="text" name="phoneContact" id="phoneContact" value="">
            <input type="submit" value="triggerSumit" name="triggerSumit">
        </form>

        <!-- End trigger submit form -->

        <div class="filter__fast">
            <div class="card" style="width: 18rem; height: fit-content; margin-top: 32px">
            <div class="card-header">
                DANH MỤC NHÀ PHỐ
            </div>
            <ul class="list-group list-group-flush">
                <?php
                    $sql = 'SELECT * FROM type_house';
                    try{
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute();
                    }
                    catch(PDOException $ex){
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class=\"list-group-item\"><a style=\"text-decoration: none;\" href=\"index.php?value=$row[type]\">$row[name]</a></li>";
                    }
                ?>
            </ul>
            </div>

            <div class="card" style="width: 18rem; height: fit-content; margin-top: 92px">
            <div class="card-header">
                DANH SÁCH DỰ ÁN
            </div>
            <ul class="list-group list-group-flush">
                <?php
                    $sql = 'SELECT * FROM project_houses';
                    try{
                        $stmt = $dbCon->prepare($sql);
                        $stmt->execute();
                    }
                    catch(PDOException $ex){
                        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class=\"list-group-item\"><a style=\"text-decoration: none;\" href=\"?project-house=$row[id]\">$row[name]</a></li>";
                    }
                ?>
            </ul>
            </div>
        </div>
        
    </div>

    <!-- Footer -->
  <footer class="text-center text-lg-start text-white" style="background-color: #2e3031">
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
              Nhapho.com
            </h6>
            <p>
              Website mua bán các loại hình nhà mặt phố đa dạng với giá cả cạnh tranh.
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">DANH MỤC</h6>
            <p>
              <a class="text-white text-decoration-none">Nhà phố liền kề</a>
            </p>
            <p>
              <a class="text-white text-decoration-none">Nhà phố thương mại</a>
            </p>
            <p>
              <a class="text-white text-decoration-none">Nhà phố xanh</a>
            </p>
            <p>
              <a class="text-white text-decoration-none">Nhà phố sân vườn</a>
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
              Các liên kết
            </h6>
            <p>
              <a style="text-decoration: none;" href="index.php" class="text-white">Trang chủ</a>
            </p>
            <p>
              <a style="text-decoration: none;" href="#" class="text-white">Hỗ trợ</a>
            </p>
          </div>

          <!-- Grid column -->
          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Liên hệ</h6>
            <p><i class="fas fa-home mr-3"></i> 19 Nguyễn Hữu Thọ, P.Tân Phong, Q7, TPHCM</p>
            <p><i class="fas fa-envelope mr-3"></i> nhapho@gmail.com</p>
            <p><i class="fas fa-phone mr-3"></i> + 072 3879 999</p>
          </div>
          <!-- Grid column -->
        </div>
        <!--Grid row-->
      </section>
      <!-- Section: Links -->

      <hr class="my-3">

      <!-- Section: Copyright -->
      <section class="p-3 pt-0">
        <div class="row d-flex">
          <!-- Grid column -->
          <div style="width: fit-content;" class="col-md-7 col-lg-8 text-center text-md-start">
            <!-- Copyright -->
            <div  class="p-3 ">
              © 2022 Copyright:
              <a class="text-white" href="index.php">Nhapho.com</a>
            </div>
            <!-- Copyright -->
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="justify-content-between d-flex col-md-5 col-lg-4 ml-lg-0 text-center text-md-end flex-grow-1">
            <div style="width: fit-content;" class="img__tick">
                <img id="img__tick" src="./assets/images/dathongbao.png" alt="">
            </div>
            <div class="social__media">
                <!-- Facebook -->
                <a href="https://www.facebook.com/khanhduy0122/" target="_blank" class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                    class="fab fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                    class="fab fa-twitter"></i></a>

                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                    class="fab fa-google"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                    class="fab fa-instagram"></i></a>
            </div>
           
          </div>
          <!-- Grid column -->
        </div>
      </section>
      <!-- Section: Copyright -->
    </div>
    <!-- Grid container -->
  </footer>
  <!-- Footer -->
    
</body>

<script src="./assets/js/validate.js"></script>
<script src="./assets/js/validateSignIn.js"></script>
<script src="./assets/js/changePass.js"></script>
<!-- <script src="./assets/js/signOut.js"></script> -->
<script src="./assets/js/clickLogo.js"></script>
<script src="./assets/js/handleProjectHouse.js"></script>
<script src="./assets/js/handleResetFilter.js"></script>
<script src="./assets/js/categoryChange.js"></script>
<script src="./assets/js/triggerForm.js"></script>
<script src="./assets/js/Post.js"></script>

</html>