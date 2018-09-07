<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(UsergroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserprofilesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(UsercurrencyaccountsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(PaymentgatewaysTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(TicketStatusesTableSeeder::class);
        $this->call(TicketPrioritiesTableSeeder::class);
        $this->call(TicketCategoriesTableSeeder::class);
        $this->call(TicketCategoriesUsersTableSeeder::class);
        $this->call(AccountingcodesTableSeeder::class);
        $this->call(ReferralgroupsTableSeeder::class);
        $this->call(CurrencyPairTableSeeder::class);
        $this->call(CurrencyMasterTableSeeder::class);
        $this->call(SocialLinksSeeder::class);
        $this->call(UserInformationTableSeeder::class);
        $this->call(MailTemplatesSeeder::class);
        $this->call(TradeCurrencyPairTableSeeder::class);
        $this->call(Erc20tokenTableSeeder::class);
        $this->call(NationalityMasterTableSeeder::class);
        
    }

}
