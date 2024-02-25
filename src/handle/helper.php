<?php
include_once '../config/configdb.php';
error_reporting(0);

function query_no_input($sql)
{
    try {
        connectDB();
        $start = $GLOBALS["conn"]->prepare($sql);
        $run = $start->execute();
        $typeSql = explode(" ", trim($sql))[0];
        if (strtoupper($typeSql) === "SELECT" && $run) {
            $result = $start->get_result();
            closeDB($start);
            return $result;
        } else {
            closeDB($start);
            $run = explode(" ", trim($sql));
            return $run;
        }
    } catch (Exception $e) {
        log_error($e->getMessage());
        throw new Exception;
    }

}
function query_input($sql, $values)
{
    try {
        // Kiểm tra số lượng tham số
        $numParams = substr_count($sql, '?');
        $numValues = count($values);
        if ($numParams !== $numValues) {
            throw new Exception("tham số truyền không trùng nhau");
        }
        connectDB();
        $start = $GLOBALS["conn"]->prepare($sql);
        $types = "";
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= "i"; // Loại dữ liệu là integer
            } elseif (is_float($value)) {
                $types .= "d"; // Loại dữ liệu là double
            } else {
                $types .= "s"; // Loại dữ liệu là string
            }
        }
        $start->bind_param($types, ...$values);
        $run = $start->execute();
        $typeSql = explode(" ", trim($sql))[0];
        if (strtoupper($typeSql) == "SELECT" && $run) {
            $result = $start->get_result();
            closeDB($start);
            return $result;
        } else {
            closeDB($start);
            return $run;
        }
    } catch (Exception $e) {
        log_error($e->getMessage());
        throw new Exception($e->getMessage());
    }


}

// tạo key value
function createKeyValueArray($keys, $values)
{
    // Kiểm tra số lượng phần tử trong mảng keys và values
    $numKeys = count($keys);
    $numValues = count($values);

    // Nếu số lượng phần tử không khớp, không thể tạo mảng key-value
    if ($numKeys !== $numValues) {
        return false; // Hoặc xử lý lỗi theo ý muốn của bạn
    }

    // Tạo mảng key-value từ các mảng keys và values
    $result = array_combine($keys, $values);

    return $result;
}

// kiểm tra có tồn tại hoặc rỗng
function checkRequest($method, $names, $allow = false)
{
    foreach ($names as $name) {
        if (isset($method["$name"])) {
            if ($method["$name"] == 0 && $allow) {
            } else if (empty($method["$name"])) {
                return false; // nếu rỗng
            }
        } else {
            return false; //nếu không tồn tại
        }
    }

    return true;
}

// đóng db
function closeDB($start)
{
    $GLOBALS['conn']->close();
    $start->close();
}

// lấy thời gian dạng dãy số
function getTimestamp($seconds)
{
    $dateTime = new DateTime();
    return $dateTime->getTimestamp() + $seconds;
}

// mã hoá
function maHoa($duLieu)
{
    // chuyển sang dạng json
    $json = json_encode($duLieu);
    $encrypted = openssl_encrypt($json, 'aes-256-cbc', get_key(), 0, get_IV());
    return $encrypted;
}

// giải mã
function giaiMa($mahoa)
{
    $json = openssl_decrypt($mahoa, 'aes-256-cbc', get_key(), 0, get_IV());
    // giải mã json và trả về
    return json_decode($json, true);
}

// lấy trang hiện tại
function getPageHere($url)
{
    $tree = explode("/", $url);
    return $tree[count($tree) - 1];
}
// chuyển trang của quyền chính và không cần tham số
function nextPage($user, $pass, $toast = "")
{
    $sql = "SELECT url FROM url JOIN quyenchinh ON quyenchinh.quyen = url.quyen JOIN taikhoan on taikhoan.user = quyenchinh.user WHERE taikhoan.user = ? AND taikhoan.pass = ? AND url.indata = 0 LIMIT 1";
    $result = query_input($sql, [$user, $pass]);
    if ($result->num_rows == 0) {
        header("Location: ../page/403.html");
    } else {
        while ($row = $result->fetch_assoc()) {
            header("Location: ../page/" . $row['url'] . $toast);
        }
    }
}

function get_ENV()
{
    try {
        // đường dẫn file env
        $envFilePath = '../config/.env';
        // đọc file
        $envData = parse_ini_file($envFilePath);
        if (count($envData) == 0) {
            return ["length" => 0];
        }
        return $envData;
    } catch (Exception $e) {
        log_error($e->getMessage());
        return ["error" => true];
    }
}

function log_error($message)
{

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $dateTime = new DateTime();
    $error_message = $dateTime->format('Y-m-d H:i:s') . "||" . $message;
    // Đường dẫn đến tệp tin log của bạn
    $log_file = '../config/log_error.txt';

    // Ghi thông điệp lỗi vào tệp tin log
    file_put_contents($log_file, $error_message . PHP_EOL, FILE_APPEND);
}

function uploadIMG($kyhieuanh)
{
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["anhsp"])) {
        

        $file_name = $_FILES['anhsp']['name'];
        $path_info = pathinfo($file_name);
        $imageFileType = strtolower($path_info['extension']);

        $target_dir = "../../public/image/uploads/";  // Thư mục nơi bạn muốn lưu trữ tệp tin
        $file_name = $kyhieuanh . getTimestamp(0).".".$imageFileType;
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;

        
        // Kiểm tra xem tệp tin đã tồn tại chưa
        // if (file_exists($target_file)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Kiểm tra kích thước tệp tin (giả sử giới hạn là 5MB)
        if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
            $uploadOk = 0;
        }

        // Cho phép các định dạng file nhất định (ở đây là chỉ cho phép hình ảnh)
        $allowedFormats = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedFormats)) {
            $uploadOk = 0;
        }

        // Kiểm tra xem $uploadOk có bằng 0 không (có lỗi xảy ra không)
        if ($uploadOk) {
            // Nếu mọi thứ đều đúng, thì tiến hành tải lên
            if (move_uploaded_file($_FILES["anhsp"]["tmp_name"], $target_file)) {
                return $file_name;
            }
        } else {
            echo "upload error";
            return null;
        }
    }
}

function remove_img($name, $location = "../../public/image/uploads/")
{
    if (trim($name)) {
        $target_file = $location . $name;
        $file_exisit = false;
        // Kiểm tra nếu tập tin đã tồn tại
        if (file_exists($target_file)) {
            $file_exisit = true;
        }

        if ($file_exisit) {
            if (!unlink($target_file)) {
                return false;
            }
        }
    }
    return true;
}

function getTime($timestamp, $format ,$timezone = "Asia/Ho_Chi_Minh")
{
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timestamp);
    $dateTime->setTimezone(new DateTimeZone($timezone));
    return $dateTime->format($format); //
}
function covint($inp, $key = false)
{
    $rt = NULL;
    if ($key) {
        if (checkRequest($inp, [$key])) {
            $rt = intval($inp[$key]);
        }
    } else {
        $rt = intval($inp);
    }
    return $rt;
}


function getBase64($F)
{

    // loại bỏ phần đầu của base64(chỉ định kiểu và đuôi ảnh)
    $imgData = str_replace('data:image/png;base64,', '', $F);
    //thay ' ' thành + để chuẩn định dạng base64
    $imgData = str_replace(' ', '+', $imgData);

    // Giải mã dữ liệu ảnh từ Base64
    $imgDecoded = base64_decode($imgData);
    return $imgDecoded;
}

function formatnumber($input)
{
    // Sử dụng number_format để định dạng số
    $formattedCurrency = number_format($input, 0, ',', '.');

    // Trả về chuỗi đã được định dạng
    return $formattedCurrency;
}
?>