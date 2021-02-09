<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "practice";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}


function ExecuteQuery($sql)
{
    $conn = OpenCon();
    $result = $conn->query($sql);
    if($result)
    {
        CloseCon($conn);
        return $result;

    }
    else
    {
        $error = "Error creating table: " . $conn->error;
        CloseCon($conn);
        return $error;
    }
}




function getSerialKey(){


    $conn = OpenCon();

    $query = "SELECT * FROM serial_keys LIMIT 1";

    $res = ExecuteQuery($query);

    $serialKey = null;

    while ($row = $res->fetch_assoc()) {

        $serialKey = $row['serialKey'];
        $query = "DELETE FROM serial_keys WHERE id = " . $row['ID'];
        ExecuteQuery($query);

    }



    CloseCon($conn);

    return $serialKey;

}


?>