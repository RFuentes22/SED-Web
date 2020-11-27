<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
$mysqli = new mysqli("localhost", "root", "root", "banc");


if($_SERVER["REQUEST_METHOD"] == "POST"){

    /* Preparar una sentencia INSERT */
    $consulta = "INSERT INTO bank_account (clientID, code, cvv, type, balance, expeditionDate) VALUES (?,?,?,?,?,?)";
    $sentencia = $mysqli->prepare($consulta);

    $sentencia->bind_param("iissis", $clientID, $code, $cvv, $type, $balance, $expeditionDate);
                
    // Set parameters
    $code = trim($_POST["code"]);
    $cvvNE = trim($_POST["cvv"]);
    $cvv = password_hash($cvvNE, PASSWORD_DEFAULT); // Creates a cvv hash
    $type=$_POST['type'];
    $balance = trim($_POST["balance"]);
    $input_dateExpedition = trim($_POST["expeditionDate"]);
    $expeditionDate=date("d-m-Y",strtotime($input_dateExpedition)); 

    $duiAux = $_SESSION["dui"];
    $result = mysqli_query($mysqli,"SELECT clientID FROM client WHERE dui = $duiAux");
    mysqli_data_seek ($result, 0);
    $extraido= mysqli_fetch_array($result);
    $clientID = $extraido['clientID'];  

    // Ejecutar la sentencia 
    if($sentencia->execute()){
        echo "Cuenta de banco creada correctamente";
        header("location: choice.php");
    }
    else{
	echo "Something went wrong. Please try again later.";
    }
    mysqli_close($mysqli);
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
        <h1>Creacion de cuenta de banco</h1>
        </div>
	<p>
            <a href="logout.php" class="btn btn-danger">Salir de la cuenta</a>
        </p>
        <p>
            <a href="choice.php" class="btn btn-primary">Atras</a>
        </p>       
      	<div class="contenedor">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                                <label>Codigo: </label>            
                                <input type="number" name="code" class="form-control" autofocus>
                        </div>
 			<div class="form-group">
                                <label>Codigo de Seguridad: </label>            
                                <input type="number" name="cvv" class="form-control" autofocus>
                        </div>	
                        <div class="form-group">
                                <label>Tipo: </label>                    
                                <input type="text" name="type" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Saldo: </label>
                                <input type="number" step="any" name="balance" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Fecha de expedicion: </label>
                                <input type="date" name="expeditionDate" class="form-control" autofocus>
                        </div>
                        
                       	<div class="btn__group">
                                <input type="submit" value="Submit" class="btn btn__primary">
                        </div>
</form>

</body>
</html>






