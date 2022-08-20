<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 => array(
                'id' => 1,
                'account' => '管理員',
                'name' => 'administrator',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$x4wFDfP7I/WIz8Zgq6BzzOSV2PzIHjvGHIAtGaCSuwittzeZqWEeu',
                'remember_token' => null,
                'created_at' => '2021-05-13 03:59:37',
                'updated_at' => '2021-05-13 03:59:37',
            ),
            1 => array(
                'id' => 3,
                'account' => '保安隊',
                'name' => 'v2152',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$8kAP4uvPoU9QbXbsJlGVOuvsk8e2PpOMuR2tw6KyOgTrKwH9M7.aW',
                'remember_token' => null,
                'created_at' => '2021-05-20 16:52:39',
                'updated_at' => '2021-05-20 16:52:39',
            ),
            2 => array(
                'id' => 4,
                'account' => '大武分局',
                'name' => 'v3205',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$JVuZOzXjPdTjGqH.XyokWuHd6xxgxQP9duCrKnibUTZX.cHsAMDUa',
                'remember_token' => null,
                'created_at' => '2021-05-20 16:55:19',
                'updated_at' => '2021-05-20 16:55:19',
            ),
            3 => array(
                'id' => 5,
                'account' => '關山分局',
                'name' => 'v3104',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$t3BuSZEpCBGMLrzdYzR1u.fmv8JYKJSc8bLLi9vs8GaqeVprA2pe.',
                'remember_token' => null,
                'created_at' => '2021-05-20 16:57:10',
                'updated_at' => '2021-05-20 16:57:10',
            ),
            4 => array(
                'id' => 6,
                'account' => '成功分局',
                'name' => 'v3304',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$f95rvB3K/Iz07KXQ60YUD.MYos.IrmwzV5Gz4RMzGgbuDcun4g0e.',
                'remember_token' => null,
                'created_at' => '2021-05-20 16:57:56',
                'updated_at' => '2021-05-20 16:57:56',
            ),
            5 => array(
                'id' => 8,
                'account' => '少年隊',
                'name' => 'v2216',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$60LzEvrdCejF47WNfKuefOBLEPyoq3kG8ZCmHshAsaLys6EESmZ0u',
                'remember_token' => null,
                'created_at' => '2021-05-20 17:01:24',
                'updated_at' => '2021-05-20 17:01:24',
            ),
            6 => array(
                'id' => 9,
                'account' => '臺東分局',
                'name' => 'v2316',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$jAtel..mlnI.jyQQTAhZcOw4E6asMKwkyOjYbB9Xu9g4ZURcGQYte',
                'remember_token' => null,
                'created_at' => '2021-05-20 17:02:17',
                'updated_at' => '2021-05-20 17:02:17',
            ),
            7 => array(
                'id' => 10,
                'account' => '交通隊',
                'name' => 'v2193',
                'email' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$3KtpYYrMGDhUAJF85LD3mekcVBU4QmXSIq9gkzB9tyHTwpUjG9eFS',
                'remember_token' => null,
                'created_at' => '2021-05-20 17:31:38',
                'updated_at' => '2021-05-20 17:31:38',
            ),
        ));

    }
}
