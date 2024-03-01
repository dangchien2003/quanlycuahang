<?php
require_once 'helper.php';
if (checkRequest($_POST, ["idsp"]) && checkRequest($_GET, ["idsp"])) {
    if ($_POST["idsp"] != $_GET['idsp']) {
        header('location: ../page/dssanpham.php?status=400&message=Sản phẩm không trùng khớp');
    } else {
        if (checkRequest($_POST, ["tensp"])) {
            $ten = $_POST['tensp'];
            $hang = getSelect("hang", "tenhang");

            $sl = cover_price($_POST['sl']) ?? 0;
            $loaihang = $_POST['loaihang'] ?? 1;
            $phanloai = getSelect("phanloai", "phanloaikhac");
            $giaban = cover_price($_POST['giaban']) ?? 0;
            $gianhap = cover_price($_POST['gianhap']) ?? 0;
            $giamgia = $_POST['giamgia'] ?? 0;
            $trangthai = $_POST['trangthai'] ?? 2;
            $ttkhac = $_POST['ttkhac']??"";
            $taoluc = getTimestamp(0);

            $sql = "update sanpham set tensp = ?, phanloai = ?, hangsx = ?, loaisp = ?, soluong = ?, giaban = ?, trangthai = ?, thongtinkhac = ?, giamgia = ?, gianhap = ? where idsp = ?";

            $update = query_input($sql, [$ten, $phanloai, $hang, $loaihang, $sl, $giaban, $trangthai, $ttkhac, $giamgia, $gianhap, $_POST['idsp']]);
            if ($update) {
                $name_file = uploadIMG("SP");
                if ($name_file) {
                    $sql = "UPDATE sanpham set anhsp = ? where idsp = ?";
                    $update = query_input($sql, [$name_file, $_POST['idsp']]);
                    if (!$update) {
                        header("Location: ../page/thongtinsanpham.php?status=200&message=Thành công và không thể lưu ảnh DB&id=".$_GET['idsp']);
                    }else {
                        $remove_file = remove_img($_POST['tenanh']);
                        if(!$remove_file) {
                            header("Location: ../page/thongtinsanpham.php?status=200&message=Đã Sửa thành công nhưng lỗi xoá ảnh&id=".$_GET['idsp']);
                        }
                    }
                }
                header("Location: ../page/thongtinsanpham.php?status=200&message=Đã Sửa thành công&id=".$_GET['idsp']);
            } else {
                header("Location: ../page/thongtinsanpham.php?status=400&message=Sửa thất bại&id=".$_GET['idsp']);
            }

        } else {
            header("Location: ../page/thongtinsanpham.php?status=400&message=Điền tên sản phẩm&id=" . $_GET['idsp']);
        }
    }
} else {
    header('location: ../page/dssanpham.php?status=400&message=Sản phẩm không trùng khớp');
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