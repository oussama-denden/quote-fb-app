#
#  dbtables.sql
#
#  Simplifies the task of creating all the database tables
#  used by the login system.
#
#  Can be run from command prompt by typing:
#
#  mysql -u yourusername -D yourdatabasename < dbtables.sql
#
#  That's with dbtables.sql in the mysql bin directory, but
#  you can just include the path to dbtables.sql and that's
#  fine too.
#
#  Please subscribe to our feeds at http://blog.geotitles.com for more such tutorials
#

#
#  Table structure for users table
#
DROP TABLE IF EXISTS quote_users;

CREATE TABLE quote_users (
 username varchar(30) primary key,
 password varchar(32),
 userid varchar(32),
 userlevel tinyint(1) unsigned not null,
 email varchar(50),
 timestamp int(11) unsigned not null
);


#
#  Table structure for active users table
#
DROP TABLE IF EXISTS quote_active_users;

CREATE TABLE quote_active_users (
 username varchar(30) primary key,
 timestamp int(11) unsigned not null
);


#
#  Table structure for active guests table
#
DROP TABLE IF EXISTS quote_active_guests;

CREATE TABLE quote_active_guests (
 ip varchar(15) primary key,
 timestamp int(11) unsigned not null
);


#
#  Table structure for banned users table
#
DROP TABLE IF EXISTS quote_banned_users;

CREATE TABLE quote_banned_users (
 username varchar(30) primary key,
 timestamp int(11) unsigned not null
);



#
#  Table structure for facebook application users table
#
DROP TABLE IF EXISTS quote_app_users;

CREATE TABLE quote_app_users (
 uid varchar(30) primary key,
 token varchar(500),
 user_name varchar(30),
 timestamp int(11) unsigned not null
);


