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
                <div class="ttp">
                    <div class="fs-15 fw-500">Trạng thái:</div>
                    <nav class="navbar navbar-light ">
                        <div class="container-fluid justify-content-start pd-0">
                            <a href="./dslinhkien.php?tt=0"><button class="btn me-2" type="button">Tất
                                    cả</button></a>
                            <a href="./dslinhkien.php?tt=6"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/buy.png" alt="" class="img-icon">Còn hàng</button></a>
                            <a href="./dslinhkien.php?tt=7"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/box.png" alt="" class="img-icon">Đã
                                    hết</button></a>
                            <a href="./dslinhkien.php?tt=2"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/empty-cart.png" alt="" class="img-icon">Ngừng
                                    bán</button></a>
                            <a href="./dslinhkien.php?tt=-1"><button class="btn me-2" type="button"><img
                                        src="../../public/image/icon/delete.png" alt="" class="img-icon">Đã
                                    xoá</button></a>
                        </div>
                    </nav>
                </div>
                <div class=" " style="width: 70%;">
                    <div class="fs-15 fw-500">Tìm kiếm(nhấn ra ngoài để tìm):</div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" required
                                value="<?php echo $_GET['search'] ?? "" ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-sv">
                <table class="table table-hover d-block">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 8%;">Mã LK</th>
                            <th scope="col" style="width: 12%;">Tên LK</th>
                            <th scope="col" style="width: 8%;">Chỉ số</th>
                            <th scope="col" style="width: 10%;">Giá bán</th>
                            <th scope="col" style="width: 5%;">Giảm</th>
                            <th scope="col" style="width: 10%;">Số lượng</th>
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
                        $tt = "linhkien.trangthai";
                        // $t = "phong.tang";
                        // if(checkRequest($_GET, ["t"])) {
                        //     $t = $_GET["t"];
                        // }
                        
                        if (checkRequest($_GET, ["page"])) {
                            $page = $_GET["page"];
                        }

                        $linhkien_da_xoa = "linhkien.xoaluc is null";
                        if (checkRequest($_GET, ["tt"], true)) {
                            switch ($_GET["tt"]) {
                                case "6":
                                    $tt = 6;
                                    break;
                                case "2":
                                    $tt = 2;
                                    break;
                                case "7":
                                    $tt = "7 or (soluong = 0 and linhkien.trangthai != 2)";
                                    break;
                                case "-1":
                                    $linhkien_da_xoa = "linhkien.xoaluc is not null";
                                    break;
                            }
                        }

                        $search = "1 = 1";
                        if (checkRequest($_GET , ["search"])) {
                            $search = "(linhkien.malinhkien = '".$_GET['search']."' or linhkien.tenlinhkien like '%".$_GET['search']."%')";
                        } 

                        $sql = "SELECT malinhkien, tenlinhkien, chiso, giaban, giamgia, soluong, trangthai, trangthai.tentrangthai, anh, xoaluc FROM linhkien JOIN trangthai on trangthai.id = linhkien.trangthai where $linhkien_da_xoa and linhkien.trangthai = $tt and $search LIMIT ?, ?";
                        $result = query_input($sql, [($page - 1) * $item_one_page, $page * $item_one_page]);
                        if ($result->num_rows == 0) {
                            echo '<div class="bi-text-center">Không có thông tin</div>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td scope="row" style="font-weight: bold;">
                                        <?php echo $row['malinhkien'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['tenlinhkien'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['chiso'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['giaban'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['giamgia'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['soluong'] ?>
                                    </td>

                                    <td>
                                        <div class="btn-tt bgr-wait">
                                            <?php echo $row['tentrangthai'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../../public/image/uploads/<?php echo $row['anh'] ?>" alt=""
                                            style="height: 70px;">
                                    </td>
                                    <td>
                                        <a href="./thongtinlinhkien.php?malk=<?php echo $row['malinhkien'] ?>&action=show  "
                                            class="show">
                                            <div class="btn-tt d-inline-block bgr-ok">Xem</div>
                                        </a>

                                        <?php
                                        if ($row['xoaluc']) {
                                            ?>
                                            <a href="#" class="show">
                                                <div class="btn-tt d-inline-block bgr-error" style="width: 200px;">
                                                    <?php
                                                    echo getTime($row['xoaluc'], 'd-m-Y H:i:s');
                                                    ?>
                                                </div>
                                            </a>

                                            <?php
                                        } else {
                                            ?>
                                            <a href="../handle/hdl_xoalinhkien.php?malk=<?php echo $row['malinhkien'] ?>&action=delete  "
                                                class="show"
                                                onclick="return confirm('Bạn có chắc chắn muốn xoá <?php echo $row['tensp'] ?>')">
                                                <div class="btn-tt d-inline-block bgr-error">Xoá</div>
                                            </a>
                                            <?php

                                        }
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
    $("input[name=search]").eq(0).on("change", function () {
        addParams("search", $("input[name=search]").val().trim());
        location.reload();
    })
</script>