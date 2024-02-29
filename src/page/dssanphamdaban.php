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
                <i class="bi bi-bookshelf"></i>Mặt hàng đã bán
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
                            <th scope="col" style="width: 5%;">Mã MH</th>
                            <th scope="col" style="width: 15%;">Tên mặt hàng</th>
                            <th scope="col" style="width: 8%;">Số lượng</th>
                            <th scope="col" style="width: 5%;">Giá bán</th>
                            <th scope="col" style="width: 10%;">Bán lúc</th>
                            <th scope="col" style="width: 12%;">Tên khách hàng</th>
                            <th scope="col" style="width: 20%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="body_table">
                        <?php
                        include_once '../handle/helper.php';
                        $item_one_page = 20;
                        $page = 1;
                        $tt = "linhkien.trangthai";
                        
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

                        $sql = "SELECT sanphamdaban.idsp, sanpham.tensp, sanphamdaban.giaban, sanphamdaban.soluong, sanphamdaban.banluc, sanphamdaban.tenkhachhang FROM sanphamdaban JOIN sanpham on sanpham.idsp = sanphamdaban.idsp limit ?, ?;";
                        // limit 
                        $result = query_input($sql, [($page - 1) * $item_one_page, $page * $item_one_page]);
                        // $result = query_no_input($sql);
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
                                        <?php echo $row['soluong'] ?>
                                    </td>
                                    <td>
                                        <?php echo formatnumber($row['giaban']) ?>đ
                                    </td>
                                    <td>
                                        <?php echo $row['banluc'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['tenkhachhang'] ?>
                                    </td>
                                    <td>
                                        <a href="./thongtindon.php?ma=<?php echo $row['idsp'] ?>&banluc=<?php echo $row['banluc'] ?>&kh=<?php echo $row['tenkhachhang'] ?>&object=sp"
                                            class="show">
                                            <div class="btn-tt d-inline-block bgr-ok">Xem</div>
                                        </a>
                                        <a href="../handle/thuhoispdaban.php?ma=<?php echo $row['idsp'] ?>&banluc=<?php echo $row['banluc'] ?>&kh=<?php echo $row['tenkhachhang'] ?>&sl=<?php echo $row['soluong'] ?>&object=sp"
                                            class="show" onclick="return confirm('Sản phẩm sẽ cật nhật lại số  lượng')">
                                            <div class="btn-tt d-inline-block bgr-info">Thu hồi</div>
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
<script>
    $("input[name=search]").eq(0).on("change", function () {
        addParams("search", $("input[name=search]").val().trim());
        location.reload();
    })
</script>