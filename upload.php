<?php
if (isset($_POST["uploading"])) {

    require_once('./api/connection.php');
    if (
        $_POST["tc"] != '' && $_POST["lh"] != '' && $_POST["full_name"] != '' && $_POST["priceSell"] != ''
        && $_POST["dt"] != '' && $_POST["vt"] != '' && $_POST["ln"] != '' && $_POST["mt"] != ''
        && $_POST["h1"] != '' && $_POST["h2"] != '' && $_POST["h3"] != '' && ($_POST["nbed"] != '0')
        && ($_POST["nbath"] != '0') && ($_POST["dateUp"] != '0000-00-00')
    ) {

        // Change format date to yyyy/mm/dd
        $date = $_POST["dateUp"];
        $dateUp = explode('-', $date);
        $d = $dateUp[2];
        $m = $dateUp[1];
        $y = $dateUp[0];
        $resultDate = $y . '-' . $m . '-' . $d;

        $sql = 'INSERT INTO houses (title, price, areas, bedrooms, bathrooms, 
        location, description, owner, date, phone, image1, image2, image3, type)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        try {
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array(
                $_POST['full_name'], $_POST["priceSell"], $_POST["dt"], $_POST["nbed"], $_POST["nbath"], $_POST["vt"], $_POST["mt"], $_POST["tc"], $resultDate, $_POST["dt"], $_POST["h1"], $_POST["h2"], $_POST["h3"],
                $_POST["ln"]
            ));

            // header("Location: index.php");
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Đăng tin thành công vui lòng chờ admin phê duyệt!")';
            echo '</script>';
            echo '<script type ="text/JavaScript">';
            echo 'window.location = "./index.php"';
            echo '</script>';
        } catch (PDOException $ex) {
            // die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
            echo '<script type ="text/JavaScript">';
            echo 'let a = alert("Đăng tin thất bại vui lòng thử lại! Chú ý: một số bài đăng có thể không được duyệt do thiếu một số thông tin cần thiết")';
            echo '</script>';
        }
    } else {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Đăng tin thất bại vui lòng thử lại! Chú ý: một số bài đăng có thể không được duyệt do thiếu một số thông tin cần thiết")';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/upload.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-2 text-center">Đăng tin</h1>
        <form action="" method="POST">
            <div class="aboutOwner mb8">
                <span class="seller">
                    Thông tin người đăng tin
                </span>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="tc" name="tc" placeholder="Nhập vào tên của bạn">
                </div>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="lh" name="lh" placeholder="Nhập vào số điện thoại">
                </div>

            </div>

            <div class="aboutHome">
                <span class="moreInf">
                    Thông tin chi tiết
                </span>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="full_name_house" name="full_name" placeholder="Nhập vào tên nhà phố">
                </div>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="priceSell" name="priceSell" placeholder="Nhập vào giá bán">
                </div>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="dt" name="dt" placeholder="Nhập vào diện tich">
                </div>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="vt" name="vt" placeholder="Nhập vào vị trí của căn nhà">
                </div>

                <div class="form-group mt8">
                    <!-- <input type="text" class="form-control" id="ln" name="ln" placeholder="Nhập vào loại nhà phố"> -->
                    <select class="w-100" name="ln" id="ln">
                        <option value="" disabled selected hidden> Loại nhà phố</option>
                        <option value="lienke"> Nhà phố liền kề</option>
                        <option value="thuongmai">Nhà phố thương mại </option>
                        <option value="xanh">Nhà phố xanh</option>
                        <option value="sanvuon">Nhà phố sân vườn</option>
                    </select>
                </div>



                <div class="form-group mt8">
                    <input type="text" class="form-control" id="nbed" name="nbed" placeholder="Nhập vào số phòng ngủ">
                </div>

                <div class="form-group mt8">
                    <input type="text" class="form-control" id="nbath" name="nbath" placeholder="Nhập vào số nhà tắm">
                </div>

                <div class="form-group mt8">
                    <textarea id="mt" style="width: 100%; outline: blue" rows="5" cols="60" name="mt" placeholder="Nhập mô tả chi tiết"></textarea>
                </div>


            </div>

            <span class="imgH">
                Ảnh mô tả
            </span>

            <div class="form-group mt8">
                <input type="text" class="form-control" id="h1" name="h1" placeholder="Hình 1">
            </div>

            <div class="form-group mt8">
                <input type="text" class="form-control" id="h2" name="h2" placeholder="Hình 2">
            </div>

            <div class="form-group mt8">
                <input type="text" class="form-control" id="h3" name="h3" placeholder="Hình 3">
            </div>

            <label class="mt8 w-100" for="dateUp">Ngày đăng: <br>
                <input class="w-100" type="date" id="dateUp" name="dateUp">
            </label>

            <div style="margin-top: 16px;" class="form-group">
                <button type="submit" name="uploading" class="btn btn-primary">Đăng tin</button>
            </div>

        </form>
        <div class="scroll-top">
            <button id="goMainPage" class="btn btn-danger">Về trang chủ</button>
        </div>
    </div>

</body>

<script>
    const goMainPage = document.getElementById('goMainPage')

    function goMain() {
        var dirPath = dirname(location.href);
        fullPath = dirPath + "/index.php";
        window.location = fullPath;
    }

    function dirname(path) {
        return path.replace(/\\/g, '/').replace(/\/[^\/]*$/, '');
    }
    goMainPage.addEventListener('click',goMain)
</script>

</html>