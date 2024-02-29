<?php 
require_once "helper.php";

if (!checkRequest($_GET , ["object"])) {
    header("location: ../page/cuahang.php?status=400&message=Không tìm thấy đối tượng");
    exit();
} 

if (!checkRequest($_GET , ["ma", "banluc", "sl"])) {
    header("location: ../page/dssanphamdaban.php?status=400&message=Không tìm thấy thông tin");
    exit();
}

$object = strtolower($_GET["object"]);
$sql1 = "";
$sql2 = "";
$location  ="";

switch ($object) {
    case "sp":
        $sql1 = "DELETE from sanphamdaban WHERE idsp = ? AND banluc = ? AND (tenkhachhang = ? or tenkhachhang is null) LIMIT 1;";

        $sql2 = "UPDATE sanpham SET soluong = soluong+? where idsp = ?";
        $location = "dssanphamdaban.php";
        break;
    case "lk":
        $sql1 = "DELETE from linhkiendaban WHERE malk = ? AND banluc = ? AND (tenkhachhang = ? or tenkhachhang is null) LIMIT 1;";

        $sql2 = "UPDATE linhkien SET soluong = soluong+? where malinhkien = ?";
        $location = "dslinhkiendaban.php";
        break;
    default:
        header("location: ../page/cuahang.php?status=400&message=Đối tượng không xác định");
        exit();   
}



$delete = query_input($sql1, [$_GET['ma'], $_GET['banluc'], $_GET['kh']]);
if(!$delete) {
    header("Location: ../page/$location?status=400&message=Không thể thu hồi");
    exit();
}
$update = query_input($sql2, [$_GET['sl'], $_GET['ma']]);
if(!$update) {
    header("Location: ../page/$location?status=400&message=Đã huỷ nhưng không thể cập nhật số lượng");
    exit();
}

header("Location: ../page/$location?status=200&message=Đã thu hồi");
?>
