<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    <?php 

    if (isset($setHomeCanonical) && !empty($setHomeCanonical)){echo $setHomeCanonical;} 

    if ($_SERVER["PHP_SELF"] == '/index.php' || $_SERVER["PHP_SELF"] == '/index_new.php')
    {
        echo '<link rel="stylesheet" href="/css/style.css" type="text/css">';
    }
    else if (stripos($_SERVER['REQUEST_URI'],'/contact/')!==false)
    {
        echo '<link rel="stylesheet" href="/css/form.css" type="text/css">';
    }
    else if (stripos($_SERVER['REQUEST_URI'],'/thankyou/')!==false)
    {
        echo '<link rel="stylesheet" href="/css/thanks.css" type="text/css">';
    }

    if (isset($ogMetaData) && !empty($ogMetaData)){echo $ogMetaData;}

    ?>
    
</head>
<body>
    <header class="header">
        <a href="/">
            <img src="/assets/Logo.png" alt="<?= $siteName ?>" class="header-logo">
        </a>
        <div class="contact-button-block">
            <a href="/contact/" class="header-button cpointer">
                <p class="header-contact">Contact us</p>
                <img src="/assets/play-solid-with-gradient.svg" class="contact-img">
            </a>
        </div>
    </header>