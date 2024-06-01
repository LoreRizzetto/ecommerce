<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class User {
    public static PDO $pdo;
    
    private int $id;
    private string $email;
    private string $password;
    private int $role_id;
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getEmail(): string{
        return $this->email;
    }
    
    public function setEmail(string $email): void {
        $this->email = $email;
    }

public function getPassword(): string{
        return $this->password;
    }
    
    public function setPassword(string $password): void {
        $this->password = $password;
    }

public function getRole_id(): int{
        return $this->role_id;
    }
    
    public function setRole_id(string $role_id): void {
        $this->role_id = $role_id;
    }
    
    
    public function __construct(string $email, string $password, int $role_id, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
    }
    
    
    public function __toString(): string {
        return "User('$this->email', '$this->password', '$this->role_id', $this->id)";
    }
    
    
    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();

        $this->local = true;
    }
    
    
    public function update(array $data = null): void {
        if ($data === null) {
            $data=[];
        }

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        if ($this->local) {
            $stmt = self::$pdo->prepare("INSERT INTO users (email, password, role_id) VALUES (:email, :password, :role_id)");
        } else {
            $stmt = self::$pdo->prepare("UPDATE users SET email = :email, password = :password, role_id = :role_id WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }
        
        $stmt->bindValue(":email", $this->email);
$stmt->bindValue(":password", $this->password);
$stmt->bindValue(":role_id", $this->role_id);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }
    
    public static function create(array $data) {
        $inst = new self($data["email"], $data["password"], $data["role_id"]);
        $inst->update();
        return $inst;
    }
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM users LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM users WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new self($record["email"], $record["password"], $record["role_id"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}
