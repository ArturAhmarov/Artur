DELIMITER $$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_proverka_id_5` (`id_old` INT)  BEGIN
SELECT * FROM `shipper` WHERE `shipper`.`id_shipper` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_proverka_id_4` (`id_old` INT)  BEGIN
SELECT * FROM `shipper` WHERE `shipper`.`id_shipper` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_proverka_id_3` (`id_old` INT)  BEGIN
SELECT * FROM `shipper` WHERE `shipper`.`id_shipper` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_proverka_id_2` (`id_old` INT)  BEGIN
SELECT * FROM `shipper` WHERE `shipper`.`id_shipper` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_buyer` (IN `date` DATE, IN `id_marketer` INT, IN `id_dep` INT, IN `id_magazine` INT)  BEGIN
INSERT INTO `buyer`
                    (
                    `date_visit`,
                    `id_marketer`,
                    `id_dep`,
                    `id_magazine`
                    )
                    VALUES (
                        date,
                        id_marketer,
                        id_dep,
                        id_magazine
                        );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_dep` (`new_name_dep` VARCHAR(100), `floor` INT, `id_magazine` INT)  BEGIN
INSERT INTO `department`
                (
                `name_dep`,
                `floor_dep`,
                `id_magazine`
                )
                VALUES
                (
                new_name_dep,
                floor,
                id_magazine
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_magazine` (`new_name_mag` VARCHAR(100), `type` VARCHAR(100), `id_owner` INT)  BEGIN
INSERT INTO `magazine`
                (
                `name_magazine`,
                `magazine_type`,
                `id_owner`
                )
                VALUES
                (
                new_name_mag,
                type,
                id_owner
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_marketer` (`new_name` VARCHAR(100), `new_age` INT, `new_gender` VARCHAR(100), `new_dep` INT)  BEGIN
INSERT INTO `marketer`
                    (
                    `name_marketer`,
                    `age_marketer`,
                    `gender`,
                    `id_dep`
                    )
                    VALUES (
                        new_name,
                        new_age,
                        new_gender,
                        new_dep
                        );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_owner` (`new_fio_owner` VARCHAR(100), `new_telephone_owner` VARCHAR(100))  BEGIN
INSERT INTO `owner`
                (
                `name_owner`,
                `telephone_owner`
                )
                VALUES
                (
                new_fio_owner,
                new_telephone_owner
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_product` (`new_name` VARCHAR(100), `new_cost` FLOAT, `new_net_cost` FLOAT, `new_quantity` INT, `new_type` VARCHAR(100), `new_dep` INT, `new_id_magazine` INT)  BEGIN
INSERT INTO `product`
                (
                `name_product`,
                `cost`,
                `net_cost`,
                `quantity_product`,
                `type`,`id_dep`,
                `id_magazine`
                )
                VALUES (
                    new_name,
                    new_cost,
                    new_net_cost,
                    new_quantity,
                    new_type,
                    new_dep,
                    new_id_magazine
                    );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_product_ship` (`id_product` INT, `id_shipper` INT)  BEGIN
INSERT INTO `product_ship`
                    (
                    `id_product`,
                    `id_shipper`
                    )
                    VALUES (
                        id_product,
                        id_shipper
                        );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_sale` (`id_buyer` INT, `date_sale` DATE, `id_marketer` INT)  BEGIN
INSERT INTO `sale`
                (
                `id_buyer`,
                `date_sale`,
                `id_marketer`
                )
                VALUES
                (
                id_buyer,
                date_sale,
                id_marketer
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_sale_product` (`id_sale` INT, `id_old` INT, `quantity` INT)  BEGIN
INSERT INTO `sale_product`
                (
                `id_sale`,
                `id_product`,
                `quantity_sale`
                )
                VALUES (
                    id_sale,
                    id_old,
                    quantity
                    );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_sh` (`id_product` INT, `quantity` INT, `id_shipper` INT, `order_status` VARCHAR(100))  BEGIN
INSERT INTO `storehouse`
                (
                `id_product`,
                `quantity_in_sh`,
                `id_shipper`,
                `order_status`
                )
                VALUES
                (
                id_product,
                quantity,
                id_shipper,
                order_status
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `add_shipper` (`new_fio_shipper` VARCHAR(100), `new_telephone_shipper` VARCHAR(100))  BEGIN
INSERT INTO `shipper`
                (
                `name_shipper`,
                `telephone_shipper`
                )
                VALUES
                (
                new_fio_shipper,
                new_telephone_shipper
                );
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `carry_product` (`id_old` INT)  BEGIN
SELECT `quantity_in_sh`,`id_product`,`order_status`FROM `storehouse` WHERE `id_order` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `delete_buyer` (`id` INT)  BEGIN
DELETE FROM `buyer` WHERE `buyer`.`id_buyer` = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_dep` (`del_per` INT)  BEGIN
DELETE FROM `department` WHERE `department`.`id_dep` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_magazine` (`del_per` INT)  BEGIN
DELETE FROM `magazine` WHERE `magazine`.`id_magazine` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_marketer` (`del_per` INT)  BEGIN
DELETE FROM `marketer` WHERE `marketer`.`id_marketer` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_owner` (`del_per` INT)  BEGIN
DELETE FROM `owner` WHERE `owner`.`id_owner` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_product` (`del_per` INT)  BEGIN
DELETE FROM `product` WHERE `product`.`id_product` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_product_ship` (`del_per` INT)  BEGIN
DELETE FROM `product_ship` WHERE `product_ship`.`id` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_sale` (`del_per` INT)  BEGIN
DELETE FROM `sale` WHERE `sale`.`id_sale` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_sh` (`del_per` INT)  BEGIN
DELETE FROM `storehouse` WHERE `storehouse`.`id_order` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `del_shipper` (`del_per` INT)  BEGIN
DELETE FROM `shipper` WHERE `shipper`.`id_shipper` = del_per;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_buyer` ()  BEGIN
SELECT* FROM buyer;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_buyer_from_product` (`id` INT)  BEGIN
SELECT p.id_sale,s.id_buyer FROM sale_product as p LEFT JOIN `sale` s ON p.id_sale = s.id_sale WHERE p.id_product = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_buyer_id` (`id` INT)  BEGIN
SELECT * FROM `buyer` WHERE `buyer`.`id_buyer` =id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_count_buyer` (IN `id` DATE)  BEGIN
SELECT * FROM `buyer` WHERE date_visit = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_count_sale` (`id` INT)  BEGIN
SELECT COUNT(*) as `count`, name_product
FROM `sale_product` AS s LEFT JOIN product p ON s.id_product = p.id_product
WHERE s.id_product = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_customers` (`id_old` INT, `new_name` VARCHAR(100), `new_age` INT, `new_gender` VARCHAR(100), `new_dep` INT)  BEGIN
UPDATE `marketer`
SET
    `name_marketer`=new_name,
    `age_marketer`=new_age ,
    `gender`= new_gender,
    `id_dep`= new_dep
WHERE `marketer`.`id_marketer` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_dep` ()  BEGIN
SELECT* FROM department;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_dep_id` (`id_old` INT)  BEGIN
SELECT * FROM `department` WHERE `department`.`id_dep` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_magazine` ()  BEGIN
SELECT* FROM magazine;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_magazine_id` (`id_old` INT)  BEGIN
SELECT * FROM `magazine` WHERE `magazine`.`id_magazine` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_marketer` ()  BEGIN
SELECT * FROM marketer;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_marketer_from_floor` (`id` INT)  BEGIN
SELECT p.id_marketer,p.name_marketer,s.floor_dep
FROM marketer as p LEFT JOIN department s ON p.id_dep = s.id_dep
WHERE s.floor_dep = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_marketer_id` (`id_old` INT)  BEGIN
SELECT * FROM `marketer` WHERE `marketer`.`id_marketer` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_order` (`id` INT)  BEGIN
SELECT s.id_product,s.name_product,p.quantity_in_sh,p.order_status
FROM storehouse as p LEFT JOIN product s ON p.id_product = s.id_product
WHERE p.id_order = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_owner` ()  BEGIN
SELECT* FROM owner;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_owner_id` (`id_old` INT)  BEGIN
SELECT * FROM `owner` WHERE `owner`.`id_owner` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product` ()  BEGIN
SELECT * FROM product;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_cost_count` (`id` INT)  BEGIN
SELECT id_product,name_product,cost,quantity_product FROM product WHERE id_product = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_from_sale` (`id` INT)  BEGIN
SELECT b.id_sale,b.quantity_sale,s.name_product,s.cost FROM sale_product as b LEFT JOIN `product` s ON b.id_product = s.id_product WHERE b.id_sale =id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_id` (`id_old` INT)  BEGIN
SELECT * FROM product WHERE product.id_product =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_page` (`start_pos` INT, `perpage` INT)  BEGIN
SELECT * FROM product LIMIT start_pos,perpage;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_ship` ()  BEGIN
SELECT * FROM product_ship
                  INNER JOIN product ON product.id_product = product_ship.id_product
                  INNER JOIN shipper ON product_ship.id_shipper = shipper.id_shipper;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_product_ship_id` (`id_old` INT)  BEGIN
SELECT * FROM `product_ship` WHERE `product_ship`.`id` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_sale` ()  BEGIN
SELECT* FROM sale;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_sale_id` (`id_old` INT)  BEGIN
SELECT * FROM `sale` WHERE `sale`.`id_sale` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_shipper` ()  BEGIN
SELECT* FROM shipper;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_shipper_id` (`id` INT)  BEGIN
SELECT p.id_shipper,s.name_shipper FROM storehouse as p LEFT JOIN `shipper` s ON p.id_shipper = s.id_shipper WHERE p.id_product = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_shipper_id_upd` (`id_old` INT)  BEGIN
SELECT * FROM `shipper` WHERE `shipper`.`id_shipper` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_sh_id` (`id_old` INT)  BEGIN
SELECT * FROM `storehouse` WHERE `storehouse`.`id_order` =id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_storehouse` ()  BEGIN
SELECT* FROM storehouse;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `get_type_product` (`id` VARCHAR(100))  BEGIN
SELECT * FROM product WHERE type = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `sale_check` (`buf` INT)  BEGIN
SELECT b.id_sale,b.quantity_sale,s.name_product,s.cost FROM sale_product as b LEFT JOIN `product` s ON b.id_product = s.id_product WHERE b.id_sale =buf;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_buyer` (`id` INT, `buyer_date` DATE, `id_market` INT, `id_dep` INT, `id_magazine` INT)  BEGIN
UPDATE `buyer`
SET
    `date_visit` = buyer_date,
    `id_marketer` = id_market,
    `id_dep` = id_dep,
    `id_magazine` = id_magazine
WHERE `buyer`.`id_buyer` = id;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_dep` (`id_old` INT, `new_name` VARCHAR(100), `new_floor` INT, `new_id_magazine` INT)  BEGIN
UPDATE `department`
SET
    `name_dep` = new_name,
    `floor_dep` = new_floor,
    `id_magazine` = new_id_magazine
WHERE `department`.`id_dep` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_magazine` (`id_old` INT, `new_name` VARCHAR(100), `new_magazine_type` VARCHAR(100), `new_id_owner` INT)  BEGIN
UPDATE `magazine`
SET
    `name_magazine` = new_name,
    `magazine_type` = new_magazine_type,
    `id_owner` = new_id_owner
WHERE `magazine`.`id_magazine` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_marketer` (`id_old` INT, `new_name` VARCHAR(100), `new_age` INT, `new_gender` VARCHAR(100), `new_dep` INT)  BEGIN
UPDATE `marketer`
SET
    `name_marketer`=new_name,
    `age_marketer`=new_age ,
    `gender`= new_gender,
    `id_dep`= new_dep
WHERE `marketer`.`id_marketer` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_owner` (`id_old` INT, `new_name` VARCHAR(100), `new_telephone` VARCHAR(100))  BEGIN
UPDATE `owner`
SET
    `name_owner`=new_name,
    `telephone_owner`=new_telephone
WHERE `owner`.`id_owner` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_product` (`id_old` INT, `new_name` VARCHAR(100), `new_cost` FLOAT, `new_net_cost` FLOAT, `new_quantity` INT, `new_type` VARCHAR(100), `new_dep` INT, `new_id_magazine` INT)  BEGIN
UPDATE `product`
SET
    `name_product`=new_name,
    `cost` = new_cost,
    `net_cost` = new_net_cost,
    `quantity_product`=new_quantity ,
    `type`= new_type,
    `id_dep`= new_dep,
    `id_magazine`=new_id_magazine
WHERE `product`.`id_product` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_product_ship` (`id_old` INT, `id_product` INT, `id_shipper` INT)  BEGIN
UPDATE `product_ship`
SET
    `id_product`=id_product,
    `id_shipper`=id_shipper
WHERE `product_ship`.`id` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_quantity` (`id_old` INT, `new_quantity` INT)  BEGIN
UPDATE `product`
SET
    `quantity_product`=new_quantity
WHERE `product`.`id_product` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_quantity_sh` (`id_old` INT, `new_quantity` VARCHAR(100))  BEGIN
UPDATE `storehouse`
SET
    `quantity_in_sh`=new_quantity
WHERE `storehouse`.`id_order` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_sale` (`id_old` INT, `id_buyer` INT, `date_sale` DATE, `id_marketer` INT)  BEGIN
UPDATE `sale`
SET
    `id_buyer` = id_buyer,
    `date_sale` = date_sale,
    `id_marketer` = id_marketer
WHERE `sale`.`id_sale` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_sh` (`id_old` INT, `id_product` INT, `quantity` INT, `id_shipper` INT, `order_status` VARCHAR(100))  BEGIN
UPDATE `storehouse`
SET
    `id_product` = id_product,
    `quantity_in_sh` = quantity,
    `id_shipper` = id_shipper,
    `order_status` = order_status
WHERE `storehouse`.`id_order` = id_old;
END$$

CREATE DEFINER=`mysql`@`localhost` PROCEDURE `upd_shipper` (`id_old` INT, `new_name` VARCHAR(100), `new_telephone` VARCHAR(100))  BEGIN
UPDATE `shipper`
SET
    `name_shipper`=new_name,
    `telephone_shipper`=new_telephone
WHERE `shipper`.`id_shipper` = id_old;
END$$

DELIMITER ;