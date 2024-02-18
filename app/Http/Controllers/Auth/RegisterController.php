<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'domain_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $tenant = Tenant::create([
            'name' => "Rapsin",
            'domain' => "Rapsin",
        ]);

        return User::create([
            'first_name' => "Tosin",
            'last_name' => "Ezekiel",
            'tenant_id' => $tenant->id,
            'email' => "exz@testing.com",
            'password' => Hash::make("Password"),
        ]);
    }
}
