<?php include './layout/header.php';
include_once '../handle/checkAccount.php';
?>

<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box">
            <div class="name">
                <i class="bi bi-node-plus-fill"></i>Thêm linh kiện
            </div>
            <div class="form-add row">
                <div class="col-md-3 icon-page">
                    <div class="icon">
                        <img src="../../public/image/icon/ic.png" alt="" class="object">
                        <img src="../../public/image/icon/plus.png" alt="" class="action">
                    </div>
                </div>
                <div class="col-md-7">
                    <form action="../handle/themlinhkien.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Mã linh kiện:</label>
                                <input type="text" class="form-control" id="" name="malk" value="" required>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Tên linh kiện:</label>
                                <input type="text" class="form-control" id="" name="tenlk" required>
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-md-4" >
                                <label for="" class="form-label">Chỉ số</label>
                                <input type="text" class="form-control" id="" name="chiso" value="">
                            </div>
                            <div class="col-md-5">
                                <label for="" class="form-label">Công dụng:</label>
                                <input type="text" class="form-control" id="" name="congdung" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" id="" name="sl" value="0" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Giá bán:</label>
                                <input type="number" class="form-control" id="" name="giaban" value="0" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá nhập:</label>
                                <input type="number" class="form-control" id="" name="gianhap" value="0" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giảm giá(%):</label>
                                <input type="number" class="form-control" id="" name="giamgia" value="0" required>
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
                                            <option value="<?php echo $row['idtrangthai']; ?>">
                                                <?php echo $row['tentrangthai']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">

                            </div>
                        </div>
                        <div class="row info-student">
                            <div class="col-md-8">
                                <label class="form-label">Ảnh sản phẩm:</label>
                                <input type="file" name="anhsp" id="inp">
                            </div>
                            <canvas class="col-md-3 a-d-d" id="anh">

                            </canvas>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Thông tin khác(từ khoá?thông tin*từ khoá?thông tin):</label>
                                <textarea type="number" class="form-control" id="" name="ttkhac" value="0"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Tạo</button>
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