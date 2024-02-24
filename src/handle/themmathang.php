<?php
include 'helper.php';
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
        $ttkhac = "";
        $taoluc = getTimestamp(0);
        
        $sql = "INSERT into sanpham(tensp, phanloai, hangsx, loaisp, soluong, giaban, trangthai, thongtinkhac, giamgia, gianhap, taoluc) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $add = query_input($sql, [$ten, $phanloai, $hang, $loaihang, $sl, $giaban, $trangthai, $ttkhac, $giamgia, $gianhap, $taoluc]);
        if ($add) {
            $name_file = uploadIMG();
            if ($name_file) {
                $sql = "UPDATE sanpham set anhsp = ? where taoluc = ?";
                $update = query_input($sql, [$name_file, $taoluc]);
                if (!$update) {
                    header("Location: ../page/themmathang.php?status=200&message=Thành công và không thể lưu ảnh DB");
                }
            }
            header("Location: ../page/themmathang.php?status=200&message=Đã tạo thành công");
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

function uploadIMG()
{
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["anhsp"])) {
        print_r($_FILES["anhsp"]);
        

        $file_name = $_FILES['anhsp']['name'];
        $path_info = pathinfo($file_name);
        $imageFileType = strtolower($path_info['extension']);

        $target_dir = "../../public/image/uploads/";  // Thư mục nơi bạn muốn lưu trữ tệp tin
        $file_name = "SP" . getTimestamp(0).".".$imageFileType;
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;

        
        // Kiểm tra xem tệp tin đã tồn tại chưa
        // if (file_exists($target_file)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Kiểm tra kích thước tệp tin (giả sử giới hạn là 5MB)
        if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
            $uploadOk = 0;
        }

        // Cho phép các định dạng file nhất định (ở đây là chỉ cho phép hình ảnh)
        $allowedFormats = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedFormats)) {
            $uploadOk = 0;
        }

        // Kiểm tra xem $uploadOk có bằng 0 không (có lỗi xảy ra không)
        if ($uploadOk) {
            // Nếu mọi thứ đều đúng, thì tiến hành tải lên
            if (move_uploaded_file($_FILES["anhsp"]["tmp_name"], $target_file)) {
                return $file_name;
            }
        } else {
            echo "upload error";
            return null;
        }
    }
}
?>