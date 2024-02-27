<?php
include 'helper.php';
add();
function add() {
try {

    if (checkRequest($_POST, ["malk", "tenlk"])) {
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
        $sql = "INSERT into linhkien(malinhkien, tenlinhkien, chiso, congdung, soluong, giaban, trangthai, thongtinkhac, giamgia, gianhap, taoluc) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $add = query_input($sql, [$ma, $ten, $chiso, $congdung, $sl, $giaban, $trangthai, $ttkhac, $giamgia, $gianhap, $taoluc]);
        if ($add) {
            $name_file = uploadIMG("LK");
            
            if ($name_file) {
                $sql = "UPDATE linhkien set anh = ? where taoluc = ?";
                $update = query_input($sql, [$name_file, $taoluc]);
                if (!$update) {
                    header("Location: ../page/themlinhkien.php?status=200&message=Thành công và không thể lưu ảnh DB&malk=".$taoluc);
                }
            }
            header("Location: ../page/thongtinlinhkien.php?status=200&message=Đã tạo thành công&malk=".$taoluc);
        } else {
            header("Location: ../page/themlinhkien.php?status=400&message=Có thể mã linh kiện đã tồn tại");
        }

    } else {
        header("Location: ../page/themlinhkien.php?status=400&message=Điền tên sản phẩm");
    }
} catch (Exception $e) {
    log_error($e->getMessage());
    header("Location: ../page/themlinhkien.php?status=400&message=Có lỗi xảy ra");
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