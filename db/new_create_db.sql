CREATE DATABASE IF NOT EXISTS db_boutique;
USE db_boutique;

CREATE TABLE IF NOT EXISTS customer_address (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    prim_address varchar(100),
    building varchar(3),
    staircase varchar(3),
    floor varchar(3),
    door varchar(3),
    supp_address varchar(100),
    postal_code varchar(5),
    city varchar(30),
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS customer (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    gender enum('F','M') NOT NULL,
    firstname varchar(30) NOT NULL,
    lastname varchar(30) NOT NULL,
    email varchar(50) UNIQUE NOT NULL,
    password varchar(32) NOT NULL,
    auth_level smallint NOT NULL,
    birthdate datetime,
    main_phone_number varchar(20) NOT NULL,
    secondary_phone_number varchar(20),
    credit_card_holder varchar(30),
    credit_card_number varchar(16),
    credit_card_expiration datetime,
    del_address_id int,
    FOREIGN KEY (del_address_id) REFERENCES customer_address(id),
    bil_address_id int,
    FOREIGN KEY (bil_address_id) REFERENCES customer_address(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS customer_order (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    created_date datetime NOT NULL,
    status enum('validated', 'canceled', 'in_progress') NOT NULL,
    customer_id int NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS bill (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ref varchar(30) UNIQUE NOT NULL,
    bill_date datetime
    customer_order_id int NOT NULL,
    FOREIGN KEY (customer_order_id) REFERENCES customer_order(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS brand (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) UNIQUE NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS category (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) UNIQUE NOT NULL,
    description varchar(1000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ref varchar(10) UNIQUE NOT NULL,
    name varchar(100) UNIQUE NOT NULL,
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

CREATE TABLE IF NOT EXISTS order_item (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    quantity int NOT NULL,
    customer_order_id int NOT NULL,
    FOREIGN KEY (customer_order_id) REFERENCES customer_order(id),
    product_id int NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS size (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    size varchar(4) UNIQUE NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product_size (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    stock int,
    product_id int NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    size_id int NOT NULL,
    FOREIGN KEY (size_id) REFERENCES size(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product_provider (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(100) UNIQUE NOT NULL,
    email varchar(50) UNIQUE NOT NULL,
    phone_number varchar(20) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS product_size_product_provider (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    delivery_date datetime,
    delivery_quantity int NOT NULL,
    product_size_id int NOT NULL,
    FOREIGN KEY (product_size_id) REFERENCES product_size(id),
    product_provider_id int NOT NULL,
    FOREIGN KEY (product_provider_id) REFERENCES product_provider(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;