English malayalam dictionary.
-----------------------------

I used dataset from https://olam.in/open/enml/ which is licensed under ODbl ( http://opendatacommons.org/licenses/odbl/summary/ ).

Created to learn usage of unicode in mysql-php environment. Spent two hours.

Environment
Ubuntu
PHP 7.0
MySQL 5.7.21
apache 2 

Create the table dictionary 
CREATE TABLE `dictionary` ( `id` int(11) NOT NULL, `english_word` varchar(150) NOT NULL, `part_of_speech` varchar(50) NOT NULL, `malayalam_definition` varchar(400) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8

To load csv to mysql:
mysql -uroot -p malayalam  -e "LOAD DATA LOCAL INFILE '~/Desktop/olam-enml.csv' INTO TABLE dictionary"

You may have to set encoding to utf8_general_ci for db and table ( I used phpmyadmin ).

A screenshot is attached.
