<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//form client
// Include config file
$mysqli = new mysqli("localhost", "root", "root", "banc");

if($_SERVER["REQUEST_METHOD"] == "POST"){

        /* Preparar una sentencia INSERT */
        $consulta = "INSERT INTO client (dui, name, lastname, birthdate, address, city, country, phone, employeeID) VALUES (?,?,?,?,?,?,?,?,?)";
        $sentencia = $mysqli->prepare($consulta);

        $sentencia->bind_param("issssssii", $dui, $name, $lastname, $birthdate, $address, $city, $country, $phone, $employeeID);

        // Set parameters
        $dui = trim($_POST["dui"]);
        $name = trim($_POST["name"]);
        $lastname = trim($_POST["lastname"]);
        $input_date=$_POST['birthdate'];
        $birthdate=date("d-m-Y",strtotime($input_date)); 
        $address = trim($_POST["address"]);
        $city = trim($_POST["city"]);
        $country = trim($_POST["country"]);
        $phone = trim($_POST["phone"]);
	$employeeID = $_SESSION["employeeID"];

        /* Ejecutar la sentencia */
        if($sentencia->execute()){
            $_SESSION["dui"] = $dui; $_SESSION["name"] = $name;
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
    <h1>Bienvenido, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> al sistemabanc.</h1>
    </div>
    <p>
       	<a href="reset-password.php" class="btn btn-warning">Recuperar Password</a>
        <a href="logout.php" class="btn btn-danger">Salir de la cuenta</a>
    </p>
    <div class="contenedor">
                <h2>Creacion de perfil de Cliente</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                                <label>DUI: </label>
                                <input type="number" name="dui" class="form-control" autofocus>
                        <div class="form-group">
                                <label>Nombre: </label>            
                                <input type="text" name="name" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Apellido: </label>
                                <input type="text" name="lastname" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Fecha de Nacimiento: </label>                    
                                <input type="date" name="birthdate" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Direccion: </label>
                                <input type="text" name="address" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Ciudad: </label>
                                <input type="text" name="city" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Pais: </label>
                                <input type="text" name="country" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                                <label>Telefono: </label>            
                                <input type="number" name="phone" class="form-control" autofocus>
                        </div>                  

			<div class="btn_group">
        			<input type="submit" value="Submit" class="btn btn_primary">
			</div>
		</form>
	</div>
	<div class="contenedor">
		<h2>Consultar informacion de Cliente</h2>
	        <div class="form-group">
		<form action="consult.php"  method="POST">
                        <label>DUI: </label>
                        <input type="number" name="duiConsult" class="form-control" autofocus>
			<input type="submit" name="consult" value="Submit" class="btn btn_primary">
		</form>
                </div> 
	</div>
</body>
</html>




