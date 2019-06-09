<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo $title; ?><?php echo $metadata[1]['title']; ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TODO-me Раскомментировать перед загрузкой на сервер TestSB -->
    <meta name="yandex-verification" content="fbc35dfc3ef66ae0" />
    <meta name='wmail-verification' content='c49202d54c0fb7f8e8847bfd048f81dd' />
    <meta name="msvalidate.01" content="60DCFF887D5472AFA3314F542E53F876" />
    <link rel="icon" type="image/png" href="/favicon.ico" />

    <link rel="stylesheet" href="/css/google_fonts.css">
    <link rel="stylesheet" href="/css/grid.css">
    <link rel="stylesheet" href="/css/fullcalendar.css">
    <link rel="stylesheet" href="/css/px-video.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/lightbox.css">
    <link rel="stylesheet" href="/css/jquery.formstyler.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/colorpicker/colorpicker.css">
    <link rel="stylesheet" href="/css/colorpicker/page.css">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/styles.css">

    <script src="/js/moment.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/amcharts/amcharts.js"></script>
    <script src="/js/amcharts/serial.js"></script>
    <script src="/js/amcharts/amstock.js"></script>
    <script src="/js/fullcalendar.min.js"></script>
    <script src="/js/locale-all.js"></script>
    <script src="/js/strings.js"></script>
    <script src="/js/px-video.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/jquery.formstyler.js"></script>
    <script src="/js/autoresize-textarea.js"></script>
    <script src="/js/masonry.pkgd.min.js"></script>
    <script src="/js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
    <script src="/js/tinymce/tinymce.min.js" type="text/javascript"></script>
    <script src="/js/js.cookie.js" type="text/javascript"></script>

    <script src="/js/script.js"></script>
    <script src="/js/scripts.js"></script>

    <script src="/js/colorpicker/colorpicker.min.js"></script>
    <!--<script src="/js/colorpicker/eye.js"></script>
    <script src="/js/colorpicker/utils.js"></script>
    <script src="/js/colorpicker/layout.js"></script>-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
    <script src="/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

    <script src="https://player.vimeo.com/api/player.js"></script>
</head>
<!-- TODO-me Раскомментировать перед загрузкой на сервер TestSB -->
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-136119880-1');
</script>
<body>
<!-- TODO-me Раскомментировать перед загрузкой на сервер TestSB -->
<?php include_once('./app_fold/views/reporting_services.php'); ?>
<span id="block-message" <?php if (!empty($message)){ echo 'class="show"';}?>>
    <?php if (!empty($message)) :
        echo $message;
    endif;?>
</span>

<div id="policy_pop-up">
    <div class="policy_pop-up_cont">
        <div class="policy_pop-up_close"></div>
        <div class="policy_pop-up_h">Подтверждая данное действие, я (Клиент) даю своё согласие ООО «Лайф Технолоджи Рус.» на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных
            <a href="<?php if (!empty($site_info['personal_data'])): echo $site_info['personal_data']; endif;?>" class="policy" target="_blank">Политикой обработки персональных данных</a>
        </div>
    </div>
</div><!-- home_pop-up -->
<div id="ml_img_pop-up">
    <div class="ml_img_pop-up_cont">
        <div class="ml_img_pop-up_close"></div>
        <div class="ml_img_pop-up_h"></div>
    </div>
</div><!-- home_pop-up -->
<!--<p id="page-info">Page rendered in <strong>{elapsed_time}</strong> seconds. Memory usage <strong>{memory_usage}</strong>. <?php /*echo  (ENVIRONMENT === 'development') ?  'PHP Version <strong>' . phpversion() . '</strong>' : '' */?></p>-->
<?php
/*<!-- Google -->
<!-- <script type="text/javascript">
    function handleClientLoad() {
        // Loads the client library and the auth2 library together for efficiency.
        // Loading the auth2 library is optional here since `gapi.client.init` function will load
        // it if not already loaded. Loading it upfront can save one network request.
        gapi.load('client:auth2', initClient);
    }

    function initClient() {
        // Initialize the client with API key and People API, and initialize OAuth with an
        // OAuth 2.0 client ID and scopes (space delimited string) to request access.
        gapi.client.init({
            'apiKey': '',
            'discoveryDocs': ['https://people.googleapis.com/$discovery/rest?version=v1'],
            'clientId': '',
            'scope': 'profile'
        }).then(function () {
            // Listen for sign-in state changes.
            gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

            // Handle the initial sign-in state.
            updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
        });
    }

    function updateSigninStatus(isSignedIn) {
        // When signin status changes, this function is called.
        // If the signin status is changed to signedIn, we make an API call.
        if (isSignedIn) {
            makeApiCall();
        }
    }

    function handleSignInClick(event) {
        // Ideally the button should only show up after gapi.client.init finishes, so that this
        // handler won't be called before OAuth is initialized.
        gapi.auth2.getAuthInstance().signIn();
    }

    function handleSignOutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
    }

    function makeApiCall() {
        // Make an API call to the People API, and print the user's given name.
        gapi.client.people.people.get({
            'resourceName': 'people/me',
            'requestMask.includeField': 'person.names'
        }).then(function(response) {
            console.log('Hello, ' + response.result.names[0].givenName);
            console.log(response.result.resourceName);
            console.log(response.result.names[0].metadata.source['id']);
        }, function(reason) {
            console.log('Error: ' + reason.result.error.message);
        });
    }
</script>-->
<!--<script async defer src="https://apis.google.com/js/api.js"
        onload="this.onload=function(){};handleClientLoad()"
        onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>-->
<!--<button id="signin-button" onclick="handleSignInClick()">Sign In</button>
<button id="signout-button" onclick="handleSignOutClick()">Sign Out</button>-->*/
?>
