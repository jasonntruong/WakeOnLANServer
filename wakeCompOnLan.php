<?php
echo "Wake On LAN Server by Jason Truong";


#Adds $computer parameter to database. Allows me to track where and when I used my Apache server to turn on my computer in an SQL database
#DELETE THIS if you do not plan on setting up a database to store $computer values. If you do, please set up your data base on your own as this function only adds to the data base
function addToDB($computer) {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $databaseName = "myDataBase";

    #form new connection
    $connection = new mysqli($servername, $username, $password, $databaseName);

    if ($connection->connect_error) {
        echo "Connection error";
        die("Connection failed: " . $connection->connect_error);
    }
    
    $sql = "INSERT INTO computerValues (compVal)
    VALUES ('$computer')";

    if ($connection->query($sql) === TRUE) {
        echo "Data added success";
    }
    else {
        echo "Error" . $connection->error;
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
    addToDB($computer);         #add to database. again DELETE THIS if you do not plan on using the database

    #if GET web request computer == "FROM_GOOGLE_HOME"
    if (strcmp($computer,"FROM_GOOGLE_HOME") == 0) {
        $command = escapeshellcmd('python wakeCompOnLan.py');   #runs python file which sends a magic lan packet to wake computer
        $output = shell_exec($command);
        echo $output;
    }
}
?>