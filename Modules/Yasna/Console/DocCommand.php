<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use ReflectionException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DocCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:doc {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reads PhpDoc.';

    /**
     * The Separator Between Name Parts
     *
     * @var string
     */
    protected $separator = '@';

    /**
     * The Found Items to get PhpDoc from
     *
     * @var array
     */
    protected $found_items = [];



    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProperties();
        $this->parseName();

        $this->showResult();
    }



    /**
     * Sets basic properties.
     */
    protected function setProperties()
    {
        $this->separator = ($this->option('separator') ?: $this->separator);
    }



    /**
     * Parses the given name.
     */
    protected function parseName()
    {
        $reflector_methods = $this->getReflectorMethods();

        foreach ($reflector_methods as $parser_method) {
            $this->$parser_method();
        }
    }



    /**
     * Returns and array of the reflector methods' name.
     *
     * @return array
     */
    protected function getReflectorMethods()
    {
        return array_filter(get_class_methods($this), function ($function_name) {
            return starts_with($function_name, 'reflect');
        });
    }



    /**
     * Reflects a method if possible.
     */
    protected function reflectMethod()
    {
        $name  = $this->argument('name');
        $parts = explode_not_empty($this->separator, $name);

        if (count($parts) == 2) {
            list($class, $method) = $parts;
            try {
                $preview_name = $class . '::' . $method . '()';
                $this->attachToFoundItems($preview_name, new ReflectionMethod($class, $method));
            } catch (ReflectionException $exception) {
                // Continue
            }
        }
    }



    /**
     * Reflects a property if possible.
     */
    protected function reflectProperty()
    {
        $name  = $this->argument('name');
        $parts = explode_not_empty($this->separator, $name);

        if (count($parts) == 2) {
            list($class, $property) = $parts;
            try {
                $preview_name = $class . '::$' . $property;
                $this->attachToFoundItems($preview_name, new ReflectionProperty($class, $property));
            } catch (ReflectionException $exception) {
                // Continue
            }
        }
    }



    /**
     * Reflects a class if possible.
     */
    protected function reflectClass()
    {

        $name  = $this->argument('name');
        $parts = explode_not_empty($this->separator, $name);

        if (count($parts) == 1) {
            $class = $parts[0];
            try {
                $this->attachToFoundItems($class, new ReflectionClass($class));
            } catch (ReflectionException $exception) {
                // Continue
            }
        }
    }



    /**
     * Reflects a helper if possible.
     */
    protected function reflectHelper()
    {
        $name  = $this->argument('name');
        $parts = explode_not_empty($this->separator, $name);

        if (count($parts) == 1) {
            $helper = $parts[0];
            try {
                $preview_name = $helper . '()';
                $this->attachToFoundItems($preview_name, new ReflectionFunction($helper));
            } catch (ReflectionException $exception) {
                // Continue
            }
        }
    }



    /**
     * Attach the given reflection with the given preview name to the found items.
     *
     * @param string                                                                 $preview_name
     * @param ReflectionMethod|ReflectionProperty|ReflectionClass|ReflectionFunction $reflection
     */
    protected function attachToFoundItems(string $preview_name, $reflection)
    {
        $this->found_items[] = [
             'preview_name' => $preview_name,
             'reflection'   => $reflection,
        ];
    }



    /**
     * Shows the result.
     */
    protected function showResult()
    {
        if (empty($this->found_items)) {
            $this->error("Unable to find PhpDoc for \"" . $this->argument('name') . "\"");
        } else {
            foreach ($this->found_items as $found_item) {
                $this->showFoundItem($found_item);
            }
        }
    }



    /**
     * Show result for the given found item.
     *
     * @param array $found_item
     */
    protected function showFoundItem(array $found_item)
    {
        $name       = $found_item['preview_name'];
        $reflection = $found_item['reflection'];

        $this->line($this->beautifyPhpDoc($name), 'fg=yellow');
        $this->showReflectionDoc($reflection);
    }



    /**
     * Show doc of the given reflection
     *
     * @param ReflectionMethod|ReflectionProperty|ReflectionClass|ReflectionFunction $reflection
     */
    protected function showReflectionDoc($reflection)
    {
        $doc = $reflection->getDocComment();

        if ($doc) {
            $this->line($this->beautifyPhpDoc($doc), 'fg=cyan');
        } else {
            $this->error('No PhpDoc yet.');
        }
    }



    /**
     * Reads and returns the PhpDoc of the target method.
     *
     * @param ReflectionMethod|ReflectionProperty|ReflectionClass|ReflectionFunction $reflection
     *
     * @return bool|string
     */
    protected function readMethodPhpDoc($reflection)
    {
        return $reflection->getDocComment();
    }



    /**
     * Beatifies the given doc string.
     *
     * @param string $doc
     *
     * @return string
     */
    protected function beautifyPhpDoc(string $doc)
    {
        return $this->docLinesMap($doc, 'ltrim');
    }



    /**
     * Maps lines of the givens string with the given callback.
     *
     * @param string   $doc
     * @param callback $callback
     *
     * @return string
     */
    protected function docLinesMap(string $doc, $callback)
    {
        $lines  = $this->getStringLines($doc);
        $mapped = array_map($callback, $lines);

        return implode(LINE_BREAK, $mapped);
    }



    /**
     * Returns an array of lines of the given string.
     *
     * @param string $string
     *
     * @return array[]|false|string[]
     */
    protected function getStringLines(string $string)
    {
        return preg_split("/[\r\n]+/", $string, -1, PREG_SPLIT_NO_EMPTY);
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
             ['name', InputArgument::REQUIRED, 'The string version of the target method.'],
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
             ['separator', 's', InputOption::VALUE_OPTIONAL, 'The separator between class name and method name.'],
        ];
    }
}
