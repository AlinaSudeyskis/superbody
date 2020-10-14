<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php if(!empty($title)): echo $title; endif; ?><?php if(!empty($metadata[1]['title'])): echo $metadata[1]['title'];  endif; ?></title>
    <meta name="keywords" content="<?php if(!empty($keywords)): echo $keywords; endif; ?>">
    <meta name="description" content="<?php if(!empty($description)): echo $description; endif; ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="/mobile-icons/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="57x57" href="/mobile-icons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/mobile-icons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/mobile-icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/mobile-icons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/mobile-icons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/mobile-icons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/mobile-icons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/mobile-icons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/mobile-icons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/mobile-icons/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/mobile-icons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/mobile-icons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/mobile-icons/android-chrome-192x192.png" sizes="192x192">
	<meta name="msapplication-square70x70logo" content="/mobile-icons/smalltile.png" />
	<meta name="msapplication-square150x150logo" content="/mobile-icons/mediumtile.png" />
	<meta name="msapplication-wide310x150logo" content="/mobile-icons/widetile.png" />
	<meta name="msapplication-square310x310logo" content="/mobile-icons/largetile.png" />

    <link rel="stylesheet" href="/css/google_fonts.css">
    <link rel="stylesheet" href="/css/grid.css">
    <link rel='stylesheet' href='/fullcalendar/core/main.css' />
    <link rel='stylesheet' href='/fullcalendar/daygrid/main.css' />
    <link rel='stylesheet' href='/fullcalendar/timegrid/main.css' />
    <link rel='stylesheet' href='/fullcalendar/list/main.css' />
    <link rel="stylesheet" href="/css/px-video.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/lightbox.css">
    <link rel="stylesheet" href="/css/jquery.formstyler.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/font-awesome/all.css">
    <link rel="stylesheet" href="/css/colorpicker/colorpicker.css">
    <link rel="stylesheet" href="/css/colorpicker/page.css">

    <?php include_once('./app_fold/views/header/reporting_services2.php'); ?>

    <script src="/js/moment.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/amcharts/amcharts.js"></script>
    <script src="/js/amcharts/serial.js"></script>
    <script src="/js/amcharts/amstock.js"></script>
    <script src='/fullcalendar/core/main.js'></script>
    <script src='/fullcalendar/daygrid/main.js'></script>
    <script src='/fullcalendar/timegrid/main.js'></script>
    <script src='/fullcalendar/list/main.js'></script>
    <script src='/fullcalendar/interaction/main.js'></script>
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

    <?php include_once('./app_fold/views/header/styles_scripts.php'); ?>

    <script src="/js/colorpicker/colorpicker.min.js"></script>
    <!--<script src="/js/colorpicker/eye.js"></script>
    <script src="/js/colorpicker/utils.js"></script>
    <script src="/js/colorpicker/layout.js"></script>-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css" />
    <script src="/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

    <script src="https://player.vimeo.com/api/player.js"></script>
    <?php if($_SERVER['SERVER_NAME'] != 'sb.theoutlines.ru' and mb_substr($_SERVER['REQUEST_URI'], 0, 15) != '/administration'): ?>
    <script src="//static-login.sendpulse.com/apps/fc3/build/loader.js" sp-form-id="23a222fb3923d54bb39a6c7de5790b59d655651dc07e91e90adad86c6f323576"></script>
    <script charset="UTF-8" src="//web.webpushs.com/js/push/2b45b28120dd22639aa19427eabaedab_1.js" async></script>
    <?php endif;?>
</head>
<body>
<?php if (!empty($site_info['advertising_mobile']) and !empty($user_session) and $user_session['advertising'] == 1 and $user_session['type'] == 3):
    echo $site_info['advertising_mobile'];
endif; ?>

<?php include_once('./app_fold/views/header/reporting_services.php'); ?>

<?php include_once('./app_fold/views/header/block_message.php'); ?>

<?php include_once('./app_fold/views/header/policy_pop_up.php'); ?>

<div id="ml_img_pop-up">
    <div class="ml_img_pop-up_cont">
        <div class="ml_img_pop-up_close"></div>
        <div class="ml_img_pop-up_h"></div>
    </div>
</div><!-- ml_img_pop-up -->
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
