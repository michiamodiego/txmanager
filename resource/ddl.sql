create database testdb;
use testdb;

create table athing (
	id integer(11) unsigned not null auto_increment, 
	afield1 varchar(60), 
	afield2 varchar(60), 
	primary key(id)
);