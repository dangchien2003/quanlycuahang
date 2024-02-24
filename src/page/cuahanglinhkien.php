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
                <i class="fa-solid fa-microchip"></i>
                Cửa hàng linh kiện
            </div>
            <div class="find" style="text-align: right;">
                <a href="./cuahanglinhkien.php"><button class="hanhdong btn-tt bgr-ok" id="submit" style="outline: none; color: white;">
                        All
                    </button></a>
                <div class="search" id="search-box">
                    <input type="text" name="" id="input-search" placeholder="Nhập từ khoá cần tìm" oninput="addclass()"
                        required value="<?php echo $_GET["f"] ?? "" ?>">
                    <button class="icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
            <div class="danhsachsanpham">
                <div class="row">
                    <?php
                    $chiso = " = linhkien.chiso";
                    $tenlk = " = linhkien.tenlinhkien";
                    if (checkRequest($_GET, ["f"])) {
                        $chiso = " like '%" . $_GET['f'] . "%'";
                        $tenlk = " like '%" . $_GET['f'] . "%'";
                    }

                    $sql = "SELECT linhkien.tenlinhkien, linhkien.malinhkien, linhkien.chiso, linhkien.giaban, linhkien.giamgia, linhkien.anh, linhkien.soluong FROM linhkien where linhkien.xoaluc is null and linhkien.trangthai in (1, 6) and (linhkien.chiso $chiso or linhkien.tenlinhkien $tenlk)";
                    $result = query_no_input($sql);
                    if ($result->num_rows != 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <a href="./linhkien.php?malk=<?php echo $row['malinhkien'] ?>" class="sanpham">
                                <div class="anhsp">
                                    <img src="../../public/image/uploads/<?php echo $row['anh'] ?>" alt="">
                                </div>
                                <div class="tensanpham">
                                    <?php echo $row['tenlinhkien'] ?>
                                </div>
                                <div class="gia">
                                    <span class="giamoi">
                                        <?php echo formatnumber($row['giaban'] - $row['giaban'] * $row['giamgia'] / 100) ?>Đ
                                    </span>
                                    <?php if ($row['giamgia']) {
                                        ?>
                                        <s class="giacu">
                                            <?php echo $row['giaban'] ?>Đ
                                        </s>
                                        <?php
                                    } ?>
                                </div>
                                <div class="sukien">
                                    <div>
                                        <?php if (!$row['soluong']) {
                                            ?>
                                            <img src="../../public/image//icon/hethang.png" alt="">
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="giamgia">
                                        <?php if ($row['giamgia']) {
                                            ?>
                                            <img src="../../public/image//icon/discount.png" alt="">
                                            <div class="giam">
                                                <?php echo $row['giamgia'] ?>%
                                            </div>
                                            <?php
                                        } ?>

                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    } else {
                        echo '<div class="bi-text-center">Không có sản phẩm</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include './layout/footer.php';
addScript(['search']) ?>
<script>
    addclass();
    $(".icon").click(function () {
        var search = $("#input-search").val();
        if (search) {
            addParams("f", search);
            location.reload();
        }

    });
</script>