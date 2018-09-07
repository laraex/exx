<?php

use Illuminate\Database\Seeder;

class MailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mail_templates')->insert([
        	'name' =>'admin_notify_kyc_verified',
           	'subject' => 'Kyc Verified',
           	'mail_content' => 'Hi :name <br> 
                                :username send the KYC document for your verification. <br> 
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
        	'name' =>'admin_notify_new_fund',
           	'subject' => 'New Fund',
           	'mail_content' => 'Hi :name <br> 
                                Added Fund Amount 
                                :deposited_amount 
                                :currency <br> 
                                :username added fund and waiting for your approval <br>
                                Thanks & Regards <br> 
                                <p>Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'admin_notify_new_ticket',
            'subject' => 'New Ticket',
            'mail_content' => 'Hi :name <br> 
                                :user raised a new ticket under 
                                    :category category with 
                                    :priority priority in 
                                    :status status and it is assigned to 
                                    :staff. Below Ticket details are: <br> 
                                Subject :subject <br> 
                                Description :content <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'admin_notify_new_user',
            'subject' => 'New User',
            'mail_content' => 'Hi :name <br> 
                                Registered a new user. Please login to see details. <br> 
                                User Name :username <br> 
                                IP Address :ip_address <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br> 
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'admin_notify_ticket_status',
            'subject' => 'Admin Notify Ticket Status',
            'mail_content' => 'Hi :name <br> 
                                :user raised ticket has now changed to 
                                :status by 
                                :staff. Below Ticket details are: <br> 
                                Subject :subject <br> 
                                Description :content <br>
                                Category :category <br> 
                                Priority :priority <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'change_password',
            'subject' => 'Change Password',
            'mail_content' => 'Hi :name <br> 
                                Your Password is changed successfully. <br> 
                                Thanks & Regards <br> 
                                <p>Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'contact_us',
            'subject' => 'Contact Us',
            'mail_content' => 'Hi :name <br> 
                                :fromname send to the below queries, <br>
                                :queries <br>
                                Thanks & Regards <br> 
                                Administration Team <br>
                                :contactno <br>
                                :skypeid <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'email_verification',
            'subject' => 'Email Verification',
            'mail_content' => 'Hi :name <br> 
                                Please verify your email, click this link <br> 
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click To Verify</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'fund_add_new_status',
            'subject' => 'New Status',
            'mail_content' => 'Hi :name <br> 
                                Your deposit :amount :currency has been successful. It will be approved after verification. <br> 
                                Transaction Number :transaction_number <br>
                                Thanks & Regards <br> 
                                <p>Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'fund_transfer_receiver',
            'subject' => 'Fund Transfer Received',
            'mail_content' => 'Hi :name <br> 
                                You have received a fund amount of 
                                :amount 
                                :currency from 
                                :sender. <br> 
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'fund_transfer_sender',
            'subject' => 'Fund Transfer Sender',
            'mail_content' => 'Hi :name <br> 
                                You have transferred a fund amount of 
                                :amount 
                                :currency to 
                                :receiver. <br> 
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'kyc_upload_successfull',
            'subject' => 'KYC Upload Successfully',
            'mail_content' => 'Hi :name <br> 
                                :username uploaded :proof successfully! <br> 
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'otp',
            'subject' => 'OTP',
            'mail_content' => 'Hi :name <br> 
                                Verify OTP :otp <br> 
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click OTP Link</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'register_new_user',
            'subject' => 'Register New User',
            'mail_content' => 'Hi :name <br> 
                                Your account was successfully created. <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'reset_password',
            'subject' => 'Reset Password',
            'mail_content' => 'Hi :username <br> 
                                Please reset your password to click below link. <br>
                                <a href= " :resetlink" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Reset Password</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'reset_transaction_password',
            'subject' => 'Reset Transaction Password',
            'mail_content' => 'Hi :username <br> 
                                Your transaction password is successfully reset. <br>
                                New transaction password is : <br>
                                :new_transaction_password <br>
                                <a href= " :reset_transaction_password_link" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to set new transaction password here.</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'reset_user_transaction_password',
            'subject' => 'Reset User Transaction Password',
            'mail_content' => 'Hi :name <br> 
                                your new transaction token <br>
                                :token, <br>
                                <a href= " :resetlink" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Reset Password</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'send_mail_touser',
            'subject' => 'Send Mail to User',
            'mail_content' => 'Hi :name, <br> 
                                :message <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);
        
        DB::table('mail_templates')->insert([
            'name' =>'staff_notify_ticket',
            'subject' => 'Staff Notify Ticket',
            'mail_content' => 'Hi :name, <br> 
                                :user raised a new ticket under 
                                :category category with 
                                :priority priority in 
                                :status status is assigned to you. Below Ticket details are: <br>
                                Subject :subject <br>
                                Description :content <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'staff_notify_ticket_status',
            'subject' => 'Staff Notify Ticket Status',
            'mail_content' => 'Hi :name, <br> 
                                :user raised ticket has now changed to 
                                :status by 
                                :admin. Below Ticket details are: <br>
                                Subject :subject <br>
                                Description :content <br>
                                Category :category <br>
                                Priority :priority <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'transaction_password',
            'subject' => 'Transaction Password',
            'mail_content' => 'Hi :name <br> 
                                Your Transaction Password is created successfully. <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'user_notify_kycreject',
            'subject' => 'User Notify KYC Reject',
            'mail_content' => 'Hi :name <br> 
                                Your KYC :proof is Rejected <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'user_notify_kycverify',
            'subject' => 'User Notify KYC Verify',
            'mail_content' => 'Hi :name <br> 
                                :proof KYC Verified successfully! <br> 
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'user_notify_ticket_status',
            'subject' => 'User Notify Ticket Status',
            'mail_content' => 'Hi :name <br> 
                                Your ticket has now changed to 
                                :status by 
                                :staff. Below Ticket details are: <br>
                                Subject :subject <br> 
                                Description :content <br>
                                Category :category <br> 
                                Priority :priority <br>
                                <a href= " :url" style="border: none;
                                    color: white; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; background-color: #008CBA;">Click to Login</a> <br>
                                Thanks & Regards <br>
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'user_send_ticket',
            'subject' => 'User Send Ticket',
            'mail_content' => 'Hi :name, <br> 
                                You raised a new ticket under 
                                :category category with 
                                :priority priority in 
                                :status status and it is assigned to 
                                :staff. Below Ticket details are: <br>
                                Subject :subject <br>
                                Description :content <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'withdraw_approve',
            'subject' => 'Withdraw Approve',
            'mail_content' => 'Hi :name, <br> 
                                Your withdraw request 
                                :amount 
                                :currency is approved by admin, and comments are below. <br>
                                :comments <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'withdraw_reject',
            'subject' => 'Withdraw Reject',
            'mail_content' => 'Hi :name, <br> 
                                Your withdraw request 
                                :amount 
                                :currency is rejected by admin, for the following below reason, <br>
                                :comments <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

        DB::table('mail_templates')->insert([
            'name' =>'withdraw_send',
            'subject' => 'Withdraw Send',
            'mail_content' => 'Hi :username, <br> 
                                :name send from the withdraw request <br>
                                Withdraw request amount is :amount <br>
                                Currency :currency <br>
                                Thanks & Regards <br> 
                                Administration Team <br>',
            'status' => 'active',
        ]);

    }
}