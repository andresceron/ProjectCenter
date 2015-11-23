// MYSQL



TBL_USERS
+---------+----------------+---------------+----------------+-----------------+---------------+---------------+--------------+---------------+
| user_id | user_firstname | user_lastname | user_email  	| user_department | user_usertype | user_usertype | user_avatar	 | user_pass	 |
+---------+----------------+---------------+----------------+-----------------+---------------+---------------+----------------+-------------+
| 1       | Firstname      | Lastname      | first@last.com	| Front-End		  | 1             | 1             | 1     		 | ********      |
+---------+----------------+---------------+----------------+-----------------+---------------+---------------+----------------+-------------+


TBL_PROJECTS
+---------+---------------+----------------------+-----------------+---------------+------------+
| proj_id | proj_name	  | proj_desc		  	 | proj_date_start | proj_date_end | proj_state |
+---------+------------+------------+-----------------+---------------+---------------+---------+
| 1       | Project Name  | Project Description  | 2015-10-04      | 2015-11-01    | 1          |
+---------+---------------+----------------------+-----------------+---------------+------------+






TBL_LINK
+-----------+---------+---------+
| link_id	| proj_id | user_id	|
+-----------+---------+---------+
| 1			| 1		  | 1		|
+-----------+---------+---------+
| 1			| 2		  | 1		|
+-----------+---------+---------+
| 1			| 3		  | 1		|
+-----------+---------+---------+
| 2			| 1		  | 2		|
+-----------+---------+---------+
| 2			| 4		  | 2		|
+-----------+---------+---------+
| 2			| 5		  | 2		|
+-----------+---------+---------+


TBL_DEPARTMENTS
+---------------+-----------------------+
| department_id	| department_name 		|
+---------------+-----------------------+
| 1				| Front-End Developer   |
+---------------+-----------------------+
| 2				| Back-End Developer    |
+---------------+-----------------------+
| 3				| Web Designer			|
+---------------+-----------------------+
| 4				| Project Manager 		|
+---------------+-----------------------+


TBL_avatars
+-----------+---------------+
| avatar_id	| avatar_url 	|
+-----------+---------------+
| 1			| avatar-01.png |
+-----------+---------------+
| 2			| avatar-02.png |
+-----------+---------------+
| 3			| avatar-03.png	|
+-----------+---------------+
| 4			| avatar-04.png |
+-----------+---------------+


TBL_TODOS
+-----------+-------------------+-----------+---------------+
| todo_id	| todo_task			| proj_id	| todo_state	|
+-----------+-------------------+-----------+---------------+
| 1			| My first task		| 1			| 1  			|
+-----------+-------------------+-----------+---------------+
| 2			| My second task	| 1			| 0  			|
+-----------+-------------------+-----------+---------------+
| 3			| My first Tasks	| 2			| 0  			|
+-----------+-------------------+-----------+---------------+
| 4			| My second Tasks	| 2			| 0  			|
+-----------+-------------------+-----------+---------------+






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

