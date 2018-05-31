<?php

namespace App\Http\Middleware;

use Closure;

class AddHeaderToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Authorization','Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUyNjhlNzdlMDljMGNjM2NhMGUyMDQ2YjNiMDU3NDU3Y2JmOWYzMzUyNTVhNGU1NDQ5NGQ5ZTQxNzhjYTA5MjQ3OGJlYTIxODk1ZGFjZjJhIn0.eyJhdWQiOiIyIiwianRpIjoiNTI2OGU3N2UwOWMwY2MzY2EwZTIwNDZiM2IwNTc0NTdjYmY5ZjMzNTI1NWE0ZTU0NDk0ZDllNDE3OGNhMDkyNDc4YmVhMjE4OTVkYWNmMmEiLCJpYXQiOjE1MTkzMDQ0MjYsIm5iZiI6MTUxOTMwNDQyNiwiZXhwIjoxNTUwODQwNDI1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Wji3hbkFedE3CkYSJnfU9XYXKECaRYeU7BlVv2I0mcWrDEErpk9aXZm3PomQYn1l7L70fxWXd4h3OCiDRj4YVyDB7_IoSNV-WfTeLxVqhfs0-DOUeVMjgMpGVIKYxjIUFUUGMU9XQ7csLRLDI1niRIEFk-peU2qset4ICipyfpsh6iupX_8JEaJZsOWkyftiZ-EFkStCw_ejxj6o2sUe7uPlUDzuJxtLRvEYELbKsY9aX62a_xBP91NwEo68BjO--TO7WIxJxAEsKR7XCA6ZfgG9lZTRhzgdJXNLw-32hpk8RuJoadTPWgP2cuu-vs81vpUmKYz9emAgifo47AGgB-HRXPyeaWeA1Uo0EQP_r64CGMXYODUXni7iBfQ1cEIXOaeSsMQ_jTGHcD_23l0KynCNMjBXeGzgIACCe6ZDmEqFd2v6HKDtXcbj1nmAwiLyq7SCWCNHMH49KkI2zUVDKgUzSZDpwuWAYW5J19Xz95lcyySlELeraWWrrTGvIBsH-1Cmj4gqw2eqIBKL2ZCRcvGfpKRtY42ixGblDLDoeCfveftW0iux4dI9-TXk-JQzjn1kQt3Y4Mpf9AezgOH-vYn2merMl-rM3bBwGD1gmNtcuZTp-o22TnP0MQXXaa4vvA3ZfSVGG5vUPFuCzaKT8ZZ6hK3nx2M0CqpbiK_yZX4');

    return $next($request);
    }
}
