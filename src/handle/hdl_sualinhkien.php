<?php
require_once 'helper.php';
if (checkRequest($_POST, ["malk"]) && checkRequest($_GET, ["malk"])) {
    if ($_POST["malk"] != $_GET['malk']) {
        header('location: ../page/dslinhkien.php?status=400&message=Sản phẩm không trùng khớp');
    } else {
        if (checkRequest($_POST, ["tenlk", "malk"])) {
            $ma = $_POST['malk'];
            $ten = $_POST['tenlk'];
            $chiso = $_POST['chiso']??NULL;
            $congdung = $_POST['congdung']??NULL;
            $sl = $_POST['sl'] ?? 0;
            $giaban = $_POST['giaban'] ?? 0;
            $gianhap = $_POST['gianhap'] ?? 0;
            $giamgia = $_POST['giamgia'] ?? 0;
            $trangthai = $_POST['trangthai'] ?? 2;
            $ttkhac = $_POST['ttkhac'] ?? NULL;
            $taoluc = getTimestamp(0);

            $sql = "UPDATE linhkien set tenlinhkien = ?, chiso = ?, congdung = ?, soluong = ?, giaban = ?, trangthai = ?, thongtinkhac = ?, giamgia = ?, gianhap = ? where malinhkien = ?";

            $update = query_input($sql, [$ten, $chiso, $congdung, $sl, $giaban, $trangthai, $ttkhac, $giamgia, $gianhap, $_POST['malk']]);
            if ($update) {
                $name_file = uploadIMG("LK");
                if ($name_file) {
                    $sql = "UPDATE linhkien set anh = ? where malinhkien = ?";
                    $update = query_input($sql, [$name_file, $_POST['malk']]);
                    if (!$update) {
                        header("Location: ../page/thongtinlinhkien.php?status=200&message=Thành công và không thể lưu ảnh DB&malk=".$_GET['malk']);
                    }else {
                        $remove_file = remove_img($_POST['tenanh']);
                        if(!$remove_file) {
                            header("Location: ../page/thongtinlinhkien.php?status=200&message=Đã Sửa thành công nhưng lỗi xoá ảnh&malk=".$_GET['malk']);
                        }
                    }
                }
                header("Location: ../page/thongtinlinhkien.php?status=200&message=Đã Sửa thành công&malk=".$_GET['malk']);
            } else {
                header("Location: ../page/thongtinlinhkien.php?status=400&message=Sửa thất bại&malk=".$_GET['malk']);
            }

        } else {
            header("Location: ../page/thongtinlinhkien.php?status=400&message=Điền tên sản phẩm&malk=" . $_GET['malk']);
        }
    }
} else {
    header('location: ../page/dslinhkien.php?status=400&message=Sản phẩm không trùng khớp');
}

function getSelect($tenc, $tenp, $colum = "", $table = "")
{
    try {
        if ($_POST[$tenc] == 0) {
            return $_POST[$tenp];
        } else {
            return $_POST[$tenc];
        }
    } catch (Exception $e) {
        log_error("ERROR getSelect()_" . $e->getMessage());
    }



}

function getThongTinKhac()
{
    if (checkRequest($_POST, ["ttkhac"])) {
        //
    }
}

?>