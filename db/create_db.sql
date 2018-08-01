CREATE DATABASE IF NOT EXISTS db_boutique;
USE db_boutique;

CREATE TABLE IF NOT EXISTS customer (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    gender enum('F','M') NOT NULL,
    firstname varchar(30) NOT NULL,
    lastname varchar(30) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(32) NOT NULL,
    auth_level smallint NOT NULL,
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
    billing_address varchar(100),
    bil_postal_code varchar(5),
    bil_city varchar(30),
    bil_address_supp varchar(100),
    bil_building varchar(3),
    bil_staircase varchar(3),
    bil_floor varchar(3),
    bil_door varchar(3),
    credit_card_holder varchar(30),
    credit_card_number varchar(16),
    credit_card_expiration datetime
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS customer_order (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    created_date datetime NOT NULL,
    status enum('validated', 'canceled', 'in_progress') NOT NULL,
    customer_id int NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS brand (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS category (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) NOT NULL,
    description varchar(1000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ref varchar(10) UNIQUE NOT NULL,
    name varchar(100) NOT NULL,
    description varchar(1000),
    price float NOT NULL,
    picture_name varchar(30),
    is_available boolean,
    is_on_promo boolean,
    reduction_percent smallint,
    promo_price float,
    is_in_selection boolean,
    brand_id int,
    FOREIGN KEY (brand_id) REFERENCES brand(id),
    category_id int NOT NULL,
    FOREIGN KEY (category_id) REFERENCES category(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS size (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    size varchar(4) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product_size (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    stock int,
    product_id int NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    size_id int NOT NULL,
    FOREIGN KEY (size_id) REFERENCES size(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS order_item (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    quantity int NOT NULL,
    customer_order_id int NOT NULL,
    FOREIGN KEY (customer_order_id) REFERENCES customer_order(id),
    product_id int NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;