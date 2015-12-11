<?php
/**
 * Created by PhpStorm.
 * User: enovichkov
 * Date: 26.05.2015
 * Time: 10:10
 */
class tools_class
{
    /**
     * @param string $subject
     * @param string $message
     * @param string $to
     * @param string $from
     * @param string string $name
     * @return bool
     * @throws Exception
     * @throws phpmailerException
     */

    public static function mail($subject, $message, $to, $from = 'info@qcop.ru', $name = 'Client')
    {
        require_once ROOT_DIR . 'libs' . DS .'phpmailer/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->SetFrom($from, 'qcop.ru');
        $mail->AddAddress($to, $name);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        return $mail->Send();
    }

    public static function formatTime($seconds)
    {
        $sec = $seconds % 60;
        $sec = $sec < 10 ? '0' . $sec : $sec;
        $seconds = floor($seconds / 60);
        $min = $seconds % 60;
        $min = $min < 10 ? '0' . $min : $min;
        $hours = floor($seconds / 60);
        $hours = $hours < 10 ? '0' . $hours : $hours;
        return $hours . ':' . $min . ':' . $sec;
    }
}