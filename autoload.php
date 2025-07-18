<?php
spl_autoload_register(function ($class) {
    // PSR-4 prefix to base directory mapping
    $prefixes = [
        'App\\' => __DIR__ . '/app/',
        'Lib\\' => __DIR__ . '/lib/',        
        // Add more if needed (e.g., 'App\\' => __DIR__ . '/app/')
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        // Skip if class does not start with this prefix
        if (strpos($class, $prefix) !== 0) continue;

        // Remove namespace prefix
        $relativeClass = substr($class, strlen($prefix));

        // Replace namespace separators with slashes, append .php
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        
        if (file_exists($file)) {
            // Enforce case sensitivity
            $realPath = realpath($file);
            if ($realPath && strcmp($realPath, $file) === 0) {
                require_once $file;
                return;
            } else {
                die("<br>Case mismatch: expected '$file' but found '$realPath'");
            }
        } else {
            die("<br>File not found for class: $class");
        }
    }

    // If no prefix matched
    die("<br>No autoload prefix matched for class: $class");
});