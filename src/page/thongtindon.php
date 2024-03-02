<?php include './layout/header.php';
include_once '../handle/checkAccount.php';
// die();
if (!checkRequest($_GET, ["object"])) {
    header("location: ./dssanpham.php?status=400&message=Đối tượng không xác định");
    exit();
}

$object = strtolower($_GET["object"]);
$sql = null;
$location = null;
switch ($object) {
    case "sp":
        $sql = "SELECT sanphamdaban.*, sanphamdaban.idsp as ma, sanpham.tensp  as ten from sanphamdaban join sanpham where sanphamdaban.idsp = ? and banluc = ? and (tenkhachhang = ? or tenkhachhang is null) limit 0,1";
        $location = 'dssanphamdaban.php';
        break;
    case "lk":
        $sql = "SELECT linhkiendaban.*, linhkiendaban.malk as ma, linhkien.tenlinhkien as ten from linhkiendaban join linhkien where linhkiendaban.malk = ? and banluc = ? and (tenkhachhang = ? or tenkhachhang is null) limit 0,1";
        $location = 'dslinhkiendaban.php';
        break;
    default:
        header("location: ./dssanpham.php?status=400&message=Đối tượng không xác định");
        exit();
}


$haveError = false;
if (checkRequest($_GET, ["ma", "banluc"])) {
    $select = query_input($sql, [$_GET['ma'], $_GET['banluc'], $_GET['kh']]);
    $order = null;
    if ($select->num_rows > 0) {
        $order = $select->fetch_assoc();
    } else {
        $haveError = true;
    }
} else {
    $haveError = true;
}

if ($haveError) {
    header("Location: ./$location?status=300&message=Không tìm thấy đơn hàng");
    exit();
}

?>

<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box">
            <div class="name">
                <i class="bi bi-box-seam"></i>Thông tin đơn hàng
            </div>
            <div class="form-add row">
                <div class="col-md-3 icon-page">
                    <div class="icon">
                        <img src="../../public/image/icon/order.png" alt="" class="object">
                        <!-- <img src="../../public/image/icon/edit.png" alt="" class="action"> -->
                    </div>
                </div>
                <div class="col-md-7">
                    <form action="../handle/hdl_suadonhang.php?object=<?php echo $object?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Mã sản phẩm:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" readonly required
                                    value="<?php echo $order['ma'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleFormControlInput1" class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="ten"
                                    readonly required value="<?php echo $order['ten'] ?>">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Số lượng:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="sl"
                                    value="<?php echo formatnumber($order['soluong']) ?>" required oninput="formatNumber(this)">
                            </div>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Ngày bán:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="banluc"
                                    required value="<?php echo $order['banluc'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Khách hàng:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="kh"
                                    value="<?php echo $order['tenkhachhang'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Giá bán:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="giaban"
                                    value="<?php echo formatnumber($order['giaban']) ?>" required oninput="formatNumber(this)">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá nhập:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="gianhap"
                                    value="<?php echo formatnumber($order['gianhap']) ?>" required oninput="formatNumber(this)">
                            </div>
                            <div class="row">
                                <div class="d-none">
                                    <input type="password" value="<?php echo $order["ma"] ?>" name="ma">
                                    <input type="password" value="<?php echo $order["banluc"] ?>" name="old_banluc">
                                    <input type="password" value="<?php echo $order["tenkhachhang"] ?>" name="old_kh">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Bạn chắc chắn muốn sửa')">Sửa</button>
                        <a href="../handle/thuhoispdaban.php?ma=<?php echo $order['ma'] ?>&banluc=<?php echo $order['banluc'] ?>&kh=<?php echo $order['tenkhachhang'] ?>&sl=<?php echo $order['soluong'] ?>&object=<?php echo $object?>"
                            class="show"
                            onclick="return confirm('Sản phẩm sẽ cật nhật lại số  lượng')">
                            <div class="btn d-inline-block bgr-info">Thu hồi</div>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>
<script>
    $(document).ready(function () {
        $("#inp").on("change", function () {
            $("#anh").removeClass("d-none");
            $("#anh").removeClass("d-none");
            $(".img-old").addClass("border-delete")
        })
        $('select[name="hang"]').change(function () {
            if ($('select[name="hang"]').val() == 0) {
                $('input[name="tenhang"]').removeClass('d-none');
            } else {
                $('input[name="tenhang"]').addClass('d-none');
            }
        })
        $('select[name="phanloai"]').change(function () {
            if ($('select[name="phanloai"]').val() == 0) {
                $('input[name="phanloaikhac"]').removeClass('d-none');
            } else {
                $('input[name="phanloaikhac"]').addClass('d-none');
            }
        })

        checkinput(["sl", "giaban", 'gianhap', 'giamgia']);
        $(`input[name="giamgia"]`).change(function () {
            if ($(`input[name="giamgia"]`).val() * 1 > 100) {
                $(`input[name="giamgia"]`).val(100)
            }
        })

    })

    function checkinput(array_name_input) {
        array_name_input.forEach(element => {
            $(`input[name="${element}"]`).change(function () {
                if ($(`input[name="${element}"]`).val() * 1 < 0) {
                    $(`input[name="${element}"]`).val(0)
                }
            })
        });
    }

    $("#inp").on("input", function () {
        cover_input_to_canvas("inp", "anh");
    })

</script>