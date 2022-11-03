<?php

function sendSendGridEmail($emailformat,$fromemail,$toemail,$bcc,$emailsubject,$emailcontent,$category,$replyemail=''){
    return sendSGEmail($emailformat, $toemail,'',$bcc,$emailsubject,$emailcontent,'', '', $fromemail, '', $replyemail, $category, COUPLE_SG_API);
}

function sendSGEmail($format, $to,$cc,$bcc,$subject,$content, $html_content, $plain_content, $from, $from_name, $reply_to, $categories, $key)
{
    require_once '/usr/local/bin/vendor/autoload.php';
    $email = new \SendGrid\Mail\Mail();

    $from = trim($from);
    $reply_to = trim($reply_to);

    // if($from=='support@team.couple.com')
    // {
    //     $from_name = 'Couple Support';
    // }
    // else if($from=='host@team.couple.com')
    // {
    //     $from_name = 'Couple Host';
    // }

    if ($from_name) {
        $email->setFrom($from, $from_name);
    } else {
        $email->setFrom($from);
    }
    $email->setSubject($subject);

    // convert recipients to arrays if not already
    if (!is_array($to)) {
        $to= explode(",", $to);
    }
    // trim and lowercase all emails
    $to = array_map('trim', $to);
    $to = array_map('strtolower', $to);

    if (!is_array($cc)) {
        $cc = explode(",", $cc);
    }
    $cc = array_map('trim', $cc);
    $cc = array_map('strtolower', $cc);

    if (!is_array($bcc)) {
        $bcc = explode(",", $bcc);
    }
    $bcc = array_map('trim', $bcc);
    $bcc = array_map('strtolower', $bcc);

    // remove any emails in multiple fields
    $cc = array_diff($cc, $to);
    $bcc = array_diff($bcc, $to, $cc);

    foreach ($bcc as $bcc_email) {
        if (filter_var($bcc_email, FILTER_VALIDATE_EMAIL)) {
            $email->addBcc($bcc_email);
        }
    }
    foreach ($cc as $cc_email) {
        if (filter_var($cc_email, FILTER_VALIDATE_EMAIL)) {
            $email->addCc($cc_email);
        }
    }
    $has_valid_to = false;
    foreach ($to as $to_email) {
        if (filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
            $email->addTo($to_email);
            $has_valid_to = true;
        }
    }

    if (!$has_valid_to) {
        return 0;
    }
    
    if ($format == 'html') {
        $html_content = $content;
    } elseif ($format == 'text') {
        $plain_content = $content;
    }

    if ($html_content) {
        $email->addContent('text/html',$html_content);
    }
    if ($plain_content) {
        $email->addContent('text/plain', $plain_content);
    }
    if ($reply_to && filter_var($reply_to, FILTER_VALIDATE_EMAIL)) {
        $email->setReplyTo($reply_to);
    }

    if (!is_array($categories)) {
        $categories = explode(",", $categories);
    }

    foreach (array_unique($categories) as $category) {
        $email->addCategory(trim($category));
    }
    $sendgrid = new \SendGrid($key);
    try {
        $response = $sendgrid->send($email);
        if ($response->statusCode() != 202) {
            ob_start();
            var_dump($response);
            var_dump($_SERVER);
            sendEmail('Failed SG v3 email', ob_get_clean(), ERROR_ALERT_EMAIL);
            return 0;
        } else {
            return 1;
        }
    } catch (Exception $e) {
        return 0;
    }
}


?>