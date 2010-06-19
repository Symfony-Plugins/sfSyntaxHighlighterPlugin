<?php
	// set the sfSyntaxHighlighterPlugin directory
	sfConfig::set( 'sf_syntax_highlighter_plugin_dir', 
		sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.
		'plugins'.DIRECTORY_SEPARATOR.
		'sfSyntaxHighlighterPlugin');