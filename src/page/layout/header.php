<?php
include '../handle/helper.php';
include "../handle/checkAccount.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="../../public/image/icon/<?php echo get_ENV()["logo"] ?>?v=<?php echo filemtime('../../public/image/icon/' . get_ENV()["logo"]) ?>"
        type="image/png">
    <title>Quản lý cửa hàng</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/calc.css?v=<?php echo filemtime('../../public/css/calc.css') ?>">
    <link rel="stylesheet" href="../../public/css/style.css?<?php echo filemtime('../../public/css/style.css') ?>">
    <link rel="stylesheet" href="../../public/css/style2.css?v=<?php echo filemtime('../../public/css/style2.css') ?>">
    <link rel="stylesheet" href="../../public/css/search.css?v=<?php echo filemtime('../../public/css/search.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/toast.css?v=<?php echo filemtime('../../public/css/toast.css') ?>">
    <?php
    error_reporting(0);
    function addStyle($name)
    {
        foreach ($name as $style) {
            echo '<script src="' . '../../public/js/' . $style . '.css"></script>';
        }
    }
    ?>
</head>

<body>

    <div id="toast"></div>
    <?php include 'calc.php' ?>

    <header class="text-white ">
        <div class="logo"><img src="../../public/image/icon/<?php echo get_ENV()["logo"] ?>" alt=""></div>
        <div class="menu ">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                    </a>
                    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                        <div class="navbar-nav" style="font-weight: 500;">
                            <a class="nav-link active text-white" aria-current="page"
                                href="<?php echo get_ENV()["linkSupport"] ?>" target="_blank"><i
                                    class="bi bi-telephone-forward-fill p-1 fs-5"></i>Điện thoại hỗ trợ:
                                <?php echo get_ENV()["sdt"] ?>
                            </a>

                            <!-- <a class="nav-link text-white" href="thongtincanhan.php"><img
                                    src="../../public/image/bg-login.jfif" alt=""></a> -->
                            <a class="nav-link text-white" href="doimatkhau.php">Đổi mật khẩu</a>
                            <a class="nav-link text-white" href="dangnhap.php"><i class="fa-solid fa-power-off"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>