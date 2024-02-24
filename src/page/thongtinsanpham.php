<?php include './layout/header.php';
// include_once '../handle/checkAccount.php';
$haveError = false;
if (checkRequest($_GET, ["id"])) {
    $sql = "SELECT * from sanpham where idsp = ?";
    $result = query_input($sql, [$_GET['id']]);
    $sp = null;
    $spIsEmpty = false;
    if ($result->num_rows > 0) {
        $sp = $result->fetch_assoc();
    } else {
        $haveError = true;
    }
}else {
    $haveError = true;
}

if($haveError) {
    header("Location: ./dssanpham.php?status=300&message=Không tìm thấy sản phẩm");
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
                <i class="bi bi-box-seam"></i>Thông tin sản phẩm
            </div>
            <div class="form-add row">
                <div class="col-md-3 icon-page">
                    <div class="icon">
                        <img src="../../public/image/icon/product.png" alt="" class="object">
                        <img src="../../public/image/icon/edit.png" alt="" class="action">
                    </div>
                </div>
                <div class="col-md-7">
                    <form action="../handle/hdl_suasanpham.php?idsp=<?php echo $sp['idsp']?>" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="tensp"
                                    required value="<?php echo $sp['tensp'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Hãng sản xuất:</label>
                                <select class="form-select" aria-label="Default select example" name="hang" required>
                                    <option value="0">Khác</option>
                                    <?php
                                    $sql = "SELECT DISTINCT hangsx from sanpham group by hangsx";
                                    $result = query_no_input($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option <?php if ($sp["hangsx"] == $row['hangsx'])
                                                echo "selected" ?>
                                                    value="<?php echo $row['hangsx']; ?>">
                                                <?php echo $row['hangsx']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4" style="padding: 0;">
                                <label for=""></label>

                                <input type="text" class="form-control d-none" id="exampleFormControlInput1"
                                    name="tenhang" style="margin-top: 13px;">
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" name="sl"
                                    value="0" value="<?php echo $sp['soluong'] ?>" required>
                            </div>
                            <?php
                            if ($sp['loaisp']) {
                                ?>
                                <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Loại hàng:</label>
                                    <div><input type="radio" name="loaihang" value="1" checked>Mới</div>
                                    <div><input type="radio" name="loaihang" value="0">Cũ</div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Loại hàng:</label>
                                    <div><input type="radio" name="loaihang" value="1">Mới</div>
                                    <div><input type="radio" name="loaihang" value="0" checked>Cũ</div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Phân loại sản phẩm:</label>
                                <select class="form-select" aria-label="Default select example" name="phanloai">
                                    <option value="0" selected>Khác</option>
                                    <?php
                                    $sql = "SELECT DISTINCT phanloai from sanpham";
                                    $result = query_no_input($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option <?php if ($sp["phanloai"] == $row['phanloai'])
                                                echo "selected" ?> value="<?php echo $row['phanloai']; ?>">
                                                <?php echo $row['phanloai']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3" style="padding: 0;">
                                <label for=""></label>
                                <input type="text" class="form-control d-none" id="exampleFormControlInput1"
                                    name="phanloaikhac" style="margin-top: 13px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Giá bán:</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" name="giaban"
                                    value="<?php echo $sp['giaban'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá nhập:</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" name="gianhap"
                                    value="<?php echo $sp['gianhap'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giảm giá(%):</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" name="giamgia"
                                    value="<?php echo $sp['giamgia'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Trạng thái:</label>
                                <select class="form-select" aria-label="Default select example" name="trangthai">
                                    <?php
                                    $sql = "SELECT idtrangthai, tentrangthai from trangthaisp join trangthai on trangthai.id = trangthaisp.idtrangthai";
                                    $result = query_no_input($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option <?php if ($sp["trangthai"] == $row['idtrangthai'])
                                                echo "selected" ?>  value="<?php echo $row['idtrangthai']; ?>">
                                                <?php echo $row['tentrangthai']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="d-none">
                                    <input type="password" value="<?php echo $sp["anhsp"] ?>" name="tenanh">
                                    <input type="password" value="<?php echo $sp["idsp"] ?>" name="idsp">
                                </div>
                            </div>
                        </div>
                        <div class="row info-student">
                            <div class="col-md-8">
                                <label class="form-label">Ảnh sản phẩm:</label>
                                <input type="file" name="anhsp" id="inp">
                            </div>

                            <canvas class="col-md-3 a-d-d d-none" id="anh">

                            </canvas>
                            <?php if ($sp["anhsp"]) {
                                ?>
                                <div class="col-md-3">
                                    <img src="../../public/image/uploads/<?php echo $sp["anhsp"] ?>" alt="" class=" a-d-d">
                                </div>
                                <canvas class="col-md-3 a-d-d d-none" id="anh">
                                <?php
                            }else {
                                ?>
                                <canvas class="col-md-3 a-d-d" id="anh">
                                <?php
                            } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Thông tin khác(từ khoá?thông tin*từ khoá?thông tin):</label>
                                <textarea type="number" class="form-control" id="exampleFormControlInput1" name="ttkhac"
                                    value="0"><?php echo $sp["thongtinkhac"]?></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success" onclick="return confirm('Bạn chắc chắn muốn sửa')">Sửa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>
<script>
    $(document).ready(function () {
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

        $('input[name="sl"]').change(function () {
            if ($('input[name="sl"]').val() * 1 < 0) {
                $('input[name="sl"]').val(0)
            }
        })
    })

    $("#inp").on("input", function () {
        cover_input_to_canvas("inp", "anh");
    })

</script>