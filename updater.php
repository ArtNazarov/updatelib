<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/updatelib.php');
define('PASS_IS', 'CHANGE_IT');
$dir = $_SERVER['DOCUMENT_ROOT'];

 

if (($_POST['action'] === 'update') && ($_POST['psw']=== PASS_IS)) {
    echo "Clearing...\n";
    // clear
    try {
        \Nzv\deleteDirectory($dir);
        
        if (\Nzv\isDirectoryEmpty($dir)) {
            echo "Clearing done!";
            if (!is_dir($dir)) { mkdir($dir, 0755); };
        } else {
            echo "Clearing failed. Something still exists.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Handle file upload and unzip
    if (isset($_FILES['update_file'])) {
        $file = $_FILES['update_file'];
        
        // Check for errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("\n Upload failed with error code " . $file['error']);
        }
        
        // Verify the file is a ZIP archive
        $file_info = pathinfo($file['name']);
        if (strtolower($file_info['extension']) !== 'zip') {
            die("\n Only ZIP archives are allowed");
        }
        
        $temp_path = $file['tmp_name'];
        $zip = new ZipArchive;
        
        if ($zip->open($temp_path) === TRUE) {
            // Extract to document root
            $zip->extractTo($dir);
            $zip->close();
            echo "\n Update successfully extracted to $dir";
        } else {
            echo "\n Failed to open the ZIP file";
        }
        
        // Clean up the temp file
        unlink($temp_path);
    } else {
        echo "\n No file uploaded";
    }
  
} else if ( ( $_GET['action'] === 'update-form') && ($_GET['psw'] === PASS_IS )) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Update Uploader</title>
    </head>
    <body>
        <h2>Upload Update ZIP</h2>
        <form action="updater.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="psw" value="' . PASS_IS . '">
            Select ZIP file to upload:
            <input type="file" name="update_file" id="update_file">
            <input type="submit" value="Upload Update" name="submit">
        </form>
    </body>
    </html>
    ';
} else {
    echo "Password or action is wrong";
}
?>
