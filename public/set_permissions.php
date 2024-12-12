<?php
$path = __DIR__ . '/media';
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
);
foreach ($iterator as $item) {
    if ($item->isDir()) {
        chmod($item, 0755); // Set folder permissions
    } elseif ($item->isFile()) {
        chmod($item, 0644); // Set file permissions
    }
}
echo "Permissions updated successfully.";
?>
