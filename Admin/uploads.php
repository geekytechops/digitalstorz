<?php
$targetDir = "uploads/"; // Directory where you want to save the images
$response = array();

// Check if the images array is set
if (isset($_FILES['images'])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        // Get the original file extension
        $fileExtension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);

        // Generate a random file name with the same extension
        $randomFileName = uniqid('img_', true) . '.' . $fileExtension;
        $targetFilePath = $targetDir . $randomFileName;

        // Check if the directory exists, if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move the file to the target directory with the random name
        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            array_push($response,$randomFileName);
        } else {
            $response[] = array("file" => $_FILES['images']['name'][$key], "status" => "error");
        }
    }

    echo json_encode($response);
} else {
    echo json_encode(array("status" => "error", "message" => "No images were uploaded."));
}
?>
