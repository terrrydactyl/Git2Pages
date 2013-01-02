<?php
/**
 * Setup instructions for GitRepoExtension parser function
 */

$wgExtensionCredits['parserhook'][] = array(
		'path' => __FILE__,
		'name' => 'GitRepoExtension',
		'description' => 'A parser function extension that will add in the contents from a file in a git repo',
		'version' => 1.0,
		'author' => array( '[http://www.mediawiki.org/wiki/User:Himeshi]' ),
		'url' => 'https://www.mediawiki.org/wiki/Manual:Parser_functions' 
	);

// Load the extension body to call the static function in the hook
$wgAutoloadClasses['GitRepoExtensionHooks'] = "$dir/GitRepoExtension.body.php";

// The function that will initialize the parser function
$wgHooks['ParserFirstCallInit'][] = 'GitRepoExtensionHooks::GitRepoExtensionSetup';

// Allow translation of the parser function name
$wgExtensionMessagesFiles['GitRepoExtensionMagic'] = dirname(__FILE__) . '/GitRepoExtension.i18n.php';

?>