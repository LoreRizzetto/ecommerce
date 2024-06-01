#!/usr/bin/python3

# {
#   "class_name": ["table_name", [("field_type_1", "field_name_1")]]
# }

classes = {
    "User": [
        "users",
        [
            ("string", "email"),
            ("string", "password"),
            ("int", "role_id"),
        ],
    ],
    "Session": [
        "sessions",
        [
            ("string", "ip"),
            ("string", "data_login"),
            ("int", "user_id"),
        ],
    ],
    "Role": ["roles", [("string", "nome"), ("string", "descrizione")]],
    "Cart": ["carts", [
        ("int", "user_id"),
    ]],
    "Product": [
        "products",
        [
            ("string", "nome"),
            ("string", "descrizione"),
            ("int", "prezzo"),
            ("string", "marca"),
        ],
    ],
    "Cart_Product": [
        "cart_product",
        [
            ("int", "qty"),
            ("int", "cart_id"),
            ("int", "product_id"),
        ]
    ]
}

for classname, (tablename, fields) in classes.items():
    # FIXME ints are not accounted for in __toString
    codice = f"""<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

class {classname} {{
    public static PDO $pdo;
    
    private int $id;
{chr(0xa).join(f"    private {t} ${name};" for (t, name) in fields)}
    
    private bool $local;
    private bool $dirty;
    
    public function getId(): int {{
        return $this->id;
    }}
    
    {(chr(0xa)*2).join((lambda u: f'''public function get{u}(): {t}{{
        return $this->{name};
    }}
    
    public function set{u}(string ${name}): void {{
        $this->{name} = ${name};
    }}''')(name.capitalize()) for (t, name) in fields)}
    
    
    public function __construct({", ".join([f"{t} ${name}" for (t, name) in fields] + ["int $id = null"])}) {{
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {{
            $this->id = $id;
        }}
        
{chr(0xa).join(f"        $this->{name} = ${name};" for (t, name) in fields)}
    }}
    
    
    public function __toString(): string {{
        return "{classname}({", ".join([f"'$this->{name}'" for (t, name) in fields] + ["$this->id"])})";
    }}
    
    
    public function delete(): void {{
        if ($this->local) {{
            throw new Error("Cannot delete local-only instance");
        }}

        $stmt = self::$pdo->prepare("DELETE FROM {tablename} WHERE id = :id");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();

        $this->local = true;
    }}
    
    
    public function update(array $data = null): void {{
        if ($data === null) {{
            $data=[];
        }}

        foreach ($data as $key => $value) {{
            $this->{{$key}} = $value;
        }}

        if ($this->local) {{
            $stmt = self::$pdo->prepare("INSERT INTO {tablename} ({", ".join(name for (t, name) in fields)}) VALUES ({", ".join(f":{name}" for (t, name) in fields)})");
        }} else {{
            $stmt = self::$pdo->prepare("UPDATE {tablename} SET {", ".join(f"{name} = :{name}" for (t,name) in fields)} WHERE id = :id");
            $stmt->bindValue(':id', $this->id);
        }}
        
        {chr(0xa).join(f'$stmt->bindValue(":{name}", $this->{name});' for (t, name) in fields)}

        $stmt->execute();

        if ($this->local) {{
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }}

        $this->dirty = false;
    }}
    
    public static function create(array $data) {{
        $inst = new self({", ".join(f'$data["{name}"]' for (t, name) in fields)});
        $inst->update();
        return $inst;
    }}
    
    
    public static function select(Filter $filter = null, int $limit = 1000000) {{
        if ($filter === null) {{
            $stmt = self::$pdo->prepare("SELECT * FROM {tablename} LIMIT " . 0+$limit);
        }} else {{
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM {tablename} WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {{
                $stmt->bindValue($key, $value);
            }}
        }}

        $stmt->execute();
        return array_map(
            function ($record) {{
                return new self({", ".join([f'$record["{name}"]' for (t, name) in fields] + ['id: $record["id"]'])});
            }},
            $stmt->fetchAll()
        );
    }}
}}
"""
    open(f"{classname}.php", "w").write(codice)

open("init.php", "w").write(f"""<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

{chr(0xa).join(f'require "{classname}.php";' for classname in classes)}
require "filter.php";

require "../../config.php";

$pdo = new PDO(
    "mysql:dbname=$DB_DATABASE;host=$DB_HOST;port=$DB_PORT;",
    $DB_USERNAME,
    $DB_PASSWORD,
);

{chr(0xa).join(f"{classname}::$pdo = $pdo;" for classname in classes)}
""")
