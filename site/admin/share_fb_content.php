<?php
include ("../include/session.php");
if (! $session->isAdmin ()) {
	header ( "Location: ../main.php" );
} else {
	/**
	 * This sample app is provided to kickstart your experience using Facebook's
	 * resources for developers.
	 * This sample app provides examples of several
	 * key concepts, including authentication, the Graph API, and FQL (Facebook
	 * Query Language). Please visit the docs at 'developers.facebook.com/docs'
	 * to learn more about the resources available to you
	 */
	
	// Provides access to app specific values such as your app id and app secret.
	// Defined in 'AppInfo.php'
	require_once ('../../facebook/AppInfo.php');
	
	/*
	 * // Enforce https on production if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') { header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); exit(); }
	 */
	
	// This provides access to helper functions defined in 'utils.php'
	require_once ('../../facebook/utils.php');
	
	/**
	 * ***************************************************************************
	 *
	 * The content below provides examples of how to fetch Facebook data using the
	 * Graph API and FQL. It uses the helper functions defined in 'utils.php' to
	 * do so. You should change this section so that it prepares all of the
	 * information that you want to display to the user.
	 *
	 * **************************************************************************
	 */
	require_once ('../../facebook/util/AppUser.php');
	require_once ('../../facebook/util/DBManager.php');
	require_once ('../../facebook/sdk/src/facebook.php');
	
	$facebook = new Facebook ( array (
			'appId' => AppInfo::appID (),
			'secret' => AppInfo::appSecret (),
			'sharedSession' => true,
			'trustForwarded' => true 
	) );
	
	?>

<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />

<title><?php echo he($app_name); ?></title>
<link rel="stylesheet" href="stylesheets/screen.css" media="Screen"
	type="text/css" />
<link rel="stylesheet" href="stylesheets/mobile.css"
	media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)"
	type="text/css" />

<!--[if IEMobile]>
    <link rel="stylesheet" href="mobile.css" media="screen" type="text/css"  />
    <![endif]-->

<!-- These are Open Graph tags.  They add meta data to your  -->
<!-- site that facebook uses when your content is shared     -->
<!-- over facebook.  You should fill these tags in with      -->
<!-- your data.  To learn more about Open Graph, visit       -->
<!-- 'https://developers.facebook.com/docs/opengraph/'       -->
<meta property="og:title" content="<?php echo he($app_name); ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo AppInfo::getUrl(); ?>" />
<meta property="og:image"
	content="<?php echo AppInfo::getUrl('/logo.png'); ?>" />
<meta property="og:site_name" content="<?php echo he($app_name); ?>" />
<meta property="og:description" content="My first app" />
<meta property="fb:app_id" content="<?php echo AppInfo::appID(); ?>" />

<script type="text/javascript" src="/javascript/jquery-1.7.1.min.js"></script>

<script type="text/javascript">
      function logResponse(response) {
        if (console && console.log) {
          console.log('The response was', response);
        }
      }

      $(function(){
        // Set up so we handle click on the buttons
        $('#postToWall').click(function() {
          FB.ui(
            {
              method : 'feed',
              link   : $(this).attr('data-url')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });

        $('#sendToFriends').click(function() {
          FB.ui(
            {
              method : 'send',
              link   : $(this).attr('data-url')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });

        $('#sendRequest').click(function() {
          FB.ui(
            {
              method  : 'apprequests',
              message : $(this).attr('data-message')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });
      });
    </script>

<!--[if IE]>
      <script type="text/javascript">
        var tags = ['header', 'section'];
        while(tags.length)
          document.createElement(tags.pop());
      </script>
    <![endif]-->
</head>
<body>
	<div id="fb-root"></div>
	<script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?php echo AppInfo::appID(); ?>', // App ID
          channelUrl : '//<?php echo $_SERVER["HTTP_HOST"]; ?>/channel.html', // Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true // parse XFBML
        });

        // Listen to the auth.login which will be called when the user logs in
        // using the Login button
        FB.Event.subscribe('auth.login', function(response) {
          // We want to reload the page now so PHP can read the cookie that the
          // Javascript SDK sat. But we don't want to use
          // window.location.reload() because if this is in a canvas there was a
          // post made to this page and a reload will trigger a message to the
          // user asking if they want to send data again.
          window.location = window.location;
        });

        FB.Canvas.setAutoGrow();
      };

      // Load the SDK Asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
<?php
	
	$content_to_share = $_POST ["content_to_share"];
	if (isset ( $content_to_share )) {
		try {
			$dbm = new DBManager ();
			$users = $dbm->fetchAllAppUsers ();
			if ($users != null && !empty($users)) {
				foreach ( $users as $user ) {
					$attachment = array (
							'access_token' => $token,
							'message' => $content_to_share,
							'name' => 'This is my demo Facebook application named quote-appli!',
							'caption' => "Caption of the Post",
							'link' => 'http://mylink.com',
							'description' => 'this is a description',
							'picture' => 'http://mysite.com/pic.gif' 
					);
					
					$result = $facebook->api ( '/' . $uid . '/feed/', 'post', $attachment );
				}
				echo "<p>Succefully shared your content to application users.</p>";
			} else {
				echo "<p>We're sorry, but an error has occurred : <b>No user to fetch   </b>";
			}
			
			
		} catch ( FacebookApiException $e ) {
			echo "<p>We're sorry, but an error has occurred : <b>" . $e->getResult () . "</b>, " . "<br>Please try again at a later time.</p>";
		}
	}
	
	?>


	<section>
		<div>
			<h1>Share</h1>
			<form action="share_fb_content.php" method="post">
				<input type="textarea" name="content_to_share"
					value="<?php echo $content_to_share;?>"> <input type="submit"
					name="submit" value="submit">
			</form>
			<a href="admin.php">Back to Admin Center</a>
		</div>
   	
   	<?php
	// $user = $facebook->getUser();
	
	// if($user == 0) {
	
	// $login_url = $facebook->getLoginUrl($params = array('scope' => "publish_stream"));
	
	// echo ("<script> top.location.href='".$login_url."'</script>");
	
	// } else { $token=$facebook->getAccessToken();
	
	// try {
	// $params = array(
	// 'access_token' => $token,
	// 'message' => "Hurray! This works :)",
	// 'name' => "This is my title",
	// 'caption' => "My Caption",
	// 'description' => "Some Description...",
	// 'link' => "http://stackoverflow.com",
	// 'picture' => "http://i.imgur.com/VUBz8.png",
	// );
	
	// $url = 'https://graph.facebook.com/'.$user.'/feed';
	// $ch = curl_init();
	// curl_setopt_array($ch, array(
	// CURLOPT_URL => $url,
	// CURLOPT_POSTFIELDS => $params,
	// CURLOPT_RETURNTRANSFER => true,
	// CURLOPT_SSL_VERIFYPEER => false,
	// CURLOPT_VERBOSE => true
	// ));
	// $result = curl_exec($ch);
	// print_r($result);
	// curl_close($ch);
	
	// }
	// catch (FacebookApiException $e) {
	// $result = $e->getResult();
	// }
	
	// }
	// //////////////////////////
	
	// ///////////////////////////
	
	?>
   
   </section>
</body>
</html>
<?php
}
?>