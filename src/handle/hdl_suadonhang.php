<?php 
require_once 'helper.php';
if (!checkRequest($_GET , ["object"])) {
    header('location: ../page/cuahang.php?status=400&message=Không tìm thấy đối tượng');
    exit();
} 

$object = strtolower($_GET["object"]);
$sql = null;
$location_when_error = "";
switch ($object) {
    case "sp":
        $sql = "UPDATE sanphamdaban SET giaban = ?, gianhap = ?, soluong = ?, banluc = ?, tenkhachhang = ? WHERE idsp = ? and banluc = ? and tenkhachhang = ?;";
        break;
    case "lk":
        $sql = "UPDATE linhkiendaban SET giaban = ?, gianhap = ?, soluong = ?, banluc = ?, tenkhachhang = ? WHERE malk = ? and banluc = ? and tenkhachhang = ?;";
        break;
    default:
        header("location: ../page/cuahang.php?status=400&message=Đối tượng không xác định");
        exit();
}

if (!checkRequest($_POST , ["ma", "sl", 'banluc', 'giaban', 'gianhap'])) {
    header("location: ./dssanpham.php?status=400&message=Thiếu thông tin");
    exit();
} 


?> 