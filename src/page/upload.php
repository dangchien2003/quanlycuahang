<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $target_dir = "./";  // Thư mục nơi bạn muốn lưu trữ tệp tin
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra xem tệp tin đã tồn tại chưa
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Kiểm tra kích thước tệp tin (giả sử giới hạn là 5MB)
    if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Cho phép các định dạng file nhất định (ở đây là chỉ cho phép hình ảnh)
    $allowedFormats = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Kiểm tra xem $uploadOk có bằng 0 không (có lỗi xảy ra không)
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Nếu mọi thứ đều đúng, thì tiến hành tải lên
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="file">Choose File:</label>
    <input type="file" name="file" id="file">
    <input type="submit" name="submit" value="Upload">
</form>

</body>
</html>
