<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {
    
    const USERNAME = "luankussner15@gmail.com";
    const PASSWORD = "<?password?>";
    const NAME_FROM = "Hcode Store";

    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false
        );

        Tpl::configure( $config );

        $tpl = new Tpl;

        foreach ($data as $key => $value) {
            $tpl->assing($key, $value);
        }

        $html = $tpl->draw($tplName, true);

        $this->mail = new \PHPMailer;

        $this->mail->isSMTP();

        $this->mail->Debugoutput = 'html';

        $this->mail->Host = 'smtp.gmail.com';

        $this->mail->Port = 587;

        $this->mail->SMTPSecure = 'tls';

        $this->mail->SMTPAuth = true;

        $this->mail->Username = Mailer::USERNAME;

        $this->mail->Password = Mailer::PASSWORD;

        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

        $this->mail->addAdress($toAddress, $toName);

        $this->Subject = $subject;

        $this->mail->msgHTML($html);
        
        $this->mail->AltBory = 'This is a plain-text message bory';
    }

    public function send()
    {
        return $this->mail->send();
    }

}