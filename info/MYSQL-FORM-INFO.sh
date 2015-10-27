// MYSQL

TBL_USERS
+---------+----------------+---------------+----------------+-----------------+---------------+
| user_id | user_firstname | user_lastname | user_email  	| user_department | user_usertype |
+---------+----------------+---------------+----------------+-----------------+---------------+
| 1       | Firstname      | Lastname      | first@last.com	| Front-End		  | 1             |
+---------+----------------+---------------+----------------+-----------------+---------------+


TBL_PROJECTS
+---------+------------+------------+-----------------+---------------+---------------+--------------+
| proj_id | proj_name  | proj_desc  | proj_date_start | proj_date_end | proj_combo_id | proj_user_id |
+---------+------------+------------+-----------------+---------------+---------------+--------------+
| 1       | Proj Test  | Test desc  | 2015-10-04      | 2015-11-01    | 1             | 1            |
+---------+------------+------------+-----------------+---------------+---------------+--------------+



TB_RELATED

==	proj_id			user_id   ==
+---------------+---------------+
| related_proj	| related_users |
+---------------+---------------+
| 1				| 1				|
+---------------+---------------+
| 1				| 2				|
+---------------+---------------+
| 1				| 3				|
+---------------+---------------+
| 2				| 1				|
+---------------+---------------+
| 2				| 4				|
+---------------+---------------+
| 2				| 5				|
+---------------+---------------+



----
FORMS
----





________________________________
___FORM START___________________

!! REGISTER
!! & With generated password/code

input	->	text	->	First Name
input	->	text	->	Last Name
input	->	email 	->	Email
input	-> 	pass	->	Password
input	->	pass	-> 	Repeat password
input	->	select 	->	Select Department
						--> Front-End
						--> Back-End
						--> Designer
						--> Q&A Tester
						--> Project Manager
						--> Copy Writer
input	->	select	->	Select User Type
						--> Administrator
						--> Member !!NOT SELECTABLE
submit 	-> 	submit 	->	Register User
-----> &userRegistred.php
	-> Redirect to index.php
	-> Notification: Registred with success.

________________________________
___FORM END_____________________





________________________________
___FORM START___________________

!! CREATE NEW USERS
!! & Only admin can create new users

input	->	text	->	First Name
input	->	text	->	Last Name
input	->	email 	->	Email
input	-> 	pass	->	Password
input	->	pass	-> 	Repeat password
input	->	select 	->	Select Department
						--> Front-End
						--> Back-End
						--> Designer
						--> Q&A Tester
						--> Project Manager
						--> Copy Writer
input	->	select	->	Select User Type
						--> Administrator
						--> Member
submit 	-> 	submit 	->	Create User
-----> &userCreated.php
	-> Redirect to Dashboard.php
	-> Notification: User created successfully.

___FORM END_____________________
________________________________





________________________________
___FORM START___________________

!! LOGIN

input	->	email 	->	Email
input	-> 	pass	->	Password
submit 	-> 	submit 	->	Login
-----> LOGIN
	-> Redirect to Dashboard.php

___FORM END_____________________
________________________________





________________________________
___FORM START___________________

!! CREATE NEW PROJECT - BASE
!! & Only admin can create new users

input	->	text	->	Project Name
input	->	text	->	Project Description
input	-> 	date	->	Project Date Start
input	->	date	-> 	Project Date End
input	->	checkbox->	Departments Required
						--> Front-End
						--> Back-End
						--> Designer
						--> Q&A Tester
						--> Project Manager
						--> Copy Writer
submit 	-> 	submit 	->	Create Project
-----> &projectCreated.php
	-> Redirect to Dashboard.php
	-> Notification: Project Created successfully.

___FORM END_____________________
________________________________





________________________________
___FORM START___________________

!! ADDING AND UPDATING INFO TO PROJECT - BODY
!! & Only admins

input	->	text	->	Project Name
input	->	text	->	Project Description
input	-> 	date	->	Project Date Start
input	->	date	-> 	Project Date End
input	->	checkbox->	Departments Required
						--> Front-End 
							--> User 1
							--> User 2
							--> User 3
							--> ...
						--> Back-End
							--> User 1
							--> User 2
							--> User 3
							--> ...
						--> Designer
							--> User 1
							--> User 2
							--> ...
						--> Q&A Tester
							--> User 1
							--> User 2
							--> ...
						--> Project Manager
							--> User 1
							--> ...
						--> Copy Writer
							--> User 1
							--> ...
input	->	text	->	Add Tasks
						--> Task 1
						--> Task 2
						--> Task 3
						--> ...

submit 	-> 	submit 	->	Update project

-----> &projectCreated.php
	-> Redirect to Dashboard.php
	-> Notification: Project updated.

___FORM END_____________________
________________________________

