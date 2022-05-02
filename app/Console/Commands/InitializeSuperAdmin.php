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
        if (Admin::where('is_super_admin')->exists()) {
            $this->error('Super Admin already exists');

            return 1;
        }

        $generatedPassword = $this->option('generate-password') ? Str::random(10) : null;

        $credentials['email'] = $this->ask('Email address');
        $credentials['name'] = $this->ask('Name', 'Super Administrator');
        $credentials['password'] = is_null($generatedPassword) ? $this->secret('Password') : $generatedPassword;
        $credentials['password_confirmation'] = is_null($generatedPassword) ? $this->secret('Confirm password') : $generatedPassword;

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email|unique:admins',
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            $this->info('Super admin could not be created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }


        $validated = $validator->validated();

        $adminCredentials = array_merge($validated, [
            'is_super_admin' => 1,
            'password' => Hash::make($validated['password']),
        ]);

        Admin::create($adminCredentials);

        $this->alert('Generated Password: '.$generatedPassword);

        $this->info('Super admin successfully created.');

        return 0;
    }
}
