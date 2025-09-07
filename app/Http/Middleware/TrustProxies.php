<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * Accepts IPs or CIDR, comma-separated via TRUSTED_PROXIES env, or '*' to trust all (behind a known load balancer/CDN).
     * Example: TRUSTED_PROXIES=127.0.0.1,10.0.0.0/8
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO
        | Request::HEADER_X_FORWARDED_AWS_ELB;

    public function __construct()
    {
        $env = env('TRUSTED_PROXIES');
        if ($env === '*') {
            $this->proxies = '*';
        } elseif (is_string($env) && trim($env) !== '') {
            $this->proxies = array_map('trim', explode(',', $env));
        } else {
            $this->proxies = null; // do not trust any proxies by default
        }
    }
}
