<?php

function notifyByEmail($to, $subject,$name,$title, $link) {

    $from = "nacer.cheniki@gmail.com"; // TODO: normalement à récupérer à partir d'un fichier de config 

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = "To: $to";
    $headers[] = "From: $from";
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    
    $template_vars = array("name"=> $name, 'title' => $title,'link' => $link,  );

    $message = get_template("templates/email.html",$template_vars);

    return mail($to, $subject, $message, implode("\r\n", $headers));
}

function get_template($templateName, $variables) {
    $dir =  dirname(__FILE__);
    $template = file_get_contents($dir .'/'. $templateName);

    foreach($variables as $key => $value)
    {
        $template = str_replace('{{ '.$key.' }}', $value, $template);
    }
    return $template;
}

//notifyByEmail("nacer.cheniki@gmail.com","nouvelle prod","cherchuer X","LODS paper","google.com");
