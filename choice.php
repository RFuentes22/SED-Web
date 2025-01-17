
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
        <div class="page-header">
        <h1>Cliente:  <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>.</h1>
        </div>
        <p>
            <a href="logout.php" class="btn btn-danger">Salir de la cuenta</a>
        </p>
	<p>
	    <a href="welcome.php" class="btn btn-info">Crear nuevo Cliente </a>
	</p>
        <p>
            <a href="bank_account.php" class="btn btn-primary">Crear cuenta de banco</a>
            <a href="creditCard.php" class="btn btn-primary">Crear tarjeta de credito</a>
        </p>
        
</body>
</html>




