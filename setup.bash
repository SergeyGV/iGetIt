#!/bin/bash

username=""
password=""

psql -h mcsdb.utm.utoronto.ca -d "$username"_309 -U $username -c 'DROP TABLE course_list;DROP TABLE appuser;DROP TABLE activity;CREATE TABLE course_list (coursename varchar(50) primary key, coursecode varchar(50), getit int, dontgetit int);CREATE TABLE activity (coursename varchar(50), username varchar(50), PRIMARY KEY(coursename, username));CREATE TABLE appuser (username varchar(50) primary key, password varchar(50), firstname varchar(50), lastname varchar(50), email varchar(50), type varchar(50), sec_q varchar(50), sec_a varchar(50));'

if [ $? -eq 0 ]; then
		echo "function getUsername(){return $username;}" >> model/model.php
		echo "function getPassword(){return $password;}" >> model/model.php
		echo "?>" >> model/model.php
fi

