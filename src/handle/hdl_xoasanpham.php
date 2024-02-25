<?php
require_once 'helper.php';
if (checkRequest($_GET, ["idsp", "action"])) {
    // select 
    if (strtolower($_GET['action']) != "delete") {
        header("Location: ../page/dssanpham.php?status=400&message=Lỗi hành động");
        exit();
    }
    $haveItem = false;
    $name_img = "";
    $sql = "SELECT anhsp from sanpham where idsp = ?";
    $result = query_input($sql, [$_GET['idsp']]);
    if ($result->num_rows) {
        $haveItem = true;
        $name_img = $result->fetch_assoc()['anhsp'];
    }
    // xoá ảnh
    $remove_img_ok = remove_img($name_img);
    
    $return_message = "";
    if (!$remove_img_ok) {
        $return_message .= "Lỗi xoá ảnh";
    } else {
        $return_message .= "Đã xoá ảnh";
        $name_img = null;
    }

    
    if (!$remove_item_ok) {
        $return_message .= " và không thể xoá dữ liệu";
    } else {
        $return_message .= " và đã xoá dữ liệu";
    }

    // xoá db
    $sql = "update sanpham set xoaluc = ?, anhsp = ? where idsp = ?";
    $remove_item_ok = query_input($sql, [strval(getTimestamp(0)), $name_img, $_GET['idsp']]);
    

    if ($remove_img_ok || $remove_item_ok) {
        header("Location: ../page/dssanpham.php?status=200&message=" . $return_message);
        exit();
    } else {
        header("Location: ../page/dssanpham.php?status=400&message=Không thể xoá");
        exit();
    }
}




?>