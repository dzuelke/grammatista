<?php

namespace Grammatista\Parser\Php;

use Grammatista\Parser\Php;

class Agavi extends Php
{
	/**
	 * Constructor. Accepts an array of options.
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @since      0.1.0
	 */
	public function __construct(array $options = array())
	{
		$this->options = array(
			'php.patterns' => array(

				'$tm->__(declare(singular_message), declare(plural_message), declare(amount))' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$tm->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$tm->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$translationManager->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$translationManager->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'getTranslationManager()->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'getTranslationManager()->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$this->tm->__(declare(singular_message), declare(plural_message), declare(amount), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$this->tm->__(declare(singular_message), declare(plural_message), declare(amount), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$translationManager->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$translationManager->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'getTranslationManager()->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'getTranslationManager()->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$this->tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
					),
				),
				'$this->tm->_(array(declare(singular_message), declare(plural_message), declare(amount)), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'plural_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
						'amount' => null, // any
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
						),
					),
				),
				'$tm->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$tm->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
					),
				),
				'$translationManager->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$translationManager->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
					),
				),
				'getTranslationManager()->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'getTranslationManager()->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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
						),
					),
				),
				'$this->tm->_(declare(singular_message), null' => array(
					'warn' => true,
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
						),
					),
				),
				'$this->tm->_(declare(singular_message), declare(domain)' => array(
					'placeholders' => array(
						'singular_message' => array(
							T_CONSTANT_ENCAPSED_STRING,
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