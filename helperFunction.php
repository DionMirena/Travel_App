<?php
function getImagePath($image_string, $default = 'assets/placeholder.jpg') {
    if (empty($image_string)) {
        return $default;
    }
    
    $images = explode(',', $image_string);
    $image_path = trim($images[0]);
    
    if (strpos($image_path, 'assets/') === false) {
        $image_path = 'assets/' . $image_path;
    }
    
    if (!file_exists($image_path)) {
        return $default;
    }
    
    return $image_path;
}
?>