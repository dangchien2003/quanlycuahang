<?php include './layout/header.php';
include_once "../handle/checkAccount.php";
$user = "";
// nếu có session account
if (checkRequest($_SESSION, ['account'])) {
    $user = $_SESSION['account']['username'];
} else if (checkRequest($_COOKIE, ['account'])) { // kiểm tra có cookie account hay không
    $account = giaiMa($_COOKIE['account']);
    $user = $account['username'];
} else {
    header("location: ../page/dangnhap.php");
} ?>
<div class="row">
    <div class="col-lg-3 bg-menu">
        <?php include './layout/menu.php' ?>
    </div>
    <div class="col-lg-9 sdp tp" style="min-height: 1000px;">
        <div class="box">
            <div class="row">
                <div class="col-lg-4 dmk">
                    <div class="name">
                        <i class="bi bi-key-fill"></i>Đổi mật khẩu
                    </div>
                    <form action="../handle/doimatkhau.php" method="post" id="form_change_password">
                        <div class="mb-3 object">
                            <label for="exampleFormControlInput1" class="form-label">Tên đăng nhập: </label>
                            <input type="text" class="" id="username" placeholder="" name="username"
                                value="<?php echo $user ?>" readonly required>
                        </div>
                        <div class="mb-3 object">
                            <label for="exampleFormControlInput1" class="form-label">Mật khẩu hiện tại: </label>
                            <input type="password" class="" id="password" placeholder="********" name="password"
                                value="" required>
                            <span class="message" id="toast_password"></span>
                        </div>
                        <div class="mb-3 object">
                            <label for="exampleFormControlInput1" class="form-label">Mật khẩu mới: </label>
                            <input type="password" class="" id="newpassword" placeholder="********" name="newpassword"
                                value="" required>
                            <span class="message" id="toast_newpassword"></span>
                        </div>

                        <div class="mb-3 object">
                            <label for="exampleFormControlInput1" class="form-label">Xác nhận mật khẩu: </label>
                            <input type="password" class="" id="passwordcomfirm" placeholder="********"
                                name="passwordcomfirm" value="" required>
                            <span class="message" id="toast_passwordcomfirm"></span>
                        </div>
                    </form>
                    <button class="btn btn-success" style="margin: 5px 0;" id="save">
                        Đổi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>
<script>
    $(document).ready(function () {
        var form = $("#form_change_password");
        var btn_save = $("#save");
        var check = false;
        $(btn_save).click(() => {
            // nếu newP rỗng
            if ($("#password").val().trim() == "") {
                $("#toast_password").text("Nhập mật khẩu")
            } else {
                $("#toast_password").text("")
                if ($("#newpassword").val().trim() == "") {
                    $("#toast_newpassword").text("Nhập ô này")
                } else {
                    $("#toast_newpassword").text("");
                    // nếu 2 mk mới k trùng nhau
                    if ($("#passwordcomfirm").val() != $("#newpassword").val()) {
                        $("#toast_passwordcomfirm").text("Mật khẩu không trùng khớp")
                    } else {
                        $("#toast_passwordcomfirm").text("")
                        // nếu trùng mật khẩu cũ và mới
                        if ($("#passwordcomfirm").val() == $("#password").val()) {
                            $("#toast_password").text("Mật khẩu mới và cũ phải khác nhau")
                        } else {
                            if ($("#newpassword").val().trim().length < 8 || $("#passwordcomfirm").val().trim().length < 8) {
                                $("#toast_passwordcomfirm").text("Mật khẩu yếu")
                            } else {
                                $(form).trigger('submit');
                            }
                        }
                    }
                }
            }

        })

    })
</script>