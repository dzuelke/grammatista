<?php

/**
 * Main Grammatista class.
 *
 * @package    Grammatista
 *
 * @author     David Zülke <david.zuelke@bitextender.com>
 * @copyright  Bitextender GmbH
 *
 * @since      0.1.0
 *
 * @version    $Id$
 */
class Grammatista
{
	const VERSION_NUMBER = '0.1.1';
	const VERSION_STATUS = 'dev';
	
	/**
	 * @var        array An array of class names and file paths for autoloading.
	 */
	protected static $autoloads = array(
		'GrammatistaEntity'                   => 'Grammatista/Entity.class.php',
		'GrammatistaException'                => 'Grammatista/Exception.class.php',
		'GrammatistaLogger'                   => 'Grammatista/Logger.class.php',
		'GrammatistaLoggerShell'              => 'Grammatista/Logger/Shell.class.php',
		'GrammatistaParser'                   => 'Grammatista/Parser.class.php',
		'GrammatistaParserDwoo'               => 'Grammatista/Parser/Dwoo.class.php',
		'GrammatistaParserPcre'               => 'Grammatista/Parser/Pcre.class.php',
		'GrammatistaParserPcreSmarty'         => 'Grammatista/Parser/Pcre/Smarty.class.php',
		'GrammatistaParserPcreSmartySlv3'     => 'Grammatista/Parser/Pcre/Smarty/Slv3.class.php',
		'GrammatistaParserPhp'                => 'Grammatista/Parser/Php.class.php',
		'GrammatistaParserPhpAgavi'           => 'Grammatista/Parser/Php/Agavi.class.php',
		'GrammatistaParserXml'                => 'Grammatista/Parser/Xml.class.php',
		'GrammatistaParserXmlAgavi'           => 'Grammatista/Parser/Xml/Agavi.class.php',
		'GrammatistaParserXmlAgaviValidation' => 'Grammatista/Parser/Xml/Agavi/Validation.class.php',
		'GrammatistaScannerFilesystem'        => 'Grammatista/Scanner/Filesystem.class.php',
		'GrammatistaScannerFilesystemRecursivedirectoryiterator' => 'Grammatista/Scanner/Filesystem/Recursivedirectoryiterator.class.php',
		'GrammatistaStorage'                  => 'Grammatista/Storage.class.php',
		'GrammatistaStoragePdo'               => 'Grammatista/Storage/Pdo.class.php',
		'GrammatistaTranslatable'             => 'Grammatista/Translatable.class.php',
		'GrammatistaTranslatablePdo'          => 'Grammatista/Translatable/Pdo.class.php',
		'GrammatistaValueholder'              => 'Grammatista/Valueholder.class.php',
		'GrammatistaWarning'                  => 'Grammatista/Warning.class.php',
		'GrammatistaWriter'                   => 'Grammatista/Writer.class.php',
		'GrammatistaWriterFile'               => 'Grammatista/Writer/File.class.php',
		'GrammatistaWriterFileC'              => 'Grammatista/Writer/File/C.class.php',
		'GrammatistaWriterFilePo'             => 'Grammatista/Writer/File/Po.class.php',
		'IGrammatistaException'               => 'Grammatista/Exception.interface.php',
		'IGrammatistaLogger'                  => 'Grammatista/Logger.interface.php',
		'IGrammatistaParser'                  => 'Grammatista/Parser.interface.php',
		'IGrammatistaScanner'                 => 'Grammatista/Scanner.interface.php',
		'IGrammatistaStorage'                 => 'Grammatista/Storage.interface.php',
		'IGrammatistaWriter'                  => 'Grammatista/Writer.interface.php',
	);
	
	/**
	 * @var        array An array of registered parsers.
	 */
	protected static $parsers = array();
	
	/**
	 * @var        array An array of event responders.
	 */
	protected static $responders = array();
	
	/**
	 * @var        array An array of registered scanners.
	 */
	protected static $scanners = array();
	
	/**
	 * @var        IBabelcotStorage A storage.
	 */
	protected static $storage = null;
	
	/**
	 * @var        array An array of registered writers.
	 */
	protected static $writers = array();
	
	/**
	 * @var        string The base filesystem path to the Grammatista distribution.
	 */
	protected static $path = null;
	
	/**
	 * Grammatista autoloader.
	 *
	 * @param      string The name of the class to autoload.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function autoload($className)
	{
		if(isset(self::$autoloads[$className])) {
			require(self::$path . '/' . self::$autoloads[$className]);
		}
	}
	
	/**
	 * Main Grammatista initialization method.
	 *
	 * This sets up the base path and registers the autoloader.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function bootstrap()
	{
		// grab the base path where we are located
		self::$path = dirname(__FILE__);
		
		// and register our autoloader
		spl_autoload_register(array('Grammatista', 'autoload'));
	}
	
	/**
	 * Version information method.
	 *
	 * Returns version number along with the version status, if applicable.
	 *
	 * @return     string A version number, including status if applicable, e.g. "1.2.0-RC2".
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getVersionInfo()
	{
		$retval = self::VERSION_NUMBER;
		
		// only append a status (like "RC3") if it is set
		if(self::VERSION_STATUS !== null) {
			$retval .= '-' . self::VERSION_STATUS;
		}
		
		return $retval;
	}
	
	/**
	 * Full version information string method.
	 *
	 * Returns the product name and the version number along with the version status, if applicable.
	 *
	 * @return     string A full version string, example: "Grammatista/1.0.0".
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getVersionString()
	{
		// a slash is common, e.g. Apache/2.2.23 or PHP/5.2.4, so we do that too
		return 'Grammatista/' . self::getVersionInfo();
	}
	
	/**
	 * Register a parser.
	 *
	 * @param      string The name of the parser.
	 * @param      array  An associative array of information for this parser.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function registerParser($name, array $parserInfo)
	{
		if(!isset($parserInfo['class'])) {
			throw new GrammatistaException('No class name given in parser info for registerParser()');
		}
		
		if(!isset($parserInfo['options']) || !is_array($parserInfo['options'])) {
			$parserInfo['options'] = array();
		}
		
		self::$parsers[$name] = $parserInfo;
	}
	
	/**
	 * Unregister a previously registered parser.
	 *
	 * @param      string The extension of the parser to remove.
	 *
	 * @return     IGrammatistaParser The parser instance that was removed from the pool, or null if no parser for that extension was registered.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function unregisterParser($name)
	{
		if(isset(self::$parsers[$name])) {
			// remember the value we are about to remove...
			$retval = self::$parsers[$name];
			unset(self::$parsers[$name]);
			
			// ...and return it
			return $retval;
		}
	}
	
	/**
	 * Retrieve a registered parser instance.
	 *
	 * @param      string The extension of the parser.
	 *
	 * @return     IGrammatistaParser A parser instance, if found.
	 *
	 * @throws     IGrammatistaException If no parser for this extension was configured.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getParser($name)
	{
		if(isset(self::$parsers[$name])) {
			return self::$parsers[$name];
		} else {
			throw new GrammatistaException(sprintf('Parser "%s" not configured.', $name));
		}
	}
	
	public static function clearParsers()
	{
		self::$parsers = array();
	}
	
	/**
	 * Register a scanner.
	 *
	 * @param      string          The name of the scanner.
	 * @param      IGrammatistaScanner A scanner instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function registerScanner($name, IGrammatistaScanner $scanner)
	{
		self::$scanners[$name] = $scanner;
	}
	
	/**
	 * Unregister a previously registered scanner.
	 *
	 * @param      string The name of the scanner to remove.
	 *
	 * @return     IGrammatistaScanner The scanner instance that was removed from the pool, or null if no scanner was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function unregisterScanner($name)
	{
		if(isset(self::$scanners[$name])) {
			// remember the value we are about to remove...
			$retval = self::$scanners[$name];
			unset(self::$scanners[$name]);
			
			// ...and return it
			return $retval;
		}
	}
	
	/**
	 * Retrieve a registered scanner instance.
	 *
	 * @param      string The name of the scanner.
	 *
	 * @return     IGrammatistaScanner A scanner instance, if found.
	 *
	 * @throws     IGrammatistaException If no scanner of this name was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getScanner($name)
	{
		if(isset(self::$scanners[$name])) {
			return self::$scanners[$name];
		} else {
			throw new GrammatistaException(sprintf('Scanner "%s" not configured.', $name));
		}
	}
	
	public static function clearScanners()
	{
		self::$scanners = array();
	}
	
	/**
	 * Set the storage.
	 *
	 * @param      IGrammatistaStorage A storage instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function setStorage(IGrammatistaStorage $storage)
	{
		self::$storage = $storage;
	}
	
	/**
	 * Retrieve the storage instance.
	 *
	 * @return     IGrammatistaStorage The storage instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getStorage()
	{
		return self::$storage;
	}
	
	/**
	 * Register a writer.
	 *
	 * @param      string          The name of the writer.
	 * @param      IGrammatistaWriter A writer instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function registerWriter($name, IGrammatistaWriter $writer)
	{
		self::$writers[$name] = $writer;
	}
	
	/**
	 * Unregister a previously registered writer.
	 *
	 * @param      string The name of the writer to remove.
	 *
	 * @return     IGrammatistaWriter The writer instance that was removed from the pool, or null if no writer was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function unregisterWriter($name)
	{
		if(isset(self::$writers[$name])) {
			// remember the value we are about to remove...
			$retval = self::$writers[$name];
			unset(self::$writers[$name]);
			
			// ...and return it
			return $retval;
		}
	}
	
	/**
	 * Retrieve a registered writer instance.
	 *
	 * @param      string The name of the writer.
	 *
	 * @return     IGrammatistaWriter A writer instance, if found.
	 *
	 * @throws     IGrammatistaException If no writer of this name was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function getWriter($name)
	{
		if(isset(self::$writers[$name])) {
			return self::$writers[$name];
		} else {
			throw new GrammatistaException(sprintf('Writer "%s" not configured.', $name));
		}
	}
	
	public static function clearWriters()
	{
		self::$writers = array();
	}
	
	public static function registerEventResponder($pattern, $callback)
	{
		if(!isset(self::$responders[$pattern])) {
			self::$responders[$pattern] = array();
		}
		self::$responders[$pattern][] = $callback;
	}
	
	public static function dispatchEvent($name, array $arguments = array())
	{
		// no regex check against patterns yet :D
		
		if(isset(self::$responders[$name])) {
			foreach(self::$responders[$name] as $callback) {
				call_user_func($callback, $name, $arguments);
			}
		}
	}
	
	public static function doScanParseStore()
	{
		foreach(self::$scanners as $scanner) {
			foreach($scanner as $item) {
				foreach(self::$parsers as $parserName => $parserInfo) {
					$parser = new $parserInfo['class']($parserInfo['options']);
					if($parser->handles($item)) {
						foreach($parser->parse($item) as $translatable) {
							if(!isset($translatable->item_name)) {
								$translatable->item_name = $item->ident;
							}
							if(!isset($translatable->parser_name)) {
								$translatable->parser_name = $parserName;
							}
							if($translatable instanceof GrammatistaTranslatable && $translatable->isValid()) {
								self::$storage->writeTranslatable($translatable);
							} else {
								if($translatable instanceof GrammatistaTranslatable) {
									$translatable = new GrammatistaWarning($translatable->getArrayCopy());
								}
								self::$storage->writeWarning($translatable);
							}
						}
					}
					unset($parser);
				}
			}
		}
	}
}

?>