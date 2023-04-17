<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\JWTManager;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Config\AuthSession;

class LoginController extends BaseController
{
    use ResponseTrait;

    /**
     * Authenticate Existing User and Issue JWT.
     */
    public function jwtLogin(): ResponseInterface
    {
        // Get the validation rules
        $rules = $this->getValidationRules();

        // Validate credentials
        if (! $this->validateData($this->request->getPost(), $rules)) {
            return $this->failValidationErrors($this->validator->getErrors(), 422);
        }

        // Get the credentials for login
        $credentials             = $this->request->getPost(setting('Auth.validFields'));
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Check the credentials
        $result = $authenticator->check($credentials);
        if (! $result->isOK()) {
            // @TODO record a failed login attempt?

            return $this->failUnauthorized($result->reason());
        }

        // Login is successful.
        $user = $result->extraInfo();

        /** @var JWTManager $manager */
        $manager = service('jwtmanager');

        // Generate JWT and return to client
        $jwt = $manager->generateToken($user);

        return $this->respond([
            'message'      => 'User authenticated successfully',
            'user'         => $user,
            'access_token' => $jwt,
        ]);
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRules(): array
    {
        return setting('Validation.login') ?? [
            'email' => [
                'label' => 'Auth.email',
                'rules' => config(AuthSession::class)->emailValidationRules,
            ],
            'password' => [
                'label'  => 'Auth.password',
                'rules'  => 'required|' . Passwords::getMaxLenghtRule(),
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes',
                ],
            ],
        ];
    }
}
