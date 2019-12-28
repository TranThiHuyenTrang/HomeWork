<?php
$images = array();$server = "localhost";
$user = "root";
$password ="";
$dbName = "photo";
$db = new mysqli($server, $user, $password, $dbName);


if (isset($_FILES["fileToUpload"])) {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
            // added by me
            $name = $_FILES["fileToUpload"]["name"];
            $sql1 = "INSERT INTO `anh`(`link`) VALUES ("."'"."img/".$name."'".")";
            $db->query($sql1);  
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    echo '<div class="grid">';
    if (isset($_POST["view"])) {
        $sql = "SELECT * from anh";
        $result = $db->query($sql)->fetch_all();
        for ($i=0; $i < count($result) ; $i++) {
            echo "<img src="."'".$result[$i][1]."'></div>";
        }    
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload file</title>
    <style type="text/css">
        /*form{
            display: grid;
            grid-template-columns: auto auto;
            align-items: center;
            text-align: center;
        }*/
        .grid{
            display: grid;
            grid-column: auto auto auto;
        }
        img{
            height: 100px;
            width: 100px;
        }
        input{
            padding: 5px 10px;
        }
        button{
            border: none;
            border-radius: 10px;
            color: white;
            height: 30px;
            padding: 5px 10px;
            font-weight: bold;
            background-image: linear-gradient(to right,rgb(0, 255, 255) ,rgb(0, 191, 255),rgb(0, 128, 255));
        }
    </style>
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    <button name="view">My Photos</button>
</form>
</body>
</html>