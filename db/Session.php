<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class Session {
    public static PDO $pdo;
    
    private int $id;
    private string $ip;
    private string $data_login;
    private int $user_id;
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getIp(): string{
        return $this->ip;
    }
    
    public function setIp(string $ip): void {
        $this->ip = $ip;
    }

public function getData_login(): string{
        return $this->data_login;
    }
    
    public function setData_login(string $data_login): void {
        $this->data_login = $data_login;
    }

public function getUser_id(): int{
        return $this->user_id;
    }
    
    public function setUser_id(string $user_id): void {
        $this->user_id = $user_id;
    }
    
    
    public function __construct(string $ip, string $data_login, int $user_id, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        
        $this->ip = $ip;
        $this->data_login = $data_login;
        $this->user_id = $user_id;
    }
    
    
    public function __toString(): string {
        return "Session('$this->ip', '$this->data_login', '$this->user_id', $this->id)";
    }
    
    
    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM sessions WHERE id = :id");
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
            $stmt = self::$pdo->prepare("INSERT INTO sessions (ip, data_login, user_id) VALUES (:ip, :data_login, :user_id)");
        } else {
            $stmt = self::$pdo->prepare("UPDATE sessions SET ip = :ip, data_login = :data_login, user_id = :user_id WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }
        
        $stmt->bindValue(":ip", $this->ip);
$stmt->bindValue(":data_login", $this->data_login);
$stmt->bindValue(":user_id", $this->user_id);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }
    
    public static function create(array $data) {
        $inst = new self($data["ip"], $data["data_login"], $data["user_id"]);
        $inst->update();
        return $inst;
    }
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM sessions LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM sessions WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new self($record["ip"], $record["data_login"], $record["user_id"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}
