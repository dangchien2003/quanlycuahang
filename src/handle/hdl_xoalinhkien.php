<?php
require_once 'helper.php';
if (checkRequest($_GET, ["malk", "action"])) {
    // select 
    if (strtolower($_GET['action']) != "delete") {
        header("Location: ../page/dslinhkien.php?status=400&message=Lỗi hành động");
        exit();
    }
    $haveItem = false;
    $name_img = "";
    $sql = "SELECT anh from linhkien where malinhkien = ?";
    $result = query_input($sql, [$_GET['malk']]);
    if ($result->num_rows) {
        $haveItem = true;
        $name_img = $result->fetch_assoc()['anh'];
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


    // xoá db
    $sql = "update linhkien set xoaluc = ?, anh = ? where malinhkien = ?";
    $remove_item_ok = query_input($sql, [strval(getTimestamp(0)), $name_img, $_GET['malk']]);
    
    
    if (!$remove_item_ok) {
        $return_message .= " và không thể xoá dữ liệu";
    } else {
        $return_message .= " và đã xoá dữ liệu";
    }
    

    if ($remove_img_ok || $remove_item_ok) {
        header("Location: ../page/dslinhkien.php?status=200&message=" . $return_message);
        exit();
    } else {
        header("Location: ../page/dslinhkien.php?status=400&message=Không thể xoá");
        exit();
    }
}else {
    header("Location: ../page/dslinhkien.php?status=400&message=Không thấy thông tin");
        exit();
}




?>