create database PHP_MVC;
use PHP_MVC;

DROP TABLE IF EXISTS contact;

CREATE TABLE contact (
	id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	email VARCHAR(255),
	phone VARCHAR(255)
);

insert into contact(id, name, email, phone) 
values(1 , 'Angel', 'email@mail.com', '593'); 
insert into contact(id, name, email, phone) 
values(2 , 'Dome', 'email@mail.com', '593');
insert into contact(id, name, email, phone) 
values(3 , 'Dyan', 'email@mail.com', '593');
insert into contact(id, name, email, phone) 
values(4 , 'Pek', 'email@mail.com', '593');

COMMIT;