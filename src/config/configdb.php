<?php
    function connectDB_LOCAL(){
        $svn = "localhost";
        $usv = "root";
        $psv = "";
        $dbsv = "php_qlcuahang";
        $GLOBALS['conn'] = new mysqli($svn, $usv, $psv, $dbsv);
        $GLOBALS['conn']->set_charset("utf8");
        if($GLOBALS['conn']->connect_error) {
            header("location ../page/dangnhap.php?status=400&message=Lỗi server");
        }
    }

    function connectDB() {
        switch($_SERVER['SERVER_NAME']) {
            case "nhom5-php.kesug.com": 
                connectDB_HOSTING();
                break;
            case "localhost": 
                connectDB_LOCAL();
                break;
            default:
                echo "Tên miền chưa xác định";
                exit();
        }
    }

    function connectDB_HOSTING(){
        $svn = "sql109.infinityfree.com";
        $usv = "if0_35868743";
        $psv = "chiennkoi123";
        $dbsv = "if0_35868743_qlcuahang";
        $GLOBALS['conn'] = new mysqli($svn, $usv, $psv, $dbsv);
        $GLOBALS['conn']->set_charset("utf8");
        if($GLOBALS['conn']->connect_error) {
            header("location ../page/dangnhap.php?status=400&message=Lỗi server");
        }
    }
    function get_key() {
        return "key";
    }

    function get_IV() {
        return "1234567890987654";
    }
?> 
