<?php

class GrammatistaParserPhpAgavi extends GrammatistaParserPhp
{
	public function __construct(array $options = array())
	{
		$this->options = array(
			'php.patterns' => array(
				
				'$tm->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->__(declare(singular_message), declare(plural_message), declare(amount))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$translationManager->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->__(declare(singular_message), declare(plural_message), declare(amount))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'getTranslationManager()->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->__(declare(singular_message), declare(plural_message), declare(amount))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$this->tm->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->__(declare(singular_message), declare(plural_message), declare(amount))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->_(array(declare(singular_message), declare(plural_message), declare(amount)))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$translationManager->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->_(array(declare(singular_message), declare(plural_message), declare(amount)))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'getTranslationManager()->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->_(array(declare(singular_message), declare(plural_message), declare(amount)))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$this->tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->_(array(declare(singular_message), declare(plural_message), declare(amount)))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'amount' => null, // any
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$tm->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->_(declare(singular_message))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$translationManager->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->_(declare(singular_message))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'getTranslationManager()->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->_(declare(singular_message))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				
				'$this->tm->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->_(declare(singular_message))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
							T_DNUMBER,
							T_LNUMBER,
						),
						'domain' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
			),
		);
		
		parent::__construct($options);
	}
}

?>