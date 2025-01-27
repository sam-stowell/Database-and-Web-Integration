<html>

<head></head>

<body>
<?php
require_once("connection.php"); 
if (isset($_GET['id'])) {
    // get owner id
    $owner_id = $_GET['id'];
    // sql statement
    $query = "SELECT * FROM `owners` WHERE id = ".$owner_id;
    $owner_details = mysqli_query($conn, $query);
    // heading
    echo "<h1>Owner Details</h1>";
    //table
    $query = "SELECT * FROM `owners` WHERE id = ".$owner_id;
    $owner_details = mysqli_query($conn, $query);
    echo "
        <table border = '1'>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>";
        // table details
        while($row = mysqli_fetch_assoc($owner_details))
        {
            echo "<tr>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["address"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
} else {
    echo "Owner ID not provided.";
}



?>
</body>
</html>