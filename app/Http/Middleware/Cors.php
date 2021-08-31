<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    private static $allowedOriginsWhitelist = [
        'http://10.66.248.51:8000',
        'http://10.4.237.33:80',
        'http://bodegarrff.xcl',
        'http://localhost',
        'http://127.0.0.1:8000',
        'https://gstc.neuronet.io',
        'http://gstc.neuronet.io',
        'http://10.66.248.200:8001',
        'http://10.66.248.200:8002',
        'http://192.168.0.131:8001',
    ];

    // All the headers must be a string

    private static $allowedOrigin = ['http://10.66.248.51:8000','http://10.4.237.33:80','http://bodegarrff.xcl',
    'http://localhost',
    'http://127.0.0.1:8000',
    'https://gstc.neuronet.io',
    'http://gstc.neuronet.io',
    'http://10.66.248.200:8001',
    'http://10.66.248.200:8002',
    'http://192.168.0.131:8001',];

    private static $allowedMethods = 'OPTIONS, GET, POST, PUT, PATCH, DELETE';

    private static $allowCredentials = 'true';

    private static $allowedHeaders = '*';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->isCorsRequest($request)) {
            return $next($request);
        }

        static::$allowedOrigin = $this->resolveAllowedOrigin($request);

        static::$allowedHeaders = $this->resolveAllowedHeaders($request);

        $headers = [
            'Access-Control-Allow-Origin'       => static::$allowedOrigin,
            'Access-Control-Allow-Methods'      => static::$allowedMethods,
            'Access-Control-Allow-Headers'      => static::$allowedHeaders,
            'Access-Control-Allow-Credentials'  => static::$allowCredentials,
        ];

        // For preflighted requests
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200)->withHeaders($headers);
        }

        $response = $next($request)->withHeaders($headers);

        return $response;
    }

    /**
     * Incoming request is a CORS request if the Origin
     * header is set and Origin !== Host
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function isCorsRequest($request)
    {
        $requestHasOrigin = $request->headers->has('Origin');

        if ($requestHasOrigin) {
            $origin = $request->headers->get('Origin');

            $host = $request->getSchemeAndHttpHost();

            if ($origin !== $host) {
                return true;
            }
        }

        return false;
    }

    /**
     * Dynamic resolution of allowed origin since we can't
     * pass multiple domains to the header. The appropriate
     * domain is set in the Access-Control-Allow-Origin header
     * only if it is present in the whitelist.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function resolveAllowedOrigin($request)
    {
        $allowedOrigin = static::$allowedOrigin;

        // If origin is in our $allowedOriginsWhitelist
        // then we send that in Access-Control-Allow-Origin

        $origin = $request->headers->get('Origin');

        if (in_array($origin, static::$allowedOriginsWhitelist)) {
            $allowedOrigin = $origin;
        }

        return $allowedOrigin;
    }

    /**
     * Take the incoming client request headers
     * and return. Will be used to pass in Access-Control-Allow-Headers
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function resolveAllowedHeaders($request)
    {
        $allowedHeaders = $request->headers->get('Access-Control-Request-Headers');

        return $allowedHeaders;
    }
}
