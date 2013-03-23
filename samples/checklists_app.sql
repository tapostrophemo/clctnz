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

INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('create checklist', '', 'INSERT INTO checklists (name) VALUES (?)', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('edit checklist', '', 'UPDATE checklists SET name = ? WHERE id = ?', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('delete checklist', '', 'DELETE FROM items WHERE checklist_id = ?\nDELETE FROM checklists WHERE id = ?', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('create item', '', 'INSERT INTO items (checklist_id, name) VALUES (?, ?)', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('edit item', '', 'UPDATE items SET name = ? WHERE id = ?', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('reorder item', '', 'UPDATE items SET seq = ? WHERE id = ?', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('delete item', '', 'DELETE FROM items WHERE id = ?', 0, '');
INSERT INTO _clctnz_operations(name, role, sql_text, has_view, view_code) VALUES('get checklists', '', 'SELECT * FROM checklists', 1, '<?php $this->view("header"); ?>\n\n<ul>\n<?php foreach ($checklists as $c): ?>\n <li><a href="/get_checklist/<?=$c->id?>"><?=$c->name?></a></li>\n<?php endforeach; ?>\n</ul>\n\n<?php $this->view("footer"); ?>');


-- application settings;

UPDATE `_clctnz_application` SET `value` = 'FOOTER HERE' WHERE `name` = 'footer';
UPDATE `_clctnz_application` SET `value` = 'HEADER HERE' WHERE `name` = 'header';
UPDATE `_clctnz_application` SET `value` = 'STYLE HERE' WHERE `name` = 'style';
UPDATE `_clctnz_application` SET `value` = 'localhost' WHERE `name` = 'db_hostname';
UPDATE `_clctnz_application` SET `value` = 'app_owner' WHERE `name` = 'db_username';
UPDATE `_clctnz_application` SET `value` = 'app_password' WHERE `name` = 'db_password';
UPDATE `_clctnz_application` SET `value` = 'app_database' WHERE `name` = 'db_database';


-- test data;

INSERT INTO `checklists` (name) VALUES
 ('go camping'),
 ('things to do with an empty aluminum can');

INSERT INTO `items` (checklist_id, name) VALUES
 (1,'pick a spot'),
 (1,'pack your gear'),
 (1,'enjoy the trip'),
 (1,'clean and put away your stuff'),
 (2,'make a radio'),
 (2,'make a model boat'),
 (2,'make art'),
 (2,'make jewelry'),
 (2,'make a chandelier'),
 (2,'use for shingles on a roof or siding'),
 (2,'make a christmas tree'),
 (2,'make christmas ornaments'),
 (2,'make origami'),
 (2,'make a robot'),
 (2,'make a guitar amplifier');


-- teardown;

DROP TABLE IF EXISTS
  checklists,
  items;

