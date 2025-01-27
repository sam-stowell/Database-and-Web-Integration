<html>

<head></head>

<body>
<?php require_once("connection.php"); 

    // query for the owner count
    $query1 = "SELECT COUNT(DISTINCT owner_id) AS owner_count FROM `dogs` WHERE id in (SELECT DISTINCT dog_id from entries)";
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $xx = $row1['owner_count'];

    // query for the dog count
    $query2 = "SELECT COUNT(DISTINCT dog_id) AS dog_count FROM `entries` WHERE 1";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $yy = $row2['dog_count'];

    // query for the event count
    $query3 = "SELECT COUNT(DISTINCT event_id) AS event_count FROM `competitions` WHERE 1";
    $result3 = mysqli_query($conn, $query3);
    $row3 = mysqli_fetch_assoc($result3);
    $zz = $row3['event_count'];


    // heading and title
    echo "<h1>Welcome to Poppleton Dog Show! This year $xx owners entered $yy dogs in $zz events!</h1></br>";
    echo "<h2>Top 10 dogs:</h2></br>";

    // SQL query for the table on the page
    $query = "
    SELECT
    dogs.name AS dog_name,
    breeds.name AS breed,
    AVG(entries.score) AS average_score,
    owners.name,
    owners.id,
    owners.email
    FROM
        dogs
    INNER JOIN entries ON dogs.id = entries.dog_id
    INNER JOIN breeds ON dogs.breed_id = breeds.id
    INNER JOIN owners ON dogs.owner_id = owners.id
    WHERE
        dogs.id IN(
        SELECT
            dog_id
        FROM
            entries
        GROUP BY
            dog_id
        HAVING
            COUNT(*) > 1
    )
    GROUP BY
        dogs.id,
        dogs.name,
        breeds.name,
        owners.name,
        owners.email
    ORDER BY
        AVG(entries.score)
    DESC
    LIMIT 10
    ";
    
    $results = mysqli_query($conn, $query); 

    //table creation for the page
    echo "
    <table border = '1'>
        <th>Name</th>
        <th>Breed</th>
        <th>Average Score</th>
        <th>Owner</th>
        <th>Owner Email</th>";
    
    // table data for the page
    while($row = mysqli_fetch_assoc($results))
    {
        echo "<tr>";
        echo "<td>".$row["dog_name"]."</td>";
        echo "<td>".$row["breed"]."</td>";
        echo "<td>".$row["average_score"]."</td>";
        echo "<td><a href='owner_details.php?id=".$row["id"]."'>".$row["name"]."</a></td>";
        echo "<td><a href='mailto:".$row["email"]."'>".$row["email"]."</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>
</html>