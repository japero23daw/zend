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
ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['uid']) && isset($_POST['ou'])) {
        $uid = $_POST['uid'];
        $ou = $_POST['ou'];
        $dn = 'uid='.$uid.',ou='.$ou.',dc=fjeclot,dc=net';
        
        $opcions = [
            'host' => 'zend-japero.fjeclot.net',
            'username' => 'cn=admin,dc=fjeclot,dc=net',
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];
        
        $ldap = new Ldap($opcions);
        $ldap->bind();
        
        try {
            $ldap->delete($dn);
            echo "<b>Entrada esborrada</b><br>";
        } catch (Exception $e) {
            echo "<b>Aquesta entrada no existeix o ha ocorregut un error</b><br>";
        }
    }
}
?>

<html>
<head>
    <title>Esborrament d'usuari LDAP</title>
</head>
<body>
    <h2>Formulari d'esborrament d'usuari</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        UID: <input type="text" name="uid"><br>
        Unitat organitzativa: <input type="text" name="ou"><br>
        <input type="submit" value="Esborra usuari"/>
        <input type="reset"/>
    </form>
    <form action="menu.php" method="GET">
        <input type="submit" value="Tornar al menu principal">
    </form>
</body>
</html>
