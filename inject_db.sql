CREATE DATABASE IF NOT EXISTS db_boutique;
USE db_boutique;

CREATE TABLE IF NOT EXISTS customer (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    gender enum('F','M') NOT NULL,
    prenom varchar(30) NOT NULL,
    nom varchar(30) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(32) NOT NULL,
    birthdate datetime,
    main_phone_number varchar(20) NOT NULL,
    secondary_phone_number varchar(20),
    delivery_address varchar(100) NOT NULL,
    del_postal_code varchar(5) NOT NULL,
    del_city varchar(30) NOT NULL,
    del_address_supp varchar(100),
    del_building varchar(3),
    del_staircase varchar(3),
    del_floor varchar(3),
    del_door varchar(3),
    billing_address varchar(100) NOT NULL,
    bil_postal_code varchar(5) NOT NULL,
    bil_city varchar(30) NOT NULL,
    bil_address_supp varchar(100),
    bil_building varchar(3),
    bil_staircase varchar(3),
    bil_floor varchar(3),
    bil_door varchar(3),
    credit_card_holder varchar(30),
    credit_card_number varchar(16),
    credit_card_expiration datetime
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS indent (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    created_date datetime NOT NULL,
    status enum('validated', 'canceled', 'in_progress') NOT NULL,
    customer_id int,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS product (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ref varchar(10) UNIQUE NOT NULL,
    name varchar(30) NOT NULL,
    description varchar(1000),
    stock int,
    price float NOT NULL,
    picture_name varchar(30),
    is_available boolean,
    is_on_promo boolean,
    is_in_selection boolean
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS product_quantity (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    quantity int NOT NULL,
    indent_id int,
    FOREIGN KEY (indent_id) REFERENCES indent(id),
    product_id int,
    FOREIGN KEY (product_id) REFERENCES product(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS category (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30),
    description varchar(1000)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS product_category (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id int,
    FOREIGN KEY (product_id) REFERENCES product(id),
    category_id int,
    FOREIGN KEY (category_id) REFERENCES category(id)
)ENGINE=InnoDB;