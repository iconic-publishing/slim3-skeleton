<?php

namespace Base\Services\Mail;

use Base\Models\User\User;
use Base\Services\Mail\Mailer\Mailable;

class Activation extends Mailable {
	
    protected $user;
    protected $identifier;

    public function __construct(User $user, $identifier) {
        $this->user = $user;
        $this->identifier = $identifier;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Account Activation')
            ->view('includes/services/emails/activation.php')
            ->with([
                'user' => $this->user,
                'identifier' => $this->identifier
            ]);
    }
	
}