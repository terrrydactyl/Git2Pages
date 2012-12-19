<?php
/**
* Execution code 
*/

class GitRepoExtensionHooks {
	public static function GitRepoExtensionSetup() {

		$parser -> setFunctionHook('snippet', 'GitRepoExtensionHooks ::PullContentFromRepo');
	}

	// Get output of the parser function.
	public static function PullContentFromRepo($parser, $repository = '',  $file = '', $start = '', $end = '') {

		$output = "Pulling content from file $file in repository $repository starting at $start and ending at $end...";

		return $output;
	}

}
?>