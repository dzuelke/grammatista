<?php

namespace Grammatista;

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
	 * @throws     IException If no class info was given in $parserInfo.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	 * @param      string The extension of the parser to remove.
	 *
	 * @return     IParser The parser instance that was removed from the pool, or null if no parser for that extension was registered.
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
	 * @return     IParser A parser instance, if found.
	 *
	 * @throws     Exception If no parser for this extension was configured.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	 * @param      string           The name of the scanner.
	 * @param      IScanner A scanner instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function registerScanner($name, IScanner $scanner)
	{
		self::$scanners[$name] = $scanner;
	}

	/**
	 * Unregister a previously registered scanner.
	 *
	 * @param      string The name of the scanner to remove.
	 *
	 * @return     IScanner The scanner instance that was removed from the pool, or null if no scanner was found.
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
	 * @return     IScanner A scanner instance, if found.
	 *
	 * @throws     Exception If no scanner of this name was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function clearScanners()
	{
		self::$scanners = array();
	}

	/**
	 * Set the storage.
	 *
	 * @param      IStorage A storage instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function setStorage(IStorage $storage)
	{
		self::$storage = $storage;
	}

	/**
	 * Retrieve the storage instance.
	 *
	 * @return     IStorage The storage instance.
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
	 * @param      string  The name of the writer.
	 * @param      IWriter A writer instance.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function registerWriter($name, IWriter $writer)
	{
		self::$writers[$name] = $writer;
	}

	/**
	 * Unregister a previously registered writer.
	 *
	 * @param      string The name of the writer to remove.
	 *
	 * @return     IWriter The writer instance that was removed from the pool, or null if no writer was found.
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
	 * @return     IWriter A writer instance, if found.
	 *
	 * @throws     Exception If no writer of this name was found.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public static function clearWriters()
	{
		self::$writers = array();
	}

	public static function registerEventResponder($pattern, $callback)
	/**
	 * Register an event handler.
	 *
	 * @param      string   The event name.
	 * @param      callable The event handler.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	{
		if(!isset(self::$responders[$pattern])) {
			self::$responders[$pattern] = array();
		}
		self::$responders[$pattern][] = $callback;
	}

	/**
	 * Dispatch an event.
	 *
	 * @param      string  The event name.
	 * @param      mixed[] The event arguments.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	 * @author     David Zülke <david.zuelke@bitextender.com>
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