<?php
include_once 'helper.php';
function checkUserPassword($user, $password, $info) {
    $sql = "select trangthai from taikhoan where tendangnhap=? and matkhau = ?";
    $result = query_input($sql, [$user, $password]);
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        switch($row['trangthai']) {
            case 9: 
                return ["login" => true, "message" =>""];
            case 8:
                return ["login" => false, "message" =>"Tài khoản đã bị khoá"];
            case 10:
                return ["login" => false, "message" =>"Tài khoản đang trong quá trình chờ duyệt"];
            default: 
                return ["login" => false, "message" =>"Tài khoản không xác định"];
        }
    }else {
        return ["login" => false, "message" =>"Tài khoản hoặc mật khẩu không chính xác"];
    }
}

?> 