<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project_Management_tool</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&family=Playpen+Sans&family=Poppins:wght@100&display=swap" rel="stylesheet">
</head>
<body>
    <h1>PMT</h1>
    <div class="nav">
        <ul>
            <li><a href="signup.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>

    <?php
        require_once 'database.php';
        if(isset($_POST["submit"])){
            $full_name = $_POST['full_name'];
            $task = $_POST['task'];
            $status = $_POST['status'];
            $due_date = $_POST['due_date'];

            $sql= "insert into addusers(full_name, task, status, due_date) values (?,?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                $prepareStmt=mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$full_name,$task,$status,$due_date);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>New task added</div>";
                    header("location: home.php");
                    die();
                }
                else{
                    die("something went wrong");
                }
        }

        function display_task($conn){
            $sql = "SELECT id, full_name, task, status, due_date FROM addusers";
            $result = $conn->query($sql);
        
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<p>" . $row["full_name"] . "</p>";
                    echo "<p>" . $row["task"] . "</p>";
                    echo "<p>" . $row["status"] . "</p>";
                    echo "<p>" . $row["due_date"] . "</p>";
                    echo "<hr>";
                }
            }
            else {
                echo "No post found";
            }
        }
    ?>

    <div class="container">
        <form action="home.php" method="post">
            <label for="full_name">Full Name:</label><br>
            <input type="text" id="full_name" name="full_name"><br>
            <label for="task">Task:</label><br>
            <input type="text" id="task" name="task"><br>
            <label for="status">Status:</label><br>
            <select id="status" name="status">
              <option value="complete">Complete</option>
              <option value="due">Due</option>
              <option value="ongoing">Ongoing</option>
            </select><br>
            <label for="due_date">Due Date:</label><br>
            <input type="date" id="due_date" name="due_date"><br>
            <input type="submit" value="Submit">
        </form>
        <hr>
    </div><br><br><br><br><br>
    
    <div class="container">
        <?php 
        display_task($conn); 
        ?>
    </div>


    <footer>
        <div class="footer">
            <p class="fooot">bharat_intern_project2</p>
        </div>
    </footer>
</body>
</html>