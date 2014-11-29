<?php
/**
 * @file
 * Contains \BtDeploy\BtMailer.
 */

namespace BtDeploy;

use PHPMailer;

class BtMailer
{
    protected $mailer;

    public function __construct($config = [])
    {
        $this->mailer = new PHPMailer;
        $config = BtDeploy::fromConfig($config, BtDeploy::parseConfig(['defaults', 'mailer']));
        $this->handleMailerConfig($config);
    }

    private function handleMailerConfig($config)
    {
        // Set mailer to use SMTP.
        $this->mailer->isSMTP();
        // Specify main and backup SMTP servers.
        $this->mailer->Host = $config['host'];
        // Enable SMTP authentication.
        $this->mailer->SMTPAuth = $config['smtpAuth'];
        $this->mailer->Username = $config['username'];
        $this->mailer->Password = $config['password'];
        // Enable TLS encryption, `ssl` also accepted.
        $this->mailer->SMTPSecure = $config['smtpSecure'];
        $this->mailer->Port = $config['port'];
        $this->mailer->From = $config['from'];
        $this->mailer->FromName = $config['fromName'];

        $to_addresses = array_key_exists('to', $config) ? $config['to'] : [];
        if (!empty($to_addresses)) {
            $addresses = explode(',', $to_addresses);
            foreach ($addresses as $address) {
                $this->mailer->addAddress($address);
            }
        }
    }

    public function mail($body, $subject = 'dev.drupal deploy', $is_html = true)
    {
        $this->mailer->Subject = $subject;
        $this->mailer->isHTML($is_html);

        if ($is_html) {
            $body = nl2br($body);
        }
        $this->mailer->Body = $body;

        if (!$this->mailer->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
}
