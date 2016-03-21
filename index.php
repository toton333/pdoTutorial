<?php

require_once 'connection.php';
if(isset($_POST['e_city'], $_POST['e_gender'])){
     if (!empty($_POST['e_city']) && !empty($_POST['e_gender'])) {
     	$city = $_POST['e_city'];
     	$gender = $_POST['e_gender'];

        /*
          Queries are easy in PDO with the two default methods: query and exec, 
          of which the later is useful if you want to get the number of rows affected and therefore this is useless 
          for SELECT statements.

          */

     //example of no user input

     $query1 = " SELECT name, salary FROM groupBy ";
     $result = $db->query($query1);
     $result->setFetchMode(PDO::FETCH_OBJ);
     while ($row = $result->fetch()) {
          echo "Salary of $row->name is $row->salary. <br/>";
     }

    echo $result->rowCount(); //for mysql database to count number of selected rows.
    echo '<br/><hr/>';

    /*

    $query = "INSERT INTO groupBy VALUES('', 'kup', 'tran', 9000, 'us')";
    $db->exec($query); or $db->query(query) both will work
    but we can use echo $db->exec($query) to get number of row inserted/updated/deleted

    */

    //example of user input this time we need to use prepared statement

          

    $query2= "SELECT name, salary FROM groupBy WHERE city=:city AND gender=:gender";

    //with array

    $statement = $db->prepare($query2);
    $statement->execute(array('city'=>$city, 'gender'=>$gender));

    /*
    $query2= "SELECT name, salary FROM groupBy WHERE city=:? AND gender=:?";

    //with array

    $statement = $db->prepare($query2);
    $statement->execute(array($city, $gender));

    we can also use bindParam() or bindValue() to bind variable seperately with datatype instead of array, which uses a string 
    $statement->bindValue(':city', $city, PDO::PARAM_STR);
    $statement->bindValue(':gender', $gender, PDO::PARAM_STR);

    or when using ?

    $statement->bindValue(1, $city, PDO::PARAM_STR);
    $statement->bindValue(2, $gender, PDO::PARAM_STR);

    Difference between bindParam() and bindValue() is bindParam() binds the actual variable while
    bindValue binds the value of the parameter

    example:
    $sex = 'male';
    $s = $dbh->prepare('SELECT name FROM students WHERE sex = :sex');
    $s->bindParam(':sex', $sex); // use bindParam to bind the variable
    $sex = 'female';
    $s->execute(); // executed with WHERE sex = 'female'

    $sex = 'male';
    $s = $dbh->prepare('SELECT name FROM students WHERE sex = :sex');
    $s->bindValue(':sex', $sex); // use bindValue to bind the variable's value
    $sex = 'female';
    $s->execute(); // executed with WHERE sex = 'male'

    bindParam can be useful if we want to use multiple queries

    $values = array('bob', 'alice', 'lisa', 'john');
    $name = '';
    $stmt = $db->prepare("INSERT INTO table(`name`) VALUES(:name)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    foreach($values as $name) {
    $stmt->execute();
}




    */
    
 
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo "Salary of ". $row['name']." is ". $row['salary']."<br/>";
    }



     } else {
     	echo "All fields are required.";
     }
     
}

/*
//transaction
try {
    $db->beginTransaction();
 
    $db->exec("SOME QUERY");
 
    $stmt = $db->prepare("SOME OTHER QUERY?");
    $stmt->execute(array($value));
 
    $stmt = $db->prepare("YET ANOTHER QUERY??");
    $stmt->execute(array($value2, $value3));
 
    $db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
}
*/

?>



<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Stored Procedure Out Parameter</title>
</head>
<body>

	<form action="" method="post">
     <input type="text" name="e_city" placeholder="Type your city here...">
     <input type="text" name="e_gender" placeholder="Type your gender here...">
     <input type="submit" value="Submit">
	</form>
	
</body>
</html>