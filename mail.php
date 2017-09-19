<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php $action = filter_input(INPUT_POST, 'action') ?>
        <?php if ( isset( $action ) ) : ?>
            <?php
            require 'includes/clases/PHPMailerAutoload.php';
            
            $to = filter_input(INPUT_POST, 'to');
            $from = filter_input(INPUT_POST, 'from');
            $host = filter_input(INPUT_POST, 'host');
            $username = filter_input(INPUT_POST, 'username');
            $password = filter_input(INPUT_POST, 'password');
            $subject = filter_input(INPUT_POST, 'subject');
            $message = filter_input(INPUT_POST, 'message');
            
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            //$mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = $host;
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = 25;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = $username;
            //Password to use for SMTP authentication
            $mail->Password = $password;
            //Set who the message is to be sent from
            $mail->setFrom($from, 'First Last');
            //Set an alternative reply-to address
            //$mail->addReplyTo('replyto@example.com', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress($to, 'John Doe');
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->Body = $message;
            //Replace the plain text body with one created manually
            //$mail->AltBody = $message;
            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');
            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }
            
            /*$to = filter_input(INPUT_POST, 'to');
            $from = filter_input(INPUT_POST, 'from');
            $subject = filter_input(INPUT_POST, 'subject');
            $message = filter_input(INPUT_POST, 'message');
                
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: SEMM - Recursos Humanos <' + $from + '>';
            
            $result = mail($to, $subject, $message, $headers);
            echo $result*/
            ?>
        
        <?php else : ?>
        <form method="post">
            <p>
                <input type="text" name="to" placeholder="to" />
            </p>
            <p>
                <input type="text" name="from" placeholder="from" />
            </p>
            <p>
                <input type="text" name="host" placeholder="host" />
            </p>
            <p>
                <input type="text" name="username" placeholder="username" />
            </p>
            <p>
                <input type="text" name="password" placeholder="password" />
            </p>
            <p>
                <input type="text" name="subject" placeholder="subject" />
            </p>
            <p>
                <textarea name="message" rows="10" cols="30">message</textarea>
            </p>
            <p>
                <input type="submit" name="action" />
            </p>
        </form>
        <?php endif; ?>
    </body>
</html>
