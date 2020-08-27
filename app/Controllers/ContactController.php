<?php

namespace Base\Controllers;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Helpers\Session;
use Base\Services\Mail\Contact;
use Base\Constructor\BaseConstructor;
use Base\Validation\Forms\ContactForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends BaseConstructor {
	
    public function contact(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'contact/contact.php');
    }
	
    public function contactSubmit(ServerRequestInterface $request, ResponseInterface $response) {
        $validation = $this->validator->validate($request, ContactForm::contactRules());

        if($validation->fails()) {
            $this->flash->addMessage('error', $this->config->get('messages.contact.error'));
            return $response->withRedirect($this->router->pathFor('contact'));
        }

        $recaptcha = new ReCaptcha($this->config->get('recaptcha.secretKey'));
        $resp = $recaptcha->verify($request->getParam('g-recaptcha-response', Filter::ip()));

        if($resp->isSuccess()) {
            $data = [
                'first_name' => ucwords(strtolower($request->getParam('first_name'))),
                'last_name' => ucwords(strtolower($request->getParam('last_name'))),
                'email_address' => $request->getParam('email_address'),
                'mobile_number' => $request->getParam('mobile_number'),
                'country' => $request->getParam('country'),
                'department' => $request->getParam('department'),
                'subject' => ucwords(strtolower($request->getParam('subject'))),
                'message' => ucfirst($request->getParam('message')),
                'gdpr' => ($request->getParam('gdpr') === 'on') ? true : false
            ];

            $this->mail->to($this->config->get('company.contactFormEmail'), $this->config->get('mail.from.name'))->send(new Contact($data));

            /*
            Send Twilio SMS here if so required
            $number = $request->getParam('mobile_number'); // If sending to User
            */
            $number = $this->config->get('twilio.companyNumber'); // If sending to you or your company
            $body = $this->view->fetch('includes/services/sms/contact.php', compact('data'));
            $this->sms->send($number, $body);

            /*
            Subcribe to MailChimp here if so required
            */
            /*
            if($data['gdpr'] === true) {
                $status = 'subscribed';
                $this->mailchimp->subscribe($data['email_address'], $data['first_name'], $status);
            }
            */

            Session::delete('old');

            $this->flash->addMessage('success', $this->config->get('messages.contact.success'));
            return $response->withRedirect($this->router->pathFor('contact'));
			
        } else if($resp->getErrorCodes()) {
            $this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
            return $response->withRedirect($this->router->pathFor('contact'));
        }
    }
	
}
