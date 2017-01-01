# IETpage
In the database create two tables using the below SQL commands  
CREATE TABLE tbl_users(user_id int(11) NOT NULL AUTO_INCREMENT, username varchar(60) NOT NULL, email varchar(60) NOT NULL, password varchar(60) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY (user_id)) ENGINE= InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;  
CREATE TABLE tbl_members(user_id int(11), username varchar(60), memno varchar(60) FOREIGN KEY(user_id) REFERENCES tbl_users(user_id));
