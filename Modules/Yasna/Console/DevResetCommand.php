<?php

namespace Modules\Yasna\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\Yasna\Entities\User;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DevResetCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "(Re)sets the developer's username / password.";

    /**
     * @var User
     */
    private $user;
    private $error_occured = false;
    private $new_password;
    private $new_username;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * @return bool|string
     */
    private function getDeveloperIdFromSetting()
    {
        return user()->getDeveloperId();
    }



    /**
     * @return int
     */
    private function getUserId()
    {
        $desired_id = $this->option('id');

        if ($desired_id == 'auto') {
            $desired_id = $this->getDeveloperIdFromSetting();
        }

        return intval($desired_id);
    }



    /**
     * @return \Modules\Yasna\Entities\User
     */
    private function selectUser()
    {
        $id   = $this->getUserId();
        $user = model('User', $id, true);

        if (!$user->exists) {
            $this->error("User Not Found.");
        }

        return $this->user = $user;
    }



    /**
     * @return bool
     */
    private function shiftDeveloperIfNecessary()
    {
        if ($this->error_occured) {
            return false;
        }
        if ($this->user->id == $this->getDeveloperIdFromSetting()) {
            return false;
        }

        $done = $this->user->markAsDeveloper();

        if (!$done) {
            $this->error("User not shifted!");
            return false;
        }

        return true;
    }



    private function checkInputs()
    {
        $this->new_username = $this->option('username');
        $this->new_password = $this->option('password');

        if ($this->new_password and $this->option('destroy')) {
            $this->error("You chose to destroy the developer account. What the hell is the 'password' then?");
        }

        if (!$this->new_password) {
            $this->new_password = str_random();
        }
    }



    /**
     * @return string
     */
    private function usernameField()
    {
        return user()->usernameField();
    }



    /**
     * Sets the username / password
     */
    private function updateUserRow()
    {
        $username_field         = $this->usernameField();
        $this->user->password   = Hash::make($this->new_password);
        $this->user->deleted_at = null;

        if ($this->new_username) {
            $this->user->$username_field = $this->new_username;
        }

        $updated = $this->user->save();

        if (!$updated) {
            $this->error("Whoops! Something went wrong. :(");
            return;
        }

        $this->info("Done :)");
        $this->info("Id:" . $this->user->id);
        $this->info("Username: " . $this->user->$username_field);
        $this->info("Password: " . $this->new_password);
    }



    /**
     * Destroys developer account if chosen by user.
     */
    private function destroyDeveloperIfNecessary()
    {
        if (!$this->option('destroy')) {
            return;
        }

        user()->removeDeveloper();
        $this->info('Got rid of the developer account.');
        die();
    }



    /**
     *
     */
    public function handle()
    {
        $this->checkInputs();
        $this->selectUser();

        if (!$this->error_occured) {
            $this->destroyDeveloperIfNecessary();
            $this->shiftDeveloperIfNecessary();
            $this->updateUserRow();
        }
    }



    /**
     * @param string $string
     * @param null   $verbosity
     */
    public function error($string, $verbosity = null)
    {
        $this->error_occured = true;
        parent::error("Error: " . $string, $verbosity);
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['new-password', InputArgument::OPTIONAL, 'New Password'],
        ];
    }



    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
             ['id', 'i', InputOption::VALUE_REQUIRED, 'Flag to shift active user to the designated id.', 'auto'],
             ['username', 'u', InputOption::VALUE_REQUIRED, 'Flag to update username as well.', null],
             ['destroy', 'd', InputOption::VALUE_NONE, "Flag to destroy the developer account", null],
             ['password', 'p', InputOption::VALUE_REQUIRED, "Flag to set a new password", null],
        ];
    }
}
