<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz</title>
</head>

<body>
    <form action="index.php" method="POST" name="formularz">
        <input type="text" name="imie" id="" placeholder="Imię">
        <input type="text" name="nazwisko" id="" placeholder="Nazwisko">
        <input type="number" name="wiek" id="" placeholder="Wiek">
        <button value="dodaj" name="dodaj" type="submit">Dodaj</button>
    </form>

    <table border="1">
        <caption>Uczniowie</caption>
        <tr>
            <th>ID</th>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Wiek</th>
        </tr>

        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "szkola2";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
             die("Błąd połączenia: " . mysqli_connect_error());
            }
         ?>

<?php
$sql = "SELECT * FROM uczniowie";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tr><th>Imię</th><th>Nazwisko</th><th>Wiek</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["Imie"]."</td><td>".$row["Nazwisko"]."</td><td>".$row["Wiek"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników";
}
mysqli_close($conn);
?>
    </table>
    
    </form>
    
</body>

</html>



opdsgfdgjklfdsgjklfdsgfdsg