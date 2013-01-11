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
		$opts = array();
		for ( $i = 1; $i < func_num_args(); $i++ ) {
			$opts[] = func_get_arg( $i );
		}
		$options = Git2PagesHooks::extractOptions( $opts );
		$output = "Pulling content from file {$options['file']} in repository {$options['repository']} from branch {$options['branch']} starting at {$options['start']} and ending at {$options['end']}...";
		return $output;
	}
}
