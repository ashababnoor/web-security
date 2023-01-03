-- creating database
create database if not exists websec;

use websec;

-- creating users table
create table if not exists users (
    id int auto_increment primary key,
    firstname varchar(50),
    lastname varchar(50),
    username varchar(20) not null unique,
    email varchar(100) not null,
    pass varchar(100) not null,
    usertype enum("user", "admin", "superadmin") default "user"
);

-- populating users with some dummy data /admins
insert into users (firstname, lastname, username, email, pass, usertype)
values ("John", "Doe", "admin", "admin@admin.com", "1234", "superadmin"),
       ("Jane", "Doe", "jane", "jane@gmail.com", "6789", "admin");

-- populating users with some dummy data /users
insert into users (firstname, lastname, username, email, pass)
values ("Shabab", "Noor", "shabab", "shabab@gmail.com", "hello"),
       ("Ahmed", "Shabab", "ahmed", "ahmed@gmail.com", "world");

-- creating notes table
create table if not exists notes (
    id int auto_increment primary key,
    title varchar(100),
    body varchar(1024),
    userid int,
    constraint fk_users_notes foreign key (userid) references users(id)
);

-- populating notes table with dummy data
INSERT INTO `notes`(`id`, `title`, `body`, `userid`) 
VALUES (1, "My first note", "Hello, this is my first note in this app.", 1), (2, "To-Do", "Finish Computer Security project asap.", 1)