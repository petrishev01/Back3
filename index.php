<?php
header('Content-Type: text/html; charset=UTF-8');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
      print('Complete');
    }
    include('form.php');
    exit();
}

$result;

try{
    $errors = FALSE;
    if (empty($_POST['field-name'])) {
        print('Заполните имя.<br/>');
        $errors = TRUE;
    }
    if (empty($_POST['field-email'])) {
        print('Заполните почту.<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['BIO'])) {
        print('Заполните биографию.<br/>');
        $errors = TRUE;
    }
    if (empty($_POST['ch'])) {
        print('Согласитесь с условиями.<br/>');
        $errors = TRUE;
    }
    if ($errors) {
        exit();
    }
    $name = $_POST['field-name'];
    $email = $_POST['field-email'];
    $dob = $_POST['field-date'];
    $gender = $_POST['radio-gender'];
    $limbs = $_POST['radio-limb'];
    $bio = $_POST['BIO'];
    $che = $_POST['ch'];
    $sup= implode(",",$_POST['superpower']);
    $conn = new PDO("mysql:host=localhost;dbname=u47476", 'u47476', '3289244', array(PDO::ATTR_PERSISTENT => true));
    $user = $conn->prepare("INSERT INTO forma SET name = ?, email = ?, dob = ?, gender = ?, limbs = ?, bio = ?, che = ?");
    $user -> execute([$_POST['field-name'], $_POST['field-email'], date('Y-m-d', strtotime($_POST['field-date'])), $_POST['radio-gender'], $_POST['radio-limb'], $_POST['BIO'], $_POST['ch']]);
    $id_user = $conn->lastInsertId();

    $user1 = $conn->prepare("INSERT INTO ability SET id = ?, super_name = ?");
    $user1 -> execute([$id_user, $sup]);
    $result = true;
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
if ($result) {
  echo "ID_user №" . $id_user;
}
?>
