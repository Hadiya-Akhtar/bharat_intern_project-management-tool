<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&family=Playpen+Sans&family=Poppins:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<?php
    if(isset($_POST["submit"])){
        $fullname=$_POST["fullname"];
        $email=$_POST["email"];
        $password=$_POST["password"];
        $passwordRepeat=$_POST["repeat_password"];


        $errors=array();
        {
            if(empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
            array_push($errors,"All field are required");
            }
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($errors,"email is not valid");
            }
            if (strlen($password)<8){
                array_push($errors,"Password must be 8 character long");
            }
            if($password!==$passwordRepeat){
                array_push($errors,"password does'nt match");
            }
            /*for removing duplication of email */
            require_once "database.php";
            $sql="select*from users where email='$email'";
            $result=mysqli_query($conn,$sql);
            $rowcount= mysqli_num_rows($result);
            if($rowcount>0){
                array_push($errors,"email already exits");
            }
            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            else{
                $sql= "insert into users(full_name, email, password) values (?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                $prepareStmt=mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$password);
                    mysqli_stmt_execute($stmt);
                    /*echo "<div class='alert alert-success'>registered successfully</div>";*/
                    header("location: home.php");
                    die();
                }
                else{
                    die("something went wrong");
                }
            }
        }
    }
    ?>

    <div class="container">
        <form action="signup.php" method="post" class="formcon">
            <div class="form_group">
                <input type="text" class="form-control" name="fullname" placeholder="fullname">
            </div>
            <div class="form_group">
                <input type="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form_group">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            <div class="form_group">
                <input type="text" class="form-control" name="repeat_password" placeholder="Repeat password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
</body>
</html>