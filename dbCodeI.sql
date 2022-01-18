create table USERS(
	idUser serial primary key,
	username varchar(50) not null,
	passwordu varchar(300) not null,
	mail varchar(50) not null,
	image varchar(70) not null
	deleted date
);

select *
from USERS;

update USERS
set image = 'fearOfTheDark.jpg'
where iduser= 12

delete from USERS
where iduser=10;

insert into USERS(username,passwordu,mail) values('tongas97','12345','tongas@gmail.com');
insert into USERS(username,passwordu,mail) values('linkinpark7','metallica5','example@user.com');

create table CATEGORIES(
	idCat serial primary key,
	nameC varchar(50) not null,
	deletedC date
);

insert into CATEGORIES(namec) values('Science');
insert into CATEGORIES(namec) values('sports');

update CATEGORIES
set namec = 'Sports'
where idcat=2

select *
from CATEGORIES;

create table POSTS(
	idPost serial primary key,
	banner varchar(80) not null,
	title varchar(100) not null,
	intro varchar(200) not null,
	contentP varchar(600) not null,
	category int not null,
	created_at date not null,
	author int not null,
	slug varchar(100),
	deletedP date,
	constraint AUT foreign key (author) references USERS (idUser)
		on delete cascade
		on update cascade,
	constraint CAT foreign key (category) references CATEGORIES (idCat)
		on delete cascade
		on update cascade
);

delete from POSTS;

select *
from POSTS;

delete from tags

create table TAGS(
	idpos int,
	nametag varchar(50),
	deletedT date,
	primary key (idpos,nametag),
	constraint IDP foreign key (idpos) references POSTS (idpost)
		on delete cascade
		on update cascade
);

select *
from TAGS;

select * 
from POSTS inner join TAGS on POSTS.idpost=TAGS.idpos


create table NEWSLETTER(
	idNew serial primary key,
	email varchar(60) unique not null,
	added_at date,
	deletedN date
);

select * from POSTS order by random() limit 2;
						

select count(idpost)
from POSTS;

select *
from NEWSLETTER;

create table COMMENTARIES(
	idCom serial primary key,
	post int not null,
	cName varchar(60) not null,
	cEmail varchar(60) not null,
	cMessage varchar(300) not null,
	added_m date not null,
	deletedc date,
	constraint POS foreign key (post) references POSTS (idPost)
);

delete
from COMMENTARIES;

select *
from COMMENTARIES;
