<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'option_name' 	=> 'company_name',
                'option_label' 	=> 'Tên đơn vị',
                'option_value' 	=> 'THPT Gio Linh',
                'option_group' 	=> 'general',
                'option_group_name' => 'Chung',
            ],
            [
                'option_name' 	=> 'company_email',
                'option_label' 	=> 'Email',
                'option_value' 	=> 'admin@gmail.com',
                'option_group' 	=> 'general',
                'option_group_name' => 'Chung',
            ],
            [
                'option_name' 	=> 'company_phone',
                'option_label' 	=> 'Số điện thoại',
                'option_value' 	=> '',
                'option_group' 	=> 'general',
                'option_group_name' => 'Chung',
            ],
            [
                'option_name' 	=> 'mail_mailer',
                'option_label' 	=> 'Nhà cung cấp',
                'option_value' 	=> '',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ],
            [
                'option_name' 	=> 'mail_host',
                'option_label' 	=> 'Host',
                'option_value' 	=> '',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ],
            [
                'option_name' 	=> 'mail_encryption',
                'option_label' 	=> 'Encryption',
                'option_value' 	=> 'tls',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ],
            [
                'option_name' 	=> 'mail_port',
                'option_label' 	=> 'Port',
                'option_value' 	=> '587',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ],
            [
                'option_name' 	=> 'mail_username',
                'option_label' 	=> 'Tài khoản',
                'option_value' 	=> 'hoangvanlong.vn1999@gmail.com',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ],
            [
                'option_name' 	=> 'mail_password',
                'option_label' 	=> 'Mật khẩu',
                'option_value' 	=> 'wuxpxsarxahcktit',
                'option_group' 	=> 'mail',
                'option_group_name' => 'Gửi email',
            ]
        ];
        foreach ($options as $option) {
            DB::table('options')->insert($option);
        }
    }
}
