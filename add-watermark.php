<?php
function addWatermark($filepath) {
    // Load the watermark logo
    $logopath = "images/logo/logo1.png";
    $logo = imagecreatefrompng($logopath);
    
    // Detect the image type
    $image_info = getimagesize($filepath);
    $image_type = $image_info[2];

    // Create an image resource from the file based on the image type
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($filepath);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($filepath);
            break;
        case IMAGETYPE_WEBP:
            $image = imagecreatefromwebp($filepath);
            break;
        default:
            echo "Unsupported image format!";
            return;
    }

    // Get dimensions of the image and logo
    $image_width = imagesx($image);
    $image_height = imagesy($image);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Scale logo to fit within the image
    $logo_max_width = $image_width / 4; // Adjust size relative to the image width
    $scale = $logo_width / $logo_max_width;
    $logo_resized_width = $logo_max_width;
    $logo_resized_height = $logo_height / $scale;

    // Resize the logo
    $logo_resized = imagecreatetruecolor($logo_resized_width, $logo_resized_height);
    imagealphablending($logo_resized, false);
    imagesavealpha($logo_resized, true);
    $transparent = imagecolorallocatealpha($logo_resized, 0, 0, 0, 127);
    imagefill($logo_resized, 0, 0, $transparent);
    imagecopyresampled($logo_resized, $logo, 0, 0, 0, 0, $logo_resized_width, $logo_resized_height, $logo_width, $logo_height);

    // Set the opacity for merging the logo
    $opacity = 13; // 0 = fully transparent, 100 = fully opaque

    // Merge the logo onto the original image with specified opacity
    imagecopymerge($image, $logo_resized, ($image_width - $logo_resized_width) / 2, ($image_height - $logo_resized_height) / 2, 0, 0, $logo_resized_width, $logo_resized_height, $opacity);

    // Save the image back to the same file path (replacing the original file)
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            imagejpeg($image, $filepath, 100); // Save and replace with max quality
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $filepath); // Save and replace
            break;
        case IMAGETYPE_WEBP:
            imagewebp($image, $filepath, 100); // Save and replace with max quality
            break;
    }

    // Free up memory
    imagedestroy($image);
    imagedestroy($logo);
    imagedestroy($logo_resized);
}
?>
