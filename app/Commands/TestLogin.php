<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestLogin extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'test:login';

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
    protected $usage = 'test:login [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = ['user', 'password'];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {

        $user = $params[0];
        $password = $params[1];
        $credentials = [
            'email'    => $user,
            'password' => $password,
        ];

        CLI::write($password);

        try {
            CLI::write("try login");
            $loginAttempt = auth()->attempt($credentials);
            if (! $loginAttempt->isOK()) {
                CLI::write("failed credential error");
                return;
            }
            session_destroy();
        }catch (\Exception $e){
        }

        CLI::write("success");
    }
}
