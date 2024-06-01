<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class Product {
    public static PDO $pdo;
    
    private int $id;
    private string $nome;
    private string $descrizione;
    private int $prezzo;
    private string $marca;
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getNome(): string{
        return $this->nome;
    }
    
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

public function getDescrizione(): string{
        return $this->descrizione;
    }
    
    public function setDescrizione(string $descrizione): void {
        $this->descrizione = $descrizione;
    }

public function getPrezzo(): int{
        return $this->prezzo;
    }
    
    public function setPrezzo(string $prezzo): void {
        $this->prezzo = $prezzo;
    }

public function getMarca(): string{
        return $this->marca;
    }
    
    public function setMarca(string $marca): void {
        $this->marca = $marca;
    }
    
    
    public function __construct(string $nome, string $descrizione, int $prezzo, string $marca, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->prezzo = $prezzo;
        $this->marca = $marca;
    }
    
    
    public function __toString(): string {
        return "Product('$this->nome', '$this->descrizione', '$this->prezzo', '$this->marca', $this->id)";
    }
    
    
    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM products WHERE id = :id");
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
            $stmt = self::$pdo->prepare("INSERT INTO products (nome, descrizione, prezzo, marca) VALUES (:nome, :descrizione, :prezzo, :marca)");
        } else {
            $stmt = self::$pdo->prepare("UPDATE products SET nome = :nome, descrizione = :descrizione, prezzo = :prezzo, marca = :marca WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }
        
        $stmt->bindValue(":nome", $this->nome);
$stmt->bindValue(":descrizione", $this->descrizione);
$stmt->bindValue(":prezzo", $this->prezzo);
$stmt->bindValue(":marca", $this->marca);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }
    
    public static function create(array $data) {
        $inst = new self($data["nome"], $data["descrizione"], $data["prezzo"], $data["marca"]);
        $inst->update();
        return $inst;
    }
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM products LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM products WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new self($record["nome"], $record["descrizione"], $record["prezzo"], $record["marca"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}
