CREATE TABLE `buyer` (
                         `id_buyer` int(11) NOT NULL,
                         `date_visit` date NOT NULL,
                         `id_marketer` int(11) NOT NULL,
                         `id_dep` int(11) NOT NULL,
                         `id_magazine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `buyer`
--

INSERT INTO `buyer` (`id_buyer`, `date_visit`, `id_marketer`, `id_dep`, `id_magazine`) VALUES
(1, '2020-06-01', 2, 1, 1),
(2, '2020-06-15', 2, 1, 1),
(3, '2020-06-13', 1, 1, 1),
(4, '2020-06-15', 2, 1, 1),
(5, '2020-06-11', 1, 2, 2),
(7, '2020-06-01', 3, 1, 2);

--
-- Триггеры `buyer`
--
DELIMITER $$
CREATE TRIGGER `buyer_sale` AFTER INSERT ON `buyer` FOR EACH ROW INSERT INTO `sale` VALUES (null,NEW.id_buyer,NEW.date_visit,NEW.id_marketer)
    $$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE `department` (
                              `id_dep` int(11) NOT NULL,
                              `name_dep` varchar(100) NOT NULL,
                              `floor_dep` int(11) NOT NULL,
                              `id_magazine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `department`
--

INSERT INTO `department` (`id_dep`, `name_dep`, `floor_dep`, `id_magazine`) VALUES
(1, 'Продукты ', 1, 2),
(2, 'Булочки', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `magazine`
--

CREATE TABLE `magazine` (
                            `id_magazine` int(11) NOT NULL,
                            `name_magazine` varchar(100) NOT NULL,
                            `magazine_type` varchar(100) NOT NULL,
                            `id_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `magazine`
--

INSERT INTO `magazine` (`id_magazine`, `name_magazine`, `magazine_type`, `id_owner`) VALUES
(1, 'Пятерка', 'Универмаг', 3),
(2, 'Магнит', 'Универмаг', 2),
(4, 'Перекресток', 'Супермаркет', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `marketer`
--

CREATE TABLE `marketer` (
                            `id_marketer` int(11) NOT NULL,
                            `name_marketer` varchar(100) NOT NULL,
                            `age_marketer` int(11) NOT NULL,
                            `gender` varchar(100) NOT NULL,
                            `salary_marketer` int(11) NOT NULL,
                            `id_dep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `marketer`
--

INSERT INTO `marketer` (`id_marketer`, `name_marketer`, `age_marketer`, `gender`, `salary_marketer`, `id_dep`) VALUES
(1, 'Галя', 50, 'Жен', 25000, 1),
(2, 'Валя', 46, 'Жен', 25000, 1),
(3, 'Иван', 33, 'Муж', 25000, 1),
(4, 'Киря', 33, 'Муж', 25000, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `owner`
--

CREATE TABLE `owner` (
                         `id_owner` int(11) NOT NULL,
                         `name_owner` varchar(100) NOT NULL,
                         `telephone_owner` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `owner`
--

INSERT INTO `owner` (`id_owner`, `name_owner`, `telephone_owner`) VALUES
(2, 'Перетягин Илья Олегович', '8800553534'),
(3, 'Ахматов Артур Азатович', '8834343434');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
                           `id_product` int(11) NOT NULL,
                           `name_product` varchar(100) NOT NULL,
                           `cost` float(9,2) NOT NULL,
  `net_cost` float(9,2) NOT NULL,
  `quantity_product` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `id_dep` int(11) NOT NULL,
  `id_magazine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id_product`, `name_product`, `cost`, `net_cost`, `quantity_product`, `type`, `id_dep`, `id_magazine`) VALUES
(4, 'Курица', 26.31, 25.01, 11, 'Мясо', 1, 1),
(5, 'Колбаса', 26.32, 25.00, 50, 'Мясо', 1, 1),
(6, 'Сок', 26.32, 25.00, 34, 'Питье', 1, 1),
(7, 'Водка', 342.00, 330.00, 22, 'Алкоголь', 1, 1),
(13, 'Хлеб', 25.32, 25.01, 4, 'Булочка', 2, 1),
(16, 'Молоко', 54.02, 45.01, 21, 'Молочка', 1, 2),
(17, 'Чипсы', 80.00, 50.00, 25, 'Сухарики', 1, 2),
(18, 'Кефир', 65.00, 54.00, 41, 'Молочка', 1, 1),
(19, 'Томаты', 110.00, 50.00, 20, 'Овощи', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sale`
--

CREATE TABLE `sale` (
                        `id_sale` int(11) NOT NULL,
                        `id_buyer` int(11) NOT NULL,
                        `date_sale` date NOT NULL,
                        `id_marketer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sale`
--

INSERT INTO `sale` (`id_sale`, `id_buyer`, `date_sale`, `id_marketer`) VALUES
(1, 2, '2020-06-04', 4),
(2, 2, '2020-06-02', 3),
(3, 3, '2020-06-02', 1),
(4, 4, '2020-06-11', 3),
(6, 7, '2020-06-01', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sale_product`
--

CREATE TABLE `sale_product` (
                                `id` int(11) NOT NULL,
                                `id_sale` int(11) NOT NULL,
                                `id_product` int(11) NOT NULL,
                                `quantity_sale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sale_product`
--

INSERT INTO `sale_product` (`id`, `id_sale`, `id_product`, `quantity_sale`) VALUES
(1, 1, 5, 1),
(2, 1, 4, 1),
(3, 2, 5, 1),
(4, 2, 4, 1),
(5, 3, 7, 1),
(6, 3, 6, 1),
(7, 1, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `shipper`
--

CREATE TABLE `shipper` (
                           `id_shipper` int(11) NOT NULL,
                           `name_shipper` varchar(100) NOT NULL,
                           `telephone_shipper` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `shipper`
--

INSERT INTO `shipper` (`id_shipper`, `name_shipper`, `telephone_shipper`) VALUES
(1, 'Касимов Данил ОЛегович', '880023432'),
(3, 'Перетягин Илья ОЛегович', '88849584');

-- --------------------------------------------------------

--
-- Структура таблицы `storehouse`
--

CREATE TABLE `storehouse` (
                              `id_order` int(11) NOT NULL,
                              `id_product` int(11) NOT NULL,
                              `quantity_in_sh` int(11) NOT NULL,
                              `id_shipper` int(11) NOT NULL,
                              `order_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `storehouse`
--

INSERT INTO `storehouse` (`id_order`, `id_product`, `quantity_in_sh`, `id_shipper`, `order_status`) VALUES
(1, 5, 15, 3, 'Заказан'),
(2, 13, 10, 3, 'Есть на складе'),
(3, 7, 3, 1, 'Заказан'),
(5, 4, 3, 3, 'Есть на складе');

--
-- Триггеры `storehouse`
--
DELIMITER $$
CREATE TRIGGER `product_update_sh` AFTER UPDATE ON `storehouse` FOR EACH ROW IF (NEW.quantity_in_sh < OLD.quantity_in_sh && NEW.order_status = "Есть на складе")
THEN
UPDATE product SET product.quantity_product =  (product.quantity_product +  (OLD.quantity_in_sh - NEW.quantity_in_sh))
WHERE NEW.id_product = product.id_product;
END IF
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `buyer`
--
ALTER TABLE `buyer`
    ADD PRIMARY KEY (`id_buyer`),
  ADD KEY `id_marketer` (`id_marketer`),
  ADD KEY `id_dep` (`id_dep`),
  ADD KEY `id_magazine` (`id_magazine`);

--
-- Индексы таблицы `department`
--
ALTER TABLE `department`
    ADD PRIMARY KEY (`id_dep`),
  ADD KEY `id_magazine` (`id_magazine`);

--
-- Индексы таблицы `magazine`
--
ALTER TABLE `magazine`
    ADD PRIMARY KEY (`id_magazine`),
  ADD KEY `id_owner` (`id_owner`);

--
-- Индексы таблицы `marketer`
--
ALTER TABLE `marketer`
    ADD PRIMARY KEY (`id_marketer`),
  ADD KEY `id_dep` (`id_dep`);

--
-- Индексы таблицы `owner`
--
ALTER TABLE `owner`
    ADD PRIMARY KEY (`id_owner`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
    ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_magazine` (`id_magazine`),
  ADD KEY `id_dep` (`id_dep`);

--
-- Индексы таблицы `sale`
--
ALTER TABLE `sale`
    ADD PRIMARY KEY (`id_sale`),
  ADD KEY `id_marketer` (`id_marketer`),
  ADD KEY `id_buyer` (`id_buyer`);

--
-- Индексы таблицы `sale_product`
--
ALTER TABLE `sale_product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_sale` (`id_sale`);

--
-- Индексы таблицы `shipper`
--
ALTER TABLE `shipper`
    ADD PRIMARY KEY (`id_shipper`);

--
-- Индексы таблицы `storehouse`
--
ALTER TABLE `storehouse`
    ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_shipper` (`id_shipper`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `buyer`
--
ALTER TABLE `buyer`
    MODIFY `id_buyer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `department`
--
ALTER TABLE `department`
    MODIFY `id_dep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `magazine`
--
ALTER TABLE `magazine`
    MODIFY `id_magazine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `marketer`
--
ALTER TABLE `marketer`
    MODIFY `id_marketer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `owner`
--
ALTER TABLE `owner`
    MODIFY `id_owner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
    MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `sale`
--
ALTER TABLE `sale`
    MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `sale_product`
--
ALTER TABLE `sale_product`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `shipper`
--
ALTER TABLE `shipper`
    MODIFY `id_shipper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `storehouse`
--
ALTER TABLE `storehouse`
    MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `buyer`
--
ALTER TABLE `buyer`
    ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`id_marketer`) REFERENCES `marketer` (`id_marketer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_2` FOREIGN KEY (`id_dep`) REFERENCES `department` (`id_dep`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_3` FOREIGN KEY (`id_magazine`) REFERENCES `magazine` (`id_magazine`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `department`
--
ALTER TABLE `department`
    ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`id_magazine`) REFERENCES `magazine` (`id_magazine`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `magazine`
--
ALTER TABLE `magazine`
    ADD CONSTRAINT `magazine_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `owner` (`id_owner`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `marketer`
--
ALTER TABLE `marketer`
    ADD CONSTRAINT `marketer_ibfk_1` FOREIGN KEY (`id_dep`) REFERENCES `department` (`id_dep`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
    ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`id_magazine`) REFERENCES `magazine` (`id_magazine`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`id_dep`) REFERENCES `department` (`id_dep`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sale`
--
ALTER TABLE `sale`
    ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`id_marketer`) REFERENCES `marketer` (`id_marketer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`id_buyer`) REFERENCES `buyer` (`id_buyer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sale_product`
--
ALTER TABLE `sale_product`
    ADD CONSTRAINT `sale_product_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_product_ibfk_2` FOREIGN KEY (`id_sale`) REFERENCES `sale` (`id_sale`);

--
-- Ограничения внешнего ключа таблицы `storehouse`
--
ALTER TABLE `storehouse`
    ADD CONSTRAINT `storehouse_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `storehouse_ibfk_2` FOREIGN KEY (`id_shipper`) REFERENCES `shipper` (`id_shipper`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

-- Таблица versions --
CREATE TABLE `versions` (
                           `id_shipper` int(11) NOT NULL,
                           `name_shipper` varchar(100) NOT NULL,
                           `telephone_shipper` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
