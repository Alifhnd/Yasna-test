<?php namespace Modules\Yasna\Services;

use Illuminate\Console\Scheduling\CallbackEvent;
use ReflectionClass;

class YasnaSchedule
{
    private $schedule;
    private $callback_event;

    protected $without_overlapping = false;



    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }



    /**
     * Handle Schedule
     */
    public function handle()
    {
        $func                = 'job';
        $frequency           = str_before($this->frequency(), ':');
        $frequency_switches  = explode(',', str_after($this->frequency(), ':'));
        $additional          = str_before($this->additional(), ':');
        $additional_switches = explode(',', str_after($this->additional(), ':'));

        $this->callback_event = $this->schedule->call(function () use ($func) {
            $this->$func();
        })
                                               ->$frequency(... $frequency_switches)
                                               ->$additional(... $additional_switches)
                                               ->name($this->getName())
                                               ->when($this->condition())
        ;

        if ($this->withoutOverlapping()) {
            $this->callback_event->withoutOverlapping();
        }

        $this->customHandle();

        //<~~ Override handle() method, if you need more options.
    }



    /**
     * Custom Handle for Additional Options
     */
    protected function customHandle()
    {
        //<~~ Override customHandle() method, if you need more options.
    }



    /**
     * @return string
     */
    protected function frequency()
    {
        return 'dailyAt:2:00';
    }



    /**
     * @return string
     */
    protected function additional()
    {
        return 'between:0:00,23:59';
    }



    /**
     * @return bool
     */
    protected function condition()
    {
        return true;
    }



    /**
     * @return bool
     */
    protected function withoutOverlapping()
    {
        return $this->without_overlapping;
    }



    /**
     * @return string
     */
    protected function getName()
    {
        return property_exists($this, 'name') ? $this->name : $this->generateName();
    }



    /**
     * @return string
     */
    protected function generateName()
    {
        return kebab_case($this->moduleName())
             . '-'
             . kebab_case((new ReflectionClass($this))->getShortName());
    }



    /**
     * @return string
     */
    protected function moduleName()
    {
        $name  = get_class($this);
        $array = explode("\\", $name);

        if (array_first($array) == 'Modules') {
            return $array[1];
        }

        return null;
    }



    /**
     * @return CallbackEvent
     */
    protected function callbackEvent()
    {
        return $this->callback_event;
    }
}
