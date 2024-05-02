<!DOCTYPE html>
<html>
<head>
    <title>Modificació d'atributs d'un usuari LDAP</title>
</head>
<body>
    <h2>Formulari de modificació d'atributs d'un usuari</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label>Unitat organitzativa:</label>
        <input type="text" name="ou"><br>
        <label>uid:</label>
        <input type="text" name="uid"><br>
        <p>Selecciona l'atribut a modificar:</p>
        <input type="radio" name="atribut" value="uidNumber">uidNumber<br>
        <input type="radio" name="atribut" value="gidNumber">gidNumber<br>
        <input type="radio" name="atribut" value="homeDirectory">Directori personal<br>
        <input type="radio" name="atribut" value="loginShell">Shell<br>
        <input type="radio" name="atribut" value="cn">cn<br>
        <input type="radio" name="atribut" value="sn">sn<br>
        <input type="radio" name="atribut" value="givenName">givenName<br>
        <input type="radio" name="atribut" value="postalAddress">PostalAddress<br>
        <input type="radio" name="atribut" value="mobile">mobile<br>
        <input type="radio" name="atribut" value="telephoneNumber">telephoneNumber<br>
        <input type="radio" name="atribut" value="title">title<br>
        <input type="radio" name="atribut" value="description">description<br><br>
        <label>Nou valor:</label>
        <input type="text" name="nou_valor"><br>
        <input type="submit" value="Modificar atribut">
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
    $atribut = $_POST['atribut'];
    $nou_valor = $_POST['nou_valor'];

    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-japero.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];

    $dn = 'uid=' . $uid . ',ou=' . $ou . ',dc=fjeclot,dc=net';

    $ldap = new Ldap($opcions);
    $ldap->bind();
    $entrada = $ldap->getEntry($dn);

    if ($entrada) {
        Attribute::setAttribute($entrada, $atribut, $nou_valor);
        $ldap->update($dn, $entrada);
        echo "Atribut modificat";
    } else {
        echo "Aquesta entrada no existeix";
    }
}
?>
