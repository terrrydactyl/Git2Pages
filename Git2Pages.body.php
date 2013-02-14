<?php
/**
 * Execution code
 */
include 'GitRepository.php';

class Git2PagesHooks {
	public static function Git2PagesSetup( $parser ) {
		$parser->setFunctionHook( 'snippet', array( 'Git2PagesHooks', 'PullContentFromRepo' ) );
		return true;
	}

	/**
	 * Converts an array of values in form [0] => "name=value" into a real
	 * associative array in form [name] => value
	 *
	 * @param array string $options
	 * @return array $results
	 */
	static function extractOptions( array $options ) {
		$results = array();
		foreach ( $options as $option ) {
			$pair = explode( '=', $option );
			if ( count( $pair ) == 2 ) {
				$name = trim( $pair[0] );
				$value = trim( $pair[1] );
				$results[$name] = $value;
			}
		}
		return $results;
	}

	/**
	 * Checks if value is an int whether it is type string or int.
	 *
	 * @param $mixed contains value to be checked
	 * @return bool true if it is an int value, false otherwise
	 */
	static function isint( $mixed ) {
		return ( preg_match( '/^\d*$/'  , $mixed) == 1 );
	}

	/**
	 * Pulls the content from a repository
	 *
	 * @param $parser will contain an array of params. The first element is the Parser object. The rest of the elements will be the user input values that will be converted.
	 */
	public static function PullContentFromRepo( $parser ) {
		global $wgGit2PagesDataDir;
		$opts = array();
		for ( $i = 1; $i < func_num_args(); $i++ ) {
			$opts[] = func_get_arg( $i );
		}
		$options = Git2PagesHooks::extractOptions( $opts );
		$url = $options['repository'];
		$gitFolder =  $wgGit2PagesDataDir . DIRECTORY_SEPARATOR . md5( $url );
		if( !isset( $options['repository'] ) || !isset( $options['filename'] ) ) {
			return 'repository and/or filename not defined.';
		}
		$gitRepo = new GitRepository( $url );
		$gitRepo->CloneGitRepo( $url, $gitFolder );
		if( isset( $options['branch'] ) ) {
			$gitRepo->GitCheckoutBranch( wfEscapeShellArg($options['branch'] ), $gitFolder );
		}
		else {
			$gitRepo->GitCheckoutBranch( 'master', $gitFolder );
		}
		$startLine = isset( $options['startline'] ) ? $options['startline'] : 1;
		$endLine = isset( $options['endline'] ) ? $options['endline'] : -1;
		if( !self::isint( $startLine ) ) {
			return '<strong class="error">startline is not an integer.</strong>';
		}
		if( $endLine != -1 && !self::isint( $endLine ) ) {
			return '<strong class="error">endline is not an integer.</strong>';
		}
		try {
			$fileContents = $gitRepo->FindAndReadFile( $options['filename'], $gitFolder, $startLine, $endLine );
			$output = '<pre>' . htmlspecialchars( $fileContents ) . '</pre>';
		} catch( Exception $ex ) {
			$output = '<strong class="error">' . $ex->getMessage() . '</strong>';
		}
		return array( $output, 'nowiki' => true, 'noparse' => true, 'isHTML' => true );
	}
}
