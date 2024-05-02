<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

session_start(); // Iniciar sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['cts'] && $_POST['adm']) {
        $opcions = [
            'host' => 'zend-japero.fjeclot.net',
            'username' => "cn=admin,dc=fjeclot,dc=net",
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];
        
        $ldap = new Ldap($opcions);
        $dn = 'cn=' . $_POST['adm'] . ',dc=fjeclot,dc=net';
        $ctsnya = $_POST['cts'];
        
        try {
            $ldap->bind($dn, $ctsnya);
            $_SESSION['logged_in'] = true; // Establecer la sesión como iniciada
            $_SESSION['username'] = $_POST['adm']; // Guardar el nombre de usuario en la sesión
            header("location: menu.php");
            exit(); // Terminar el script después de redirigir
        } catch (Exception $e) {
            echo "<b>Contrasenya incorrecta</b><br><br>";
        }
    }
}

?>
<html>
<head>
    <title>AUTENTICACIÓ AMB LDAP</title>
</head>
<body>
    <a href="https://zend-japero.fjeclot.net/autent/index.php">Torna a la pàgina inicial</a>
</body>
</html>
