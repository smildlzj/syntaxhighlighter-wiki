<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the file directly.
if (!defined('MEDIAWIKI')) {
  echo <<<EOT
To install syntaxhighlighter extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/syntaxhighlighter/syntaxhighlighter.php" );
EOT;
  exit(1);
}

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['syntaxhighlighter'] = $dir. 'syntaxhighlighter.body.php';
$wgExtensionMessagesFiles['syntaxhighlighter'] = $dir. 'syntaxhighlighter.i18n.php';

$wgPrettifyAdditionalLanguages = array(
		'AS3',
		'AppleScript',
		'Bash',
		'CSharp',
		'ColdFusion',
		'Cpp',
		'Css',
		'Delphi',
		'Diff',
		'Erlang',
		'Groovy',
		'JScript',
		'Java',
		'JavaFX',
		'Perl',
		'Php',
		'Plain',
		'PowerShell',
		'Python',
		'Ruby',
		'Sass',
		'Scala',
		'Sql',
		'Vb',
		'Xml'
);


function efSyntaxhighlighter_Scripts() {
  global $wgPrettifyAdditionalLanguages;
  $scripts = array('init.js' , 'syntaxhighlighter_3.0.83/scripts/shCore.js');
  foreach ($wgPrettifyAdditionalLanguages as $language) {
    $scripts[] = "syntaxhighlighter_3/scripts/shBrush$language.js";
  }
  return $scripts;
}

/**
 * Register parser hook
 */
function efSyntaxhighlighter_Setup( &$parser ) {
    $parser->setHook('source', array('syntaxhighlighter', 'parserHook'));
  return true;
}

$wgExtensionCredits['other'][] = array(
  'path' => __FILE__,
  'name' => 'syntaxhighlighter',
  'author' => '[http://www.open-lib.com Open-Lib]',
  'url' => 'http://www.mediawiki.org/wiki/Extension:syntaxhighlighter',
  'version' => '0.1',
  'descriptionmsg' => 'syntaxhighlighter-description'
);

// Register parser hook
$wgHooks['ParserFirstCallInit'][] = 'efSyntaxhighlighter_Setup';
// Register before display hook
$wgHooks['BeforePageDisplay'][] = 'syntaxhighlighter::beforePageDisplay';

$wgResourceModules['ext.syntaxhighlighter'] = array(
  'localBasePath' => dirname(__FILE__),
  'remoteExtPath' => 'syntaxhighlighter',
  'styles' => array('syntaxhighlighter_3/styles/shCoreDefault.css'),
  'scripts' => efSyntaxhighlighter_Scripts()
);

