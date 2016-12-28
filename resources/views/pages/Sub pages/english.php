<?php

/**
 * English language file for PHP Contact Form.
 * NB: Don't use any HTML special characters in translations.
 * https://www.dunweber.com/docs/scripts/kildekoder/kontaktformular.source.php
 */

define('FORM_TITLE',				'Contact Form');
define('FORM_SENDER_NAME',			'Your name:');
define('FORM_SENDER_EMAIL',			'Your e-mail:');
define('FORM_SENDER_SUBJECT',		'Subject:');
define('FORM_SENDER_MESSAGE',		'Message:');
define('FORM_COPY',					'Copy to you:');
define('FORM_VERIFICATION_IMG',		'Verification:');
define('FORM_VERIFICATION_NEW',		'Try another image');
define('FORM_VERIFICATION_ANSWER',	'Repeat text:');
define('FORM_BUTTON_SEND',			'Send');
define('FORM_BUTTON_RESET',			'Reset');
define('ERR_INFO',					'You need to fill in:');
define('ERR_MISSING_NAME',			'Your name.');
define('ERR_INVALID_EMAIL',			'A valid e-mail address.');
define('ERR_MISSING_SUBJECT',		'A subject description.');
define('ERR_MISSING_MESSAGE',		'A message or question.');
define('ERR_BANNED_WORDS',			'A name, subject, or message without inappropriate words.');
define('ERR_VERIFICATION_WRONG',	'Letters shown in the image (only letters A-Z, case insensitive).');
define('ERR_SERVER_NO_GD',			'PHP GD library is not installed on the server. Contact the website administrator.');
define('SEND_TIME',					'Time:');
define('SENDER_IP',					'IP:');
define('MAIL_SEND_INFO',			'Contact from '.$_SERVER['HTTP_HOST']);
define('MAIL_SEND_SUCCESS',			'Your mail was successfully sent with the following info:');
define('MAIL_SEND_COPY',			'A copy was sent to:');
define('MAIL_SEND_ERR',				'An error occurred while sending.');
define('MAIL_SEND_ERR_EXTRA',		'Please try again in a few minuttes. If the issue persists please contact the website administrator.');

?>