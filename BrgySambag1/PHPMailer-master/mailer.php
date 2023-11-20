<?php
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server hostname for gmail
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'barangaysambag01@gmail.com';
    $mail->Password = 'wiis kfss oqay ldxf'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 587; // SMTP port (usually 587 for TLS)
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
    );
    $mail->setFrom('barangaysambag01@gmail.com', 'Sambag1');
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'RESET PASSWORD (do not share)';
?>