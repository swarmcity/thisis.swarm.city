<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $email = filter_var(trim($_POST["requestEmailAddress"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["voucherHandle"]);

        // Check that data was sent to the mailer.
        if ( empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "swarmcitycomm@gmail.com";
        // $recipient = "barbeegomes@gmail.com";

        // Set the email subject.
        $subject = "Swarm City Slack Invite Request";

        // Build the email content.
        $email_content .= "Requester Email: $email\n\n";
        $email_content .= "Voucher Handle: $message\n";

        // Build the email headers.
        $email_headers = "From: $email";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Your request has been sent. Someone will be in touch shortly.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your request. Please try again.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>