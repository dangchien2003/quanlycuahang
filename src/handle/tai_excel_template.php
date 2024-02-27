<?php
require_once "helper.php";
if (checkRequest($_GET, ["object"])) {
    $namefile = "";
    switch (strtolower($_GET["object"])) {
        case "sp":
            $namefile = 'themsp.xlsx';
            $url_after_download = "../page/themmathang.php";
            break;
        case "lk":
            $namefile = 'themlk.xlsx';
            $url_after_download = "../page/themlinhkien.php";
            break;
        default:
            $url_after_download = "../page/cuahang.php?status=400&message=Không tìm thấy yêu cầu";
    }
    // Đường dẫn đến tập tin cần tải về
    if(!$namefile) {
        header("location: $url_after_download");
    }
    $file_path = "..//..//public//insert_template//$namefile";
    // Kiểm tra xem tập tin có tồn tại không
    if (file_exists($file_path)) {
        ob_clean();
        // Thiết lập tiêu đề và loại MIME cho phản hồi
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        
        // Đọc và xuất dữ liệu của tập tin
        readfile($file_path);
        // Kết thúc thực thi script
        // không cần chuyển trang
    } else {
        // Nếu tập tin không tồn tại, hiển thị thông báo lỗi
        header("location: $url_after_download?status=400&message=Không tìm thấy file");
    }

}else {
    header("location: ../page/cuahang.php?status=400&message=Không tìm thấy thông tin");
}

?>