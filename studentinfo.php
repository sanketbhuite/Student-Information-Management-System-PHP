<?php

// Function to enter student data
function enter_data() {
    $name = readline("Enter student name: ");
    $rollno = readline("Enter roll number: ");
    $marks = readline("Enter marks: ");
    return array($name, $rollno, $marks);
}

// Function to write data into the file
function write_data($data) {
    $file = fopen("student_info.txt", "a+");
    fwrite($file, implode("|", $data) . "\n");
    fclose($file);
}

// Function to search for student data
function search($s) {
    $file = fopen("student_info.txt", "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            if (strpos($line, $s) !== false) {
                fclose($file);
                return $line;
            }
        }
        fclose($file);
    }
    return null;
}

// Function to update student data
function update($s, $new_info) {
    $lines = file("student_info.txt", FILE_IGNORE_NEW_LINES);
    $file = fopen("student_info.txt", "w");

    foreach ($lines as $line) {
        if (strpos($line, $s) !== false) {
            fwrite($file, $new_info . "\n");
        } else {
            fwrite($file, $line . "\n");
        }
    }
    fclose($file);
}

// Function to delete student data
function delete($s) {
    $lines = file("student_info.txt", FILE_IGNORE_NEW_LINES);
    $file = fopen("student_info.txt", "w");

    foreach ($lines as $line) {
        if (strpos($line, $s) === false) { // Write only lines that do not match the search string
            fwrite($file, $line . "\n");
        }
    }
    fclose($file);
}

// Function to display student data
function display_data() {
    $file = fopen("student_info.txt", "r");
    echo "Name\tRoll Number\tMarks\n";
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $data = explode("|", trim($line));
            if (count($data) >= 3) {
                echo "{$data[0]}\t{$data[1]}\t{$data[2]}\n";
            } else {
                echo "Invalid data format in file.\n";
            }
        }
        fclose($file);
    }
}

// Main program loop
while (true) {
    echo "\nEnter choice\n1: Add the Student ID\n2: Read the Information\n3: Search the Student ID\n4: Update the Data\n5: Delete the Data\n6: Exit\n";
    $choice = readline("Enter choice: ");

    switch ($choice) {
        case "1":
            $data = enter_data();
            write_data($data);
            echo "Data added!!\n";
            break;

        case "2":
            echo "Student information:\n";
            display_data();
            break;

        case "3":
            $s = readline("Enter student ID to search: ");
            $r = search($s);
            if ($r) {
                echo "Entered word/value exists\n";
                echo "Student info: $r";
            } else {
                echo "Student not found.\n";
            }
            break;

        case "4":
            $s = readline("Enter student ID to update: ");
            $ni = readline("Enter new information (Name|RollNumber|Marks): ");
            update($s, $ni);
            echo "Student info updated.\n";
            break;

        case "5":
            $s = readline("Enter student ID to delete: ");
            delete($s);
            echo "Student info deleted.\n";
            break;

        case "6":
            echo "Program completed.\n";
            exit;

        default:
            echo "Invalid choice. Please try again.\n";
    }
}

?>