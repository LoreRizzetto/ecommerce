<?php

class FilterType {
// $value is the literal / column name
    static int $Column = 1;
    static int $Literal = 2;

// the value is [operator, *args]
    static int $BinaryOp = 3;
    static int $UnaryOp = 4;
}


class Filter {
    public static array $binary_operators = [
        // comparison operators
        "eq" => "=", // NULL aware eq, 1 if both NULL, 0 if only one
        "gte" => ">=",
        "gt" => ">",
        "lte" => "<=",
        "lt" => "<",
        "neq" => "!=",

        // pattern operators
        "like" => "LIKE",
        "regexp" => "REGEXP",

        // boolean operators
        "or" => "OR",
        "xor" => "XOR",
        "and" => "AND",

        // ...
        "soundslike" => "SOUNDS LIKE",
    ];

    public static array $unary_operators = [
        "not" => "NOT"
    ];

    public int $type;
    public mixed $value;

    public static function __callStatic (string $name, array $arguments): Filter {
        return new Filter(FilterType::$Column, $name);
    }

    public function __construct(int $type, mixed $value) {
        $this->type = $type;
        $this->value = $value;
    }

    public function __call(string $name, array $arguments): Filter {
        if (isset(self::$binary_operators[$name])) {
            if (count($arguments) != 1) {
                throw new Error("Incorrect number of arguments passed to binary operator $name");
            }
            return new Filter(
                FilterType::$BinaryOp,
                [
                    $name,
                    $this,
                    $arguments[0] instanceof Filter ?
                        $arguments[0] :
                        new Filter(FilterType::$Literal, $arguments[0])
                ]
            );
        } else if (isset(self::$unary_operators[$name])) {
            if (count($arguments) != 0) {
                throw new Error("Incorrect number of arguments passed to binary operator $name");
            }
            return new Filter(FilterType::$UnaryOp, [$name, $this]);
        } else {
            throw new Error("Unrecognized action");
        }
    }

    public function render(string $depth=""): array {
        if ($this->type === FilterType::$Column) {
            $query = $this->value;
            $params = [];
        } else if ($this->type === FilterType::$Literal) {
            $query = ":ltr$depth";
            $params = ["ltr$depth" => $this->value];

        } else if ($this->type === FilterType::$BinaryOp) {
            list($query1, $params1) = $this->value[1]->render($depth . "bl");
            list($query2, $params2) = $this->value[2]->render($depth . "br");
            $query = $query1 . self::$binary_operators[$this->value[0]] . $query2;
            $params = array_merge($params1, $params2);

        } else if ($this->type === FilterType::$UnaryOp) {
            list($query, $params) = $this->value[1]->render($depth . "u");
            $query =  self::$unary_operators[$this->value[0]] . $query;

        } else {
            throw new Error("Type not supported");
        }

        return ["(" . $query . ")", $params];
    }

    public function __toString(): string {
        return "Filter(" . $this->type . ", "
            . (
            is_array($this->value) ?
                ("[" . implode(",", $this->value) . "]") :
                $this->value
            ) . ")";
    }
}