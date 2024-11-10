<?php // show.php показывает конкретную запись

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$currentUserId = 1;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_GET['id']
])->findOrFail();

authorize((int)$note['user_id'] === $currentUserId);

view("notes/show.view.php", [
    'heading' => 'Note',
    'note' => $note
]);