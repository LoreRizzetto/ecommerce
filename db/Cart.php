<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class Cart {
    public static PDO $pdo;
    
    private int $id;
    private int $user_id;
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getUser_id(): int{
        return $this->user_id;
    }
    
    public function setUser_id(string $user_id): void {
        $this->user_id = $user_id;
    }
    
    
    public function __construct(int $user_id, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        
        $this->user_id = $user_id;
    }
    
    
    public function __toString(): string {
        return "Cart('$this->user_id', $this->id)";
    }
    
    
    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM carts WHERE id = :id");
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
            $stmt = self::$pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        } else {
            $stmt = self::$pdo->prepare("UPDATE carts SET user_id = :user_id WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }
        
        $stmt->bindValue(":user_id", $this->user_id);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }
    
    public static function create(array $data) {
        $inst = new self($data["user_id"]);
        $inst->update();
        return $inst;
    }
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM carts LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM carts WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new self($record["user_id"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}
