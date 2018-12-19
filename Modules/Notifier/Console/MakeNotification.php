<?php

namespace Modules\Notifier\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeNotification extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-notification [class-name] [module-name]';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a ready-to-use notification class.';

    protected $module = false;
    protected $module_name;
    protected $class_name;



    /**
     * purify the class and module names, supplied from the command line.
     */
    protected function purifyInputs()
    {
        $this->class_name  = $this->argument('class_name');
        $this->module_name = $this->argument('module_name');

        $this->class_name  = studly_case($this->class_name);
        $this->module_name = studly_case($this->module_name);

        if ($this->class_name and !str_contains($this->class_name, 'Notification')) {
            $this->class_name .= "Notification";
        }

        $this->module = module($this->module_name);
    }



    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->purifyInputs();

        if (!$this->class_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-notification [class_name] [module_name]. Both are required.');
            return;
        }

        $this->makeFolder();
        $this->makeFile();
    }



    /**
     * make file
     */
    protected function makeFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->class_name . ".php";

        if (file_exists($path)) {
            $this->warn("File already exists!");
            return;
        }

        $file = fopen($path, 'w', true);
        fwrite($file, "<?php ");
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, "namespace " . str_after($this->module->namespace('Notifications'), "\\") . ";");
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, 'use Modules\Notifier\Notifications\YasnaNotificationAbstract;');
        fwrite($file, LINE_BREAK);
        fwrite($file, 'use Illuminate\Contracts\Queue\ShouldQueue;');
        fwrite($file, LINE_BREAK);
        fwrite($file, 'use Illuminate\Notifications\Messages\MailMessage;');
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);

        fwrite($file, "class $this->class_name extends YasnaNotificationAbstract implements ShouldQueue" . LINE_BREAK);
        fwrite($file, "{" . LINE_BREAK);

        fwrite($file, TAB . "/**" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* TODO: get the notification's delivery channels." . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @param mixed $notifiable' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* @return array" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*/" . LINE_BREAK);
        fwrite($file, TAB . 'public function via($notifiable)' . LINE_BREAK);
        fwrite($file, TAB . '{' . LINE_BREAK);
        fwrite($file, TAB . TAB . 'return [' . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . '$this->yasnaMailChannel(),' . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . '$this->yasnaSmsChannel(),' . LINE_BREAK);
        fwrite($file, TAB . TAB . '];' . LINE_BREAK);
        fwrite($file, TAB . '}' . LINE_BREAK);

        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);

        fwrite($file, TAB . "/**" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* TODO: get the mail representation of the notification." . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @param mixed $notifiable' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @return \Illuminate\Notifications\Messages\MailMessage' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*/" . LINE_BREAK);
        fwrite($file, TAB . 'public function toMail($notifiable)' . LINE_BREAK);
        fwrite($file, TAB . '{' . LINE_BREAK);
        fwrite($file, TAB . TAB . 'return (new MailMessage)' . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . "->subject('Folan Happened')" . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . "->greeting('Salam')" . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . "->line('The introduction to the notification.')" . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . "->action('Notification Action', 'https://yasna.team')" . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . "->line('Thank you for using our application!')" . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . SPACE . ";" . LINE_BREAK);
        fwrite($file, TAB . '}' . LINE_BREAK);

        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);

        fwrite($file, TAB . "/**" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* TODO: get the sms representation of the notification." . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @param mixed $notifiable' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @return string' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*/" . LINE_BREAK);
        fwrite($file, TAB . 'public function toSms($notifiable)' . LINE_BREAK);
        fwrite($file, TAB . '{' . LINE_BREAK);
        fwrite($file, TAB . TAB . 'return "jafar";' . LINE_BREAK);
        fwrite($file, TAB . '}' . LINE_BREAK);

        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);

        fwrite($file, TAB . "/**" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* TODO: get the array representation of the notification." . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @param mixed $notifiable' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @return array' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*/" . LINE_BREAK);
        fwrite($file, TAB . 'public function toArray($notifiable)' . LINE_BREAK);
        fwrite($file, TAB . '{' . LINE_BREAK);
        fwrite($file, TAB . TAB . 'return [' . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . '//' . LINE_BREAK);
        fwrite($file, TAB . TAB . '];' . LINE_BREAK);
        fwrite($file, TAB . '}' . LINE_BREAK);

        fwrite($file, "}" . LINE_BREAK);

        fclose($file);

        $this->info("$path is created!");
    }



    /**
     * make the required folder
     */
    protected function makeFolder()
    {
        $path = $this->folderPath();
        if (!is_dir($path)) {
            mkdir($path);
            $this->line("Made folder...");
        }
    }



    /**
     * get the required folder path
     *
     * @return string
     */
    protected function folderPath()
    {
        return $this->module->getPath('Notifications');
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
             ['class_name', InputArgument::OPTIONAL, 'Notification Class Name'],
             ['module_name', InputArgument::OPTIONAL, 'Module Name'],
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
        ];
    }
}
