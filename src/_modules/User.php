<?php
require_once __DIR__ . '/../bootstrap.php';
class User
{
  private ?int $user_id = null;
  private string $first_name;
  private ?string $middle_name;
  private string $last_name;
  private string $email;
  private string $password;
  private Roles $role;
  private int $default_password;

  public function __construct(
    Roles $role,

    string $first_name,
    ?string $middle_name,
    string $last_name,

    string $email,
    string $password,
    
    bool $isHashed = false,
    $extra = null)
  {
    $this->role = $role;
    $this->first_name = $first_name;
    $this->middle_name = $middle_name;
    $this->last_name = $last_name; 
    $this->email = $email;

    if ($isHashed) {
      $this->password = $password; // di na need i hash ule, kasi galing na sya sa database
    } else {
      $this->password = password_hash($password, PASSWORD_DEFAULT); // hash the password kaagad
    }
    // mag ttrue lang yung isHashed if galing sa database yung user 'object', using fromDatabase()
  }

  public function getRole(): Roles
  {
    return $this->role;
  }
  
  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getDefaultPasswordString(): string
  {
    return (string) $this->default_password;
    
    // string ang return type para ma lagay natin sa password field sa frontend later
  }

  public function save(mysqli $conn): bool
  {
    $this->default_password = rand(1000, 9999); // random four-digit default_password

    $stmt = $conn->prepare("
            INSERT INTO users (role, first_name, middle_name, last_name, email, password, default_password)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

    $role = $this->role->value;
    $middle_name = $this->middle_name ?? null; // para di completely blank sa db

    $stmt->bind_param(
      "ssssssi",
      $role,
      $this->first_name,
      $middle_name,
      $this->last_name,
      $this->email,
      $this->password,
      $this->default_password
    );

    $result = $stmt->execute();
    $stmt->close();

    return $result;
  }

  public static function searchEmail(mysqli $conn, string $email, string $password)
  {
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

    // verify password
    if (!password_verify($password, $user['password'])) {
      return "Password does not match the email provided.";
    }

    // SUCCESS → return full user row
    return $user;
  }

  // para ma compare yung ininput na pass vs hashed password from database
  public static function checkPassword(string $enteredPassword, string $hashedPassword): string|bool
  {
    return password_verify($enteredPassword, $hashedPassword) // comparing the two
      ? true // boolean return pag tama yung pass
      : "Password does not match the email provided."; // string return pag mali.
  }

  public static function fromDatabase(array $row): self
  {
    $user = new self
    (
      Roles::from($row['role']),
      $row['first_name'],
      $row['middle_name'],
      $row['last_name'],
      $row['email'],
      $row['password'],
      true
    );
    // yung last argument which is bool true ay para ma 'override' yung isHashed false sa User constructor

    $user->default_password = $row['default_password']; // kunin yung default_password sa db

    return $user;
  }
}
?>