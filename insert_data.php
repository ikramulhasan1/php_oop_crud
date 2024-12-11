<?php
if (isset($_POST['add_student'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $age = $_POST['age'];

    
    echo $firstName, $lastName, $age;
}
