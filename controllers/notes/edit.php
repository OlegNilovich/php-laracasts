<?php // edit.php показывает форму для редактирования записи

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$currentUserId = 1;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_GET['id']
])->findOrFail();

authorize((int)$note['user_id'] === $currentUserId);

view("notes/edit.view.php", [
	'heading' => 'Edit Note',
	'errors' => [],
	'note' => $note
]);
