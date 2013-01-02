<?php
/**
 * Execution code
 */

class GitRepoExtensionHooks {
	public static function GitRepoExtensionSetup() {

		$parser -> setFunctionHook( 'snippet', 'GitRepoExtensionHooks::PullContentFromRepo' );
	}

    /**
     * Pulls the content from a repository
     *
     * @param Parser $parser a parser instance
     * @param string $repository The Git repository to fetch content from
     * @param string $file The file to fetch content from
     * @param int $start The first snippet line number
     * @param int $end The last snippet line number
     * @return string The output of the parser function
     */

    public static function PullContentFromRepo( $parser, $repository = '',  $file = '', $start = '', $end = '' ) {

		$output = "Pulling content from file $file in repository $repository starting at $start and ending at $end...";

		return $output;
        }
}
