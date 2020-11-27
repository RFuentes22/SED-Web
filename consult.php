<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST") {

        $mysqli = new mysqli("localhost", "root", "root", "banc");

        $duiAux = ($_POST['duiConsult']) ? $_POST['duiConsult'] : $_SESSION['duiCo'];
        $S_SESSION["dui"] = $duiAux;
        $result = mysqli_query($mysqli,"SELECT * FROM client WHERE dui = $duiAux");
        mysqli_data_seek ($result, 0);
        $client= mysqli_fetch_array($result);
        $nameClient = $client['name'];

     if ($_POST['mod']){
        $consulta = "UPDATE client SET name=?,lastname=?,birthdate=?,address=?,city=?,country=?,phone=? WHERE dui = ?";
        $sentencia = $mysqli->prepare($consulta);
        $sentencia->bind_param("ssssssii", $name, $lastname, $birthdate, $address, $city, $country, $phone, $duiC);
        
       	$duiC = trim($_POST["dui"]); 
        $name = trim($_POST["name"]); $lastname = trim($_POST["lastname"]); $birthdate = trim($_POST["birthdate"]);
        $address = trim($_POST["address"]); $city = trim($_POST["city"]); $country = trim($_POST["country"]); $phone = trim($_POST["phone"]);

        if($sentencia->execute()){
             echo "Datos actualizados";  
             $_SESSION['duiCo'] = $duiC;
             header("Location: welcome.php");
             //exit;
        } else{
              echo "Oops! Something went wrong. Please try again later.";
        }

        
       	}
           mysqli_close($mysqli);

        }
?>
         
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Login</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
            <style type="text/css">
                body{ font: 14px sans-serif; }
                .wrapper{ width: 350px; padding: 20px; }
            </style>
        </head>
        <body>
            <div class="page-header">
                <h1>Cliente:  <b><?php echo $nameClient; ?></b>.</h1>
            </div>
            <p>
       	<a href="welcome.php" class="btn btn-primary">Atras</a> 
        <a href="bank_account.php" class="btn btn-primary">Crear cuenta de banco</a>
        <a href="creditCard.php" class="btn btn-primary">Crear tarjeta de credito</a>
    </p>
<div class="contenedor">
    <h2>Datos personales: </h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
         <div class="form-group">
                <input type="hidden" name="dui" class="form-control" autofocus value=<?php echo $client['dui']; ?>>
         </div>
         <div class="form-group">
                <label>Nombre: </label>            
                <input type="text" name="name" class="form-control" autofocus value=<?php echo $client['name']; ?>>
         </div>
         <div class="form-group">
                 <label>Apellido: </label>
                 <input type="text" name="lastname" class="form-control" autofocus value=<?php echo $client['lastname']; ?>>
         </div>
         <div class="form-group">
                 <label>Fecha de Nacimiento: </label>                    
                 <input type="date" name="birthdate" class="form-control" autofocus value=<?php echo $client['birthdate']; ?>>
         </div>
         <div class="form-group">
                 <label>Direccion: </label>
                 <input type="text" name="address" class="form-control" autofocus value=<?php echo $client['address']; ?>>
         </div>
         <div class="form-group">
                 <label>Ciudad: </label>
                 <input type="text" name="city" class="form-control" autofocus value=<?php echo $client['city']; ?>>
         </div>
         <div class="form-group">
                 <label>Pais: </label>
                 <input type="text" name="country" class="form-control" autofocus value=<?php echo $client['country']; ?>>
         </div>
         <div class="form-group">
                 <label>Telefono: </label>            
                 <input type="number" name="phone" class="form-control" autofocus value=<?php echo $client['phone']; ?>>
         </div>                  
         <div class="btn_group">
         <input type="submit" name="mod" value="Modificar Datos" class="btn btn_primary">
         </div>
    </form>
</div>
</body>
</html>
