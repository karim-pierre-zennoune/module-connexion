-- Pour commencer, créez votre base de données nommée “moduleconnexion” à l’aide de
-- phpmyadmin. Dans cette bdd, créez une table “utilisateurs” qui contient les champs
-- suivants :
-- ● id, int, clé primaire et Auto Incrément
-- ● login, varchar de taille 255
-- ● prenom, varchar de taille 255
-- ● nom, varchar de taille 255
-- ● password, varchar de taille 255


CREATE DATABASE IF NOT EXISTS moduleconnexion CHARACTER SET utf8 COLLATE utf8_general_ci;
USE moduleconnexion;

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);


-- Créez un utilisateur qui aura la possibilité d’accéder à l’ensemble des informations. Son
-- login, prénom, nom et mot de passe sont “admin”.
-- php > echo password_hash("admin", PASSWORD_DEFAULT);
-- $2y$10$E3DnfCzh86c4ipxfIsZkgePH4uyNfbUR3ZIYQ.l1MF/llrcMf8R.a

INSERT INTO utilisateurs (login, prenom, nom, password) VALUES 
('admin', 'admin', 'admin', '$2y$10$E3DnfCzh86c4ipxfIsZkgePH4uyNfbUR3ZIYQ.l1MF/llrcMf8R.a');