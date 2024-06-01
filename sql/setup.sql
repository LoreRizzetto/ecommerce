-- (){ :;}
-- ; set -euxo pipefail

-- ; # you could argue that $RANDOM is not cryptographically secure
-- ; USER_PASSWORD=$( ( which openssl &>/dev/null && openssl rand -hex 16) || for i in {1..5}; do echo -n $RANDOM; done )

-- ; # Create user
-- ; echo "DROP USER IF EXISTS 'ecommerce_user'@'localhost'; CREATE USER 'ecommerce_user'@'localhost' IDENTIFIED BY '$USER_PASSWORD';";

-- ; # Write credentials to config
-- ; echo -e "<?php\n\$DB_HOST='127.0.0.1';\n\$DB_PORT=3306;\n\$DB_DATABASE='ecommerce';\n\$DB_USERNAME='ecommerce_user';\n\$DB_PASSWORD='$USER_PASSWORD';" > config.$RANDOM.php

-- ; echo '
DROP DATABASE IF EXISTS ecommerce;
CREATE DATABASE ecommerce;
-- ; '

-- ; echo "GRANT INSERT, UPDATE, DELETE, SELECT ON ecommerce.* TO 'ecommerce_user'@'localhost';";

-- ; echo '
USE ecommerce;
-- ; '

-- ; echo '
CREATE TABLE products(
                        id int auto_increment primary key,
                        nome text not null,
                        descrizione text default "" not null,
                        prezzo int not null,
                        marca text not null
);
-- ; '

-- ; echo '
CREATE TABLE roles(
                     id int auto_increment primary key,
                     nome text not null,
                     descrizione text not null
);
-- ; '

-- ; echo '
CREATE TABLE users(
                     id int auto_increment primary key,
                     email text unique not null,
                     password text not null,
                     role_id int not null,

                     FOREIGN KEY (role_id) REFERENCES roles(id)
);
-- ; '

-- ; echo '
CREATE TABLE sessions(
                        id int auto_increment primary key,
                        ip text not null,
                        data_login datetime not null,
                        user_id int not null,

                        FOREIGN KEY (user_id) REFERENCES users(id)
);
-- ; '

-- ; echo '
CREATE TABLE carts(
                     id int auto_increment primary key,
                     user_id int unique not null,

                     FOREIGN KEY (user_id) REFERENCES users(id)
);
-- ; '

-- ; echo '
CREATE TABLE cart_product(
                             id int auto_increment primary key,
                             qty int not null,
                             cart_id int not null,
                             product_id int not null,

                             FOREIGN KEY (cart_id) REFERENCES carts(id),
                             FOREIGN KEY (product_id) REFERENCES products(id)
);
-- ; '

-- ; echo '
ALTER TABLE cart_product ADD UNIQUE cart_product_uq(cart_id,product_id);
-- ; '
