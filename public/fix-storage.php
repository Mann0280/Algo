<?php
/**
 * Advanced Standalone Storage Link Fixer
 * Handles Shared Hosting structures (e.g. public_html vs stock/public)
 */

$shortcut = __DIR__ . '/storage';

// Detect Target Path
// 1. Try relative if this script is in public_html and laravel is in stock/
$targetCandidate1 = __DIR__ . '/../stock/storage/app/public';
// 2. Try relative if this script is in stock/public
$targetCandidate2 = __DIR__ . '/../../storage/app/public';

$target = file_exists($targetCandidate1) ? $targetCandidate1 : (file_exists($targetCandidate2) ? $targetCandidate2 : null);

echo "<h3>Advanced Symbolic Link Fixer</h3>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Detected Target: " . ($target ?: "<b style='color:red'>NOT FOUND</b>") . "<br>";
echo "Shortcut to Create: $shortcut <br><br>";

if (!$target) {
    echo "<b>Error:</b> Could not find the Laravel storage folder. <br>";
    echo "Looking for: <br>";
    echo " - $targetCandidate1 <br>";
    echo " - $targetCandidate2 <br>";
    echo "Please edit this script to set the target path manually.";
    exit;
}

// 1. Handle existing path
if (file_exists($shortcut) || is_link($shortcut)) {
    echo "<b>Note:</b> A link or folder already exists at 'public/storage'.<br>";
    if (is_link($shortcut)) {
        echo "Current Target: " . @readlink($shortcut) . "<br>";
        echo "Deleting old link...<br>";
        @unlink($shortcut);
    } else {
        echo "<b>WARNING:</b> A REAL FOLDER exists at 'public/storage'.<br>";
        echo "Please delete the FOLDER 'storage' inside your 'public_html' via File Manager, then refresh this page.";
        exit;
    }
}

// 2. Attempt Symlink
if (@symlink($target, $shortcut)) {
    echo "<b style='color:green'>SUCCESS!</b> The link has been created.<br>";
} else if (function_exists('exec')) {
    echo "Native symlink failed. Trying shell command...<br>";
    $cmd = "ln -s " . escapeshellarg($target) . " " . escapeshellarg($shortcut);
    @exec($cmd, $o, $r);
    if ($r === 0) {
        echo "<b style='color:green'>SUCCESS!</b> (via shell) The link has been created.<br>";
    } else {
        echo "<b style='color:red'>FAILED</b> even via shell. Permission denied.<br>";
    }
} else {
    echo "<b style='color:red'>FAILED.</b> symlink() is disabled and exec() is restricted.<br>";
    echo "Please contact your hosting provider and ask them to create a link from <code>$shortcut</code> to <code>$target</code>.";
}

// 3. Set Permissions as requested
if (file_exists($target)) {
   @chmod($target, 0775);
   echo "Fixed permissions for target: 775<br>";
}
if (file_exists($shortcut)) {
   @chmod($shortcut, 0775);
   echo "Fixed permissions for shortcut: 775<br>";
}
