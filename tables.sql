create table user_reg(user_id int primary key auto_increment,
name varchar(100),
email varchar(30),
password varchar(30),
confirm_password varchar(30),
contact int(10),
address varchar(250)
);

create table admin(admin_id int primary key auto_increment,
name varchar(100),
email varchar(30),
password varchar(30)
);

create table equipments(eq_id int primary key,
name varchar (50),
eq_type varchar(50),
rent_price varchar(50),
status varchar(50),
eq_img longtext,
description varchar(250)
);

create table contact(name varchar(50),
email varchar(50),
contact int(10),
message varchar(250)
);
create table rental(user_id int 