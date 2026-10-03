<?php
    $to      = 'bhupati.jagi@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: bhupati.jagi@gmail.com'       . "\r\n" .
                 'Reply-To: bhupati.jagi@gmail.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)) {
        echo "Mail send";
    } else {
        echo "Error";
    }
?>