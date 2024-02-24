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
                <i class="bi bi-bookshelf"></i>Sản phẩm đã tạo
            </div>
            <div class="find">
                <div class="find-tang ">
                    <div class="fs-15 fw-500">Tầng:</div>
                    <select class="form-select " aria-label="Default select example" id="tang">
                        <option value="0">Tất cả</option>
                        <?php

                        ?>
                    </select>
                </div>
                <div class="ttp">
                    <div class="fs-15 fw-500">Trạng thái:</div>
                    <nav class="navbar navbar-light ">
                        <form class="container-fluid justify-content-start pd-0">
                            <a href="./dssanpham.php?tt=0"><button class="btn me-2" type="button">Tất
                                    cả</button></a>
                            <a href="./dssanpham.php?tt=1"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/buy.png" alt="" class="img-icon">Đang
                                    bán</button></a>
                            <a href="./dssanpham.php?tt=7"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/box.png" alt="" class="img-icon">Đã
                                    hết</button></a>
                            <a href="./dssanpham.php?tt=2"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/empty-cart.png" alt="" class="img-icon">Ngừng
                                    bán</button></a>
                            <a href="./dssanpham.php?tt=-1"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/delete.png" alt="" class="img-icon">Đã
                                    xoá</button></a>
                        </form>
                    </nav>
                </div>
            </div>
            <div class="table-sv">
                <table class="table table-hover d-block">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">Mã SP</th>
                            <th scope="col" style="width: 20%;">Tên SP</th>
                            <th scope="col" style="width: 5%;">Giá bán</th>
                            <th scope="col" style="width: 5%;">Giảm</th>
                            <th scope="col" style="width: 5%;">Số lượng</th>
                            <th scope="col" style="width: 5%;">Trạng thái</th>
                            <th scope="col" style="width: 5%;">Ảnh</th>
                            <th scope="col" style="width: 20%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="body_table">
                        <?php
                        include_once '../handle/helper.php';
                        $item_one_page = 20;
                        // $result = null;
                        $page = 1;
                        $tt = "sanpham.trangthai";
                        // $t = "phong.tang";
                        // if(checkRequest($_GET, ["t"])) {
                        //     $t = $_GET["t"];
                        // }
                        
                        if (checkRequest($_GET, ["page"])) {
                            $page = $_GET["page"];
                        }

                        $sanpham_da_xoa = "sanpham.xoaluc is null";
                        if (checkRequest($_GET, ["tt"], true)) {
                            switch ($_GET["tt"]) {
                                case "1":
                                    $tt = 1;
                                    break;
                                case "2":
                                    $tt = 2;
                                    break;
                                case "7":
                                    $tt = 7;
                                    break;
                                case "-1":

                                    $sanpham_da_xoa = "sanpham.xoaluc is not null";
                                    break;
                            }
                        }
                        $sql = "SELECT idsp, tensp, giaban, soluong, trangthai, trangthai.tentrangthai, anhsp, xoaluc FROM sanpham JOIN trangthai on trangthai.id = sanpham.trangthai where $sanpham_da_xoa and sanpham.trangthai = $tt LIMIT ?, ?";

                        $result = query_input($sql, [($page - 1) * $item_one_page, $page * $item_one_page]);
                        if ($result->num_rows == 0) {
                            echo '<div class="bi-text-center">Không có thông tin</div>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td scope="row" style="font-weight: bold;">
                                        <?php echo $row['idsp'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['tensp'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['giaban'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['soluong'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['trangthai'] ?>
                                    </td>

                                    <td>
                                        <div class="btn-tt bgr-wait">
                                            <?php echo $row['tentrangthai'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../../public/image/uploads/<?php echo $row['anhsp'] ?>" alt=""
                                            style="height: 70px;">
                                    </td>
                                    <td>
                                        <a href="./thongtinsanpham.php?id=<?php echo $row['idsp'] ?>&action=show  "
                                            class="show">
                                            <div class="btn-tt d-inline-block bgr-ok">Xem</div>
                                        </a>

                                        <?php
                                        if ($row['xoaluc']) {
                                            ?>
                                            <a href="#" class="show">
                                                <div class="btn-tt d-inline-block bgr-error" style="width: 200px;">
                                                    <?php

                                                    $dateTime = new DateTime();
                                                    $dateTime->setTimestamp($row['xoaluc']);
                                                    $dateTime->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                                                    echo $dateTime->format('d-m-Y H:i:s'); //
                                                    ?>
                                                </div>
                                            </a>

                                            <?php
                                        } else {
                                            ?>
                                            <a href="../handle/hdl_xoasanpham.php?idsp=<?php echo $row['idsp'] ?>&action=delete  "
                                                class="show"
                                                onclick="return confirm('Bạn có chắc chắn muốn xoá <?php echo $row['tensp'] ?>')">
                                                <div class="btn-tt d-inline-block bgr-error">Xoá</div>
                                            </a>
                                            <?php

                                        }
                                        print_r($date);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>
<script>
    var timestamp = new Date().getTime();
    console.log(timestamp);
</script>