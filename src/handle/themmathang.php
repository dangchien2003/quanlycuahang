<?php
include 'helper.php';
add();
function add() {
try {

    if (checkRequest($_POST, ["tensp"])) {
        $ten = $_POST['tensp'];
        $hang = getSelect("hang", "tenhang");

        $sl = $_POST['sl'] ?? 0;
        $loaihang = $_POST['loaihang'] ?? 1;
        $phanloai = getSelect("phanloai", "phanloaikhac");
        $giaban = $_POST['giaban'] ?? 0;
        $gianhap = $_POST['gianhap'] ?? 0;
        $giamgia = $_POST['giamgia'] ?? 0;
        $trangthai = $_POST['trangthai'] ?? 2;
        $ttkhac = $_POST['ttkhac']??NULL;
        $taoluc = getTimestamp(0);
        
        $sql = "INSERT into sanpham(tensp, phanloai, hangsx, loaisp, soluong, giaban, trangthai, thongtinkhac, giamgia, gianhap, taoluc) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $add = query_input($sql, [$ten, $phanloai, $hang, $loaihang, $sl, $giaban, $trangthai, $ttkhac, $giamgia, $gianhap, $taoluc]);
        if ($add) {
            $name_file = uploadIMG("SP");
            
            if ($name_file) {
                $sql = "UPDATE sanpham set anhsp = ? where taoluc = ?";
                $update = query_input($sql, [$name_file, $taoluc]);
                if (!$update) {
                    header("Location: ../page/thongtinsanpham.php?status=200&message=Thành công và không thể lưu ảnh DB&id=".$taoluc);
                }
            }
            header("Location: ../page/thongtinsanpham.php?status=200&message=Đã tạo thành công&id=".$taoluc);
        } else {
            header("Location: ../page/themmathang.php?status=400&message=Tạo thất bại");
        }

    } else {
        header("Location: ../page/themmathang.php?status=400&message=Điền tên sản phẩm");
    }
} catch (Exception $e) {
    log_error($e->getMessage());
    header("Location: ../page/themmathang.php?status=400&message=Có lỗi xảy ra");
}
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
        log_error("ERROR getSelect()_". $e->getMessage());
    }



}

function getThongTinKhac()
{
    if (checkRequest($_POST, ["ttkhac"])) {
        //
    }
}
?>