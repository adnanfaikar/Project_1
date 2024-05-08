<?php
$upload_directory = "uploads/";

$files = scandir($upload_directory);
$count = 0; // Initialize counter for images in the current row

foreach($files as $file) {
    if ($file != '.' && $file != '..') {
        // Start a new row if the current row is filled with 6 images
        if ($count % 6 == 0) {
            echo "<div style='display: flex; flex-wrap: wrap;'>";
        }
        
        // Display the image
        echo "<div style='flex: 0 0 16.666%; max-width: 16.666%; padding: 5px;'>";
        echo "<img src='$upload_directory/$file' alt='Uploaded File' style='max-width: 100%; max-height: 100%;'>";
        echo "</div>";
        
        $count++; // Increment the image counter

        // Close the row if it's filled with 6 images
        if ($count % 6 == 0) {
            echo "</div>"; // Close the row
        }
    }
}

// Close the last row if it's not fully filled
if ($count % 6 != 0) {
    echo "</div>"; // Close the last row
}
?>
