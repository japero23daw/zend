<!DOCTYPE html>
<html>
<head>
    <title>Afegir usuari LDAP</title>
</head>
<body>
    <h2>Formulari d'afegiment d'usuari</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label>Unitat organitzativa:</label>
        <input type="text" name="ou"><br>
        <label>uid:</label>
        <input type="text" name="uid"><br>
        <label>uidNumber:</label>
        <input type="text" name="uidNumber"><br>
        <label>gidNumber:</label>
        <input type="text" name="gidNumber"><br>
        <label>Directori personal:</label>
        <input type="text" name="homeDirectory"><br>
        <label>Shell:</label>
        <input type="text" name="loginShell"><br>
        <label>cn:</label>
        <input type="text" name="cn"><br>
        <label>sn:</label>
        <input type="text" name="sn"><br>
        <label>givenName:</label>
        <input type="text" name="givenName"><br>
        <label>PostalAddress:</label>
        <input type="text" name="postalAddress"><br>
        <label>Mobile:</label>
        <input type="text" name="mobile"><br>
        <label>TelephoneNumber:</label>
        <input type="text" name="telephoneNumber"><br>
        <label>Title:</label>
        <input type="text" name="title"><br>
        <label>Description:</label>
        <input type="text" name="description"><br>
        <input type="submit" value="Afegir usuari">
    </form>
    <form action="menu.php" method="GET">
        <input type="submit" value="Tornar al menu principal">
    </form>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("location: login.php");
    exit(); 
}
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ou = $_POST['ou'];
    $uid = $_POST['uid'];
    $uidNumber = $_POST['uidNumber'];
    $gidNumber = $_POST['gidNumber'];
    $homeDirectory = $_POST['homeDirectory'];
    $loginShell = $_POST['loginShell'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $givenName = $_POST['givenName'];
    $postalAddress = $_POST['postalAddress'];
    $mobile = $_POST['mobile'];
    $telephoneNumber = $_POST['telephoneNumber'];
    $title = $_POST['title'];
    $description = $_POST['description'];

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
    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', ['inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top']);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $uidNumber);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $gidNumber);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $homeDirectory);
    Attribute::setAttribute($nova_entrada, 'loginShell', $loginShell);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $givenName);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $postalAddress);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobile);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telephoneNumber);
    Attribute::setAttribute($nova_entrada, 'title', $title);
    Attribute::setAttribute($nova_entrada, 'description', $description);

    $dn = 'uid=' . $uid . ',ou=' . $ou . ',dc=fjeclot,dc=net';

    if ($ldap->add($dn, $nova_entrada)) {
        echo "Usuari creat";
    } else {
        echo "Error en la creació de l'usuari";
    }
}
?>
