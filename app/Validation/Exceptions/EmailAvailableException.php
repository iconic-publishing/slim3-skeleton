<?php

namespace Base\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvailableException extends ValidationException {
	
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'That email address is already registered.',
        ],
    ];
	
}
