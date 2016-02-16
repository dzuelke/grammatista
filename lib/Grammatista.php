<?php

namespace Grammatista;

/**
 * Main Grammatista class.
 *
 * @package    Grammatista
 *
 * @author     David Zülke <dzuelke@gmail.com>
 * @author     Dominik del Bondio <ddb@bitextender.com>
 * @copyright  Bitextender GmbH
 *
 * @since      0.1.0
 *
 * @version    $Id$
 */
class Grammatista
{
	const VERSION_NUMBER = '0.2.0';
	const VERSION_STATUS = 'dev';

	/**
	 * @var        ParserInterface[] An array of registered parsers.
	 */
	protected static $parsers = array();

	/**
	 * @var        callable[] An array of event responders.
	 */
	protected static $responders = array();

	/**
	 * @var        ScannerInterface[] An array of registered scanners.
	 */
	protected static $scanners = array();

	/**
	 * @var        StorageInterface A storage.
	 */
	protected static $storage = null;

	/**
	 * @var        WriterInterface[] An array of registered writers.
	 */
	protected static $writers = array();

	/**
	 * Version information method.
	 *
	 * Returns version number along with the version status, if applicable.
	 *
	 * @return     string A version number, including status if applicable, e.g. "1.2.0-RC2".
	 *
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
	 * @param      string $name       The name of the parser.
	 * @param      array  $parserInfo An associative array of information for this parser.
	 *
	 * @throws     Exception If no class info was given in $parserInfo.
	 *
	 * @since      0.1.0
	 */
	public static function registerParser($name, array $parserInfo)
	{
		if(!isset($parserInfo['class'])) {
			throw new Exception('No class name given in parser info for registerParser()');
		}

		if(!isset($parserInfo['options']) || !is_array($parserInfo['options'])) {
			$parserInfo['options'] = array();
		}

		self::$parsers[$name] = $parserInfo;
	}

	/**
	 * Unregister a previously registered parser.
	 *
	 * @param      string $name The extension of the parser to remove.
	 *
	 * @return     ParserInterface|null The parser instance that was removed from the pool, or null if no parser for that extension was registered.
	 *
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

		return null;
	}

	/**
	 * Retrieve a registered parser instance.
	 *
	 * @param      string $name The extension of the parser.
	 *
	 * @return     ParserInterface A parser instance, if found.
	 *
	 * @throws     Exception If no parser for this extension was configured.
	 *
	 * @since      0.1.0
	 */
	public static function getParser($name)
	{
		if(isset(self::$parsers[$name])) {
			return self::$parsers[$name];
		} else {
			throw new Exception(sprintf('Parser "%s" not configured.', $name));
		}
	}

	public static function clearParsers()
	{
		self::$parsers = array();
	}

	/**
	 * Register a scanner.
	 *
	 * @param      string           $name    The name of the scanner.
	 * @param      ScannerInterface $scanner A scanner instance.
	 *
	 * @since      0.1.0
	 */
	public static function registerScanner($name, ScannerInterface $scanner)
	{
		self::$scanners[$name] = $scanner;
	}

	/**
	 * Unregister a previously registered scanner.
	 *
	 * @param      string $name The name of the scanner to remove.
	 *
	 * @return     ScannerInterface|null The scanner instance that was removed from the pool, or null if no scanner was found.
	 *
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

		return null;
	}

	/**
	 * Retrieve a registered scanner instance.
	 *
	 * @param      string $name The name of the scanner.
	 *
	 * @return     ScannerInterface A scanner instance, if found.
	 *
	 * @throws     Exception If no scanner of this name was found.
	 *
	 * @since      0.1.0
	 */
	public static function getScanner($name)
	{
		if(isset(self::$scanners[$name])) {
			return self::$scanners[$name];
		} else {
			throw new Exception(sprintf('Scanner "%s" not configured.', $name));
		}
	}

	/**
	 * Remove all registered scanner instances.
	 *
	 * @since      0.1.0
	 */
	public static function clearScanners()
	{
		self::$scanners = array();
	}

	/**
	 * Set the storage.
	 *
	 * @param      StorageInterface $storage A storage instance.
	 *
	 * @since      0.1.0
	 */
	public static function setStorage(StorageInterface $storage)
	{
		self::$storage = $storage;
	}

	/**
	 * Retrieve the storage instance.
	 *
	 * @return     StorageInterface The storage instance.
	 *
	 * @since      0.1.0
	 */
	public static function getStorage()
	{
		return self::$storage;
	}

	/**
	 * Register a writer.
	 *
	 * @param      string          $name   The name of the writer.
	 * @param      WriterInterface $writer A writer instance.
	 *
	 * @since      0.1.0
	 */
	public static function registerWriter($name, WriterInterface $writer)
	{
		self::$writers[$name] = $writer;
	}

	/**
	 * Unregister a previously registered writer.
	 *
	 * @param      string $name The name of the writer to remove.
	 *
	 * @return     WriterInterface|null The writer instance that was removed from the pool, or null if no writer was found.
	 *
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

		return null;
	}

	/**
	 * Retrieve a registered writer instance.
	 *
	 * @param      string $name The name of the writer.
	 *
	 * @return     WriterInterface A writer instance, if found.
	 *
	 * @throws     Exception If no writer of this name was found.
	 *
	 * @since      0.1.0
	 */
	public static function getWriter($name)
	{
		if(isset(self::$writers[$name])) {
			return self::$writers[$name];
		} else {
			throw new Exception(sprintf('Writer "%s" not configured.', $name));
		}
	}

	/**
	 * Remove all registered writer instances.
	 *
	 * @since      0.1.0
	 */
	public static function clearWriters()
	{
		self::$writers = array();
	}

	/**
	 * Register an event handler.
	 *
	 * @param      string   $pattern The event name.
	 * @param      callable $callback The event handler.
	 *
	 * @since      0.1.0
	 */
	public static function registerEventResponder($pattern, $callback)
	{
		if(!isset(self::$responders[$pattern])) {
			self::$responders[$pattern] = array();
		}
		self::$responders[$pattern][] = $callback;
	}

	/**
	 * Dispatch an event.
	 *
	 * @param      string  $name      The event name.
	 * @param      mixed[] $arguments The event arguments.
	 *
	 * @since      0.1.0
	 */
	public static function dispatchEvent($name, array $arguments = array())
	{
		// no regex check against patterns yet :D

		if(isset(self::$responders[$name])) {
			foreach(self::$responders[$name] as $callback) {
				call_user_func($callback, $name, $arguments);
			}
		}
	}

	/**
	 * Parse and store the translations.
	 *
	 * @since      0.1.0
	 */
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
							if($translatable instanceof Translatable && $translatable->isValid()) {
								self::$storage->writeTranslatable($translatable);
							} else {
								if($translatable instanceof Translatable) {
									$translatable = new Warning($translatable->getArrayCopy());
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