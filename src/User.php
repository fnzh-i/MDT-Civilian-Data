<?php
  require_once "DBConnect.php";

  Class User {
    private ?int $user_id = null;
    private string $email;
    private string $password;

    public function __construct(string $email, string $password) {
      $this->email = $email;
      $this->password = $password;
    }

    public function getEmail(): string {
      return $this->email;
    }

    public function getPassword(): string {
      return $this->password;
    }

    public function save(mysqli $conn): bool {
      $stmt = $conn->prepare("
        INSERT INTO users(email, password)
        VALUES (?, ?)
      ");

      $email = $this->getEmail();
      $password = $this->getPassword();

      $stmt->bind_param(
        "ss",
        $email,
        $password
      );

      return $stmt->execute();
    }

    public static function searchEmail(mysqli $conn, string $email, string $password): string | bool {
      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
          $stmt->close();
          return "Email '$email' not found in users table.";
      }

      $stmt->close();

      return self::checkPassword($conn, $email, $password);
    }

    
    public static function checkPassword(mysqli $conn, string $email, string $password): string | bool {
      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
      $stmt->bind_param("ss", $email, $password);
      $stmt->execute();

      $result = $stmt->get_result();

      $exists = $result->num_rows > 0;
      $stmt->close();

      return $exists ? true : "Password does not match the email provided.";
    }
  }
?>