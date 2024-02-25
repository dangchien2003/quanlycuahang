<?php
    require_once 'helper.php';
    if (checkRequest($_GET , ["malk", "action"])) {
        if(strtolower($_GET['action']) == "recall") {
            $sql = "UPDATE linhkien set xoaluc = NULL where malinhkien = ?";
            $update = query_input($sql, [$_GET['malk']]);
            if($update) {
                header("Location: ../page/thongtinlinhkien.php?status=200&message=Đã thu hồi sản phẩm&malk=".$_GET['malk']);
                exit();
            }else {
                header("Location: ../page/thongtinlinhkien.php?status=400&message=Lỗi thu hồi&malk=".$_GET['malk']);
                exit();
            }
        }else {
            header("Location: ../page/thongtinlinhkien.php?status=300&message=Hành động không xác định&malk=".$_GET['malk']);
            exit();
        }
    } else {
        header("Location: ../page/dslinhkien.php?status=400&message=Không xác định");
        exit();
    }
?> 