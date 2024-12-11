<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\User;

$config = require __DIR__ . '/src/config.php';
$db = new Database($config['db']);
$user = new User($db);

// Пример

// Поиск пользователей
echo "<h2>Поиск пользователей:</h2>";
$users = $user->search(); // Все пользователи
echo "<h3>Все пользователи:</h3>";
print_r($users);

$users = $user->search('John'); // Пользователи с именем John
echo "<h3>Пользователи с именем John:</h3>";
print_r($users);

$users = $user->search('@example.com'); // Пользователи с email на домене example.com
echo "<h3>Пользователи с email на домене example.com:</h3>";
print_r($users);

// Добавление пользователя
echo "<h2>Добавление пользователя:</h2>";
$newUserId = $user->add('New User', 'newuser@example.com');
if ($newUserId !== false) {
    echo "Пользователь добавлен с ID: " . $newUserId . "<br>";
} else {
    echo "Ошибка при добавлении пользователя.<br>";
}

// Обновление пользователя
echo "<h2>Обновление пользователя:</h2>";
if ($user->update($newUserId, 'Updated User', 'updateduser@example.com') !== false) {
    echo "Пользователь с ID {$newUserId} обновлен.<br>";
} else {
    echo "Ошибка при обновлении пользователя или пользователь не найден.<br>";
}

// Удаление пользователя
echo "<h2>Удаление пользователя:</h2>";
if ($user->delete($newUserId) !== false) {
    echo "Пользователь с ID {$newUserId} удален.<br>";
} else {
    echo "Ошибка при удалении пользователя или пользователь не найден.<br>";
}
