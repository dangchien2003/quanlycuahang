<?php
include_once  'helper.php';
include_once  'check.php'; // bao gồm helper.php
try {
    huyTatCaCookie($_SERVER);
    if (checkRequest($_POST, ['username', 'password'], false)) {
        $result = checkUserPassword($_POST["username"], $_POST["password"], true);
        // đúng tài khoản mật khẩu
        if ($result['login']) {
            $account = ["username"=>$_POST["username"], "password"=>$_POST["password"], "dieSS"=>getTimestamp(get_ENV()['timeSession'])];
            // có nhớ tkmk
            if (checkRequest($_POST, ['nho'], false)) {
                // mã hoá user và pass
                $account_mh = maHoa($account);

                // đẩy về cookie
                setcookie("account", $account_mh, time() + get_ENV()['timeCookie'], '/', false, true);
                // chuyển hướng trang
            } else {
                // không nhớ tkmk
                session_start();
                $_SESSION["account"] = $account;
                // chuyển hướng trang
            }

            header("Location: ../page/quanly.php");
            
        } else {
            // chuyển hướng
            header("Location: ../page/dangnhap.php?status=400&message=".$result['message']);
        }
    } else {
        header("Location: ../page/dangnhap.php?message=Nhập thông tin đầy đủ&status=400");
    }
} catch (Exception $e) {
    log_error($e->getMessage());
    header("Location: ../page/dangnhap.php?message=Hiện không thể đăng nhập&status=400");
}

function huyTatCaCookie($server)
{
    if (isset($server['HTTP_COOKIE'])) {
        $cookies = explode(';', $server['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            if(strtoupper($name) != "PHPSESSID") {
                setcookie($name, '', time() - get_ENV()['timeCookie'], '/');
            }
        }
    }
    // huỷ session
    session_start();
    session_destroy();
}
