<?php
require_once 'helper.php';
if (!checkRequest($_GET, ["object"])) {
    header('location: ../page/cuahang.php?status=400&message=Không tìm thấy đối tượng');
    exit();
}

$object = strtolower($_GET["object"]);
$sql = null;
$location_when_error = "";
switch ($object) {
    case "sp":
        $sql = "UPDATE sanphamdaban SET giaban = ?, gianhap = ?, soluong = ?, banluc = ?, tenkhachhang = ? WHERE idsp = ? and banluc = ? and (tenkhachhang = ? or tenkhachhang is NULL)";
        $location_when_error = "dssanphamdaban.php";
        break;
    case "lk":
        $sql = "UPDATE linhkiendaban SET giaban = ?, gianhap = ?, soluong = ?, banluc = ?, tenkhachhang = ? WHERE malk = ? and banluc = ? and (tenkhachhang = ? or tenkhachhang is NULL)";
        $location_when_error = "dslinhkiendaban.php";
        break;
    default:
        header("location: ../page/cuahang.php?status=400&message=Đối tượng không xác định");
        exit();
}

if (!checkRequest($_POST, ["ma", "sl", 'banluc', 'giaban', 'gianhap', 'old_banluc'], true)) {
    header("location: ../page/$location_when_error?status=400&message=Thiếu thông tin");
    exit();
}


$update = query_input($sql, [$_POST['giaban'], $_POST['gianhap'], $_POST['sl'], $_POST['banluc'], $_POST['kh'], $_POST['ma'], $_POST['old_banluc'], $_POST['old_kh']]);

if(!$update) {
    header("location: ../page/$location_when_error?status=400&message=Lỗi sửa thông tin");
    exit();
}

header("location: ../page/thongtindon.php?status=200&message=Sửa thành công&ma=".$_POST['ma']."&banluc=".$_POST['banluc']."&kh=".$_POST['kh']."&object=".$object);
exit();

?>