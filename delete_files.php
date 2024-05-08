<?php
$upload_directory = "uploads/";

// Check if files to delete are set and not empty
if(isset($_POST['filesToDelete']) && !empty($_POST['filesToDelete'])) {
    // Loop through each selected file
    foreach($_POST['filesToDelete'] as $filename) {
        // Construct the full path to the file
        $filepath = $upload_directory . $filename;
        
        // Check if the file exists and is writable
        if(file_exists($filepath) && is_writable($filepath)) {
            // Attempt to delete the file
            if(unlink($filepath)) {
                // File deleted successfully
                // You can log this event if needed
                echo "File deleted: " . $filename;
            } else {
                // Failed to delete the file
                // You can log this event or handle the error as needed
                echo "Failed to delete file: " . $filename;
            }
        } else {
            // File does not exist or is not writable
            // You can log this event or handle the error as needed
            echo "File not found or not writable: " . $filename;
        }
    }
    
    // Return success message
    echo "success";
} else {
    // No files selected for deletion
    echo "No files selected for deletion.";
}
?>
