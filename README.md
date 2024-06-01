# Ecommerce


## Routes

### GET /login.php
Shows login page.
If user already logged in redirect to /

### POST /login.php
Urlencoded body:
- username: str
- password: str
- csrf_token: str

### GET /
Shows tiled list of available products

### GET /product.php?id=123
Shows product details

### POST /modify_cart.php
Urlencoded body:
- action: Literal["DELETE", "UPDATE"]
    - DELETE:
        - product_id: int
    - UPDATE
        - product_id: int
        - qty: int
- csrf_token

### GET /cart.php
Displays cart