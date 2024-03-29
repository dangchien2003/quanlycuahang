<?php include './layout/header.php';
include_once '../handle/checkAccount.php';
$haveError = false;
if (checkRequest($_GET, ["malk"])) {
    $sql = "SELECT * from linhkien where malinhkien = ? or taoluc = ?";
    $result = query_input($sql, [$_GET['malk'], $_GET['malk']]);
    $sp = null;
    $spIsEmpty = false;
    if ($result->num_rows > 0) {
        $sp = $result->fetch_assoc();
    } else {
        $haveError = true;
    }
} else {
    $haveError = true;
}

if ($haveError) {
    header("Location: ./dslinhkien.php?status=300&message=Không tìm thấy sản phẩm");
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
                <i class="bi bi-cpu"></i>Thông tin linh kiện
            </div>
            <div class="form-add row">
                <div class="col-md-3 icon-page">
                    <div class="icon">
                        <img src="../../public/image/icon/product.png" alt="" class="object">
                        <img src="../../public/image/icon/edit.png" alt="" class="action">
                    </div>
                </div>
                <div class="col-md-7">
                    <form action="../handle/hdl_sualinhkien.php?malk=<?php echo $sp['malinhkien'] ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Mã linh kiện:</label>
                                <input type="text" class="form-control" id="" value="<?php echo $sp['malinhkien'] ?>" required readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Tên linh kiện:</label>
                                <input type="text" class="form-control" id="" name="tenlk" value="<?php echo $sp['tenlinhkien'] ?>" required >
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-md-4" >
                                <label for="" class="form-label">Chỉ số</label>
                                <input type="text" class="form-control" id="" name="chiso" value="<?php echo $sp['chiso'] ?>">
                            </div>
                            <div class="col-md-5">
                                <label for="" class="form-label">Công dụng:</label>
                                <input type="text" class="form-control" id="" name="congdung" value="<?php echo $sp['congdung'] ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="form-label">Số lượng:</label>
                                <input type="text" class="form-control" id="" name="sl" value="<?php echo formatnumber($sp['soluong']) ?>" required oninput="formatNumber(this)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Giá bán:</label>
                                <input type="text" class="form-control" id="" name="giaban" value="<?php echo formatnumber($sp['giaban']) ?>" required oninput="formatNumber(this)">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá nhập:</label>
                                <input type="text" class="form-control" id="" name="gianhap" value="<?php echo formatnumber($sp['gianhap']) ?>" required oninput="formatNumber(this)">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giảm giá(%):</label>
                                <input type="number" class="form-control" id="" name="giamgia" value="<?php echo $sp['giamgia'] ?>" required oninput="this.value = this.value*1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Trạng thái:</label>
                                <select class="form-select" aria-label="Default select example" name="trangthai">
                                    <?php
                                    $sql = "SELECT idtrangthai, tentrangthai from trangthailk join trangthai on trangthai.id = trangthailk.idtrangthai";
                                    $result = query_no_input($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option <?php if ($sp["trangthai"] == $row['idtrangthai'])
                                            echo "selected" ?> value="<?php echo $row['idtrangthai']; ?>">
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
                                    <input type="password" value="<?php echo $sp["anh"] ?>" name="tenanh">
                                    <input type="text" class="form-control" id="" name="malk" value="<?php echo $sp['malinhkien'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row info-student">
                            <div class="col-md-6">
                                <label class="form-label">Ảnh sản phẩm:</label>
                                <input type="file" name="anhsp" id="inp">
                            </div>

                            <canvas class="col-md-3 a-d-d d-none" id="anh">

                            </canvas>
                            <?php if ($sp["anh"]) {
                                ?>
                                <div class="col-md-3 ">
                                    <img src="../../public/image/uploads/<?php echo $sp["anh"] ?>" alt=""
                                        class="a-d-d img-old">
                                </div>
                                <canvas class="col-md-3 a-d-d d-none" id="anh">
                                    <?php
                            } else {
                                ?>
                                    <canvas class="col-md-3 a-d-d" id="anh">
                                        <?php
                            } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Thông tin khác(từ khoá?thông tin*từ khoá?thông tin):</label>
                                <textarea type="number" class="form-control" id="" name="ttkhac" ><?php echo $sp['thongtinkhac'] ?></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Bạn chắc chắn muốn sửa')">Sửa</button>
                        <?php
                        if ($sp['xoaluc']) {
                            ?>
                            <a href="../handle/hdl_boxoalinhkien.php?malk=<?php echo $sp["malinhkien"] ?>&action=recall  "
                                class="show"
                                onclick="return confirm('Bạn có chắc chắn muốn bỏ xoá <?php echo $sp['tenlinhkien'] ?>')">
                                <div class="btn d-inline-block bgr-wait">Mở khoá</div>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="../handle/hdl_xoalinhkien.php?malk=<?php echo $sp["malinhkien"] ?>&action=delete"
                                class="show"
                                onclick="return confirm('Bạn có chắc chắn muốn xoá <?php echo $sp['tenlinhkien'] ?>')">
                                <div class="btn d-inline-block bgr-error">Xoá</div>
                            </a>
                            <?php
                        }

                        ?>
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