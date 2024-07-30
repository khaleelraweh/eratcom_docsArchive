<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name'                  => 'PayPal',
            'code'                  => 'PPEX',
            'driver_name'           => 'PayPal_Express',

            // for live start 
            'merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'merchant_password'     => 'Xt%5fGW5',
            'client_id'             =>  null,
            'client_secret'         =>  null,
            'username'              =>  null,
            'password'              =>  null,
            'signature'             =>  null,
            // for live end 

            //for sandbox start 
            'sandbox_merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'sandbox_merchant_password'     => 'Xt%5fGW5',
            'sandbox_client_id'             =>  'AXlsfY5KcThBcK5rUxcFDcx9JXBbKpPNhcUSJV0G5Ms28xjB0ycjBgdqEGBDq9HuQEeEik5Ksw9geNHx',
            'sandbox_client_secret'         =>  'EDIpsdrdyfYFIts4pQcNuRgLp6yeBJXRHAHNyoFqzzamF0lPixCyajicIs1s-jhoIVZhN5-St36_LYJ6',
            'sandbox_username'              =>  'sb-8r3ti27897192_api1.business.example.com',
            'sandbox_password'              =>  'U4TZ9HP945LK46DD',
            'sandbox_signature'             =>  'Aea3S-zQp8Wqw4vgMOI6c015u53PAVd-zx7jfw4rggCePjO.YYHnRZBS',
            //for standbox end 

            'sandbox'               =>  true,
            'status'                =>  true,


        ]);

        PaymentMethod::create([
            'name'                  => 'creditDebit',
            'code'                  => 'CDpx',
            'driver_name'           => 'Paytabs_Express',

            // for live start 
            'merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'merchant_password'     => 'Xt%5fGW5',
            'client_id'             =>  null,
            'client_secret'         =>  null,
            'username'              =>  null,
            'password'              =>  null,
            'signature'             =>  null,
            // for live end 

            //for sandbox start 
            'sandbox_merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'sandbox_merchant_password'     => 'Xt%5fGW5',
            'sandbox_client_id'             =>  'AXlsfY5KcThBcK5rUxcFDcx9JXBbKpPNhcUSJV0G5Ms28xjB0ycjBgdqEGBDq9HuQEeEik5Ksw9geNHx',
            'sandbox_client_secret'         =>  'EDIpsdrdyfYFIts4pQcNuRgLp6yeBJXRHAHNyoFqzzamF0lPixCyajicIs1s-jhoIVZhN5-St36_LYJ6',
            'sandbox_username'              =>  'sb-8r3ti27897192_api1.business.example.com',
            'sandbox_password'              =>  'U4TZ9HP945LK46DD',
            'sandbox_signature'             =>  'Aea3S-zQp8Wqw4vgMOI6c015u53PAVd-zx7jfw4rggCePjO.YYHnRZBS',
            //for standbox end 

            'sandbox'               =>  true,
            'status'                =>  true,


        ]);

        PaymentMethod::create([
            'name'                  => 'freePaid',
            'code'                  => 'FP',
            'driver_name'           => 'FP',

            // for live start 
            'merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'merchant_password'     => 'Xt%5fGW5',
            'client_id'             =>  null,
            'client_secret'         =>  null,
            'username'              =>  null,
            'password'              =>  null,
            'signature'             =>  null,
            // for live end 

            //for sandbox start 
            'sandbox_merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'sandbox_merchant_password'     => 'Xt%5fGW5',
            'sandbox_client_id'             =>  'AXlsfY5KcThBcK5rUxcFDcx9JXBbKpPNhcUSJV0G5Ms28xjB0ycjBgdqEGBDq9HuQEeEik5Ksw9geNHx',
            'sandbox_client_secret'         =>  'EDIpsdrdyfYFIts4pQcNuRgLp6yeBJXRHAHNyoFqzzamF0lPixCyajicIs1s-jhoIVZhN5-St36_LYJ6',
            'sandbox_username'              =>  'sb-8r3ti27897192_api1.business.example.com',
            'sandbox_password'              =>  'U4TZ9HP945LK46DD',
            'sandbox_signature'             =>  'Aea3S-zQp8Wqw4vgMOI6c015u53PAVd-zx7jfw4rggCePjO.YYHnRZBS',
            //for standbox end 

            'sandbox'               =>  true,
            'status'                =>  true,


        ]);

        PaymentMethod::create([
            'name'                          => 'kurimaBank',
            'code'                          => 'KB',
            'driver_name'                   => 'KB',

            // for live start 
            'merchant_email'                => 'sb-8r3ti27897192@business.example.com',
            'merchant_password'             => 'Xt%5fGW5',
            'client_id'                     =>  null,
            'client_secret'                 =>  null,
            'username'                      =>  null,
            'password'                      =>  null,
            'signature'                     =>  null,
            // for live end 

            //for sandbox start 
            'sandbox_merchant_email'        => 'sb-8r3ti27897192@business.example.com',
            'sandbox_merchant_password'     => 'Xt%5fGW5',
            'sandbox_client_id'             =>  'AXlsfY5KcThBcK5rUxcFDcx9JXBbKpPNhcUSJV0G5Ms28xjB0ycjBgdqEGBDq9HuQEeEik5Ksw9geNHx',
            'sandbox_client_secret'         =>  'EDIpsdrdyfYFIts4pQcNuRgLp6yeBJXRHAHNyoFqzzamF0lPixCyajicIs1s-jhoIVZhN5-St36_LYJ6',
            'sandbox_username'              =>  'sb-8r3ti27897192_api1.business.example.com',
            'sandbox_password'              =>  'U4TZ9HP945LK46DD',
            'sandbox_signature'             =>  'Aea3S-zQp8Wqw4vgMOI6c015u53PAVd-zx7jfw4rggCePjO.YYHnRZBS',
            //for standbox end 

            'sandbox'               =>  true,
            'status'                =>  true,


        ]);
    }
}
