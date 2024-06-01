USE ecommerce;

DELETE FROM users;
DELETE FROM roles;

INSERT INTO roles
VALUES (1, "ADMIN", "amministratore del sito"),
       (2, "USER", "utente del sito");

INSERT INTO users -- admin@admin.admin : admin
VALUES (1, "admin@admin.admin", "$2y$10$xNovlWgmT.GF3O0zpfEpie71TgaAEU2c7xkpUArGaAOFjfqKtnEM2", 1);
