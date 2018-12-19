<?php
namespace Modules\Yasna\Services\ModuleTraits;

use Illuminate\Support\Facades\View;

trait ServicesTrait
{
    protected static $services;
    protected static $registered_services = [];

    protected $current_service;
    protected $current_key;
    protected $bypass_conditions = false;



    /*
    |--------------------------------------------------------------------------
    | General Inquery
    |--------------------------------------------------------------------------
    |
    */

    public function services()
    {
        /*-----------------------------------------------
        | Statically Called ...
        */
        if ($this->static()) {
            $result = [];
            $i      = 1;
            foreach ($this->list() as $module_name) {
                foreach (module($module_name)->services() as $service_name) {
                    $result[$i] = "$module_name:$service_name";
                    $i++;
                }
            }

            return $result;
        }


        /*-----------------------------------------------
        | Dynamic ...
        */
        $result = [];
        foreach ($this->registeredKeys() as $service) {
            $module_name  = str_before($service, ':');
            $service_name = str_after($service, ':');
            if ($module_name != $this->name) {
                continue;
            }

            $count = module($module_name)->service($service_name)->count();

            $result[] = "$service_name ($count)";
        }

        return $result;
    }



    public function rawServices()
    {
        return self::$services;
    }



    /*
    |--------------------------------------------------------------------------
    | Registry
    |--------------------------------------------------------------------------
    |
    */
    public function isRegistered()
    {
        $needle = "$this->name:$this->current_service";

        return in_array($needle, $this->registeredKeys());
    }



    public function registeredKeys()
    {
        return array_keys(self::$registered_services);
    }



    public function registered()
    {
        $array = [];

        foreach (self::$registered_services as $key => $service) {
            if (!$this->static() and $this->name != $service['module_name']) {
                continue;
            }
            self::$registered_services[$key]['usages'] = service($key)->count();
            $array[]                                   = self::$registered_services[$key];
        }

        $array = array_sort($array, function ($value) {
            return $value['service_name'];
        });

        return $array;
    }



    public function unregistered()
    {
        $return = [];

        /*-----------------------------------------------
        | Static Calls ...
        */
        if ($this->static()) {
            foreach ($this->rawServices() as $module_name => $service) {
                $return[] = module($module_name)->unregistered();
            }

            return array_flatten($return);
        }

        /*-----------------------------------------------
        | Dynamic Calls ...
        */
        if (!isset($this->rawServices()[$this->name])) {
            return [];
        }
        foreach ($this->rawServices()[$this->name] as $service_name => $service) {
            $needle = "$this->name:$service_name";
            if (!service($needle)->isRegistered()) {
                $return[] = $needle;
            }
        }

        return $return;
    }



    public function register($service = null, $comment = null)
    {
        /*-----------------------------------------------
        | If Input Argument is filled ...
        */
        if (isset($service)) {
            if (str_contains($service, ":")) {
                return service($service)->register(null, $comment);
            } else {
                return $this->service($service)->register(null, $comment);
            }
        }

        /*-----------------------------------------------
        | Normal Action ...
        */
        $slug = "$this->name:$this->current_service";

        self::$registered_services[$slug] = [
             'module_name'  => $this->name,
             'service_name' => $this->current_service,
             'comment'      => $comment,
             'usages'       => 0,
        ];

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    |
    */
    public function service($service_name)
    {
        $this->current_service = $service_name;

        return $this;
    }



    public function withDisabled()
    {
        $this->bypass_conditions = true;

        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Add Chain Methods
    |--------------------------------------------------------------------------
    |
    */
    public function add($key = null)
    {
        $map = "$this->name.$this->current_service";

        /*-----------------------------------------------
        | Random Key Generation (if not provided) ...
        */
        if (!$key) {
            do {
                $key = str_random(10);
            } while (array_has(self::$services, "$map.$key"));
        }

        /*-----------------------------------------------
        | Keys, already set ...
        */
        if ($this->has($key)) {
            $this->current_key = $key;
            return $this;
        }


        /*-----------------------------------------------
        | Property Set ...
        */
        $this->current_key = $key;
        array_set(self::$services, "$map.$key", [
             'default'   => false,
             'key'       => $key,
             'order'     => "22",
             'permit'    => null,
             'condition' => true,
             'comment'   => null,
        ]);

        return $this;
    }



    public function set($field_name, $value)
    {
        array_set(self::$services, "$this->name.$this->current_service.$this->current_key.$field_name", $value);

        return $this;
    }



    public function icon($value)
    {
        return $this->set('icon', $value);
    }



    public function caption($value)
    {
        if (!is_closure($value)) {
            if (str_contains($value, 'trans:')) {
                return $this->trans(str_after($value, 'trans:'));
            }
        }

        return $this->set('caption', $value);
    }



    public function trans($value, ... $trans_arguments)
    {
        return $this->set('caption', trans($value, ... $trans_arguments));
    }



    public function link($value)
    {
        if (!is_closure($value)) {
            if (str_contains($value, 'url:')) {
                $value = url(str_after($value, 'url:'));
            }
        }

        return $this->set('link', $value);
    }



    public function order($value)
    {
        return $this->set('order', intval($value));
    }



    public function comment($value)
    {
        return $this->set('comment', $value);
    }



    public function permit($value)
    {
        return $this->set('permit', $value);
    }



    public function condition($value)
    {
        return $this->set('condition', $value);
    }



    public function blade($value)
    {
        if (!is_closure($value)) {
            $value = strtolower($value);
            /*-----------------------------------------------
            | Safe Action while inn Debug Mode ...
            */
            if (config('app.debug') and !View::exists($value)) {
                return $this->blade("manage::widgets.blank");
            }
        }

        /*-----------------------------------------------
        | Return ...
        */

        return $this->set('blade', $value);
    }



    public function width($value)
    {
        return $this->set('width', $value);
    }



    public function method($value)
    {
        if (str_contains($value, ':') and !str_contains($value, '::')) {
            $module = module(str_before($value, ':'));
            $value  = str_after($value, ':');

            if (str_contains($value, "Controller")) { //@TODO: Add more Identifier, like providers etc.
                $value = $module->controller($value);
                $value = str_replace("@", "::", $value);
            } else {
                $value = $module->provider() . '::' . $value;
            }
        }

        return $this->set('method', $value);
    }



    public function default($value)
    {
        return $this->set('default', $value);
    }



    public function trait($value)
    {
        if (str_contains($value, ':')) {
            $module     = module(str_before($value, ':'));
            $trait_name = str_after($value, ':');
            $value      = $module->getNamespace("Entities\\Traits\\" . studly_case($trait_name));
        }

        return $this->set('trait', $value);
    }



    public function class($value)
    {
        return $this->set('class', $value);
    }



    public function color($value)
    {
        return $this->set('color', $value);
    }



    public function to($value)
    {
        if (str_contains($value, ':')) {
            $value = str_after($value, ':');
        }

        return $this->set('to', $value);
    }



    public function value($value)
    {
        return $this->set('value', $value);
    }



    /*
    |--------------------------------------------------------------------------
    | Read Chain Methods
    |--------------------------------------------------------------------------
    |
    */
    public function read()
    {
        if (!$this->isInitialized()) {
            return [];
        }
        /*-----------------------------------------------
        | Check Registry ...
        */
        if (!$this->isRegistered()) {
            return [];
        }

        /*-----------------------------------------------
        | Preparations ...
        */
        $array = array_get(self::$services, "$this->name.$this->current_service");
        $array = array_sort($array, function ($value) {
            if (!isset($value['order'])) {
                $value['order'] = 1;
            }

            return $value['order'];
        });

        /*-----------------------------------------------
        | Closures ...
        */
        foreach ($array as $key => $inside) {
            foreach ($inside as $field => $value) {
                if (is_closure($value)) {
                    $array[$key][$field] = $value();
                }
            }
        }


        /*-----------------------------------------------
        | WithDisabled ...
        */
        if (!$this->bypass_conditions) {
            $array = array_where($array, function ($value, $key) {
                $condition = $value['condition'];
                if (is_closure($condition)) {
                    $condition = $condition();
                }
                return boolval($condition);
            });
        }

        /*-----------------------------------------------
        | Return ...
        */

        return $array;
    }



    public function count()
    {
        return count($this->read());
    }



    public function indexed(... $keys)
    {
        $result  = [];
        $array   = $this->read();
        $counter = 0;

        foreach ($array as $item) {
            foreach ($keys as $key) {
                if (isset($item[$key])) {
                    $result[$counter][] = $item[$key];
                } else {
                    $result[$counter][] = null;
                }
            }
            $counter++;
        }

        return $result;
    }



    public function paired($result_value, $result_key = 'key')
    {
        $result = [];
        $array  = $this->read();

        foreach ($array as $key => $item) {
            if (isset($item[$result_key]) and isset($item[$result_value])) {
                $result[$item[$result_key]] = $item[$result_value];
            }
        }

        return $result;
    }



    public function has($key)
    {
        return boolval(count($this->find($key)->get()));
    }



    public function find($key)
    {
        if (isset($this->read()[$key])) {
            $this->current_key = $key;
        } else {
            $this->current_key = null;
        }

        return $this;
    }



    public function get($key1 = null, $key2 = null)
    {
        /*-----------------------------------------------
        | Polymorphism handling ...
        */
        if (isset($key2)) {
            return $this->find($key1)->get($key2);
        } else {
            $key = $key1;
        }


        /*-----------------------------------------------
        | When not properly set ...
        */
        if (!$this->current_key) {
            if ($key) {
                return null;
            } else {
                return [];
            }
        }

        /*-----------------------------------------------
        | When a whole array is requested ...
        */
        if (!$key) {
            return $this->read()[$this->current_key];
        }

        /*-----------------------------------------------
        | When a single key is requested ...
        */
        if (isset($this->read()[$this->current_key][$key])) {
            return $this->read()[$this->current_key][$key];
        } else {
            return null;
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Process
    |--------------------------------------------------------------------------
    |
    */
    public function remove($key)
    {
        $map = "$this->name.$this->current_service.$key";
        array_forget(self::$services, $map);

        return $this;
    }



    public function update($key)
    {
        $this->current_key = $key;

        return $this;
    }



    public function handle(...$arguments)
    {
        $array = $this->read();
        foreach ($array as $item) {
            if (isset($item['method'])) {
                $item['method'](... $arguments);
            }
        }

        return $this;
    }



    public function isset($argument = null)
    {
        if (!count($this->read())) {
            return false;
        }
        if ($argument) {
            return isset($this->read()[$argument]);
        }

        return true;
    }
}
