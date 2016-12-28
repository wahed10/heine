<?php
$receiver_emails = 'afghanboy@live.dk'; // <--- Set receiver e-mails comma separated (mail1@example.xxx, mail2@example.xxx)
require_once( 'danish.php' ); // <--- Select file with language ('english.php' or 'danish.php')
require_once( 'mailer.php' ); // Include mail engine (must come before any HTML output)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo FORM_TITLE; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo  ENCODING; ?>" />
	<link rel="stylesheet" type="text/css" href="../../../../public/css/style.form.css" media="all" />
	<script type="text/javascript" src="../../../../public/js/javascript.js"></script>
	</head>
<body>

<!--
/**
 * PHP Contact Form
 * Version: 2015-04-07 23:07:00 (UTC+02:00)
 * Author:  Christian L. D�nweber
 * Webpage: https://www.dunweber.com/docs/scripts/kildekoder/kontaktformular.source.php
 * Copyright (C) 2006-2015 Christian L. D�nweber
 * This program is distributed under the GNU General Public License,
 * see <http://www.gnu.org/licenses/gpl.html>.
 *
 * Challenge/security image adapted from article by Edward Eliot:
 * http://articles.sitepoint.com/article/toughen-forms-security-image
 * Font by courtesy of: http://www.webpagepublicity.com/free-fonts.html
 * Icon by courtesy of: http://www.famfamfam.com/
 */
-->

	<?php echo $responseToUser; //Show info to the user - comes from mailer.php ?>
	
	<form action="#mailInfo" method="post" id="contactForm" accept-charset="<?php echo ENCODING; ?>">
	<fieldset>
	<legend><?php echo FORM_TITLE; ?></legend>
		<label for="name"><?php echo FORM_SENDER_NAME; ?></label>
		<input type="text" id="name" name="name" class="textInput" onkeypress="return event.keyCode!=13"
        	value="<?php echo htmlentities(isset($_POST['name'])?$_POST['name']:'', ENT_QUOTES, ENCODING); ?>" />
		<br />
		<label for="email"><?php echo FORM_SENDER_EMAIL; ?></label>
		<input type="text" id="email" name="email" class="textInput" onkeypress="return event.keyCode!=13"
        	value="<?php echo htmlentities(isset($_POST['email'])?$_POST['email']:'', ENT_QUOTES, ENCODING); ?>" />
		<br />
		<label for="subject"><?php echo FORM_SENDER_SUBJECT; ?></label>
		<input type="text" id="subject" name="subject" class="textInput" onkeypress="return event.keyCode!=13"
        	value="<?php echo htmlentities(isset($_POST['subject'])?$_POST['subject']:'', ENT_QUOTES, ENCODING); ?>" />
		<br />
		<label for="message"><?php echo FORM_SENDER_MESSAGE; ?></label>
		<textarea id="message" name="message" cols="45" rows="10"><?php echo htmlentities(isset($_POST['message'])?$_POST['message']:'', ENT_QUOTES, ENCODING); ?></textarea>
		<br />
		
		<label for="copy"><?php echo FORM_COPY; ?></label>
		<input type="checkbox" id="copy" name="copy" value="1" class="checkboxInput" onkeypress="return event.keyCode!=13"
			<?php echo (isset($_POST["copy"])?'checked="checked "':''); ?>/>
		<br />
        <!--
		/**
		<label for="challengeAnswer"><?php echo FORM_VERIFICATION_IMG; ?></label>
		<img src="../../../../resources/views/pages/Sub pages/challenge-image.php?width=153&amp;height=22" id="challengeImg" alt="" />
		<input type="image" src="../../../../public/images/reload.png" alt="<?php echo FORM_VERIFICATION_NEW; ?>" title="<?php echo FORM_VERIFICATION_NEW; ?>"
               onclick="document.forms['contactForm'].submit()" id="reloadButton" />
		<br />
		<label for="challengeAnswer"><?php echo FORM_VERIFICATION_ANSWER; ?></label>
		<input type="text" id="challengeAnswer" name="challengeAnswer" class="answerInput"
			onkeypress="return clickSubmitOnEnter(document.forms['contactForm'],event);" />
		<br />
        */
        -->

		<label>&nbsp;</label>
		<input type="submit" class="button" id="send" name="send" value="<?php echo FORM_BUTTON_SEND; ?>"
			onclick="return checkFormContent(document.forms['contactForm'],<?php echo '\''.ERR_INFO.' \',\''.ERR_MISSING_NAME.'\',\''.
				ERR_INVALID_EMAIL.'\',\''.ERR_MISSING_SUBJECT.'\',\''.ERR_MISSING_MESSAGE.'\',\''.ERR_VERIFICATION_WRONG.'\''; ?>);" />
		<input type="submit" class="button" id="reset" name="reset" value="<?php echo FORM_BUTTON_RESET; ?>" />
	</fieldset>
	</form>

</body>
</html>
