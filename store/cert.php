<?php
require_once '../DB/Clerk.php';

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Avtorizacija na podlagi polj certifikata X.509</title>
    </head>
    <body>
        <?php
        //$authorized_users = ["Clerk John", "Admin Steve", "Clerk Bob"];
        
        $authorized_users = array();
        $certs = Clerk::getCertificates();
        foreach ($certs as $key => $value):
            array_push($authorized_users, $value["cert"]);
        endforeach;
        array_push($authorized_users, "Admin Steve");

        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        if ($client_cert == null) {
            die('ERROR: Certificate not set');
        }

        $cert_data = openssl_x509_parse($client_cert);
        $commonname = (is_array($cert_data['subject']['CN']) ?
                        $cert_data['subject']['CN'][0] : $cert_data['subject']['CN']);
        if (in_array($commonname, $authorized_users)) {
            header("Location: reg_store.php");
        } else {
            echo "You are NOT authorized!";
        }
        ?>
    </body>
</html>