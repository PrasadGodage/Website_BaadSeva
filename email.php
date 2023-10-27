<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "soulsoft.gauravvanam@gmail.com";
        
        # Sender Data
        // $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            // echo "Please complete the form and try again.";
            exit;
        }
        
        # Mail Content
        $content = "Name: $name\n";
        $content .= "Email: $email\n";
        $content .= "Subject: $subject\n";
        $content .= "Message: $message\n";
        $subject = "Baad International Services PVT.LTD. New Enquirey added" ;
        # email headers.
        $headers = $content;

        # Send the email.
        $success = mail($mail_to, $subject, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            json_decode("Thank You! Your message has been sent.");
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
			json_decode("Oops! Something went wrong, we couldn't send your message.");
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
		json_decode("There was a problem with your submission, please try again.");
    }