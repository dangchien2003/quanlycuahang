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
                        // $tt = "sinhvien.tinhTrang";
                        // $t = "phong.tang";
                        // if(checkRequest($_GET, ["t"])) {
                        //     $t = $_GET["t"];
                        // }
                        
                        if (checkRequest($_GET, ["page"])) {
                            $page = $_GET["page"];
                        }

                        // if (checkRequest($_GET, ["tt"], true)) {
                        //     switch ($_GET["tt"]) {
                        //         case "2":
                        //             $tt = 2;
                        //             break;
                        //         case "1":
                        //             $tt = 1;
                        //             break;
                        //     }
                        // }
                        $sql = "SELECT idsp, tensp, giaban, soluong, trangthai, trangthai.tentrangthai, anhsp FROM sanpham JOIN trangthai on trangthai.id = sanpham.trangthai where sanpham.xoaluc is null LIMIT ?, ?";

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
                                        <a href="../handle/hdl_xoasanpham.php?idsp=<?php echo $row['idsp'] ?>&action=delete  "
                                            class="show" onclick="return confirm('Bạn có chắc chắn muốn xoá <?php echo$row['tensp'] ?>')">
                                            <div class="btn-tt d-inline-block bgr-error">Xoá</div>
                                        </a>
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