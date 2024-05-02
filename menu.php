<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
        session_unset(); 
        session_destroy(); 
        header("location: login.php"); 
        exit(); 
    }
}
?>
<html>
<head>
    <title>PÀGINA WEB DEL MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</title>
</head>
<body>
    <h2>MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</h2>
    <br><br>
    <p>Selecciona una opción:</p>
    <ol>
        <li><a href="visualitzacio.php">Visualización de datos</a></li>
        <li><a href="creacio.php">Creación de usuario</a></li>
        <li><a href="esborrament.php">Esborrament d'usuari</a></li>
        <li><a href="modificacio.php">Modificación d'atributs</a></li>
    </ol>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="submit" name="logout" value="Cerrar sesión"/>
    </form>
</body>
</html>
