<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("location: login.php");
    exit(); 
}
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;
ini_set('display_errors',0);
if ($_GET['usr'] && $_GET['ou']){
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-japero.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    $ldap = new Ldap($opcions);
    $ldap->bind();
    $entrada='uid='.$_GET['usr'].',ou='.$_GET['ou'].',dc=fjeclot,dc=net';
    $usuari=$ldap->getEntry($entrada);
    echo "<b><u>".$usuari["dn"]."</b></u><br>";
    foreach ($usuari as $atribut => $dada) {
        if ($atribut != "dn") echo $atribut.": ".$dada[0].'<br>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>
MOSTRANT DADES D'USUARIS DE LA BASE DE DADES LDAP
</title>
</head>
<body>
<h2>Formulari de selecció d'usuari</h2>
<form action="https://zend-japero.fjeclot.net/zendldap" method="GET">
Unitat organitzativa: <input type="text" name="ou"><br>
Usuari: <input type="text" name="usr"><br>
<input type="submit"/>
<input type="reset"/>
</form>
</body>
    <form action="menu.php" method="GET">
        <input type="submit" value="Tornar al menu principal">
    </form>
</html>