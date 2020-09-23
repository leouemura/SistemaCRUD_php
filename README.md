### BANCO DE DADOS MySQL com servidor WAMP

Neste projeto foi utilizado o Query Builder para a criação de tabelas SQL no mySQL.
Para a utilização deste site é necessário realizar as seguintes criações/configurações no banco de dados:
1) Criar um database com o nome "fisio"
2) Criar uma tabela chamada "users" com 5 colunas: 'user_id', 'username', 'password', 'email', 'authorization'
3) OBS: A coluna user_id é uma chave primaria com auto incremento
4) user_id:int(11) | username:varchar(20) | password:varchar(32) com criptografia md5 | email:varchar(40) | authorization:varchar(3) possiveis tipos de permissão: 'adm' ou 'usr'

DATABASE NAME = fisio
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `authorization`) VALUES (NULL, 'seu_usuario', 'sua_senha', 'seu_email', 'sua_permissao');


## FEATURES
O usuario com permissão 'adm' possui o navbar com features adicionais como visualização de clientes e acessos recentes, features que o usuario com permissão 'usr' não possui...

NAVBAR -> ABA CLIENTE:
-Cadastro de novos usuarios
-Visualização dos dados de todos os usuarios cadastrados no sistema
-Create
-Read
-Update
-Delete

## PAGES
-login -> index.php
-home -> main.php
-listagem de usuarios -> crud_usuarios.php
    -criar novo usuario -> CRUD/create.php
    -listar um único usuario -> CRUD/read.php
    -atualizar usuario -> CRUD/update.php
    -deletar usuario -> CRUD/delete.php
