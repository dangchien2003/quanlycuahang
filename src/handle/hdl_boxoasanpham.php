<?php
    require_once 'helper.php';
    if (checkRequest($_GET , ["idsp", "action"])) {
        if(strtolower($_GET['action']) == "recall") {
            $sql = "UPDATE sanpham set xoaluc = NULL where idsp = ?";
            $update = query_input($sql, [$_GET['idsp']]);
            if($update) {
                header("Location: ../page/thongtinsanpham.php?status=200&message=Đã thu hồi sản phẩm&id=".$_GET['idsp']);
                exit();
            }else {
                header("Location: ../page/thongtinsanpham.php?status=400&message=Lỗi thu hồi&id=".$_GET['idsp']);
                exit();
            }
        }else {
            header("Location: ../page/thongtinsanpham.php?status=300&message=Hành động không xác định&id=".$_GET['idsp']);
            exit();
        }
    } else {
        header("Location: ../page/dssanpham.php?status=400&message=Không xác định");
        exit();
    }
?> 