<?php
/**
 * Setup instructions for GitRepoExtension parser function
 */

$wgExtensionCredits['parserhook'][] = array(
    'path' => __FILE__,
    'name' => 'Git2Pages',
    'description' => 'A parser function extension that will add in the contents from a file in a git repo',
    'version' => '1.0',
    'author' => array( 'Teresa Cho' , 'Himeshi de Silva' ),
    'url' => 'https://www.mediawiki.org/wiki/Extension:Git2Pages',
);

// Load the extension body to call the static function in the hook
$wgAutoloadClasses['Git2PagesHooks'] = __DIR__ . '/Git2Pages.body.php';

// The function that will initialize the parser function
$wgHooks['ParserFirstCallInit'][] = 'Git2PagesHooks::Git2PagesSetup';

// Allow translation of the parser function name
$wgExtensionMessagesFiles['Git2Pages'] = __DIR__ . '/Git2Pages.i18n.magic.php';
