<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin';

    protected $description = 'Tạo tài khoản admin (superadmin)';

    public function handle()
    {
        $name = $this->ask('Tên admin:');
        $email = $this->ask('Email đăng nhập:');
        $password = $this->secret('Mật khẩu:');

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'superadmin',
        ]);

        $this->info('✔ Tạo tài khoản admin thành công!');
    }
}
