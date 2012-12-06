-- setup;

CREATE TABLE `checklists` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `items` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seq` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- triggers;

CREATE TRIGGER on_create_items BEFORE INSERT ON items
FOR EACH ROW
  SET NEW.seq = (SELECT Coalesce(Max(seq)+1, 1) FROM items WHERE checklist_id = NEW.checklist_id);


-- operations;

INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('create checklist', '', 'INSERT INTO checklists (name) VALUES (?)');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('edit checklist', '', 'UPDATE checklists SET name = ? WHERE id = ?');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('delete checklist', '', 'DELETE FROM items WHERE checklist_id = ?\nDELETE FROM checklists WHERE id = ?');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('create item', '', 'INSERT INTO items (checklist_id, name) VALUES (?, ?)');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('edit item', '', 'UPDATE items SET name = ? WHERE id = ?');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('reorder item', '', 'UPDATE items SET seq = ? WHERE id = ?');
INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('delete item', '', 'DELETE FROM items WHERE id = ?');


-- application settings;

UPDATE `_clctnz_application` SET `value` = 'FOOTER HERE' WHERE `name` = 'footer';
UPDATE `_clctnz_application` SET `value` = 'HEADER HERE' WHERE `name` = 'header';
UPDATE `_clctnz_application` SET `value` = 'STYLE HERE' WHERE `name` = 'style';


-- test data;

INSERT INTO `checklists` (name) VALUES ('go camping');
INSERT INTO `items` (checklist_id, name) VALUES
 (1,'pick a spot'),
 (1,'pack your gear'),
 (1,'enjoy the trip'),
 (1,'clean and put away your stuff');


-- teardown;

DROP TABLE IF EXISTS
  checklists,
  items;

