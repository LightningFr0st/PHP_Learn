<?php

header('Content-Type: text/html; charset=ISO-8859-1');

require_once('SafeFormBuilder.php');
require_once('CryptoManager.php');

$template_generator = new SafeFormBuilder(file_get_contents('template.html'),"POST", "_self");
$template_generator->addTextField("crypt", "Default text");
$template_generator->render();

$cipher = new CryptoManager("aes-256-ctr",hex2bin('000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f'));

if (isset($_POST['crypt'])) {
    $message = $_POST['crypt'];
    $encrypted = $cipher->encrypt($message);
    $decrypted = $cipher->decrypt($encrypted);
    echo "<h2>Plaintext: ".$message."</h2>";
    echo "<h2>Ecnrypted: ".htmlspecialchars($encrypted)."</h2>";
    echo "<h2>Decrypted: ".$decrypted."</h2>";
}
