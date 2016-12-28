<php
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

// Start PHP session if not already
if (strcmp(session_id(),"") === 0) {
	session_start();
}

// Get image parameters from http query
$width = isset($_GET['width'])?((int)$_GET['width']):150;
$height = isset($_GET['height'])?((int)$_GET['height']):30;

// Initialize new challenge image object. Set number of characters and tilted lines in the image
$image = new ChallengeImage($width, $height, 4, 20);

// Create the image and output it to the browser if possible
$image->create();

// Get text written in image for checking against user entered values
$_SESSION['challengeSolution'] = $image->getCode();

/**
 * Challenge image class. Create an image with different letters in different
 * fonts and grayscale colours and with random lines in the backgound for obscurity.
 */
class ChallengeImage 
{
	// Following parameters can be altered as desired (colour values must be 0-255)
	var $bgColour = 240; // Image background colour
	
	var $lineColourLow = 140; // Distortion lines colour range lowest value
	var $lineColourHigh = 200; // Distortion lines colour range highest value
	
	var $charColourLow = 50; // Characters colour range lowest value
	var $charColourHigh = 110; // Characters colour range highest value
	
	var $font = './Halter Pinchy.ttf'; // TrueType font to be used
	
	var $fontSizeMin = 10; // Font size minimum value
	var $fontSizeMax = 14; // Font size maximum value
	
	// Character rotation angle range: [-$angleMax;-$angleMin] and [$angleMin;$angleMax]
	var $angleMin = 5; // Minimum rotation angle
	var $angleMax = 25; // Maximum rotation angle

	var $image;
	var $width;
	var $height;
	var $numChars;
	var $charSpacing;
	var $numLines;
	var $imageCode;
	
	/**
	 * Contructor. Initialize the image.
	 */
	function ChallengeImage($width = 150, $height = 30, $numChars = 4, $numLines = 20)
	{
		// Get image parameters
		$this->width = $width;
		$this->height = $height;
		$this->numChars = $numChars;
		$this->numLines = $numLines;
		
		// Create new image
		$this->image = imagecreatetruecolor($width, $height);
		
		// Set image background colour
		$bg = imagecolorallocate($this->image, $this->bgColour, $this->bgColour, $this->bgColour);
		imagefilledrectangle($this->image, 0, 0, $width-1, $height-1, $bg);
	
		// Calculate spacing between characters based on width of image
		$this->charSpacing = (int)($this->width / $this->numChars);
	}
	
	/**
	 * Create the image and write it to the browser.
	 */
	function create()
	{
		// Make the content of the image
		$this->drawLines();
		$this->generateCode();
		$this->drawCharacters();
		
		// Tell browser that image data is PNG
		header('Content-type: image/png');
		
		// Output image to the browser
		imagepng($this->image);
		
		// Free memory used by the image
		imagedestroy($this->image);
	}
	
	/**
	 * Get the code of characters on the image for comparison with user answer.
	 * @return String
	 */
	function getCode()
	{
		return $this->imageCode;
	}
	
	/**
	 * Generate the code of characters for the image.
	 */
	function generateCode()
	{
		// Reset current code
		$this->imageCode = '';
		
		// Generate code as random characters in the range A-Z (ASCII 65-90/0x41-0x5A)
		for ($i = 0; $i < $this->numChars; $i++) {
			$this->imageCode .= chr(rand(65, 90));
		}
	}
	
	/**
	 * Draw the code characters on the image.
	 */
	function drawCharacters()
	{
		// Write the created code to the image
		for ($i = 0; $i < strlen($this->imageCode); $i++) {
			// Use a random greyscale colour
			$colourVal = rand($this->charColourLow, $this->charColourHigh);
			$colour = imagecolorallocate($this->image, $colourVal, $colourVal, $colourVal);
			
			// Use a random font size
			$fontSize = rand($this->fontSizeMin,$this->fontSizeMax);
			
			// Calculate coordinates for the character
			$x = $this->charSpacing/3 + $this->charSpacing * $i;
			$y = $this->height/2 + $fontSize/2;
			
			// Write character to the image in a random angle
			imagettftext($this->image,
				$fontSize,
				(rand(0,1)==1?1:-1)*rand($this->angleMin,$this->angleMax),
				$x,
				$y,
				$colour,
				$this->font,
				$this->imageCode[$i]);
		}
	}
	
	/**
	 * Draw lines in random directions on the image.
	 */
	function drawLines()
	{
		for ($i = 0; $i < $this->numLines; $i++) {
			// Get a random greyscale colour
			$colourVal = rand($this->lineColourLow, $this->lineColourHigh);
			$colour = imagecolorallocate($this->image, $colourVal, $colourVal, $colourVal);
			
			// Draw the line on the image
			imageline($this->image,
				rand(0, $this->width),
				rand(0, $this->height),
				rand(0, $this->width),
				rand(0, $this->height),
				$colour);
		}
	}
}
?>
