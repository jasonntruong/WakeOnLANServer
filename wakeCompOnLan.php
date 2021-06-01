<?php
#Detecting errors
ini_set('display_errors', true);
error_reporting(E_ALL);

echo "Wake On LAN Server by Jason Truong";

$GOOGLE_HOME_PASSWORD = getenv('TURN_ON_PC'); #Security environment variable. Acts as the password - computer only turns on if POST request matches the password
$PC_PHYS_ADDRESS = getenv('PC_PHYS_ADDRESS'); #Security environment variable. Acts as the MAC address for the computer I want to turn on

function addToDB($computer) {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $databaseName="myDatabase";

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
	addToDB("FROM_GOOGLE_HOME");	   			 #adds FROM_GOOGLE_HOME to database so I know the web request came from my google home
	$wakeComputer = shell_exec("wakeonlan {$PC_PHYS_ADDRESS}");		#runs command with PC's MAC address which sends a magic lan packet to wake computer
	echo $wakeComputer;
    }
    else if (empty($REQ_PASSWORD) == false) {           #ex. $REQ_PASSWORD empty on homepage
        addToDB("REQ_PASSWORD {$REQ_PASSWORD}");       #adds to database so I know if someone is using the web request and server elsewhere
    }
}
?>