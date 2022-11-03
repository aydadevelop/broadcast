<?php

require_once '/etc/config_couple.php';
$rootPath = '../';
require_once $rootPath.'inc/config.php';
require_once $rootPath.'inc/email.php';

$redirectThanks = '/thankyou/';
$redirectError = '/contact/';

date_default_timezone_set('UTC');
$todayDate = date('Y-m-d H:i:s');

$fname = (isset($_POST['fname']) ) ? trim($_POST['fname']) : '';
$lname = (isset($_POST['lname']) ) ? trim($_POST['lname']) : '';
$email = (isset($_POST['email']) ) ? trim($_POST['email']) : '';
$job = (isset($_POST['job']) ) ? trim($_POST['job']) : '';
$company = (isset($_POST['company']) ) ? trim($_POST['company']) : '';
$website = (isset($_POST['website']) ) ? trim($_POST['website']) : '';
$phone = (isset($_POST['phone']) ) ? trim($_POST['phone']) : '';
$info = (isset($_POST['help']) ) ? trim($_POST['help']) : '';

$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);

$email = strtolower($email);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$email = '';
}

$job = htmlspecialchars($job);
$company = htmlspecialchars($company);
$website = strip_tags($website);
$website = htmlspecialchars($website);
$phone = preg_replace('/\D/', '', $phone);
$info = htmlspecialchars($info);

if (empty($fname) || empty($lname) || empty($email) || empty($job) || empty($company) || empty($website) || empty($phone) || empty($info))
{
	header('Location: '.$redirectError);
    exit();
}

$error = '';

if (strlen($info) > 1000)
{
    $info = substr($info, 0, 1000);
}

try
{
	$stmtAdd = $dbConn->prepare("INSERT INTO interactPltf_contact (iapCt_fname, iapCt_lname, iapCt_email, iapCt_job, iapCt_co, iapCt_website, iapCt_phone, iapCt_info, iapCt_dateAdded, iapCt_ip) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmtAdd->bind_param("ssssssssss", $fname, $lname, $email, $job, $company, $website, $phone, $info, $todayDate, $VISITORIP);
	$stmtAdd->execute();
	$stmtAdd->close();

	$alertTo = 'mlipson@interactiveplatforms.com';
	$emailSubj = 'Interactive Platforms - Contact Us';

	$comment = "*Internal System Message Notice*\n\n";
    $comment .= "$emailSubj";
    $comment .= "\n\nName: $fname $lname";
    $comment .= "\n\nEmail: $email";
    $comment .= "\n\nJob: $job";
    $comment .= "\n\nCo.: $company";
    $comment .= "\n\nWebsite: $website";
    $comment .= "\n\nPhone: $phone";
    $comment .= "\n\nInfo: $info";
    
    sendSendGridEmail('html', $supportEmail, $alertTo, 'tpanovec@corp.lawyer.com', $emailSubj, nl2br($comment), 'Support Notification Email Internal');
}
catch(Exception $e)
{
    $error = 'Error: interactive platforms contact - ' . $e->getMessage();
    echo "Sorry we're unable to process your request at this time.";
    logError($email, $PATH_INFO, $VISITORIP, $error, $todayDate, $dbConn);
}

if (empty($error))
{
	header('Location: '.$redirectThanks);
	exit();
}

function logError($userInfo, $pageUrl, $userIP, $errorMsg, $todayDate, $dbConn)
{
    try
    {
        $stmtAdd = $dbConn->prepare("INSERT INTO couple_error_log (cplErl_date, cplErl_userInfo, cplErl_pageUrl, cplErl_userIP, cplErl_errorMsg) 
        VALUES (?, ?, ?, ?, ?)");
        $stmtAdd->bind_param("sssss", $todayDate, $userInfo, $pageUrl, $userIP, $errorMsg);
        $stmtAdd->execute();
        $stmtAdd->close();
    }
    catch (Exception $e) 
    {
        $error = 'Error: processing... ';
    }
}

?>