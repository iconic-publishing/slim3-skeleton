<?php

namespace Base\Controllers\Auth;

use Base\Helpers\Session;
use Base\Models\User\User;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Base\Validation\Forms\Auth\AuthForm;
use Psr\Http\Message\ServerRequestInterface;

class AuthLoginController extends BaseConstructor {

    public function getLogin(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/auth/login.php');
    }

    public function postLogin(ServerRequestInterface $request, ResponseInterface $response) {
        $validation = $this->validator->validate($request, AuthForm::loginRules());

        if($validation->fails()) {
            $this->flash->addMessage('error', $this->config->get('messages.login.error'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        $identifier = $request->getParam('email_or_username');
        $email_address = $request->getParam('email_address');
        $password = $request->getParam('password');

        $user = User::where(function($query) use ($identifier) {
            return $query->where('email_address', $identifier)->orWhere('username', $identifier);
        })->first();

        if($user->recover_hash) {
            $this->flash->addMessage('warning', $this->config->get('messages.login.passwordReset'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        if(!$user || !$this->hash->passwordCheck($password, $user->password)) {
            $this->flash->addMessage('error', $this->config->get('messages.login.notUser'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        if(!$user->active) {
            $this->flash->addMessage('warning', $this->config->get('messages.login.notActive'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        if($user->locked) {
            $this->flash->addMessage('warning', $this->config->get('messages.login.locked'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        if($user && $this->hash->passwordCheck($password, $user->password)) {
            Session::put('user', $user->id);

            $size = $this->config->get('auth.token');
            $token = $this->hash->hashed($size);
            $user->createLoginToken($token);

            if($this->auth->user()->isGroup()) {
                return $response->withRedirect($this->router->pathFor('admin', compact('token')));
            } else {
                return $response->withRedirect($this->router->pathFor('member', compact('token')));
            }
        } else {
            $this->flash->addMessage('warning', $this->config->get('messages.login.notActive'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }
    }

}

