# Ecommerce
Ecommerce website using PHP and MysSQL.

### 'dbFiles' Folder:
Contains 2 essential file:
 - connection => To make the connection to the database and configure the database settings.
 - constraints => This have a static methods to add constraints in the database.

### 'models' Folder:
Each class(file) in this folder represent a table in the database. Any column attribute or table should be configure here. The tables
are created automaticly but to add a new column/attribute you should add it from the DBMS then configure it here.

**Important!**
 - 'dbparent' class is the parent of all the other classes where it contains the connection to the database and some models-shared attribute and methodes.

Make a instance of any model then use the function inside it.
  Example:
  ```bash 
  $user = new User();
  $user->add('Hamzeh','hamzed@gmsail.com','12345678', Role::ADMIN, 'Amman', '0799999999');
```



### 'othrt' Folder 
Contains some files (Take a look).
