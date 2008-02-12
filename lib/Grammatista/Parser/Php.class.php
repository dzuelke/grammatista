<?php

abstract class GrammatistaParserPhp extends GrammatistaParser
{
	const T_PLACEHOLDER = 1202226086;
	
	const PATTERN_TYPE_SINGULAR = 'singular';
	const PATTERN_TYPE_PLURAL = 'plural';
	const PATTERN_TYPE_WARNING = 'warning';
	
	protected $patterns = array();
	
	public function __construct(array $options = array())
	{
		parent::__construct($options);
		
		foreach($this->options['php.patterns'] as $pattern => $info) {
			$this->patterns[$pattern] = $info + array(
				'tokens' => $this->parsePattern($pattern),
				'warn' => false,
			);
		}
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		return $entity->type == 'php';
	}
	
	protected function parsePattern($pattern)
	{
		$tokens = $this->tokenize('<?php ' . $pattern);
		
		$retval = array();
		
		for($i = 0; $i < count($tokens); $i++) {
			if(
				is_array($tokens[$i]) && 
				$tokens[$i][0] == T_DECLARE && 
				isset($tokens[$i+1]) && $tokens[$i+1] === '(' && 
				isset($tokens[$i+2]) && is_array($tokens[$i+2]) && $tokens[$i+2][0] == T_STRING && 
				isset($tokens[$i+3]) && $tokens[$i+3] === ')' 
			) {
				$retval[] = array(0 => self::T_PLACEHOLDER, 1 => $tokens[$i+2][1], 2 => $tokens[$i+2][2]);
				$i += 3;
			} else {
				$retval[] = $tokens[$i];
			}
		}
		
		return $retval;
	}
	
	protected function tokenize($source)
	{
		$tokens = array();
		
		$i = 0;
		foreach(token_get_all($source) as $token) {
			$i++;
			if(is_array($token)) {
				switch($token[0]) {
					
					case T_COMMENT:
						$translationComment = preg_match('/^((\/\*+)|#+|\/{2,})\s*' . preg_quote($this->options['comment_prefix']) . '\s*(.+)\s*(?(2)\*\/)$/ms', $token[1], $matches);
						
						if(!$translationComment) {
							continue 2;
						} else {
							$token[1] = $matches[3];
							break;
						}
						
					case T_WHITESPACE:
					case T_INLINE_HTML:
					case T_OPEN_TAG:
					case T_CLOSE_TAG:
						continue 2;
						break;
				}
			} else {
				// no array, which means it's a simple character token, such as comma or braces. we combine a sequence of those into one item, because that potentially makes it easier to detect certain imbalances
				if(isset($tokens[$i-1]) && !is_array($tokens[$i-1])) {
					$tokens[--$i] .= $token;
				}
			}
			$tokens[] = $token;
		}
		
		return $tokens;
	}
	
	protected function decodeToken(array $token)
	{
		switch($token[0]) {
			case T_CONSTANT_ENCAPSED_STRING:
				return eval('return ' . $token[1] . ';');
			default:
				return var_export($token[1], true);
		}
	}
	
	protected function findBalance(array $tokens, $index, $lastInPattern = false)
	{
		$balance = 0;
		
		for($i = $index; $i < count($tokens); $i++) {
			if($lastInPattern && ($tokens[$i] == ',' || $tokens[$i] == ')')) {
				break;
			}
			if($tokens[$i] == ',' && $balance == 0) {
				break;
			}
			
			switch($tokens[$i]) {
				case '(':
				case '{':
					$balance++;
					break;
				case ')':
				case '}':
					$balance--;
					break;
			}
			
			if($balance < 0) {
				$balance = 0;
				break;
			}
		}
		
		// var_dump('<imbalance>', $imbalance, $i, $index, '</imbalance>');
		
		if($balance != 0) {
			throw new GrammatistaException('Unbalanced expression');
		} else {
			return $i - $index;
		}
	}
	
	protected function compareToken(array $tokens, $index)
	{
		foreach($this->patterns as $string => $pattern) {
			$i = $index;
			
			for($j = 0; $j < count($pattern['tokens']); $j++) {
				
				if(is_array($pattern['tokens'][$j]) && $pattern['tokens'][$j][0] == self::T_PLACEHOLDER) {
					// var_dump('comparing:', $tokens[$i + $j], $pattern['tokens'][$j]);
					// var_dump('placeholder "' . $pattern['tokens'][$j][1] . '"! woot! checking balance...');
					// a placeholder. continue until we have a balanced set of parentheses
					try {
						$skip = $this->findBalance($tokens, $i + $j, $j == (count($pattern['tokens']) - 1));
					} catch(GrammatistaException $e) {
						var_dump('imbalance. aborting...');
						// TODO: handle this. doesn't ever happen so far.
					}
					// if($skip > 1 || !is_array($tokens[$i + $j]) || !in_array($tokens[$i + $j][0], array(T_CONSTANT_ENCAPSED_STRING, T_DNUMBER, T_LNUMBER))) {
					// if($skip > 1 || !is_array($tokens[$i + $j]) || (is_array($pattern['placeholders'][$pattern['tokens'][$j][1]]) && !in_array($tokens[$i + $j][0], $pattern['placeholders'][$pattern['tokens'][$j][1]]))) {
					// 	var_dump("no encapsed string. aborting:", $tokens[$i + $j], $skip);
					// 	continue 2;
					// }
					// var_dump('next:', $tokens[$i + $j + $skip], $pattern['tokens'][$j + $skip]);
					$i += $skip - 1;
					continue;
					// $j++;
					// var_dump($skip);
					// var_dump($tokens[$i + $j], $tokens[$i + $j + $skip]);
				}
				
				if(!isset($tokens[$i + $j])) {
					continue 2;
				}
				if(gettype($tokens[$i + $j]) != gettype($pattern['tokens'][$j])) {
					continue 2;
				}
				if(!is_array($tokens[$i + $j]) && $tokens[$i + $j] != $pattern['tokens'][$j]) {
					continue 2;
				}
				if(is_array($tokens[$i + $j]) && $tokens[$i + $j][0] != $pattern['tokens'][$j][0]) {
					continue 2;
				}
				if(is_array($tokens[$i + $j]) && $tokens[$i + $j][1] != $pattern['tokens'][$j][1]) {
					continue 2;
				}
			}
			
			return $string;
		}
		
		return false;
	}
	
	public function extractInfo(array $tokens, $i, $pattern)
	{
		$info = array();
		
		for($j = 0; $j < count($pattern['tokens']); $j++) {
			if(is_array($pattern['tokens'][$j]) && $pattern['tokens'][$j][0] == self::T_PLACEHOLDER) {
				// var_dump('placeholder "' . $pattern['tokens'][$j][1] . '"! woot! checking balance...');
				// a placeholder. continue until we have a balanced set of parentheses
				try {
					$skip = $this->findBalance($tokens, $i + $j, $j == (count($pattern['tokens']) - 1));
				} catch(GrammatistaException $e) {
					var_dump('imbalance. aborting...');
					// TODO: handle this. doesn't ever happen so far.
				}
				// var_dump($tokens[$i + $j], $tokens[$i + $j + $skip]);
				$valid = true;
				if($skip > 1 || !is_array($tokens[$i + $j]) || (is_array($pattern['placeholders'][$pattern['tokens'][$j][1]]) && !in_array($tokens[$i + $j][0], $pattern['placeholders'][$pattern['tokens'][$j][1]]))) {
					// todo: throw warning
					$valid = false;
					break;
					// die('omg');
				} elseif($pattern['placeholders'][$pattern['tokens'][$j][1]] !== null) {
					// okay, so the argument is valid, but we need to skip it! (e.g. an amount where anything, like $count, is allowed)
					$info[$pattern['tokens'][$j][1]] = $this->decodeToken($tokens[$i + $j]);
				}
				$j += $skip;
				// var_dump($skip);
			}
		}
		
		$info = array(
			'singular_message' => isset($info['singular_message']) ? $info['singular_message'] : null,
			'plural_message' => isset($info['plural_message']) ? $info['plural_message'] : null,
			'line' => (int)$tokens[$i][2],
			'domain' => isset($info['domain']) ? $info['domain'] : null,
		);
		
		if($valid && !$pattern['warn']) {
			return new GrammatistaTranslatable($info);
		} else {
			return new GrammatistaWarning($info);
		}
		
		// "decode" all values
		foreach($info as $key => $value) {
			$info[$key] = eval('return ' . $value . ';');
		}
		
		// var_dump('LOLZ', $info, 'LOLZ');
		
		return $info;
	}
	
	public function parse(GrammatistaEntity $entity)
	{
		$retval = array();
		
		$tokens = $this->tokenize($entity->content);
		
		$lastComment = null;
		
		for($i = 0; $i < count($tokens); $i++) {
			
			if(isset($tokens[$i][0]) && $tokens[$i][0] == T_COMMENT) {
				// comment? remember it
				$lastComment = $tokens[$i][1];
			}
			
			// check if token (and those following) match one of the patterns
			if(($pattern = $this->compareToken($tokens, $i)) !== false) {
				$info = $this->extractInfo($tokens, $i, $this->patterns[$pattern]);
				$info->comment = $lastComment ? $lastComment : null;
				
				$retval[] = $info;
				
				// $retval[] = new GrammatistaTranslatable(array(
				// 	'singular_message' => $info['singular_message'],
				// 	'plural_message' => isset($info['plural_message']) ? $info['plural_message'] : null,
				// 	'line' => $info['line'] ? (int)$info['line'] : null,
				// 	'comment' => $lastComment ? $lastComment : null,
				// 	'domain' => $info['domain'],
				// ));
				
				// and reset the last comment
				$lastComment = null;
			}
			// // check if token (and those following) match one of the patterns
			// if(($info = $this->compareAndExtract($tokens, $i)) !== null) {
			// 	$retval[] = new GrammatistaTranslatable(array(
			// 		'singular_message' => $info['singular_message'],
			// 		'plural_message' => isset($info['plural_message']) ? $info['plural_message'] : null,
			// 		'line' => $info['line'] ? (int)$info['line'] : null,
			// 		'comment' => $lastComment ? $lastComment : null,
			// 		'domain' => $info['domain'],
			// 	));
			// 	
			// 	// and reset the last comment
			// 	$lastComment = null;
			// }
		}
		
		Grammatista::dispatchEvent('grammatista.parser.parsed');
		
		return $retval;
	}
}

?>