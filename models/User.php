<?php
require_once 'config/Database.php';

class UserModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getPdo();
    }

    public function register($nickName, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (nick_name, email, password) VALUES (:nickName, :email, :password)");
        $stmt->bindParam(':nickName', $nickName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
   
    public function updateUser($user_id, $nickName, $photoProfile, $autobiography, $hashedNewPassword = null)
{
    $sql = "UPDATE users SET nick_name = :nickName, autobiography = :autobiography";

    if ($photoProfile !== null) {
        $sql .= ", photo_profile = :photoProfile";
    }

    if ($hashedNewPassword !== null) {
        $sql .= ", password = :password";
    }

    $sql .= " WHERE user_id = :user_id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':nickName', $nickName);
    $stmt->bindParam(':autobiography', $autobiography);
    $stmt->bindParam(':user_id', $user_id);

    if ($photoProfile !== null) {
        $stmt->bindParam(':photoProfile', $photoProfile);
    }

    if ($hashedNewPassword !== null) {
        $stmt->bindParam(':password', $hashedNewPassword);
    }

    return $stmt->execute();
}
public function getUserById($user_id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Повертає асоціативний масив
}

public function getWorksByUserId($userId) {
    $stmt = $this->db->prepare("SELECT * FROM work WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function deleteUser($user_id) {
    try {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return true;
    } catch (PDOException $e) {
        
        return false;
    }
}
}
?>
