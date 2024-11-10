<?php // update.php редактирует конкретную запись

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;

// Поиск нужной записи
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_POST['id']
])->findOrFail();

// Авторизация юзера
authorize((int)$note['user_id'] === $currentUserId);

// Валидация формы
$errors = [];

if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

// Если нет ошибок валидации, обновленяем запись
if (count($errors)) {
	return view('notes/edit.view.php', [
		'heading' => 'Edit Note',
		'errors' => $errors,
		'note' => $note
	]);
}

$db->query('UPDATE notes SET body = :body WHERE id = :id', [
	'id' => $_POST['id'],
	'body' => $_POST['body']
]);

// Редирект
header('location: /notes');
die();