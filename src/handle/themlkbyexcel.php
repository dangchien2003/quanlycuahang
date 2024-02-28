<?php
require_once "helper.php";
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$excel_name = upload();

if ($excel_name) {
    $target_dir = "./";
    $filePath = $target_dir . $excel_name;
    $inserted_row = insert($filePath);
    $return_status = 200;
    $return_message = "";
    if(!$inserted_row) {
        $return_status = 400;
        $return_message.= "Không thể thêm (Mã, Tên, Trạng thái là bắt buộc)";
    }
    else if($inserted_row == -1) {
        $return_status = 400;
        $return_message.= "Không có dữ liệu thêm";
    }
    else {
        $return_message.= "Đã thêm $inserted_row linh kiện";
    }
    if(!remove_file($filePath)) {
        $return_message.= " và không thể xoá file";
    }

    header("Location: ../page/themlinhkien.php?status=$return_status&message=$return_message");
}else {
    header("Location: ../page/themlinhkien.php?status=400&message=Không thể lưu file");
}

function upload($kyhieuanh = "excel")
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {


        $file_name = $_FILES['file']['name'];
        $path_info = pathinfo($file_name);
        $FileType = strtolower($path_info['extension']);

        $target_dir = "./";  // Thư mục nơi bạn muốn lưu trữ tệp tin
        $file_name = $kyhieuanh . getTimestamp(0) . "." . $FileType;
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;

        // Cho phép các định dạng file nhất định (ở đây là chỉ cho phép hình ảnh)
        $allowedFormats = array("xlsx", "xls");
        if (!in_array($FileType, $allowedFormats)) {
            $uploadOk = 0;
        }

        // Kiểm tra xem $uploadOk có bằng 0 không (có lỗi xảy ra không)
        if ($uploadOk) {
            // Nếu mọi thứ đều đúng, thì tiến hành tải lên
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                return $file_name;
            }
        } else {
            echo "upload error";
            return null;
        }
    }
}

function insert($filePath)
{
    $count_row_insert = 0;
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    if($highestRow <= 4) {
        return -1;
    }
    $sql = "insert into linhkien(malinhkien, tenlinhkien, chiso, congdung, soluong, gianhap, giaban, giamgia, trangthai, thongtinkhac, xoaluc, taoluc) VALUES ";
    $values = [];
    $stop_loop = false;
    for ($row = 5; $row <= $highestRow; $row++) {
        for ($colASII = 65; $colASII <= 75; $colASII++) {
            $col = chr($colASII);
            $cellValue = $sheet->getCell($col . $row)->getValue()??NULL;
            // cột tên
            if($colASII == 65) {
                if(!$cellValue) {
                    $stop_loop = true;
                    break;
                }
            }
            // cột xoá lúc
            if($colASII == 75) {
                if($cellValue == "1") {
                    array_push($values, getTimestamp(0));
                }else {
                    array_push($values, NULL);
                }
                // tạo lúc
                array_push($values, getTimestamp(0));
                break;
            }
            array_push($values, $cellValue ?? NULL);
            
        }
        if($stop_loop) {
            break;
        }
        $sql .= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?), ";
        $count_row_insert++;
    }
    
    $sql = substr($sql, 0, -2);
    $result =  query_input($sql, $values);
    if($result) {
        return $count_row_insert;
    }else {
        return false;
    }
    
}

function remove_file($filePath)
{
    $file_exisit = false;
    // Kiểm tra nếu tập tin đã tồn tại
    if (file_exists($filePath)) {
        $file_exisit = true;
    }

    if ($file_exisit) {
        if (!unlink($filePath)) {
            return false;
        }
    }
    return true;
}
?>