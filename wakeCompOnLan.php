<?php

#Adds $computer parameter to database
function addToDB($computer) {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $databaseName = "myDB";

    #form new connection
    $connection = new mysqli($servername, $username, $password, $databaseName);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    #inserts computer values into ALLCOMPUTER table in database myDB
    $sql = "INSERT INTO ALLCOMPUTER (compVal)
    VALUES ('$computer')";
    if ($connection->query($sql) === TRUE) {
        echo "Data added succesfully";
    }
    else {
        echo "Error adding to Database" . $connection->error;
    }

    $connection->close;
}

#Formats data
function formatData($data) {
    $data = trim($data);                #removes whitespaces at both ends
    $data = stripslashes($data);        #removes slashes
    $data = htmlspecialchars($data);    #converts special characters to HTML entities; prevents PHP_SELF exploit
    return $data;
}   

#on GET web request for computer...
if(isset($_GET['computer'])) {
    $computer = formatData($_GET['computer']);
    addToDB($computer);         #add to database

    #if GET web request computer == "FROM_GOOGLE_HOME"
    if (strcmp($computer,"FROM_GOOGLE_HOME") == 0) {
        $command = escapeshellcmd('python wakeCompOnLan.py');   #runs python file which sends a magic lan packet to wake computer
        $output = shell_exec($command);
        echo $output;
    }
}
?>