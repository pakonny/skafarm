<?php
class User
{
    private $conn;
    private $table = "master_user";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByEmail($email)
    {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql   = "SELECT * FROM {$this->table} WHERE email = '$email' LIMIT 1";
        $res   = mysqli_query($this->conn, $sql);
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    public function create($data)
    {
        $username = mysqli_real_escape_string($this->conn, $data['username']);
        $email    = mysqli_real_escape_string($this->conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $role     = $data['role'] ?? 'pengunjung';

        $sql = "INSERT INTO {$this->table} (username, email, password, role)
                VALUES ('$username', '$email', '$password', '$role')";
        return mysqli_query($this->conn, $sql);
    }
}
