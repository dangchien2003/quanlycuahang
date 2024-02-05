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
                <i class="bi bi-shop-window"></i>Sản phẩm hiện có
            </div>
            <div class="danhsachsanpham">
                <div class="row">
                    <?php $sql = "SELECT sanpham.tensp, sanpham.idsp, sanpham.giaban, sanpham.giamgia, sanpham.loaisp, sanpham.anhsp FROM sanpham where sanpham.trangthai in (1, 6);";
                    $result = query_no_input($sql);
                    if ($result->num_rows != 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <a href="./sanpham.php?id=<?php echo $row['idsp'] ?>" class="sanpham">
                                <div class="anhsp">
                                    <img src="../../public/image/uploads/<?php echo $row['anhsp'] ?>" alt="">
                                </div>
                                <div class="tensanpham">
                                    <?php echo $row['tensp'] ?>
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
                                        <?php if (!$row['loaisp']) {
                                            ?>
                                            <img src="../../public/image//icon/clock.png" alt="">
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="giamgia">
                                        <?php if ($row['giamgia']) {
                                            ?>
                                            <img src="../../public/image//icon/discount.png" alt="">
                                            <div class="giam"><?php echo $row['giamgia'] ?>%</div>
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

<?php include './layout/footer.php' ?>