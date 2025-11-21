<?php
  require_once __DIR__ . '/../bootstrap.php';
  Class User {
    private ?int $user_id = null;
    private string $email;
    private string $password;

    public function __construct(string $email, string $password, bool $isHashed = false) {
      $this->email = $email;

      if ($isHashed) {
        $this->password = $password; // di na need i hash ule, kasi galing na sya sa database
      } else {
        $this->password = password_hash($password, PASSWORD_DEFAULT); // hash the password kaagad
      }

      // mag ttrue lang yung isHashed if galing sa database yung user 'object', using fromDatabase()
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

      $stmt->bind_param("ss", $email, $password);

      return $stmt->execute();
    }

    public static function searchEmail(mysqli $conn, string $email, string $password): string | bool {
      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) { // if non-existent yung ininput na email sa db
          $stmt->close();
          return "Email '$email' not found in users table.";
      }

      $user = $result->fetch_assoc(); // kunin yung hashed password sa db, if found yung email sa db
      $stmt->close();

      return self::checkPassword($password, $user['password']); // first param is yung ininput sa UI, second param is galing sa database
    }

    // para ma compare yung ininput na pass vs hashed password from database
    public static function checkPassword(string $enteredPassword, string $hashedPassword): string | bool {
      return password_verify($enteredPassword, $hashedPassword) // comparing the two
        ? true // boolean return pag tama yung pass
        : "Password does not match the email provided."; // string return pag mali.
    }

    // gagamitin na pala ito, para sa frontend, to fetch Users sa database
    public static function fromDatabase(array $row): self { // will return 'self' meaning mag-rereturn ng User object
      return new self($row['email'], $row['password'], true);
      // yung last argument which is bool true ay para ma 'override' yung isHashed false sa User constructor
    }
  }
?>