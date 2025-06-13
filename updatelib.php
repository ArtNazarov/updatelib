<?php

namespace Nzv;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

function deleteDirectory($dir) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            rmdir($file->getPathname());
        } else {
            unlink($file->getPathname());
        }
    }
    return rmdir($dir);
}

function isDirectoryEmpty($dir){
    if (!file_exists($dir)) return true;
	$iterator = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
	$count = iterator_count($iterator);
	return $count === 0;
}


