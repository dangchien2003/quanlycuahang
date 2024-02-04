<?php include './layout/header.php';
//  include_once '../handle/checkAccount.php' ?>
<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box ">
            <form action="#" method="post" class="thongtinsanpham">
                <input type="text" name="idsp" class="d-none">
                <div class="anhsp">
                    <img src="../../public/image/uploads/anhsp2.jpg" alt="">
                </div>
                <div class="chitiet">
                    <h5>
                        Nồi cơm điện sunhouse
                    </h5>
                    <div class="gia">
                        <span>Giá bán: </span>
                        <input type="text" class="giamoi d-none" value="200000" name="giaban">
                        <span class="giamoi">200.000Đ</span>
                        <s class="giacu">250.000Đ</s>
                    </div>
                    <span class="">Sản phẩm : <span>Cũ</span><span> | </span></span>
                    <span class="giamgia">
                        Giảm: <span>50%</span>
                    </span>
                    <br>
                    <span>Số lượng: 5</span>
                    <div>
                        <button class="hanhdong btn-tt bgr-ok" onclick="return confirm('Xác nhận bán sản phẩm')">
                            Bán hàng
                        </button>
                        <span>
                            <script> var max_sl = 5; </script>
                            <i class="bi bi-chevron-down"></i>
                            <input type="number" value="1" class="btn me-2" style="width: 50px; height: 30px" id="sl" name="sl">
                            <i class="bi bi-chevron-up"></i>
                        </span>
                    </div>
                </div>
            </form>
            <br>
            <div class="box" style="height: 800px;">
                <h5>Thông tin khác</h5>
                <ul>
                    <li>So von: 100V</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>
<script>
    $(".bi-chevron-down").click(function() {
        $("#sl").val(($("#sl").val()*1)-1?($("#sl").val()*1)-1:1);
    })
    $(".bi-chevron-up").click(function() {
        $("#sl").val(($("#sl").val()*1)+1 < max_sl?($("#sl").val()*1)+1:max_sl);
    })
</script>