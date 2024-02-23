<?php include './layout/header.php';
 include_once '../handle/checkAccount.php' ;
$row = null;
$error = ["e" => false, "message" => ""];
if (checkRequest($_GET, ["id"])) {
    $sql = "SELECT sanpham.*, sanpham.phanloai, sanpham.soluong, sanpham.gianhap FROM sanpham where sanpham.trangthai in (1, 6) and sanpham.idsp = ?";
    $result = query_input($sql, [$_GET['id']]);
    $result->num_rows == 1 ? $row = $result->fetch_assoc() : $error = ["e" => true, "message" => "Không tìm thấy sản phẩm"];
    $giaban = $row['giaban'] - $row['giaban'] * $row['giamgia'] / 100;
} else {
    $error = ["e" => true, "message" => "Không thấy thông tin"];
}
if ($error['e']) {
    header("Location: ./cuahang.php?status=400&message=" . $error['message']);
    exit();
}
?>
<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box ">
            <form action="../handle/banhang.php?mh=sp" method="post" class="thongtinsanpham">
                <input type="password" name="idsp" class="d-none" value="<?php echo $row['idsp']?>">
                <input type="password" name="gn" class="d-none" value="<?php echo $row['gianhap']?>">
                <div class="anhsp">
                    <img src="../../public/image/uploads/<?php echo $row['anhsp']?>" alt="">
                </div>
                <div class="chitiet">
                    <h5>
                        <?php echo $row['tensp'] ?>
                    </h5>
                    <div class="gia">
                        <span>Giá bán: </span>
                        <input type="text" class="giamoi d-none" value="<?php echo ($giaban) ?>" name="giaban">
                        <span class="giamoi">
                            <?php echo formatnumber($giaban) ?>Đ
                        </span>
                        <?php ?>
                        <?php if ($row['giamgia']) {
                            ?>
                            <s class="giacu">
                                <?php echo formatnumber($row["giaban"]) ?>Đ
                            </s>
                            <?php
                        } ?>
                    </div>
                    <span class="">Sản phẩm : <span>
                            <span>
                                <?php if ($row['loaisp'] == 1)
                                    echo "Mới";
                                else
                                    echo "Cũ"; ?>
                            </span>
                            <?php if ($row['giamgia']) {
                                ?>
                                <span> |
                                </span>
                                <span class="giamgia">
                                    Giảm: <span>
                                        <?php echo $row['giamgia'] ?>%
                                    </span>
                                </span>
                                <?php
                            } ?>

                            <br>
                            <span>Số lượng:
                                <?php echo $row['soluong'] ?>
                            </span>
                        <?php 
                        if($row['soluong']) {
                             ?> 
                             <div>
                                <button class="hanhdong btn-tt bgr-ok" id="submit">
                                    Bán hàng
                                </button>
                                <span>
                                    <script> var max_sl = <?php echo $row['soluong'] ?>; </script>
                                    <i class="bi bi-chevron-down"></i>
                                    <input type="number" value="1" class="btn me-2" style="width: 50px; height: 30px"
                                        id="sl" name="sl">
                                    <i class="bi bi-chevron-up"></i>
                                </span>
                            </div><?php 
                        }else {
                            ?>
                            <div style="color: red;">
                                Hết hàng
                            </div>
                            <?php
                        }
                        ?> 
                </div>
            </form>
            <br>
            <div class="box" style="height: 800px;">
                <h5>Thông tin khác</h5>
                <ul>
                    <li>Loại hàng: <?php echo $row['phanloai']?></li>
                    <?php 
                    if($row['thongtinkhac']) {
                        $li = explode('*',$row['thongtinkhac']);
                        foreach($li as $value) {
                            $content = explode('?', $value);
                            echo "<li>$content[0]: $content[1]</li>";
                        }
                    }
                    ?> 
                </ul>
            </div>
        </div>
    </div>
</div>



<?php include './layout/footer.php' ?>
<script>
    $(".bi-chevron-down").click(function () {
        $("#sl").val(($("#sl").val() * 1) - 1 ? ($("#sl").val() * 1) - 1 : 1);
    })
    $(".bi-chevron-up").click(function () {
        $("#sl").val(($("#sl").val() * 1) + 1 < max_sl ? ($("#sl").val() * 1) + 1 : max_sl);
    })

    $("#sl").on("change", function () {
        if ($("#sl").val() > max_sl || $("#sl").val() <= 0) {
            $("#sl").val(1);
        }
    });

    $(".thongtinsanpham").submit(function (event) {
        event.preventDefault();
    })
    $("#submit").click(function () {
        var kh = prompt("Nhập tên khách hàng");
        
        $(".thongtinsanpham").append(`<input type="text" class="d-none" name="kh" value="${kh}">`);
        $(".thongtinsanpham").off("submit").submit();
    })
</script>