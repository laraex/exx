<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
    public function run()
    {
        DB::table('settings')->insert([
            'key'           => 'sitetitle',
            'name'          => 'Site Title',
            'description'   => 'Site Title to show in Browser Bar',
            'value'         => 'Nuxigen - Crypto Currency Exchange',
            'field'         => '{"name":"value","label":"Value", "title":"Site Title" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'sitename',
            'name'          => 'Site Name',
            'description'   => 'This Cryptoextrade is used in emails and copyrights',
            'value'         => 'Nuxigen',
            'field'         => '{"name":"value","label":"Value", "title":"Site Title" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'sitelogo',
            'name'          => 'Site Logo',
            'description'   => 'Logo of the website. Recommended Size : 220px (w) x 45px (h)',
            'value'         => 'uploads/static/nuxigen_logo.png',
            'field'         => '{"name":"value","label":"Value" ,"type":"browse"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'currency',
            'name'          => 'Site Currency',
            'description'   => 'Currency of the Website',
            'value'         => 'USD',
            'field'         => '{"name":"value","label":"Value", "title":"Currency" ,"type":"select_from_array"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'default_sponsor',
            'name'          => 'Default Sponsor',
            'description'   => 'Default Sponsor of the site (give email)',
            'value'         => 'root@nuxigen.uk',
            'field'         => '{"name":"value","label":"Value", "title":"Currency" ,"type":"email"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'matrix_width',
            'name'          => 'Matrix Width',
            'description'   => 'Matrix Width for Geneology (set 0 for Unilvel)',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value", "title":"Currency" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);
        
         DB::table('settings')->insert([
            'key'           => 'pagecount',
            'name'          => 'Pagination',
            'description'   => 'Pagination Count',
            'value'         => '10',
            'field'         => '{"name":"value","label":"Value", "title":"Pagination Count" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'adminemail',
            'name'          => 'Admin Email',
            'description'   => 'Admin Email Address',
            'value'         => 'admin@cryptoextrade.com',
            'field'         => '{"name":"value","label":"Value", "title":"Admin Email" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'contact',
            'name'          => 'Contact Us',
            'description'   => 'Contact us Address',
            'value'         => '<p>Company Name</p><p>Addressline 1</p><p>Address line 2</p><p>City</p><p>State</p><p>ZipCode</p><p>Country</p>',
            'field'         => '{"name":"value","label":"Value", "title":"Contact us Address" ,"type":"textarea"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'captchasitekey',
            'name'          => 'Captcha Sitekey',
            'description'   => 'Google Captcha Sitekey',
            'value'         => '', //6Lcbbw8UAAAAAP3AEMKBhQscti04wIN7MSwFd-pu
            'field'         => '{"name":"value","label":"Value", "title":"Google Captcha Sitekey" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'register_captcha_active',
            'name'          => 'Register Catcha Active',
            'description'   => 'Register Catcha Active',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

        DB::table('settings')->insert([
            'key'           => 'contactus_captcha_status',
            'name'          => 'Contact us Catcha Status',
            'description'   => 'Status for Contact us Catcha',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
      
        DB::table('settings')->insert([
            'key'           => 'google_analytics_code',
            'name'          => 'Google Analytics Code',
            'description'   => 'Analytics Code for Google',
            // 'value'         => '',
            'field'         => '{"name":"value","label":"Value", "title":"Google Analytics Code" ,"type":"textarea"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);       
    
        DB::table('settings')->insert(
        [
            'key' => "favicon",
            'name' => "Favicon",
            'description' => "Site Favicon",
            'value'         => '/uploads/static/favicon.png',
            'field'         => '{"name":"value","label":"Value", "title":"Site Favicon" ,"type":"browse", "disk":"uploads"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);       
      
  
        DB::table('settings')->insert([
            'key'           => 'footercss',
            'name'          => 'Footer Css',
            'description'   => 'Added Footer Css',
            'value'         => '',
            'field'         => '{"name":"value","label":"Value", "title":"Added Footer Css" ,"type":"textarea"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'headerscript',
            'name'          => 'Header Script',
            'description'   => 'Script for Header',
            'value'         => '',
            'field'         => '{"name":"value","label":"Value", "title":"Script for Header" ,"type":"textarea"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'footerscript',
            'name'          => 'Footer Script',
            'description'   => 'Script for Footer',
            'value'         => '',
            'field'         => '{"name":"value","label":"Value", "title":"Script for Footer" ,"type":"textarea"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'withdraw_min_amount',
            'name'          => 'Withdraw Minimum Amount',
            'description'   => 'Withdraw Minimum Amount',
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Withdraw Minimum Amount" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'withdraw_max_amount',
            'name'          => 'Withdraw Maximum Amount',
            'description'   => 'Withdraw Maximum Amount',
            'value'         => '100',
            'field'         => '{"name":"value","label":"Value", "title":"Withdraw Maximum Amount" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'monthly_withdraw_limit',
            'name'          => 'Monthly Withdraw Limit',
            'description'   => 'Withdraw Limit for Month',
            'value'         => '10',
            'field'         => '{"name":"value","label":"Value", "title":"Withdraw Limit" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);

         DB::table('settings')->insert([
            'key'           => 'daily_withdraw_limit',
            'name'          => 'Daily Withdraw Limit',
            'description'   => 'Daily Withdraw Limit',
            'value'         => '2',
            'field'         => '{"name":"value","label":"Value", "title":"Daily Withdraw Limit" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert(
        [
            'key' => "login_status",
            'name' => "Login Status",
            'description' => "Active/Inactive",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Login Status" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_register_down',
            'name'          => 'Force Register Down',
            'description'   => 'Force Register Down',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Force Register Down" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_email_verification_for_deposit',
            'name'          => 'Email verification for Fund deposit',
            'description'   => 'Email verification for Fund deposit',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

          DB::table('settings')->insert([
            'key'           => 'force_email_verification_for_fund_transfer',
            'name'          => 'Force email verification for fund transfer',
            'description'   => 'Force email verification for fund transfer',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_email_verification_for_withdraw',
            'name'          => 'Force email verification for withdraw',
            'description'   => 'Force email verification for withdraw',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_kyc_verification_for_deposit',
            'name'          => 'Force KYC verification for Fund deposit',
            'description'   => 'Force KYC verification for Fund deposit',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_kyc_verification_for_fund_transfer',
            'name'          => 'Force KYC verification for fund transfer',
            'description'   => 'Force KYC verification for fund transfer',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_kyc_verification_for_withdraw',
            'name'          => 'Force KYC Verification For Withdraw',
            'description'   => 'Force KYC Verification For Withdraw',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_deposit_down',
            'name'          => 'Force Fund Deposit Down',
            'description'   => 'Force Fund Deposit Down',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

         DB::table('settings')->insert([
            'key'           => 'force_withdraw_down',
            'name'          => 'Force Withdraw Down',
            'description'   => 'Force Withdraw Down',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

          DB::table('settings')->insert([
            'key'           => 'welcomepopupstatus',
            'name'          => 'Welcome Page Popup Status',
            'description'   => 'Status for Welcome Page',
            'value'         => '0',
            'field'         => '{"name":"value","Status for Welcome Page":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

          DB::table('settings')->insert([
            'key'           => 'dashboardpopupstatus',
            'name'          => 'Dashboard Popup Status',
            'description'   => 'Status for Dashboard Popup',
            'value'         => '0',
            'field'         => '{"name":"value","Status for Dashboard Popup":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

         DB::table('settings')->insert(
        [
            'key' => "fundtransfer_min_amount",
            'name' => "Fund Transfer Minimum Amount",
            'description' => "Fund Transfer Minimum Amount",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Fund Transfer Minimum Amount" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

         DB::table('settings')->insert(
        [
            'key' => "fundtransfer_max_amount",
            'name' => "Fund Transfer Maximum Amount",
            'description' => "Fund Transfer Maximum Amount",
            'value'         => '100',
            'field'         => '{"name":"value","label":"Value", "title":"Fund Transfer Maximum Amount" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert(
        [
            'key' => "fundtransfer_commission",
            'name' => "Fund Transfer commission",
            'description' => "Fund Transfer commission",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Fund Transfer commission" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert(
        [
            'key' => "exchange_commission",
            'name' => "Commission for exchange",
            'description' => "Commission for exchange",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Commission for exchange" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
      
       DB::table('settings')->insert(
        [
            'key' => "BTC-reserve-amount-buy",
            'name' => "BTC Reserve Amount Buy",
            'description' => "Value for BTC Reserve Amount",
            'value'         => '0.0001',
            'field'         => '{"name":"value","label":"Value", "title":"Value for BTC Reserve Amount" ,"type":"text"}',
            'active'        => '1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

       DB::table('settings')->insert(
        [
            'key' => "BTC-commission-buy",
            'name' => "BTC buy commission",
            'description' => "Commission for buy BTC (%)",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Commission for buy BTC" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
       DB::table('settings')->insert(
        [
            'key' => "LTC-reserve-amount-buy",
            'name' => "LTC Reserve Amount Buy",
            'description' => "Value for LTC Reserve Amount",
            'value'         => '0.1',
            'field'         => '{"name":"value","label":"Value", "title":"Value for LTC Reserve Amount" ,"type":"text"}',
            'active'        => '1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

       DB::table('settings')->insert(
        [
            'key' => "LTC-commission-buy",
            'name' => "LTC buy commission",
            'description' => "Commission for buy LTC (%)",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Commission for buy LTC" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
       

        DB::table('settings')->insert(
        [
            'key' => "DOGE-reserve-amount-buy",
            'name' => "DOGE Reserve Amount Buy",
            'description' => "Value for DOGE Reserve Amount",
            'value'         => '2',
            'field'         => '{"name":"value","label":"Value", "title":"Value for DOGE Reserve Amount" ,"type":"text"}',
            'active'        => '1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);


       DB::table('settings')->insert(
        [
            'key' => "DOGE-commission-buy",
            'name' => "DOGE buy commission",
            'description' => "Commission for buy DOGE (%)",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value", "title":"Commission for buy DOGE" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        

       DB::table('settings')->insert([
            'key'           => 'twofactor_auth_status',
            'name'          => 'Two Factor Authentication Status',
            'description'   => 'Status for Two Factor',
            'value'         => '1',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);    

       DB::table('settings')->insert([
            'key'           => 'min_kyc',
            'name'          => 'Min Kyc',
            'description'   => 'Min Kyc',
            'value'         => '2',
            'field'         => '{"name":"value","label":"Value", "title":"Min Kyc" ,"type":"text"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 
        ]);

        DB::table('settings')->insert([
            'key' => "maintenance_status",
            'name' => "Maintenance Status",
            'description' => "Maintenance Status",
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"On", "0":"Off"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert([
            'key' => "maintenance_message",
            'name' => "Maintenance Message",
            'description' => "Maintenance Message",
            'value'         => 'Thank You For Your Support',
            'field'         => '{"name":"value","label":"Value", "title":"Maintenance Message" ,"type":"ckeditor"}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert(
        [
            'key' => "livefeed_status",
            'name' => "Live Feed Status",
            'description' => "Active/Inactive",
            'value'         => '1',
            'field'         => '{"name":"value","label":"Live Feed Status" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('settings')->insert([
            'key'           => 'force_email_verification_login_status',
            'name'          => 'Force Email Verification Login Status',
            'description'   => 'Force Email Verification Login Status',
            'value'         => '0',
            'field'         => '{"name":"value","label":"Value" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"), 

        ]);
    }
}
