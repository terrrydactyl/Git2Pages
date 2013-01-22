<?php
/**
 * Execution code
 */

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
	 * Pulls the content from a repository
	 *
	 * @param $parser will contain an array of params. The first element is
	 * the Parser object. The rest of the elements will be the user input
	 * values that will be converted.
	 */
	public static function PullContentFromRepo( $parser ) {
		global $wgGit2PagesDataDir;
		$opts = array();
		for ( $i = 1; $i < func_num_args(); $i++ ) {
			$opts[] = func_get_arg( $i );
		}
		$options = Git2PagesHooks::extractOptions( $opts );
		$wgGit2PagesDataDir = sys_get_temp_dir();
		chdir( $wgGit2PagesDataDir );
		$url = $options['repository'];
		if( !file_exists( md5( $url ) ) ) {
			wfShellExec( 'git clone ' . wfEscapeShellArg( $url ) . ' ' . $wgGit2PagesDataDir . DIRECTORY_SEPARATOR . md5( $url ), $limit=1000000 );
			wfDebug( 'Git2Pages: Cloned a git repository.' );
		}
		else {
			wfDebug( 'Git2Pages: git repository exists, didn\'t clone.' );
		}
		return wfShellExec( 'ls' );
	}
}
