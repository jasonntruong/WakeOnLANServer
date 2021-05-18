<?php
echo "Wake On LAN Server by Jason Truong";

$GOOGLE_HOME_PASSWORD = getenv('TURN_ON_PC', true); #Security environment variable. Acts as the password - computer only turns on if POST request matches the password

#Adds $computer parameter to database. Allows me to track where and when I used my Apache server to turn on my computer in a SQL database
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
    @$connection->close;
}

#Formats data
function formatData($data) {
    $data = trim($data);                #removes whitespaces at both ends
    $data = stripslashes($data);        #removes slashes
    $data = htmlspecialchars($data);    #converts special characters to HTML entities; prevents PHP_SELF exploit
    return $data;
}   

#decode the JSON data from IFTTT's webrequest
$jsonData = file_get_contents('php://input');
$decodedData = json_decode($jsonData);

@$_POST['REQ_PASSWORD'] = formatData($decodedData->REQ_PASSWORD);      #@ to hide potential warnings (i.e when accessing homepage there's no POST request so unwanted warning shows)

#on POST web request...
if(isset($_POST['REQ_PASSWORD'])) {
    $REQ_PASSWORD = $_POST['REQ_PASSWORD'];

    #if POST web request $REQ_PASSWORD == $GOOGLE_HOME_PASSWORD
    if (strcmp($REQ_PASSWORD, $GOOGLE_HOME_PASSWORD) == 0) {
        addToDB("FROM_GOOGLE_HOME");                            #adds FROM_GOOGLE_HOME to database so I know the web request came from my google home
        $command = escapeshellcmd('python wakeCompOnLan.py');   #runs python file which sends a magic lan packet to wake computer
        $output = shell_exec($command);
        echo $output;
    }
    else if (empty($REQ_PASSWORD) == false) {           #ex. $REQ_PASSWORD empty on homepage
        addToDB("REQ_PASSWORD {$REQ_PASSWORD}");       #adds to database so I know if someone is using the web request and server elsewhere
    }
}
?>