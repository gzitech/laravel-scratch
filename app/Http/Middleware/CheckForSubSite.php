<?php

namespace App\Http\Middleware;

use Closure;
use App\Contracts\Repositories\SiteRepository;
use Illuminate\Support\Facades\Cache;

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

        $viewKey = config('site.cache_cur_site_id');

        if(in_array($domain, $this->domains)) {
            $site = $this->site->site(0);
            app()->instance('App\Site', $site);
            \Illuminate\Support\Facades\View::share($viewKey, $site->id);

        } else {
            $cacheKey = config('site.cache_sub_site_key') . $domain;

            $site = Cache::get($cacheKey, null);

            if($site === null) {
                $site = $this->site->findByDomain($domain);

                if($site !== null) {
                    Cache::put($cacheKey, $site);
                }
            }

            if($site !== null && $site->id > 0) {
                app()->instance('App\Site', $site);
                \Illuminate\Support\Facades\View::share($viewKey, $site->id);
            } else {
                abort(403);
            }
        }

        return $next($request);
    }
}
