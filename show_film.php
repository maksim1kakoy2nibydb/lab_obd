<?php include("includes/header.php"); ?>
<?php
$host = "localhost";
$user = "root";
$password ="";
$database = "cinema";
$film_id = "";
$name = "";
$rating = "";
$description = "";
$starring = "";
$year = "";
$image = "";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// connect to mysql database
try{
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Error';
}


// get values from the form
function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['film_id'];
    $posts[1] = $_POST['name'];
    $posts[2] = $_POST['rating'];
    $posts[3] = $_POST['description'];
    $posts[4] = $_POST['starring'];
    $posts[5] = $_POST['year'];
    $posts[6] = $_POST['image'];
    return $posts;
}
?>
<main>
    <header>
            <li id="img"><a href = "show_film.php"><img width = "170px" src = "image/log.png"></a></li>
            <li><a class="ex_button" href="logout.php">Выйти</a></li>
    </header>

    <div>
        <div class="container mshow_film">
            <form action="show_film.php" method="post">
            </form>
            <h2>Список фильмов</h2>
            <?php
            $conn = new mysqli("localhost", "root", "", "cinema");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM film";
            if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<table>
    <tr>
    <th>Постер</th>
    <th>Название</th>
    <th>Жанр</th>
    <th>Год</th>
    <th>Рейтинг</th>
    <th>В ролях</th>
    </tr>";
    foreach($result as $row){
        echo "<tr>";
        echo "<td>" ?> <img src = "<?php echo $row["image"]; ?>" width = 200px> <?php "</td>";
        echo "<td class = 'film_name'>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["year"] . "</td>";
        echo "<td class ='rating'>" . $row["rating"] . "</td>";
        echo "<td class = 'starring'>" . $row["starring"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}

$conn->close();
?>
<?php include("includes/footer.php"); ?>
