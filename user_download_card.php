<?php
$slots = ['1' => '6:00AM to 7:00AM', '2' => '7:00AM to 8:00AM', '3' => '8:00AM to 9:00AM', '4' => '4:30PM to 5:30PM', '5' => '5:30PM to 6:30PM', '6' => '6:30PM to 7:30PM'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded and there's no error
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded file's temporary location
        $tmpName = $_FILES['image']['tmp_name'];

        // Get the image type and dimensions
        $imageInfo = getimagesize($tmpName);
        if ($imageInfo !== false) {
            // Extract MIME type
            $mimeType = $imageInfo['mime'];

            // Create an image resource based on the file type
            switch ($mimeType) {
                case 'image/png':
                    $dbimage = imagecreatefrompng($tmpName);
                    break;
                case 'image/jpeg': // Handles both .jpg and .jpeg
                    $dbimage = imagecreatefromjpeg($tmpName);
                    break;
                default:
                    die('Unsupported image format. Please upload a PNG or JPG file.');
            }

            if ($dbimage === false) {
                die('Failed to create an image resource from the uploaded file.');
            }

            // Perform operations on the image (e.g., add text, resize, etc.)

            $name = $_POST['name'];
            $id = $_POST['id'];
            $slot = $_POST['slot'];
            $slot = $slots[$slot];
            $expiry = $_POST['expiry'];
            $expiry = date('d-m-Y', strtotime($expiry));
            $ename = $_POST['ename'];
            $econtact = $_POST['econtact'];
            $subid = '24CFC_' . $id . '_452';

            $imgPath = 'static/gym_card.png';
            $image = imagecreatefrompng($imgPath);

            $black = imagecolorallocate($image, 0, 0, 0);
            $fontPath = 'static/Times_New_Roman.ttf';

            imagettftext($image, 50, 0, 50, 370, $black, $fontPath, "Name: $name");
            imagettftext($image, 50, 0, 50, 520, $black, $fontPath, "Student ID: $id");
            imagettftext($image, 50, 0, 50, 670, $black, $fontPath, "Slot: $slot");
            imagettftext($image, 50, 0, 50, 820, $black, $fontPath, "Expiry: $expiry");
            imagettftext($image, 50, 0, 50, 970, $black, $fontPath, "Emergency Details :");
            imagettftext($image, 50, 0, 50, 1120, $black, $fontPath, "$ename - $econtact");
            imagettftext($image, 60, 0, 900, 1120, $black, $fontPath, "$subid");

            $maxWidth = 575;
            $maxHeight = 700;

            $originalWidth = imagesx($dbimage);
            $originalHeight = imagesy($dbimage);

            $aspectRatio = $originalWidth / $originalHeight;
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                if ($aspectRatio > 1) {
                    $newWidth = $maxWidth;
                    $newHeight = $maxWidth / $aspectRatio;
                } else {
                    $newHeight = $maxHeight;
                    $newWidth = $maxHeight * $aspectRatio;
                }
            } else {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }

            $resizedDbImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedDbImage, $dbimage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            imagecopy($image, $resizedDbImage, 1050, 350, 0, 0, $newWidth, $newHeight);

            imagedestroy($dbimage);
            imagedestroy($resizedDbImage);




            // For demonstration, let's output the image to the browser
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: attachment; filename="'.$id.'_profile.png"');
            switch ($mimeType) {
                case 'image/png':
                    imagepng($image);
                    break;
                case 'image/jpeg':
                    imagejpeg($image);
                    break;
            }

            // Free the memory associated with the image resource
            imagedestroy($image);
        } else {
            die('The uploaded file is not a valid image.');
        }
    } else {
        die('No file uploaded or an error occurred during the upload.');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Image</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">

        <label for="name">Enter name</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="id">Enter student id</label>
        <input type="text" id="id" name="id" required><br><br>

        <label for="slot">Enter slot (1-6)</label>
        <input type="number" id="slot" name="slot" required min="1" max="6"><br><br>

        <label for="expiry">Enter expiry date</label>
        <input type="date" id="expiry" name="expiry" required><br><br>

        <label for="ename">Enter emargency name</label>
        <input type="text" id="ename" name="ename" required><br><br>

        <label for="econtact">Enter emergency contact</label>
        <input type="text" id="econtact" name="econtact" required maxlength="10"><br><br>

        <label for="image">Upload an image (PNG, JPG):</label>
        <input type="file" name="image" id="image" accept="image/png, image/jpeg" required><br><br>
        <button type="submit">Upload</button>
    </form>
</body>

</html>