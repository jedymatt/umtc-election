<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InitializeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superadmin:init {--generate-password : Generates a random password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize super admin account when it does not exist';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Admin::where('is_super_admin', 1)->exists()) {
            $this->error('Super Admin already exists');

            return 1;
        }

        $generatedPassword = $this->option('generate-password') ? Str::random(10) : null;
        $credentials = $this->getCredentials($generatedPassword);
        $validator = $this->validator($credentials);

        if ($validator->fails()) {
            $this->info('Super admin could not be created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $this->createSuperAdminAccount($validator);

        if (!is_null($generatedPassword)) {
            $this->alert('Generated Password: ' . $generatedPassword);
        }

        $this->info('Super admin successfully created.');

        return 0;
    }

    /**
     * @param array $credentials
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public function validator(array $credentials): \Illuminate\Validation\Validator|\Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($credentials, [
            'email' => 'required|string|email|unique:admins',
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed',
        ]);
    }

    /**
     * @param $validator
     * @return void
     */
    public function createSuperAdminAccount($validator): void
    {
        $adminCredentials = $validator->safe()->merge([
            'is_super_admin' => 1,
            'password' => Hash::make($validator->safe()->offsetGet('password')),
        ])->all();

        Admin::create($adminCredentials);
    }

    /**
     * @param string|null $generatedPassword
     * @return array
     */
    public function getCredentials(?string $generatedPassword): array
    {
        $credentials['email'] = $this->ask('Email address');
        $credentials['name'] = $this->ask('Name', 'Super Administrator');
        $credentials['password'] = is_null($generatedPassword) ? $this->secret('Password') : $generatedPassword;
        $credentials['password_confirmation'] = is_null($generatedPassword) ? $this->secret('Confirm password') : $generatedPassword;

        return $credentials;
    }
}
