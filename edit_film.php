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
// Search
if(isset($_POST['search']))
{
    $data = getPosts();  
    $search_Query = "SELECT * FROM film WHERE film_id = $data[0]"; 
    $search_Result = mysqli_query($connect, $search_Query); 
    if($search_Result)
    {
        if(mysqli_num_rows($search_Result))
        {
            while($row = mysqli_fetch_array($search_Result))
            {
                $film_id = $row['film_id'];
                $name = $row['name'];
                $rating = $row['rating'];
                $description = $row['description'];
                $starring = $row['starring'];
                $year = $row['year'];
                $image = $row['image'];
            }
        }else{
            echo "<h2 class = 'err'>Не найден фильм с таким ID!</h2>";
        }
    }else{
        echo 'Result Error';
    }
}
// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    $insert_Query = "INSERT INTO `film`(`name`, `rating`,`description`,`starring`,`year`,`image`) VALUES ('$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]')";
    try{
        $insert_Result = mysqli_query($connect, $insert_Query);
        
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo "<h2 class = 'done' >Фильм добавлен.</h2>";
            }else{
                echo "<h2 class = 'err'>Данные введены неправильно!</h2>";
            }
        }
    } catch (Exception $ex) {
        echo 'Error Insert '.$ex->getMessage();
    }
}
// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    $delete_Query = "DELETE FROM `film` WHERE `film_id` = $data[0]";
    try{
        $delete_Result = mysqli_query($connect, $delete_Query);
        
        if($delete_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo "<h2 class = 'done'>Фильм удален.</h2>";
            }else{
                echo "<h2 class = 'err'>Данные введены неправильно!</h2>";
            }
        }
    } catch (Exception $ex) {
        echo "<h2 class = 'err'>Ошибка удаления!</h2>".$ex->getMessage();
    }
}
// Edit
if(isset($_POST['update']))
{
    $data = getPosts();
    $update_Query = "UPDATE `film` SET `name` = '$data[1]', `rating` = '$data[2]', `description` = '$data[3]', `starring` = '$data[4]', `year`  = '$data[5]',`image`  = '$data[6]' WHERE `film_id` = '$data[0]' ";
    try{
        $update_Result = mysqli_query($connect, $update_Query);
        
        if($update_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo "<h2 class = 'done'>Информацию про фильм изменено.</h2>";
            }else{
                echo '';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update '.$ex->getMessage();
    }
}
?>
<main>
    <header>
            <li id="img"><a href = "edit_film.php"><img width = "170px" src = "image/log.png"></a></li>
            <li><a class="ex_button" href="logout.php">Выйти</a></li>
    </header>
<div class="container mshow_film">
    <div id="show_film">
        <form action="edit_film.php" method="post">

            <input class="input" type="number" name="film_id" 
            placeholder="Номер" value="<?php echo $film_id;?>"><br><br>

            <input type="text" name="name" placeholder="Название" value="<?php 
            echo $name;?>"><br><br>

            <input class="input" type="number" step="0.01" name="rating" 
            placeholder="Рейтинг" value="<?php echo $rating;?>"><br><br>

            <input  type="text" name="description" placeholder="Жанр" 
            value="<?php echo $description;?>"><br><br>

            <input  type="text" name="starring" placeholder="В ролях" 
            value="<?php echo $starring;?>"><br><br>

             <input class="input" type="number" name="year" 
            placeholder="Год выпуска" value="<?php echo $year;?>"><br><br>

            <input  type="text" name="image" placeholder="URL" 
            value="<?php echo $image;?>"><br><br>

            <div>
                <!-- Input For Add Values To Database-->
                <input type="submit" class="button" name="insert" 
                value="Добавить">

                <!-- Input For Edit Values -->
                <input type="submit" class="button" name="update" 
                value="Изменить">

                <!-- Input For Clear Values -->
                <input type="submit" class="button" name="delete" 
                value="Удалить">

                <!-- Input For Find Values With The given ID -->
                <input type="submit" class="button" name="search" 
                value="Найти">
            </div>
        </div>
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
    echo "<p>Всего фильмов: $rowsCount</p>";
    echo "<table>
    <tr>
    <th>№</th>
    <th>Постер</th>
    <th>Название</th>
    <th>Жанр</th>
    <th>Рейтинг</th>
    <th>Год</th>
    <th>В ролях</th>
    </tr>";
    foreach($result as $row){
        echo "<tr>";
        echo "<td >" . $row["film_id"] . "</td>";
        echo "<td>" ?>
        <img src = "<?php echo $row["image"]; ?>" width = 200px> <?php "</td>";
        echo "<td class = 'film_name'>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td class ='rating'>" . $row["rating"] . "</td>";         
        echo "<td>" . $row["year"] . "</td>";
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
