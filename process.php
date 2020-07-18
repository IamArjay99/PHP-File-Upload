<?php

    // First : make sure that the file is not empty.
    function checkError($error) {
        return $error === 0 ? true : false;
    }

    // Second : make sure the file name in English characters, numbers and (_-.) symbols, For more protection.
    function checkName($name) {
        return (preg_match("`^[-0-9A-Z_\.]+$`i",$name)) ? true : false;
    }

    // Third : make sure that the file name not bigger than 250 characters.
    function checkNameLength($name) {
        return strlen($name) <= 255 ? true : false;
    }

    // Fourth: Check File extensions and Mime Types that you want to allow in your project.
    function checkFileExtension($type) {
        $type = strtolower($type);
        $allowedExtensions = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/jpe"]; 
        // in_array(find, array, strict)
        return in_array($type, $allowedExtensions, true) ? true : false;
    }

    // Fifth: Check file size
    function checkSize($size) {
        // This is in MB format
        $allowedSize = 2.0; 
        // Convert bytes into MB and to 2 decimal point
        $convertToMB = number_format($size / 125000, 2);
        return $convertToMB < $allowedSize ? true : false;
    }

    function getFileActualExtension($name) {
        $path_parts = pathinfo($name);
        $dirname = $path_parts['dirname'];
        $basename = $path_parts['basename'];
        $extension = $path_parts['extension'];
        $filename = $path_parts['filename']; // since PHP 5.2.0
        return $extension;
    }

    // Single file
    if (isset($_POST['file1'])) {
        // Var dump gives information about the data in variable
        // var_dump($_FILES['file1']);

        // Print in human readable
        // print_r($_FILES['file1']);

        $name = $_FILES['file1']['name'];
        $type = $_FILES['file1']['type'];
        $tmp_name = $_FILES['file1']['tmp_name'];
        $error = $_FILES['file1']['error'];
        $size = $_FILES['file1']['size'];

        if (checkError($error)) {
            if (checkName($name)) {
                if (checkNameLength($name)) {
                    if (checkFileExtension($type)) {
                        if (checkSize($size)) {
                            $fileActualExtension = getFileActualExtension($name);
                            // Make it unique filename to avoid overwritten of the file
                            $path = "upload/".uniqid('', true).".".$fileActualExtension;
                            move_uploaded_file($tmp_name, $path);
                            echo "success";
                        } else {
                            echo "Size must not be greater than 2MB";
                        }
                    } else {
                        echo "Only images file are allowerd";
                    }
                } else {
                    echo "Name must not exceed to 255 characters length";
                }
            } else {
                echo "Name must not contain any special characters.";
            }
        } else {
            echo "There's an error in the file.";
        }
    }

    // For multiple files
    if (isset($_POST['file2'])) {
        $count = count($_FILES['file2']['name']);

        $successCount = 0;
        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $name = $_FILES['file2']['name'][$i];
            $type = $_FILES['file2']['type'][$i];
            $tmp_name = $_FILES['file2']['tmp_name'][$i];
            $error = $_FILES['file2']['error'][$i];
            $size = $_FILES['file2']['size'][$i];

            if (checkError($error)) {
                if (checkName($name)) {
                    if (checkNameLength($name)) {
                        if (checkFileExtension($type)) {
                            if (checkSize($size)) {
                                $fileActualExtension = getFileActualExtension($name);
                                // Make it unique filename to avoid overwritten of the file
                                $path = "upload/".uniqid('', true).".".$fileActualExtension;
                                array_push($data, [$tmp_name, $path]);
                                $successCount++;
                            } else {
                                echo "Size must not be greater than 2MB";
                                return;
                            }
                        } else {
                            echo "Only images file are allowerd";
                            return;
                        }
                    } else {
                        echo "Name must not exceed to 255 characters length";
                        return;
                    }
                } else {
                    echo "Name must not contain any special characters.";
                    return;
                }
            } else {
                echo "There's an error in the file.";
                return;
            }
        }

        // If all had passed all the requirements, then upload it
        if ($successCount === $count) {
            for ($i = 0; $i < $successCount; $i++) {
                $tmp_name = $data[$i][0];
                $path = $data[$i][1];
                move_uploaded_file($tmp_name, $path);
            }
            echo "Success";
        }
    }