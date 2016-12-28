/**
 * PHP Contact Form
 * Version: 2015-04-07 23:07:00 (UTC+02:00)
 * Author:  Christian L. Dünweber
 * Webpage: https://www.dunweber.com/docs/scripts/kildekoder/kontaktformular.source.php
 * Copyright (C) 2006-2015 Christian L. Dünweber
 * This program is distributed under the GNU General Public License,
 * see <http://www.gnu.org/licenses/gpl.html>.
 *
 * Challenge/security image adapted from article by Edward Eliot:
 * http://articles.sitepoint.com/article/toughen-forms-security-image
 * Font by courtesy of: http://www.webpagepublicity.com/free-fonts.html
 * Icon by courtesy of: http://www.famfamfam.com/
 */

/**
 * Check form fields for valid content.
 * @param	String ID of the form.
 * @return	boolean True if all fields where valid.
 */
function checkFormContent(form, genericTxt, nameTxt, emailTxt, subjectTxt, messageTxt, challengeTxt)
{
	if (checkField(form.name, genericTxt+nameTxt) &&
		checkEmail(form.email, genericTxt+emailTxt) &&
		checkField(form.subject, genericTxt+subjectTxt) &&
		checkField(form.message, genericTxt+messageTxt) &&
		checkField(form.challengeAnswer, genericTxt+challengeTxt)) {
		return true;
	}

	return false;
}

/**
 * Check if form field is empty.
 * @param	String field ID.
 * @param	String description of the field.
 * @return	boolean True if anything is written in the field.
 */
function checkField(field, errTxt)
{
	if (field.value.length < 1) {
		alert(errTxt);
		field.focus();
		return false;
	}

	return true;
}	

/**
 * Check if an e-mail adress looks valid, i.e. on the form x@x.xxx.
 * @param	String form ID - must contain a field with id="email"
 * @return	boolean True if anything e-mail looks good.
 */
function checkEmail(field, errTxt)
{
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if (!filter.test(field.value)) {
		alert(errTxt);
		field.focus();
		return false;
	}
	
	return true;
}

/**
 * Clicks the form element with ID "send" to submit when Enter is pressed in a text field.
 * @param	String ID of the form.
 * @param	Event of the element.
 * @return	boolean False if the Enter button was pressed (since it clicks submit) and and true for any other key.
 */
function clickSubmitOnEnter(form, event)
{
	if (event.keyCode == 13) {
		form.send.click();
		return false;
	}

	return true;
}
