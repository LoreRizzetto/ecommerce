<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class Cart_Product {
    public static PDO $pdo;
    
    private int $id;
    private int $qty;
    private int $cart_id;
    private int $product_id;
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getQty(): int{
        return $this->qty;
    }
    
    public function setQty(string $qty): void {
        $this->qty = $qty;
    }

public function getCart_id(): int{
        return $this->cart_id;
    }
    
    public function setCart_id(string $cart_id): void {
        $this->cart_id = $cart_id;
    }

public function getProduct_id(): int{
        return $this->product_id;
    }
    
    public function setProduct_id(string $product_id): void {
        $this->product_id = $product_id;
    }
    
    
    public function __construct(int $qty, int $cart_id, int $product_id, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        
        $this->qty = $qty;
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
    }
    
    
    public function __toString(): string {
        return "Cart_Product('$this->qty', '$this->cart_id', '$this->product_id', $this->id)";
    }
    
    
    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM cart_product WHERE id = :id");
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
            $stmt = self::$pdo->prepare("INSERT INTO cart_product (qty, cart_id, product_id) VALUES (:qty, :cart_id, :product_id)");
        } else {
            $stmt = self::$pdo->prepare("UPDATE cart_product SET qty = :qty, cart_id = :cart_id, product_id = :product_id WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }
        
        $stmt->bindValue(":qty", $this->qty);
$stmt->bindValue(":cart_id", $this->cart_id);
$stmt->bindValue(":product_id", $this->product_id);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }
    
    public static function create(array $data) {
        $inst = new self($data["qty"], $data["cart_id"], $data["product_id"]);
        $inst->update();
        return $inst;
    }
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM cart_product LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM cart_product WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new self($record["qty"], $record["cart_id"], $record["product_id"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}
