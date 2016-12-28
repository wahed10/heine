<?php
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

// A few necessary settings
define('ENCODING', '-8');		// Set character encoding
ini_set('default_charset', ENCODING);	// Set PHP default charset
mb_internal_encoding(ENCODING);			// Set encoding for multibyte string functions
error_reporting(0);						// Turn off error reporting
session_start();						// Session is used for challenge image (must come before any HTML output)

// Check if the form has been submitted and process the data
$responseToUser = checkContentAndSendMailTo($receiver_emails);

/**
 * Check form content before sending the mail to the list of receivers.
 * @param $receiver_emails Comma separated list of receivers (visible to each others).
 * @return HTML string with success or error message of sending the mail.
 */
function checkContentAndSendMailTo($receiver_emails)
{
	// Check if PHP GD library for creating images is installed on the server, if not exit since the script won't work
	if (!extension_loaded('gd') || !function_exists('imagepng')) {
		exit(ERR_SERVER_NO_GD);
	}
	
	// Check if the user pressed reset in the form
	if (isset($_POST['reset'])) {
		unset($_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']);
		header('Location: .'); // Enables user to reload (F5) without being warned to resend data
		return '';
	}
	
	// Check if the user has clicked the submit button and not just reloaded the verification image
	if (!isset($_POST['send'])) {
		return '';
	}
	
	// Get submitted data and preprocess it
	$name = isset($_POST['name'])?$_POST['name']:'';
	$name = htmlentities($name, ENT_QUOTES, ENCODING);
	$name = trim(preg_replace("/\r|\n/", ' ', $name));
	
	$email = isset($_POST['email'])?$_POST['email']:'';
	$email = htmlentities($email, ENT_QUOTES, ENCODING);
	$email = trim(preg_replace("/\r|\n/", ' ', $email));
	
	$subject = isset($_POST['subject'])?$_POST['subject']:'';
	$subject = htmlentities($subject, ENT_QUOTES, ENCODING);
	$subject = trim(preg_replace("/\r|\n/", ' ', $subject));
	
	$message = isset($_POST['message'])?$_POST['message']:'';
	$message = htmlentities($message, ENT_QUOTES, ENCODING);
	$message = trim(preg_replace("/\r\n/","<br/>\n", $message));
	
	$copy = isset($_POST['copy'])?true:false;
/*
	$challengeAnswer = isset($_POST['challengeAnswer'])?trim($_POST['challengeAnswer']):'';
	$challengeSolution = trim($_SESSION['challengeSolution']);
	// Check for errors in submitted data
	$errors = array();

	if (!preg_match("/[A-z]/", $name)) {
		$errors[] = ERR_MISSING_NAME;
	}
	if (!checkEmail($email)) {
		$errors[] = ERR_INVALID_EMAIL;
	}
	if (!preg_match("/[A-z]/", $subject)) {
		$errors[] = ERR_MISSING_SUBJECT;
	}
	if (!preg_match("/[A-z]/", $message)) {
		$errors[] = ERR_MISSING_MESSAGE;
	}
	if (unwantedWords($name) || unwantedWords($subject) || unwantedWords($message)) {
		$errors[] = ERR_BANNED_WORDS;
	}
	if (strcmp(strtolower($challengeAnswer),strtolower($challengeSolution)) != 0) {
		$errors[] = ERR_VERIFICATION_WRONG;
	}
	*/
	// Any errors are explained to the user else the mail is sent and a status message shown

	if (count($errors) > 0) {
		return showErrorMessages($errors);
	}
	else {
		return sendMail($name, $email, $subject, $message, $copy, $receiver_emails);
	}
}

/**
 * Send mail as HTML to a list of receivers.
 * @param $name Name of the sender.
 * @param $email E-mail address of the sender.
 * @param $subject Subject of the mail.
 * @param $message Body of the mail.
 * @param $copy True or false for sending a self-copy to $email.
 * @param $receiver_emails Comma separated list of receiver e-mail addresses.
 * @return HTML string with success or error message.
 */
function sendMail($name, $email, $subject, $message, $copy, $receiver_emails)
{
	// Build HTML table with submitted data
	$message = '<table cellspacing="0" class="messageTable">
		<tr>
			<td class="leftCol" valign="top"><strong>'.FORM_SENDER_NAME.'</strong></td>
			<td class="rightCol">'.$name.'</td>
		</tr>
		<tr>
			<td class="leftCol" valign="top"><strong>'.FORM_SENDER_EMAIL.'</strong></td>
			<td class="rightCol">'.$email.'</td>
		</tr>
		<tr>
			<td class="leftCol" valign="top"><strong>'.FORM_SENDER_SUBJECT.'</strong></td>
			<td class="rightCol">'.$subject.'</td>
		</tr>
		<tr>
			<td class="leftCol" valign="top"><strong>'.FORM_SENDER_MESSAGE.'</strong></td>
			<td class="rightCol">'.$message.'</td>
		</tr>
		<tr>
			<td class="leftCol" valign="top"><strong>'.SEND_TIME.'</strong></td>
			<td class="rightCol">'.gmstrftime("%Y-%m-%d %H:%M:%S", time()).' (UTC)</td>
		</tr>
		<tr>
			<td class="leftCol" valign="top"><strong>'.SENDER_IP.'</strong></td>
			<td class="rightCol">'.$_SERVER['REMOTE_ADDR'].'</td>
		</tr>
		</table>';

	// Build HTML document for sending
	$message_mail ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<title>'.MAIL_SEND_INFO.'</title>
			<meta http-equiv="content-type" content="text/html; charset='.ENCODING.'" />
			<style type="text/css">
			<!--
			'.file_get_contents('style.mail.css').'
			-->
			</style>
		</head>
		<body>
			<h3>'.MAIL_SEND_INFO.'</h3>
			'.$message.'
		</body>
		</html>';
		
	// Prepare to send e-mail. Subject must satisfy RFC 2047
	$message_mail = wordwrap($message_mail, 70); //Should not be longer than 70 characters
	$name = mb_encode_mimeheader(html_entity_decode($name, ENT_QUOTES), ENCODING);
	$subject = mb_encode_mimeheader(MAIL_SEND_INFO.': '.html_entity_decode($subject, ENT_QUOTES), ENCODING);
	$info = '';
	
	$header = 'From: '.$name.' <'.$email.'>'. "\r\n".
		'MIME-Version: 1.0'. "\r\n".
		'Content-type: text/html; charset='.ENCODING. "\r\n".
		'X-Mailer: PHP/'.phpversion();

	// Send to all comma separated e-mails in $receiver_emails. Must comply with RFC 2822
	if (mail($receiver_emails, $subject, $message_mail, $header)) {
		if ($copy) {// If the user requested a copy
			mail($email, $subject, $message_mail, $header);
			$info = '<p>'.MAIL_SEND_COPY.' <strong>'.$email.'.</strong></p>';
		}
		
		unset($_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']);
		
		return '<div id="mailInfo">'.
			'<h3 class="successText">'.MAIL_SEND_SUCCESS.'</h3>'.
			$message . $info.'</div>';
	}
	else {
		return '<div id="mailInfo">'.
			'<h3 class="errorText">'.MAIL_SEND_ERR.'</h3>'.
			'<p>'.MAIL_SEND_ERR_EXTRA.'</p></div>';
	}
}

/**
 * Error message handler. Write out content of array $errors in an unordered list.
 * @param $errors Array with error descriptions.
 * @return HTML string with unordered list with all errors.
 */
function showErrorMessages($errors)
{
	$message = '<div id="mailInfo"><h3 class="errorText">'.ERR_INFO.'</h3><ul>';
	
	for ($i = 0; $i < count($errors); $i++) {
		$message .= '<li>'.$errors[$i].'</li>';
	}
	
	return $message.'</ul></div>';
}

/**
 * Checks the given string for banned words found in file banned_words.txt where
 * the banned words or sentences are stored one separate lines. A line can contain
 * spaces but should not have either leading or trailing spaces.
 * The function searches the input string and returns true if any match is found.
 * If the file banned_words.txt could not be found, the function allows to continue and
 * returns false. Thereby banned words can be disabled simply by deleting banned_words.txt
 * or leaving the file empty.
 * @param $str String to check for banned words.
 * @return boolean True if any match is found.
 */
function unwantedWords($str)
{
	$bannedWordsURL = 'banned_words.txt';
	$bannedWordsArray = file($bannedWordsURL, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	if ($bannedWordsArray != false) {
		$bannedWords = implode('|', $bannedWordsArray);
		$remove = array("\n", "\r", "\t");
		$bannedWords = str_replace($remove, "", $bannedWords);
	}
	else {
		return false; // File not found: Allow to continue if banned words are not required
	}
	
	if (preg_match('/\b('.$bannedWords.')\b/i', $str) !== 0) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Check an e-mail address to be on the form x@x.xx or x@x.xxx and check for a DNS
 * record of type MX, A, or CNAME for given Internet host name (only works on Windows
 * as of PHP 5.3.0).
 * @param $email String to check.
 * @return boolean
 */
function checkEmail($email)
{ 
	if ((preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/',$email)) ||
		(preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)))
	{
		$host = explode('@', $email);
		
		if (function_exists('checkdnsrr')) {
			if (checkdnsrr($host[1], 'MX') ||
				checkdnsrr($host[1], 'A') ||
				checkdnsrr($host[1], 'CNAME')) {
				return true;
			}
		}
		else {
			return true; // Do not block prior to PHP 5.3.0 on Windows
		}
	}
	
	return false;
}

?>