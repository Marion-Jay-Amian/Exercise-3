<?php
$directory = 'data/';


if (!file_exists($directory)) {
    mkdir($directory, 0755, true);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

$file_path = '';
$name = '';

if ($action === 'create' || $action === 'append' || $action === 'load' || $action === 'read') {
    $name = isset($_POST['name']) ? $_POST['name'] : (isset($_GET['name']) ? $_GET['name'] : '');
    $file_path = $directory . str_replace(' ', '_', $name) . '.txt';
}

echo "<!-- File path: $file_path -->";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($action === 'create') {
        if (!empty($_POST['name']) && !empty($_POST['age']) && !empty($_POST['email'])) {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $email = $_POST['email'];
            
            if (!file_exists($file_path)) {
                $content = "Name: $name\nAge: $age\nEmail: $email\n";
                file_put_contents($file_path, $content);
                echo "New file '$file_path' created.";
            } else {
                echo "File '$file_path' already exists.";
            }
        } else {
            echo "Please fill out all fields.";
        }
    } elseif ($action === 'append') {
        if (!empty($_POST['name']) && !empty($_POST['age']) && !empty($_POST['email'])) {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $email = $_POST['email'];
            
            if (file_exists($file_path)) {
                $content = "\nUpdated Age: $age\nUpdated Email: $email\n";
                file_put_contents($file_path, $content, FILE_APPEND);
                echo "Information appended successfully to '$file_path'.";
            } else {
                echo "File does not exist. Please create the file first.";
            }
        } else {
            echo "Please fill out all fields.";
        }
    }
} elseif ($action === 'load') {
    if (file_exists($file_path)) {
        $contents = file_get_contents($file_path);
        echo "File contents of '$file_path':\n" . nl2br(htmlspecialchars($contents));
    } else {
        echo "File '$file_path' does not exist.";
    }
} elseif ($action === 'read') {
    if (file_exists($file_path)) {
        $lines = file($file_path, FILE_IGNORE_NEW_LINES);
        echo "Reading file '$file_path' line by line:\n";
        foreach ($lines as $line) {
            echo htmlspecialchars($line) . "<br>";
        }
    } else {
        echo "File '$file_path' does not exist.";
    }
} else {
    echo "Invalid action.";
}
?>
