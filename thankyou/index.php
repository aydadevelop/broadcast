<?php

ob_start("ob_gzhandler");
$rootPath = '../';
require_once $rootPath.'inc/config.php';

$pageTitle = $siteName.' - Thank You';

require_once $rootPath.'_header.php';

?>
    <div class="title-for-form">
        <h1 class="form-title">Get in touch.</h1>
        <p class="title-p">Let’s start a conversation.</p>
    </div>
    <div class="info">
        <div class="info-text">
            <h2 class="info-title">Thank you for your inquiry.</h2>
            <p class="info-text">We'll be in touch within 48 hours.</p>
        </div>
        <img src="/assets/interactive-platform-final-03-1.png" class="info-img" alt="">

    </div>

<?php

require_once $rootPath.'_footer.php';

?>