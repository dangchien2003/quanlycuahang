<?php 
include 'helper.php';
if(checkRequest($_GET, ["mh"])) {
    switch($_GET["mh"]) {
        case "sp":
            bansanpham();
            break;
        case "lk":
            banlinhkien();
            break;
        default: 
            header("Location: ../page/cuahang.php");
    }
}

// kiểm tra đầu vào
function checkinput($ma) {
    if(!checkRequest($_POST, [$ma, "sl", "giaban"])) {
        return false;
    }
    return true;
}

function bansanpham() {
    // kiểm tra đầu vào
    if(checkinput("idsp")) {
        // update số lượng
        $sql = "UPDATE sanpham SET soluong = soluong - ? WHERE idsp = ?";
        $update = query_input($sql, [$_POST['sl'], $_POST['idsp']]);
        
        if($update) {
            // thêm bảng đã bán
            $sql = "INSERT into sanphamdaban(idsp, giaban, gianhap, soluong, banluc, tenkhachhang) values(?, ?, ?, ?, ?, ?)";
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $add = query_input($sql, [$_POST['idsp'], $_POST['giaban'], $_POST['gn'], $_POST['sl'], date("Y-m-d H:i:s"), $_POST['kh']]);
            if($add) {
                header("Location: ../page/sanpham.php?status=200&message=Đã bán&id=".$_POST['idsp']);
            }else {
                header("Location: ../page/sanpham.php?status=400&message=Có lỗi khi bán&id=".$_POST['idsp']);
            }
        }else {
            header("Location: ../page/sanpham.php?status=400&message=Có lỗi khi bán&id=".$_POST['idsp']);
        }
    }else {
        header("Location: ../page/cuahang.php");
    }
    
}

function banlinhkien() {
    // kiểm tra đầu vào
    if(checkinput("malk")) {
        // update số lượng
        $sql = "UPDATE linhkien SET soluong = soluong - ? WHERE malinhkien = ?";
        $update = query_input($sql, [$_POST['sl'], $_POST['malk']]);
        
        if($update) {
            // thêm bảng đã bán
            $sql = "INSERT into linhkiendaban(malk, giaban, gianhap, soluong, banluc, tenkhachhang) values(?, ?, ?, ?, ?, ?)";
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $add = query_input($sql, [$_POST['malk'], $_POST['giaban'], $_POST['gn'], $_POST['sl'], date("Y-m-d H:i:s"), $_POST['kh']]);
            if($add) {
                header("Location: ../page/linhkien.php?status=200&message=Đã bán&malk=".$_POST['malk']);
            }else {
                header("Location: ../page/linhkien.php?status=400&message=Có lỗi khi bán&malk=".$_POST['malk']);
            }
        }else {
            header("Location: ../page/linhkien.php?status=400&message=Có lỗi khi bán&malk=".$_POST['malk']);
        }
    }else {
        header("Location: ../page/cuahanglinhkien.php");
    }
}
?>
