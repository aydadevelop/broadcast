<?php

require_once '/etc/config_couple.php';
$rootPath = '../';
require_once $rootPath.'inc/config.php';
require_once $rootPath.'inc/email.php';

$redirectThanks = '/thankyou/';
$redirectError = '/contact/';
$sendAlert = false;

date_default_timezone_set('UTC');
$todayDate = date('Y-m-d H:i:s');

$contactFormVal = (isset($_POST[CONTACTFORM_ID]) ) ? trim($_POST[CONTACTFORM_ID]) : '';
if (empty($contactFormVal))
{
    header('Location: '.$redirectThanks);
    exit();
}
else if ($contactFormVal != CONTACTFORM_VAL)
{
    header('Location: '.$redirectThanks);
    exit();
}

$checkDate = date('Y-m-d H:i:s',strtotime($todayDateCheck. '-1 day'));
$ipList = ['85.208.115.246','5.227.27.149','191.102.181.207','178.68.119.51','84.17.43.36','182.16.184.67','201.47.2.246','194.36.96.30','144.48.49.67','188.126.89.116','94.158.36.183','196.16.74.206','14.179.177.59','196.196.246.25','194.36.97.209','138.199.36.200', '191.101.217.114', '90.179.7.202', '37.139.53.81'];

$emailList = ['ericjonesmyemail@gmail.com','no-replywaxia@gmail.com', 'atoncetry@gmail.com', 'faulding.clinton@googlemail.com'];

if (!empty($VISITORIP) && in_array($VISITORIP, $ipList))
{
    header('Location: '.$redirectThanks);
    exit();
}

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

if (in_array($email, $emailList))
{
    header('Location: '.$redirectThanks);
    exit();
}
else if (strpos($website, 'boostlead') !== false || strpos($company, 'boostlead') !== false || strpos($website, 'hojagoak.com') !== false)
{
    header('Location: '.$redirectThanks);
    exit();
}

if (!validUrl($website))
{
    $sendAlert = true;
}

$error = '';

if (strlen($info) > 1000)
{
    $info = substr($info, 0, 1000);
}

$chkData = checkSubmit($dbConn);

if (!empty($chkData))
{
    // search $chkData for email and IP combo submitted within past day - if found, redirect to Thanks
    $gotEmail = array_filter($chkData, function($element) use($email, $VISITORIP, $checkDate){
                        return (isset($element['email']) && $element['email'] == $email) 
                                && (isset($element['ip']) && $element['ip'] == $VISITORIP) 
                                &&  (isset($element['dateAdded']) && $element['dateAdded'] >= $checkDate);
                    });

    if (count($gotEmail) > 0)
    {
        // user already submitted recently - send alert email and redirect
        $sendAlert = true;
    }
}

if ($sendAlert)
{
    $alertTo = 'tpanovec@corp.lawyer.com';
    $emailSubj = 'Interactive Platforms - Contact Abuse';

    $comment = "*Internal System Message Notice*\n\n";
    $comment .= "$emailSubj";
    $comment .= "\n\nName: $fname $lname";
    $comment .= "\n\nEmail: $email";
    $comment .= "\n\nJob: $job";
    $comment .= "\n\nCo.: $company";
    $comment .= "\n\nWebsite: $website";
    $comment .= "\n\nPhone: $phone";
    $comment .= "\n\nInfo: $info";
    $comment .= "\n\nIP: $VISITORIP";
    
    sendSendGridEmail('html', $supportEmail, $alertTo, '', $emailSubj, nl2br($comment), 'Support Notification Email Internal');

    header('Location: '.$redirectThanks);
    exit();
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
    $comment .= "\n\nIP: $VISITORIP";
    
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

// --- functions --- 

function validUrl($url)
{
    return preg_match('/^http:\/\/|(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/', $url);
}

function checkSubmit($dbConn)
{
    try
    {
        $data = [];
        $sql="SELECT iapCt_email as email, iapCt_dateAdded as dateAdded, iapCt_ip as ip 
        FROM interactPltf_contact 
        GROUP BY iapCt_email, iapCt_ip";
        $stmt = $dbConn->prepare($sql); 
        $stmt->execute();
        $result = $stmt->get_result();
        $num_rows = mysqli_num_rows($result);
        $stmt->close();

        if ($num_rows > 0)
        {
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
        }
    }
    catch(Exception $e)
    {
        $error = 'Error: interactive platforms contact lookup: ' . $e->getMessage();
        logError('', $_SERVER['REQUEST_URI'], $_SERVER["REMOTE_ADDR"], $error, $dbConn);
    }

    return $data;
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