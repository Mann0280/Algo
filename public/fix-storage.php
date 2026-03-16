<?php
/**
 * Standalone Storage Link Fixer
 * Bypasses Laravel routing and exec() restrictions.
 */

// Relative to the public folder
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

echo "<h3>Symbolic Link Fixer</h3>";
echo "Target: $target <br>";
echo "Shortcut: $shortcut <br><br>";

if (file_exists($shortcut) || is_link($shortcut)) {
    echo "<b>Note:</b> A link or folder already exists at 'public/storage'.<br>";
    if (is_link($shortcut)) {
        echo "Current Target: " . readlink($shortcut) . "<br>";
    }
    echo "If images are broken, delete the folder 'public/storage' and run this again.";
    exit;
}

if (!file_exists($target)) {
    echo "<b>Error:</b> Target folder not found at '$target'. Make sure you uploaded at least one image.";
    exit;
}

if (symlink($target, $shortcut)) {
    echo "<b style='color:green'>SUCCESS!</b> The link has been created.";
} else {
    echo "<b style='color:red'>FAILED.</b> Permission denied or symlink() disabled. Please contact hosting support.";
}
