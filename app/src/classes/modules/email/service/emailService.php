<?php

namespace app\src\classes\modules\email\service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class emailService
{
    /**
     * @var PHPMailer
     */
    private $mail;
    public $assunto = '';
    public $conteudo = '';
    public $copia = [];
    public $anexos = [];

    /**
     * emailService constructor.
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Port = 587;
        $this->mail->Mailer = 'smtp';
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAutoTLS = true;
        $this->mail->AuthType = 'PLAIN';
        $this->mail->Host = "mail.sicoficial.com.br";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "sicnotificacao@sicoficial.com.br";
        $this->mail->Password = '!Dlfs02**';
        $this->mail->CharSet = 'UTF-8';
        $this->mail->SMTPDebug = 0;

        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    /**
     * addEmbeddedImage()
     * @param $arquivo
     * @param $siglaimagem
     * @throws Exception
     */
    public function AddEmbeddedImage($arquivo, $siglaimagem)
    {

        $file = __DIR__ . "/../../../../../../view/pages/assets/img/{$arquivo}";

        if (file_exists($file)) {
            $this->mail->AddEmbeddedImage($file, $siglaimagem);
        }
    }

    /**
     * addCopy()
     * @param array $emails
     * @throws Exception
     */
    public function addCopy($emails = [])
    {
        if (count($emails) > 0) {
            foreach ($emails as $email) {
                $this->mail->addCC($email);
            }
        }
    }

    /**
     * addCopyHidden()
     * @param array $emails
     * @throws Exception
     */
    public function addCopyHidden($emails = [])
    {
        if (count($emails) > 0) {
            foreach ($emails as $email) {
                $this->mail->addBCC($email);
            }
        }
    }

    /**
     * @return string
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param string $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    /**
     * @return string
     */
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * @param string $conteudo
     */
    public function setConteudo($conteudo)
    {
        $this->conteudo = $conteudo;
    }

    /**
     * @return array
     */
    public function getCopia()
    {
        return $this->copia;
    }

    /**
     * @param array $copia
     */
    public function setCopia($copia)
    {
        $this->copia = $copia;
    }

    /**
     * @return array
     */
    public function getAnexos()
    {
        return $this->anexos;
    }

    /**
     * @param array $anexos
     */
    public function setAnexos($anexos)
    {
        $this->anexos = $anexos;
    }

    /**
     * enviarEmail()
     * @param $email
     * @param $nome
     * @return bool
     * @throws Exception
     */
    public function enviarEmail($email, $nome)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->mail->setFrom('sicnotificacao@sicoficial.com.br', 'SIC');
            $this->mail->addAddress($email, $nome);

            if (count($this->getCopia()) > 0) {
                foreach ($this->getCopia() as $copiaemail) {
                    $this->mail->addCC($copiaemail);
                }
            }

            if (count($this->getAnexos()) > 0) {
                foreach ($this->getAnexos() as $anexo) {
                    $this->mail->addAttachment($anexo);
                }
            }

            $this->mail->IsHTML(true);
            $this->mail->Subject = $this->getAssunto();
            $this->mail->Body = $this->getConteudo();

            $this->mail->send();

            return true;
        }

        return false;
    }
}