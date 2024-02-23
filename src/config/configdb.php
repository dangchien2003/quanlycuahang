<?php
    function connectDB(){
        $svn = "localhost";
        $usv = "root";
        $psv = "";
        $dbsv = "php_qlcuahang";
        $GLOBALS['conn'] = new mysqli($svn, $usv, $psv, $dbsv);
        if($GLOBALS['conn']->connect_error) {
            header("location ../page/dangnhap.php?status=400&message=Lỗi server");
        }
    }

    // function connectDB(){
    //     $svn = "sql109.infinityfree.com";
    //     $usv = "if0_35868743";
    //     $psv = "chiennkoi123";
    //     $dbsv = "if0_35868743_qlcuahang";
    //     $GLOBALS['conn'] = new mysqli($svn, $usv, $psv, $dbsv);
    //     if($GLOBALS['conn']->connect_error) {
    //         header("location ../page/dangnhap.php?status=400&message=Lỗi server");
    //     }
    // }
    function get_key() {
        return "key";
    }

    function get_IV() {
        return "1234567890987654";
    }
?> 
