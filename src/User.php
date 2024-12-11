<?php

namespace App;

use PDO;
use PDOException;

class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /*
     Поиск пользователей по имени или email.
     
      @param string $searchString Поисковая строка (имя или email).
      @return array Массив пользователей.
     */
    public function search(string $searchString = ''): array
    {
        if (empty($searchString)) {
            $sql = "SELECT * FROM users";
            $stmt = $this->db->query($sql);
        } else {
            $sql = "SELECT * FROM users WHERE name LIKE :search OR email LIKE :search";
            $stmt = $this->db->query($sql, [' :search' => "%{$searchString}%"]);
        }

        return $stmt->fetchAll();
    }

    /*
      Добавление нового пользователя.
     
      @param string $name Имя пользователя.
      @param string $email Email пользователя.
      @return int|false ID добавленного пользователя или false в случае ошибки.
     /
    public function add(string $name, string $email): int|false
    {
        if (!$this->validateEmail($email)) {
            return false;
        }

        $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $this->db->query($sql, [' :name' => $name, ' :email' => $email]);

        return $stmt ? $this->db->lastInsertId() : false;
    }

    /*
      Обновление данных пользователя.
     
      @param int $id ID пользователя.
      @param string $name Новое имя пользователя.
      @param string $email Новый email пользователя.
      @return bool True в случае успеха, false в случае ошибки или если пользователь не найден.
     */
    public function update(int $id, string $name, string $email): bool
    {
        if (!$this->exists($id)) {
            return false;
        }

        if (!$this->validateEmail($email)) {
            return false;
        }

        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->query($sql, [' :id' => $id, ' :name' => $name, ' :email' => $email]);

        return $stmt->rowCount() > 0;
    }

    /*
      Удаление пользователя.
     
      @param int $id ID пользователя.
      @return bool True в случае успеха, false в случае ошибки или если пользователь не найден.
     /
    public function delete(int $id): bool
    {
        if (!$this->exists($id)) {
            return false;
        }

        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->query($sql, [' :id' => $id]);

        return $stmt->rowCount() > 0;
    }

    /*
      Проверка существования пользователя по ID.
     
      @param int $id ID пользователя.
      @return bool True, если пользователь существует, false в противном случае.
     */
    public function exists(int $id): bool
    {
        $sql = "SELECT 1 FROM users WHERE id = :id";
        $stmt = $thisф->db->query($sql, [' :id' => $id]);

        return $stmt->fetchColumn() !== false;
    }

    /*
      Проверка валидности email.
     
      @param string $email Email для валидации.
      @return bool True, если email валиден, false в противном случае.
     */
    private function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
