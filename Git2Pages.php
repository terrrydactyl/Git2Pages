<?php
/**
 * Setup instructions for GitRepoExtension parser function
 */

$wgExtensionCredits['parserhook'][] = array(
    'path' => __FILE__,
    'name' => 'Git2Pages',
    'description' => 'A parser function extension that will add in the contents from a file in a git repo',
    'version' => '1.0',
    'author' => array( '[https://www.mediawiki.org/wiki/User:Himeshi]' ),
    'url' => 'https://www.mediawiki.org/wiki/Extension:Git2Pages',
);

// Load the extension body to call the static function in the hook
$wgAutoloadClasses['GitRepoExtensionHooks'] = "$dir/Git2Pages.body.php";

// The function that will initialize the parser function
$wgHooks['ParserFirstCallInit'][] = 'GitRepoExtensionHooks::GitRepoExtensionSetup';

// Allow translation of the parser function name
$wgExtensionMessagesFiles['Git2Pages'] = __DIR__ . '/Git2Pages.i18n.magic.php';
