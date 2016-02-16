<?php

use Grammatista\Grammatista;

error_reporting(E_ALL | E_STRICT);

require(__DIR__ . '/../vendor/autoload.php');

Grammatista::registerScanner('fs', new \Grammatista\Scanner\Filesystem(array(
	'filesystem.path' => realpath(dirname(__FILE__) . '/test1/'),
	'filesystem.skip_patterns' => array(
		'#/\.svn$#',
	)
)));

Grammatista::registerParser('agxml', array('class' => 'Grammatista\\Parser\\Xml\\Agavi\\Validation'));
Grammatista::registerParser('gettextphp', array('class' => 'Grammatista\\Parser\\Php\\Agavi'));
Grammatista::registerParser('agsmarty', array(
	'class' => 'Grammatista\\Parser\\Pcre\\Smarty',
	'options' => array(
		'pcre.comment_pattern' => '/\{\*\s*%s\s*(?P<comment>[^\*\}]+?)\s*\*\}(?!.*?\{trans[\s\}])/s',
		'pcre.patterns' => array(
			// '/\{trans(\s+(domain=(["\']?)(?P<domain>(?(3)((?!(?<!\\\\)\3).)*|[^\s\}]+))\3|[^\s\}"\'=]+=[^\s\}"\']+|[^\s\}=]+=(["\']?)(?(6)((?!(?<!\\\\)\6).)*|[^\s\}]+)\6))*\s*\}\s*(?P<subpattern>.+?)\s*\{\/trans\}/ms' => array( // best so far! doesn't handle domains without quotation marks yet
			'/\{trans(\s+(domain=(["\'])?(?P<domain>.*?(?(-2)(?=(?<!\\\\)\g{-2})|(?=[\s\}])))(?(-2)\g{-2})|[^\s\}=]+=(["\'])?.*?(?(-1)(?=(?<!\\\\)\g{-1})|(?=[\s\}]))(?(-1)\g{-1})))*\s*\}\s*(?P<subpattern>.+?)\s*\{\/trans\}/ms' => array( // best so far! doesn't handle domains without quotation marks yet
				'/(\s*\{singular\}(?P<singular_message>.+?)\{\/singular\}|\s*\{plural\}(?P<plural_message>.+?)\{\/plural\})+\s*/s' => true,
				'/(?P<singular_message>.+)/s' => true,

			),
			// '/[^\s\}=]+=(["\'])?(?P<singular_message>.*?(?(-2)(?=(?<!\\\\)\g{-2}\|)|(?=\|)))(?(-2)\g{-2})\|trans(?=[\s\}\:\|])(\:(["\'])?(?P<domain>.*?(?(-2)(?=(?<!\\\\)\g{-2})|(?=[\s\}"\'\:\|])))(?(-2)\g{-2}))?/' => true,
			'/[^\s\}="\']+=(["\'])?(?P<singular_message>[^"\']*?(?(-2)(?=(?<!\\\\)\g{-2}\|trans[\s\|\:\}])|(?=\|trans[\s\|\:\}])))(?(-2)\g{-2})\|trans(?=[\s\|\:\}])(\:(["\'])?(?P<domain>.*?(?(-2)(?=(?<!\\\\)\g{-2})|(?=[\s\}"\'\:])))(?(-2)\g{-2}))?/' => true,
		),
	),
));

Grammatista::setStorage(new \Grammatista\Storage\Pdo(array('pdo.dsn' => 'sqlite:' . dirname(__FILE__) . '/' . $_SERVER['REQUEST_TIME'] . '.sqlite')));

$logger = new \Grammatista\Logger\Shell();
Grammatista::registerEventResponder('grammatista.parser.parsed', array($logger, 'log'));
Grammatista::registerEventResponder('grammatista.storage.translatable.written', array($logger, 'log'));
Grammatista::registerEventResponder('grammatista.storage.warning.written', array($logger, 'log'));
Grammatista::registerEventResponder('grammatista.writer.written', array($logger, 'log'));

Grammatista::doScanParseStore();

$currentDomain = null;
foreach(Grammatista::getStorage()->readTranslatables() as $translatable) {
	if($translatable->domain != $currentDomain) {
		$currentDomain = $translatable->domain;

		// new writer
		$writer = new \Grammatista\Writer\File\Po(array(
			'file.basedir' => dirname(__FILE__) . '/' . $_SERVER['REQUEST_TIME'],
			'file.pattern' => $currentDomain . '.pot',
		));
	}

	$writer->writeTranslatable($translatable);
}

?>