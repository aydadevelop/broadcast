<?php

ob_start("ob_gzhandler");
$rootPath = '../';
require_once $rootPath.'inc/config.php';

$pageTitle = $siteName.' - Contact Us';

$ogMetaUrl = $secureURL.'/contact/';
require_once $rootPath.'_ogMetaData.php';
require_once $rootPath.'_header.php';

?>

    <div class="title-for-form">
        <h1 class="form-title">Get in touch.</h1>
        <p class="title-p">Let’s start a conversation.</p>
    </div>
    <form class="form" action="_proc_Contact.php" method="POST" onsubmit="return onSubmitForm(event)">
        <div class="form-left-block">
            <div class="user-information">
                <div class="user-name">
                    <div class="first-name">
                        <label id="fnameLabel" for="fname" class="label-font-style">First name*</label>
                        <input type="text" class="input-left border-style" id="fname" name="fname" maxlength="45">
                    </div>
                    <div class="break"></div>
                    <div class="last-name">
                        <label id="lnameLabel" for="lname" class="label-font-style ">Last name*</label>
                        <input type="text" class="input-left border-style" id="lname" name="lname" maxlength="45">
                    </div>
                </div>
                <div class="user-info flex-about-info">
                    <label id="emailLabel" for="email" class="label-font-style">Business email*</label>
                    <input type="email" class="input-left  border-style" id="email" name="email" maxlength="75">
                </div>
                <div class="user-info flex-about-info">
                    <label id="jobLabel" for="job" class="label-font-style">Job title*</label>
                    <input type="text" class="input-left border-style" id="job" name="job" maxlength="45">
                </div>
                <div class="user-info flex-about-info">
                    <label id="companyLabel" for="company" class="label-font-style">Company*</label>
                    <input type="text" class="input-left border-style" id="company" name="company" maxlength="45">
                </div>
                <div class="user-info flex-about-info">
                    <label id="websiteLabel" for="website" class="label-font-style">Company website*</label>
                    <input type="url" class="input-left border-style" id="website" name="website" maxlength="75">
                </div>
                <div class="user-info flex-about-info">
                    <label id="phoneLabel" for="phone" class="label-font-style">Phone*</label>
                    <input type="number" class="input-left border-style" id="phone" name="phone" maxlength="25">
                </div>
            </div>
        </div>
        <div class="form-right-block">
            <p id="helpLabel" class="label-font-style">How can we help*</p>
            <textarea id="help" name="help" rows="10" class="form-textarea textarea-style border-style" maxlength="1000"></textarea>
            <button class="form-button cpointer">Submit</button>
        </div>
        <input type="hidden" name="<?= CONTACTFORM_ID ?>" value="<?= CONTACTFORM_VAL ?>">
    </form>

<script>
    function onSubmitForm()
    {
        const fnameLabel = document.getElementById('fnameLabel');
        const fname = document.getElementById('fname');
        const isValidFname = fname.value.length > 0;
        if (isValidFname) {
            fnameLabel.className = 'label-font-style';
            fname.className = 'input-left border-style';
        }
        else {
            fnameLabel.className = 'label-font-style color-red';
            fname.className = 'input-left border-style-invalid';
        }
        const lnameLabel = document.getElementById('lnameLabel');
        const lname = document.getElementById('lname');
        const isValidLname = lname.value.length > 0;
        if (isValidLname) {
            lnameLabel.className = 'label-font-style';
            lname.className = 'input-left border-style';
        }
        else {
            lnameLabel.className = 'label-font-style color-red';
            lname.className = 'input-left border-style-invalid';
        }
        const emailLabel = document.getElementById('emailLabel');
        const email = document.getElementById('email');
        const isValidEmail = email.value.length > 0;
        if (isValidEmail) {
            emailLabel.className = 'label-font-style';
            email.className = 'input-left border-style';
        }
        else {
            emailLabel.className = 'label-font-style color-red';
            email.className = 'input-left border-style-invalid';
        }
        const jobLabel = document.getElementById('jobLabel');
        const job = document.getElementById('job');
        const isValidJob = job.value.length > 0;
        if (isValidJob) {
            jobLabel.className = 'label-font-style';
            job.className = 'input-left border-style';
        }
        else {
            jobLabel.className = 'label-font-style color-red';
            job.className = 'input-left border-style-invalid';
        }
        const companyLabel = document.getElementById('companyLabel');
        const company = document.getElementById('company');
        const isValidCompany = company.value.length > 0;
        if (isValidCompany) {
            companyLabel.className = 'label-font-style';
            company.className = 'input-left border-style';
        }
        else {
            companyLabel.className = 'label-font-style color-red';
            company.className = 'input-left border-style-invalid';
        }
        const websiteLabel = document.getElementById('websiteLabel');
        const website = document.getElementById('website');
        const isValidWebsite = website.value.length > 0;
        if (isValidWebsite) {
            websiteLabel.className = 'label-font-style';
            website.className = 'input-left border-style';
        }
        else {
            websiteLabel.className = 'label-font-style color-red';
            website.className = 'input-left border-style-invalid';
        }
        const phoneLabel = document.getElementById('phoneLabel');
        const phone = document.getElementById('phone');
        const isValidPhone = phone.value.length > 0;
        if (isValidPhone) {
            phoneLabel.className = 'label-font-style';
            phone.className = 'input-left border-style';
        }
        else {
            phoneLabel.className = 'label-font-style color-red';
            phone.className = 'input-left border-style-invalid';
        }
        const helpLabel = document.getElementById('helpLabel');
        const help = document.getElementById('help');
        const isValidHelp = help.value.length > 0;
        if (isValidHelp) {
            helpLabel.className = 'label-font-style';
            help.className = 'form-textarea textarea-style border-style';
        }
        else {
            helpLabel.className = 'label-font-style color-red';
            help.className = 'form-textarea textarea-style border-style-invalid';
        }

        const isValid = isValidFname && isValidLname && isValidEmail && isValidJob && isValidCompany && isValidWebsite && isValidPhone && isValidHelp;
        if (!isValid)
        {
            return false;
        }
    }
</script>

<?php

require_once $rootPath.'_footer.php';

?>