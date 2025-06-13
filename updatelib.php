<?php

namespace Nzv;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;
use CURLFile;
use Exception;

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

function sendUpdates($url, $psw, $pathToFile) {
    if (!file_exists($pathToFile)) {
        throw new Exception("Файл не найден: $pathToFile");
    }

    $postFields = [
        'psw' => $psw,
        'action' => 'update',
        'update_file' => new CURLFile($pathToFile)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("Ошибка cURL: $error");
    }

    curl_close($ch);
    return $response;
}



