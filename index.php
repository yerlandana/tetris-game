<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = `login`;

try{
    $conn = new PDO("mysql:host = $servername;
     dbname = $dbname", $username, $password);  //changed to ""

    $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        
$name=$passowrd= $nameErr=$passwordErr = $error="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(test_input($_POST["name"]))){
        $nameErr = "Enter Username";
        console_log("Enter Username");
    }else{
        $name = test_input($_POST["name"]);
    }
    if(empty(test_input($_POST["password"]))){
        $passwordErr = "Enter Password";
        console_log("Enter Password");
    }else{
        $password = test_input($_POST["password"]
    );
    }
}

if(empty($nameErr)&&empty($passwordErr)) {
    $stmt = $conn->query("SELECT user.id FROM login.user
     WHERE user.name = '$name' AND user.password = '$password';");
    if($stmt->execute()){
        if($stmt->rowcount()== 1){
            session_start();
            $_SESSION["name"] = $name;
            header("location: welcome.php");
            console_log("Welcome"); 
        }else{
            $error = "username or password didn't match"; 
            console_log("Password didn't match");
        }   
    }
}
}
catch (Exception $e) { 
    echo $e->getMessage(); 
} 


function test_input($data){
$data = trim($data);
$data = stripcslashes($data);
$data = htmlspecialchars($data);
return $data;
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

?>

<!DOCTYPE html>
<html>
    <title>Tetris</title>
    <meta charset="utf-8">
    <body align ="center">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"
             method = "post">
     <b>LOGIN INTO ACCOUNT</b></br><br>
     Login:
     </br><input type = "text" name="name"><span><?php echo $nameErr; ?></span><br><br>
     Password:
     </br><input type="password" name="password"><span><?php echo $passwordErr; ?></span><br><br>
     <span><?php echo $error; ?></span>
    <input type="submit" name="submit" value="Login"></input>
</form>
<?php $conn = null; ?>
</body>
</html>