<?php

/**
 * Danish language file for PHP Contact Form.
 * NB: Don't use any HTML special characters in translations.
 * https://www.dunweber.com/docs/scripts/kildekoder/kontaktformular.source.php
 */

define('FORM_TITLE',				'Kontaktformular');
define('FORM_SENDER_NAME',			'Dit navn:');
define('FORM_SENDER_EMAIL',			'Din e-mail:');
define('FORM_SENDER_SUBJECT',		'Emne:');
define('FORM_SENDER_MESSAGE',		'Besked:');
define('FORM_COPY',					'Kopi til dig:');
define('FORM_VERIFICATION_IMG',		'Bekr�ftelse:');
define('FORM_VERIFICATION_NEW',		'Pr�v et andet billede');
define('FORM_VERIFICATION_ANSWER',	'Gentag tekst:');
define('FORM_BUTTON_SEND',			'Send');
define('FORM_BUTTON_RESET',			'Nulstil');
define('ERR_INFO',					'Du mangler at udfylde:');
define('ERR_MISSING_NAME',			'Dit navn.');
define('ERR_INVALID_EMAIL',			'Gyldig e-mailadresse.');
define('ERR_MISSING_SUBJECT',		'Et emne.');
define('ERR_MISSING_MESSAGE',		'En besked eller et sp�rgsm�l.');
define('ERR_BANNED_WORDS',			'Et navn, emne eller besked uden st�dende ord.');
define('ERR_VERIFICATION_WRONG',	'Teksten fra billedet (kun bogstaver A-Z, ingen forskel p� store og sm� bogstaver).');
define('ERR_SERVER_NO_GD',			'PHP GD library er ikke installeret p� serveren. Kontakt hjemmesideadministratoren.');
define('SEND_TIME',					'Tid:');
define('SENDER_IP',					'IP:');
define('MAIL_SEND_INFO',			'Kontakt fra '.$_SERVER['HTTP_HOST']);
define('MAIL_SEND_SUCCESS',			'Din mail blev succesfuldt afsendt med f�lgende indhold:');
define('MAIL_SEND_COPY',			'En kopi blev sendt til:');
define('MAIL_SEND_ERR',				'Der opstod en fejl ved afsendelse.');
define('MAIL_SEND_ERR_EXTRA',		'Pr�v igen om nogle minutter. Hvis fejlen forts�tter kontakt da hjemmesideadministratoren.');

?>