<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    
    //chargement de la librairie  email de code ignitor
    
    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.orange.fr';
    $config['smtp_user'] = 'julien.fouksmann@orange.fr';
    $config['smtp_crypto']  = 'ssl';
    $config['smtp_pass'] = 'Bidou@210';
    $config['smtp_port'] = 465;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $email_to = "julien.fouksmann.mac@gmail.com";
        
        # Sender Data
        $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email_from = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email_from, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Merci de compléter le formulaire et de renvoyer votre message.";
            exit;
        }
        
        # Mail Content
        $this->email->from($email_from, 'Identification');
        $this->email->to($email_to);
        $this->email->subject('Subject:'. $subject);
        $this->email->message('Message: ' . $message);

        
        //$content = "New Messgae From Name: $name\n";
        //$content .= "Email: $email\n\n";
        //$content .= "Subject: $subject\n\n";
        //$content .= "Message:\n$message\n";

        
        # Send the email.
        //Send mail
        if($this->email->send())
        {
            //$this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
            http_response_code(200);
            echo "Merci! Votre message a bien été envoyé.";
        }
        else
        {
            //$this->session->set_flashdata("email_sent","You have encountered an error");
            http_response_code(500);
            echo "Oops! Something went wrong, we couldn't send your message.";
            echo $this->email->print_debugger();
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Il y a eu un problème lors de l'envoi du mail, merci de réessayer.";
    }

?>
