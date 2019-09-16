<?php

namespace App\Http\Middleware;

use Closure;
use App\Contracts\Repositories\SiteRepository;

class CheckForSubSite
{
    protected $site, $domains;

    public function __construct(SiteRepository $site)
    {
        $this->site = $site;
        $this->domains = config("site.domains");
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        $domain = preg_replace('#^www\.(.+\.)#i', '$1', $host);

        if(in_array($domain, $this->domains)) {
            $site = $this->site->site(0);
            app()->instance('App\Site', $site);

        } else {
            $site = $this->site->getSiteByDomain($domain);

            if($site !== null && $site->id > 0) {
                app()->instance('App\Site', $site);
            } else {
                abort(404);
            }
        }

        return $next($request);
    }
}
