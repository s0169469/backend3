<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u',$_POST['email'])) {
  print('Зaполните email.<br/>');
  $errors = TRUE;
}

if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='w')) {
  print('Заполните пол.<br/>');
  $errors = TRUE;
}
if (empty($_POST['limbs']) || ($_POST['limbs']!='1' && $_POST['limbs']!='2' && $_POST['limbs']!='3' && $_POST['limbs']!='4')) {
  print('Заполните количество конечностей.<br/>');
  $errors = TRUE;
}

if (empty($_POST['biography']) || !preg_match('/^([0-9a-zA-Zа-яА-Я\,\.\s]{1,})$/', $_POST['biography']) ){
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}
if (empty($_POST['ability'])) {
  print('Заполните сверхспособности.<br/>');
  $errors = TRUE;
}



// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.
$user = 'u51489';
$pass = '7565858';
$db = new PDO('mysql:host=localhost;dbname=u51489', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, year = ?, gender = ?, biography = ?, limbs = ?");
  $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['biography'], $_POST['limbs'] ]);
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

$app_id = $db->lastInsertId();

try{
  $stmt = $db->prepare("REPLACE INTO abilities (id,name_of_ability) VALUES (10, 'Бессмертие'), (20, 'Прохождение сквозь стены'), (30, 'Левитация')");
  $stmt-> execute();
}
catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
}

//try {
  //$stmt = $db->prepare("INSERT INTO link SET app_id = ?, ab_id = ?");
  //foreach ($_POST['abilities'] as $ability) {
  //$stmt -> execute([$app_id, $ability]);
  //}
//}
try {
  $stmt = $db->prepare("INSERT INTO ability_application SET application_id = ?, ability_id = ?");
  foreach ($_POST['abilities'] as $ability) {
    if ($ability=='Бессмертие')
    {$stmt -> execute([$application_id, 10]);}
    else if ($ability=='Прохождение сквозь стены')
    {$stmt -> execute([$application_id, 20]);}
    else if ($ability=='Левитация')
    {$stmt -> execute([$application_id, 30]);}
  }
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');

