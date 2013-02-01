<?php
/**
 * A class to manipulate a Git repository.
 */
class GitRepository {
	protected $gitUrl;

	/**
	 * Initializes a new instance of the class GitRepository.
	 *
	 * @param string $gitUrl contains url to the git repository
	 */
	function __construct( $gitUrl ) {
		$this->gitUrl = $gitUrl;
		$branch = 'master';
	}

	/**
	 * Clones Git repo in unique folder.
	 *
	 * @param string $dataDir contains directory where repo is cloned.
	 * @param string $gitFolder path to local git repo
	 */
	static function CloneGitRepo( $url, $gitFolder ) {
		if( !file_exists( $gitFolder ) ) {
			wfShellExec( 'git clone ' . wfEscapeShellArg( $url ) . ' ' . $gitFolder );
			wfDebug( 'Git2Pages: Cloned a git repository.' );
		}
		else {
			wfDebug( 'Git2Pages: git repository exists, didn\'t clone.' );
		}
	}

	/**
	 * Checkouts out Git branch
	 *
	 * @param string $branch is the branch to be checked
	 * @param string $gitFolder is the Git repository in which the branch will be checked in
	 */
	function GitCheckoutBranch( $branch, $gitFolder ) {
		wfShellExec( 'git --git-dir=' . $gitFolder . '/.git --work-tree=' . $gitFolder . ' checkout ' . $branch );
		wfDebug( 'Git2Pages: Changed to branch ' . $branch );
	}

	/**
	 * Finds and reads the file.
	 *
	 * @param string $gitFolder contains the path to  git repo folder
	 * @param array $options contains user inputs
	 */
	function FindAndReadFile( $filename, $gitFolder ) {
		$filePath = $gitFolder . DIRECTORY_SEPARATOR . $filename;
		if( !file_exists( $filePath ) ) {
			wfDebug( 'Git2Pages: File does not exist' );
		}
	}
}
