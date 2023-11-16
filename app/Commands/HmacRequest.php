<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class HmacRequest extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Hmac';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'hmac:request';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'hmac:request <key> <secret> <method> <url> <body>';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'key'    => 'Your key.',
        'secret' => 'Your secretKey.',
        'method' => 'HTTP mehod. E.g., GET, POST.',
        'url'    => 'Request URL.',
        'body'   => 'Request body.',
    ];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     */
    public function run(array $params)
    {
        if (count($params) !== 5) {
            CLI::error('Invalid arguments.');
            $this->showHelp();

            return EXIT_ERROR;
        }

        $key       = $params[0];
        $secretKey = $params[1];
        $method    = $params[2];
        $url       = $params[3];
        $body      = $params[4];

        $client = Services::curlrequest();

        $hashValue = hash_hmac('sha256', $body, $secretKey);

        $response = $client
            ->setHeader('Authorization', "HMAC-SHA256 {$key}:{$hashValue}")
            ->setBody($body)
            ->request($method, $url);

        CLI::write($response->getBody());

        return EXIT_SUCCESS;
    }
}
