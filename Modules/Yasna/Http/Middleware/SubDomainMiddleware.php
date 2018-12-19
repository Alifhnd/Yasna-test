<?php

namespace Modules\Yasna\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubDomainMiddleware
{
    protected $sub_domain;
    protected $default_subDomain = 'global';
    protected $domain_model;



    /**
     * SubDomainMiddleware constructor.
     */
    public function __construct()
    {
        $this->detectSubDomain();
    }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->hasNoSubDomain()) {
            setDomain($this->default_subDomain);
        } elseif ($this->subDomainIsValid()) {
            setDomain($this->domain_model->slug);
        } else {
            return redirect(str_replace($this->sub_domain . '.', '', $request->url()));
        }

        return $next($request);
    }



    /**
     * @return bool
     */
    protected function hasNoSubDomain()
    {
        return !boolval($this->sub_domain);
    }



    /**
     * Detect specified sub domain
     */
    public function detectSubDomain()
    {
        $parts = array_reverse(explode('.', request()->getHost()));
        if (count($parts) > 2) {
            $this->sub_domain = $parts[2];
        }
    }



    /**
     * @return bool
     */
    protected function subDomainIsValid()
    {
        $this->domain_model = model('domain')->firstOrNew(['alias'=> $this->sub_domain]);
        return $this->domain_model->exists;
    }
}
