<?php
require_once('./api/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Admin</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark ">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <img id="logo" src="./assets/images/logo.png" alt="logo">

                <ul class="effect navbar-nav">
                    <li class="nav-item">
                        <a id="OptionAP" class="nav-link active" aria-current="page" href="#">Duyệt bài đăng</a>
                    </li>
                    <li class="nav-item">
                        <a id="managerUser" class="nav-link" href="#">Quản lý tài khoản</a>
                    </li>
                </ul>
            </div>
            <div>
                <ul id="option__admin">
                    <span id="helloAdmin">Xin chào, <span id="nameAdmin"> admin</span></span>
                    <li><a id="signOut" href="./logout.php">Đăng xuất</a></li>
                </ul>
            </div>
        </div>

    </nav>

    <div class="body container">

        <!-- Table accept post -->
        <table id="tableAcceptPost" class="table table-dark table-hover">
            <tr style="text-align: center;">
                <td>#</td>
                <td>Ngày đăng</td>
                <td>Đăng bởi</td>
                <td>Số điện thoại</td>
                <td>Trạng thái</td>
                <td>Thao tác</td>
            </tr>
            <?php
            $sql = 'SELECT * FROM houses WHERE status = ' . "'" . 'processing' . "'";

            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
                // die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }


            $i = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr style=\"text-align: center;\">";

                echo "<td onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")' 
                >$i</td>";

                echo "<td onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")'
                >$row[date]</td>";

                echo "<td onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")'
                >$row[owner]</td>";

                echo "<td onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")'
                >$row[phone]</td>";

                echo "<td onclick='autoSubmit(\"" . $row["id"] . "\" , \"" . $row["title"] . "\", \"" . $row["image1"] . "\"
                , \"" . $row["image2"] . "\" , \"" . $row["image3"] . "\" , \"" . $row["owner"] . "\", \"" . $row["phone"] . "\")'
                >chờ duyệt</td>";
                
                echo "<td>";
                echo "<a id=\"btnAccept\" class=\"mr6\" href=\"#\" onclick=(getValue($row[id])) >Duyệt</a>";
                echo "<a id=\"btnDel\" href=\"#\" onclick=(goDelete($row[id])) >Xóa</a>";
                echo "</td>";
                echo "</tr>";
                $i = $i + 1;
            }
            ?>
        </table>

        <!-- Table accept post -->

        <!-- Table manage users -->

        <table id="tableUsers" class="table table-dark table-hover">
            <tr style="text-align: center;">
                <td>#</td>
                <td>Email</td>
                <td>Mật khẩu</td>
                <td>Tên người dùng</td>
                <td>Thao tác</td>
            </tr>
            <?php
            $j = 1;
            $sql = 'SELECT * FROM users WHERE email != ' . "'" . 'admin@gmail.com' . "'";

            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
                die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            }


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr  style=\"text-align: center;\">";
                echo "<td>$i</td>";
                echo "<td>$row[email]</td>";
                echo "<td>$row[password]</td>";
                echo "<td>$row[name]</td>";
                echo "<td>";
                echo "<a class=\"mr6\" href=\"#\" onclick=(getUpate(\"" . $row["email"] . "\")) >Đặt lại mật khẩu</a>";
                echo "<a href=\"#\" onclick=(goDeleteUser(\"" . $row["email"] . "\"))>Xóa</a>";
                echo "</td>";
                echo "</tr>";
                $j = $j + 1;
            }
            ?>
        </table>
        <!-- End table manage users -->
    </div>

    <!-- Show infHouse -->
    <?php
    if (
        isset($_POST["infHouseId"]) && isset($_POST["infHouseName"]) && isset($_POST["img1"])
        && isset($_POST["img2"]) && isset($_POST["img3"]) && isset($_POST["owner"]) && isset($_POST["phoneContact"])
    ) {
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
            <img id="x" src="./assets/images/close.png" alt="x">
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
                        <button id="btnCallOwner" class="call btn btn-primary flex-grow-1">
                            <img id="phone" src="./assets/images/telephone.png" alt="phone">
                            <span class="callNow">Liên hệ ngay</span>
                            <span class="phoneNumber"><?php echo $_POST["phoneContact"] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="body container">
            <h3 class="mt16"><?php echo $_POST["infHouseName"] ?></h3>
            <?php
            $sql = 'SELECT * FROM houses WHERE id = ' . "'" . $id . "'";

            try {
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
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

    <form style="display: none;" id="formTrigger" action="./accept_Del_Post.php" method="POST">
        <input type="text" id="idPOST" name="idPOST" value="">
    </form>

    <form style="display: none;" id="formTriggerDelete" action="./accept_Del_Post.php" method="POST">
        <input type="text" id="idDelete" name="idDelete" value="">
    </form>

    <form style="display: none;" id="formTriggerDeleteUser" action="./delete_updateUser.php" method="POST">
        <input type="text" id="emailUser" name="emailUser" value="">
    </form>

    <form style="display: none;" id="formTriggerUserUpdate" action="./delete_updateUser.php" method="POST">
        <input type="text" id="emailUserUpdate" name="emailUserUpdate" value="">
    </form>

</body>

<script src="./assets/js/admin.js"></script>

<script>
    function getValue(id) {
        $('idPOST').value = id
        $('formTrigger').submit()
    }

    function goDelete(id) {
        $('idDelete').value = id
        $('formTriggerDelete').submit()
    }

    function goDeleteUser(email) {
        $('emailUser').value = email
        $('formTriggerDeleteUser').submit()
    }

    function getUpate(email) {
        $('emailUserUpdate').value = email
        $('formTriggerUserUpdate').submit()
    }
</script>

</html>