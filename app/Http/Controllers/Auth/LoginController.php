<?php

namespace App\Http\Controllers\Auth;

use App\Models\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $tenantRedirectTo = '/tenants/dashboard';


    public function redirectPath(){
        $tenantId = auth()->user()->tenant_id ?? null;

        if(!isset($tenantId)){
            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
        }

        $tenant = Tenant::whereId($tenantId)->first();
        $url = sprintf('http://%s.%s.test/tenants/dashboard', $tenant->domain, "propel");
    
        return $url;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
