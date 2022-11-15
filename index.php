<?php

ob_start("ob_gzhandler");
$rootPath = '';
require_once $rootPath.'inc/config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$setHomeCanonical = '<link rel="canonical" href="'.$secureURL.'" />';

$ogMetaUrl = $secureURL;
require_once $rootPath.'_ogMetaData.php';
require_once $rootPath.'_header.php';

?>

    <div class="presentation-block">
        <div class="presentation-content">
            <div class="presentation-content-text">
                <h1 class="presentation-title">Live, audience-interactive broadcasts on a global scale</h1>
                <p class="presentation-text">Develop groundbreaking shows and build superfan communities with
                    our cutting-edge, multi-channel experiences.
                </p>
                <div class="contact-button">
                    <a href="/contact/" class="presentation-button button-top">
                        <p>Contact us</p>
                        <img src="/assets/play-solid-with-gradient — white.svg" class="contact-img " alt="triagle">
                    </a>
                </div>
                <img src="/assets/ip_product_hero.png" alt="Interactive Platforms" class="presentation-photo radius-img">
            </div>
        </div>
    </div>
    <div class="advantage">
        <div class="advantage-card">
            <img src="/assets/ip_multi-channel_streaming.jpg" class="card-img radius-img" alt="Interactive Platforms - Multi-channel streaming">
            <div class="card-text-content margin-left">
                <h2 class="card-title">MULTI-CHANNEL STREAMING</h2>
                <p class="card-text">
                    Develop show concepts that broadcast multiple streams of content in parallel, giving viewers the
                    freedom to move between channels and a truly personalized experience of the event.
                </p>
            </div>
        </div>
        <div class="advantage-card reverse">
            <div class="card-text-content margin-right">
                <h2 class="card-title">ULTRA-LOW LATENCY</h2>
                <p class="card-text">
                    Deliver video streams globally with sub-one-second latency, enabling viewer interactivity to become
                    a key component of your show.
                </p>
            </div>
            <img src="/assets/ip_ultra-low_latency.jpg" class="card-img radius-img" alt="Interactive Platforms - Ultra-low latency">
        </div>
        <div class="advantage-card">
            <img src="/assets/ip_audience_interactivity.jpg" class="card-img radius-img" alt="Interactive Platforms - Audience interactivity">
            <div class="card-text-content margin-left">
                <h2 class="card-title">AUDIENCE INTERACTIVITY</h2>
                <p class="card-text">
                    Engage your audience with interactive features (such as audio/video participation, voting, chatting,
                    virtual gifting, and instant challenges), giving them real-time influence over the show’s outcome.
                </p>
            </div>
        </div>
        <div class="advantage-card reverse">
            <div class="card-text-content margin-right">
                <h2 class="card-title">ADVANCED MODERATION</h2>
                <p class="card-text">
                    Produce live, interactive content with high confidence and low risk thanks to AI-based moderation.
                </p>
            </div>
            <img src="/assets/ip_advanced_moderation.jpg" class="card-img radius-img" alt="Interactive Platforms - Advanced moderation">
        </div>
    </div>
    <div class="experience">
        <div class="experience-title">
            <h2 class="experience-title-text">Experiences powered by Interactive Platforms</h2>
        </div>
        <div class="experience-info">
            <div class="experience-left">
                <img src="/assets/ip_coupleTV.jpg" alt="Interactive Platforms - CoupleTV">
                <img src="/assets/coupletv_logo.svg" alt="CoupleTV" class="experience-logo">
                <p class="experience-text">
                    CoupleTV combines the best features of reality TV with its own awesomely innovative interface: 26
                    love-seeking singles spend eight weeks getting to know each other over virtual speed dates, all of
                    which are streamed online in an elimination-style dating show controlled by viewers.
                </p>
            </div>
            <div class="break"></div>
            <div class="experience-right">
                <img src="/assets/ip_Couple.jpg" alt="Interactive Platforms - Couple">
                <img src="/assets/couple_logo.svg" alt="Couple" class="experience-logo">
                <p class="experience-text">
                    Couple hooks singles up with the partners <i>and</i>  the party. Users meet their matches and then own the
                    open mic or crush trivia with the crowd ... all at one insanely fun event.
                </p>
            </div>
        </div>
    </div>
    <div class="creating">
        <h2 class="creating-text">Start creating your live, audience-interactive show today.</h2>
        <div class="contact-button">
            <a href="/contact/" class="presentation-button  button-bottom">
                <p>Contact us</p>
                <img src="/assets/play-solid-with-gradient — white.svg" class="contact-img" alt="triagle">
            </a>
        </div>
    </div>
    
<?php

require_once $rootPath.'_footer.php';

?>