<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
    	DB::table('countries')->Insert([
    		'name'=>'AFGHANISTAN',
			'short_name'=>'AF',
			'iso_code'=>'AFG',
			'tel_prefix'=>'93',
			'status' => 'active',
			'created_at' => date("Y-m-d H:i:s"),
		    'updated_at' => date("Y-m-d H:i:s"),    
        ]);

		DB::table('countries')->Insert([
			'name'=>'ALBANIA',
			'short_name'=>'AL',
			'iso_code'=>'ALB',
			'tel_prefix'=>'355',
			'status' => 'active',
	     	'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ALGERIA',
	'short_name'=>'DZ',
	'iso_code'=>'DZA',
	'tel_prefix'=>'213',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'AMERICAN SAMOA',
	'short_name'=>'AS',
	'iso_code'=>'ASM',
	'tel_prefix'=>'1684',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ANDORRA',
	'short_name'=>'AD',
	'iso_code'=>'AND',
	'tel_prefix'=>'376',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ANGOLA',
	'short_name'=>'AO',
	'iso_code'=>'AGO',
	'tel_prefix'=>'244',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ANGUILLA',
	'short_name'=>'AI',
	'iso_code'=>'AIA',
	'tel_prefix'=>'1264',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ANTARCTICA',
	'short_name'=>'AQ',
	'iso_code'=>'ANT',
	'tel_prefix'=>'11',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ANTIGUA AND BARBUDA',
	'short_name'=>'AG',
	'iso_code'=>'ATG',
	'tel_prefix'=>'1268',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ARGENTINA',
	'short_name'=>'AR',
	'iso_code'=>'ARG',
	'tel_prefix'=>'54',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ARMENIA',
	'short_name'=>'AM',
	'iso_code'=>'ARM',
	'tel_prefix'=>'374',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ARUBA',
	'short_name'=>'AW',
	'iso_code'=>'ABW',
	'tel_prefix'=>'297',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'AUSTRALIA',
	'short_name'=>'AU',
	'iso_code'=>'AUS',
	'tel_prefix'=>'61',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'AUSTRIA',
	'short_name'=>'AT',
	'iso_code'=>'AUT',
	'tel_prefix'=>'43',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'AZERBAIJAN',
	'short_name'=>'AZ',
	'iso_code'=>'AZE',
	'tel_prefix'=>'994',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BAHAMAS',
	'short_name'=>'BS',
	'iso_code'=>'BHS',
	'tel_prefix'=>'1242',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BAHRAIN',
	'short_name'=>'BH',
	'iso_code'=>'BHR',
	'tel_prefix'=>'973',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BANGLADESH',
	'short_name'=>'BD',
	'iso_code'=>'BGD',
	'tel_prefix'=>'880',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BARBADOS',
	'short_name'=>'BB',
	'iso_code'=>'BRB',
	'tel_prefix'=>'1246',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BELARUS',
	'short_name'=>'BY',
	'iso_code'=>'BLR',
	'tel_prefix'=>'375',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BELGIUM',
	'short_name'=>'BE',
	'iso_code'=>'BEL',
	'tel_prefix'=>'32',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BELIZE',
	'short_name'=>'BZ',
	'iso_code'=>'BLZ',
	'tel_prefix'=>'501',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BENIN',
	'short_name'=>'BJ',
	'iso_code'=>'BEN',
	'tel_prefix'=>'229',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BERMUDA',
	'short_name'=>'BM',
	'iso_code'=>'BMU',
	'tel_prefix'=>'1441',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BHUTAN',
	'short_name'=>'BT',
	'iso_code'=>'BTN',
	'tel_prefix'=>'975',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BOLIVIA',
	'short_name'=>'BO',
	'iso_code'=>'BOL',
	'tel_prefix'=>'591',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BOSNIA AND HERZEGOVINA',
	'short_name'=>'BA',
	'iso_code'=>'BIH',
	'tel_prefix'=>'387',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BOTSWANA',
	'short_name'=>'BW',
	'iso_code'=>'BWA',
	'tel_prefix'=>'267',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BOUVET ISLAND',
	'short_name'=>'BV',
	'iso_code'=>'BI',
	'tel_prefix'=>'33',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BRAZIL',
	'short_name'=>'BR',
	'iso_code'=>'BRA',
	'tel_prefix'=>'55',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BRITISH INDIAN OCEAN TERRITORY',
	'short_name'=>'IO',
	'iso_code'=>'IO',
	'tel_prefix'=>'246',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BRUNEI DARUSSALAM',
	'short_name'=>'BN',
	'iso_code'=>'BRN',
	'tel_prefix'=>'673',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BULGARIA',
	'short_name'=>'BG',
	'iso_code'=>'BGR',
	'tel_prefix'=>'359',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BURKINA FASO',
	'short_name'=>'BF',
	'iso_code'=>'BFA',
	'tel_prefix'=>'226',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'BURUNDI',
	'short_name'=>'BI',
	'iso_code'=>'BDI',
	'tel_prefix'=>'257',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CAMBODIA',
	'short_name'=>'KH',
	'iso_code'=>'KHM',
	'tel_prefix'=>'855',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CAMEROON',
	'short_name'=>'CM',
	'iso_code'=>'CMR',
	'tel_prefix'=>'237',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CANADA',
	'short_name'=>'CA',
	'iso_code'=>'CAN',
	'tel_prefix'=>'1',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CAPE VERDE',
	'short_name'=>'CV',
	'iso_code'=>'CPV',
	'tel_prefix'=>'238',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CAYMAN ISLANDS',
	'short_name'=>'KY',
	'iso_code'=>'CYM',
	'tel_prefix'=>'1345',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CENTRAL AFRICAN REPUBLIC',
	'short_name'=>'CF',
	'iso_code'=>'CAF',
	'tel_prefix'=>'236',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CHAD',
	'short_name'=>'TD',
	'iso_code'=>'TCD',
	'tel_prefix'=>'235',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CHILE',
	'short_name'=>'CL',
	'iso_code'=>'CHL',
	'tel_prefix'=>'56',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CHINA',
	'short_name'=>'CN',
	'iso_code'=>'CHN',
	'tel_prefix'=>'86',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CHRISTMAS ISLAND',
	'short_name'=>'CX',
	'iso_code'=>'CX',
	'tel_prefix'=>'61',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COCOS [ KEELING],ISLANDS',
	'short_name'=>'CC',
	'iso_code'=>'CC',
	'tel_prefix'=>'672',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COLOMBIA',
	'short_name'=>'CO',
	'iso_code'=>'COL',
	'tel_prefix'=>'57',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COMOROS',
	'short_name'=>'KM',
	'iso_code'=>'COM',
	'tel_prefix'=>'269',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CONGO',
	'short_name'=>'CG',
	'iso_code'=>'COG',
	'tel_prefix'=>'242',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
	'short_name'=>'CD',
	'iso_code'=>'COD',
	'tel_prefix'=>'242',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COOK ISLANDS',
	'short_name'=>'CK',
	'iso_code'=>'COK',
	'tel_prefix'=>'682',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COSTA RICA',
	'short_name'=>'CR',
	'iso_code'=>'CRI',
	'tel_prefix'=>'506',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'COTE DIVOIRE',
	'short_name'=>'CI',
	'iso_code'=>'CIV',
	'tel_prefix'=>'225',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CROATIA',
	'short_name'=>'HR',
	'iso_code'=>'HRV',
	'tel_prefix'=>'385',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CUBA'
	,'short_name'=>'CU'
	,'iso_code'=>'CUB'
	,'tel_prefix'=>'53',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CYPRUS',
	'short_name'=>'CY',
	'iso_code'=>'CYP',
	'tel_prefix'=>'357',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'CZECH REPUBLIC',
	'short_name'=>'CZ',
	'iso_code'=>'CZE',
	'tel_prefix'=>'420',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'DENMARK',
	'short_name'=>'DK'
	,'iso_code'=>'DNK'
	,'tel_prefix'=>'45',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'DJIBOUTI',
	'short_name'=>'DJ',
	'iso_code'=>'DJI',
	'tel_prefix'=>'253',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'DOMINICA',
	'short_name'=>'DM',
	'iso_code'=>'DMA',
	'tel_prefix'=>'1767',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'DOMINICAN REPUBLIC',
	'short_name'=>'DO',
	'iso_code'=>'DOM',
	'tel_prefix'=>'1809',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ECUADOR',
	'short_name'=>'EC',
	'iso_code'=>'ECU',
	'tel_prefix'=>'593',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'EGYPT'
	,'short_name'=>'EG'
	,'iso_code'=>'EGY'
	,'tel_prefix'=>'20',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'EL SALVADOR',
	'short_name'=>'SV',
	'iso_code'=>'SLV',
	'tel_prefix'=>'503',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'EQUATORIAL GUINEA',
	'short_name'=>'GQ',
	'iso_code'=>'GNQ',
	'tel_prefix'=>'240',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ERITREA',
	'short_name'=>'ER',
	'iso_code'=>'ERI',
	'tel_prefix'=>'291',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ESTONIA',
	'short_name'=>'EE',
	'iso_code'=>'EST',
	'tel_prefix'=>'372',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ETHIOPIA',
	'short_name'=>'ET',
	'iso_code'=>'ETH',
	'tel_prefix'=>'251',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FALKLAND ISLANDS -MALVINAS',
	'short_name'=>'FK',
	'iso_code'=>'FLK',
	'tel_prefix'=>'500',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FAROE ISLANDS',
	'short_name'=>'FO',
	'iso_code'=>'FRO',
	'tel_prefix'=>'298',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FIJI',
	'short_name'=>'FJ',
	'iso_code'=>'FJI',
	'tel_prefix'=>'679',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FINLAND',
	'short_name'=>'FI',
	'iso_code'=>'FIN',
	'tel_prefix'=>'358',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FRANCE'
	,'short_name'=>'FR'
	,'iso_code'=>'FRA'
	,'tel_prefix'=>'33',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FRENCH GUIANA',
	'short_name'=>'GF',
	'iso_code'=>'GUF',
	'tel_prefix'=>'594',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FRENCH POLYNESIA',
	'short_name'=>'PF',
	'iso_code'=>'PYF',
	'tel_prefix'=>'689',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'FRENCH SOUTHERN TERRITORIES',
	'short_name'=>'TF',
	'iso_code'=>'TF',
	'tel_prefix'=>'11',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GABON',
	'short_name'=>'GA',
	'iso_code'=>'GAB',
	'tel_prefix'=>'241',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GAMBIA',
	'short_name'=>'GM',
	'iso_code'=>'GMB',
	'tel_prefix'=>'220',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GEORGIA',
	'short_name'=>'GE',
	'iso_code'=>'GEO',
	'tel_prefix'=>'995',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GERMANY',
	'short_name'=>'DE',
	'iso_code'=>'DEU',
	'tel_prefix'=>'49',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GHANA',
	'short_name'=>'GH',
	'iso_code'=>'GHA',
	'tel_prefix'=>'233',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GIBRALTAR',
	'short_name'=>'GI',
	'iso_code'=>'GIB',
	'tel_prefix'=>'350',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GREECE',
	'short_name'=>'GR',
	'iso_code'=>'GRC',
	'tel_prefix'=>'30',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GREENLAND',
	'short_name'=>'GL',
	'iso_code'=>'GRL',
	'tel_prefix'=>'299',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GRENADA',
	'short_name'=>'GD',
	'iso_code'=>'GRD',
	'tel_prefix'=>'1473',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUADELOUPE',
	'short_name'=>'GP',
	'iso_code'=>'GLP',
	'tel_prefix'=>'590',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUAM',
	'short_name'=>'GU',
	'iso_code'=>'GUM',
	'tel_prefix'=>'1671',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUATEMALA',
	'short_name'=>'GT',
	'iso_code'=>'GTM',
	'tel_prefix'=>'502',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUINEA',
	'short_name'=>'GN',
	'iso_code'=>'GIN',
	'tel_prefix'=>'224',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUINEA-BISSAU',
	'short_name'=>'GW',
	'iso_code'=>'GNB',
	'tel_prefix'=>'245',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'GUYANA',
	'short_name'=>'GY',
	'iso_code'=>'GUY',
	'tel_prefix'=>'592',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HAITI',
	'short_name'=>'HT',
	'iso_code'=>'HTI',
	'tel_prefix'=>'509',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HEARD ISLAND AND MCDONALD ISLANDS',
	'short_name'=>'HM',
	'iso_code'=>'HM',
	'tel_prefix'=>'11',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HOLY SEE-VATICAN CITY STATE',
	'short_name'=>'VA',
	'iso_code'=>'VAT',
	'tel_prefix'=>'39',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HONDURAS',
	'short_name'=>'HN',
	'iso_code'=>'HND',
	'tel_prefix'=>'504',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HONG KONG',
	'short_name'=>'HK',
	'iso_code'=>'HKG',
	'tel_prefix'=>'852',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'HUNGARY',
	'short_name'=>'HU',
	'iso_code'=>'HUN',
	'tel_prefix'=>'36',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ICELAND',
	'short_name'=>'IS',
	'iso_code'=>'ISL',
	'tel_prefix'=>'354',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'INDIA',
	'short_name'=>'IN',
	'iso_code'=>'IND',
	'tel_prefix'=>'91',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'INDONESIA',
	'short_name'=>'ID',
	'iso_code'=>'IDN',
	'tel_prefix'=>'62',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'IRAN, ISLAMIC REPUBLIC OF',
	'short_name'=>'IR',
	'iso_code'=>'IRN',
	'tel_prefix'=>'98',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'IRAQ',
	'short_name'=>'IQ',
	'iso_code'=>'IRQ',
	'tel_prefix'=>'964',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'IRELAND',
	'short_name'=>'IE',
	'iso_code'=>'IRL',
	'tel_prefix'=>'353',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ISRAEL',
	'short_name'=>'IL',
	'iso_code'=>'ISR',
	'tel_prefix'=>'972',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ITALY',
	'short_name'=>'IT',
	'iso_code'=>'ITA',
	'tel_prefix'=>'39',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'JAMAICA',
	'short_name'=>'JM',
	'iso_code'=>'JAM',
	'tel_prefix'=>'1876',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'JAPAN',
	'short_name'=>'JP',
	'iso_code'=>'JPN',
	'tel_prefix'=>'81',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'JORDAN',
	'short_name'=>'JO',
	'iso_code'=>'JOR',
	'tel_prefix'=>'962',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KAZAKHSTAN',
	'short_name'=>'KZ',
	'iso_code'=>'KAZ',
	'tel_prefix'=>'7',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KENYA',
	'short_name'=>'KE',
	'iso_code'=>'KEN',
	'tel_prefix'=>'254',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KIRIBATI',
	'short_name'=>'KI',
	'iso_code'=>'KIR',
	'tel_prefix'=>'686',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KOREA-DEMOCRATIC PEOPLES REPUBLIC OF',
	'short_name'=>'KP',
	'iso_code'=>'PRK',
	'tel_prefix'=>'850',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KOREA, REPUBLIC OF',
	'short_name'=>'KR',
	'iso_code'=>'KOR',
	'tel_prefix'=>'82',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KUWAIT',
	'short_name'=>'KW',
	'iso_code'=>'KWT',
	'tel_prefix'=>'965',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'KYRGYZSTAN',
	'short_name'=>'KG',
	'iso_code'=>'KGZ',
	'tel_prefix'=>'996',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC',
	'short_name'=>'LA',
	'iso_code'=>'LAO',
	'tel_prefix'=>'856',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LATVIA',
	'short_name'=>'LV',
	'iso_code'=>'LVA',
	'tel_prefix'=>'371',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LEBANON',
	'short_name'=>'LB',
	'iso_code'=>'LBN',
	'tel_prefix'=>'961',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LESOTHO',
	'short_name'=>'LS',
	'iso_code'=>'LSO',
	'tel_prefix'=>'266',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LIBERIA',
	'short_name'=>'LR',
	'iso_code'=>'LBR',
	'tel_prefix'=>'231',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LIBYAN ARAB JAMAHIRIYA',
	'short_name'=>'LY',
	'iso_code'=>'LBY',
	'tel_prefix'=>'218',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LIECHTENSTEIN',
	'short_name'=>'LI',
	'iso_code'=>'LIE',
	'tel_prefix'=>'423',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LITHUANIA',
	'short_name'=>'LT',
	'iso_code'=>'LTU',
	'tel_prefix'=>'370',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'LUXEMBOURG',
	'short_name'=>'LU',
	'iso_code'=>'LUX',
	'tel_prefix'=>'352',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MACAO',
	'short_name'=>'MO',
	'iso_code'=>'MAC',
	'tel_prefix'=>'853',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
	'short_name'=>'MK',
	'iso_code'=>'MKD',
	'tel_prefix'=>'389',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MADAGASCAR',
	'short_name'=>'MG',
	'iso_code'=>'MDG',
	'tel_prefix'=>'261',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MALAWI',
	'short_name'=>'MW',
	'iso_code'=>'MWI',
	'tel_prefix'=>'265',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MALAYSIA',
	'short_name'=>'MY',
	'iso_code'=>'MYS',
	'tel_prefix'=>'60',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MALDIVES',
	'short_name'=>'MV',
	'iso_code'=>'MDV',
	'tel_prefix'=>'960',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MALI',
	'short_name'=>'ML',
	'iso_code'=>'MLI',
	'tel_prefix'=>'223',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MALTA',
	'short_name'=>'MT',
	'iso_code'=>'MLT',
	'tel_prefix'=>'356',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MARSHALL ISLANDS',
	'short_name'=>'MH',
	'iso_code'=>'MHL',
	'tel_prefix'=>'692',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MARTINIQUE',
	'short_name'=>'MQ',
	'iso_code'=>'MTQ',
	'tel_prefix'=>'596',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MAURITANIA',
	'short_name'=>'MR',
	'iso_code'=>'MRT',
	'tel_prefix'=>'222',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MAURITIUS',
	'short_name'=>'MU',
	'iso_code'=>'MUS',
	'tel_prefix'=>'230',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MAYOTTE',
	'short_name'=>'YT',
	'iso_code'=>'YT',
	'tel_prefix'=>'269',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MEXICO',
	'short_name'=>'MX',
	'iso_code'=>'MEX',
	'tel_prefix'=>'52',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MICRONESIA, FEDERATED STATES OF',
	'short_name'=>'FM',
	'iso_code'=>'FSM',
	'tel_prefix'=>'691',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MOLDOVA, REPUBLIC OF',
	'short_name'=>'MD',
	'iso_code'=>'MDA',
	'tel_prefix'=>'373',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MONACO',
	'short_name'=>'MC',
	'iso_code'=>'MCO',
	'tel_prefix'=>'377',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MONGOLIA',
	'short_name'=>'MN',
	'iso_code'=>'MNG',
	'tel_prefix'=>'976',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MONTSERRAT',
	'short_name'=>'MS',
	'iso_code'=>'MSR',
	'tel_prefix'=>'1664',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MOROCCO',
	'short_name'=>'MA',
	'iso_code'=>'MAR',
	'tel_prefix'=>'212',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MOZAMBIQUE',
	'short_name'=>'MZ',
	'iso_code'=>'MOZ',
	'tel_prefix'=>'258',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'MYANMAR',
	'short_name'=>'MM',
	'iso_code'=>'MMR',
	'tel_prefix'=>'95',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NAMIBIA',
	'short_name'=>'NA',
	'iso_code'=>'NAM',
	'tel_prefix'=>'264',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NAURU',
	'short_name'=>'NR',
	'iso_code'=>'NRU',
	'tel_prefix'=>'674',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NEPAL',
	'short_name'=>'NP',
	'iso_code'=>'NPL',
	'tel_prefix'=>'977',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NETHERLANDS',
	'short_name'=>'NL',
	'iso_code'=>'NLD',
	'tel_prefix'=>'31',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NETHERLANDS ANTILLES',
	'short_name'=>'AN',
	'iso_code'=>'ANT',
	'tel_prefix'=>'599',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NEW CALEDONIA',
	'short_name'=>'NC',
	'iso_code'=>'NCL',
	'tel_prefix'=>'687',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NEW ZEALAND',
	'short_name'=>'NZ',
	'iso_code'=>'NZL',
	'tel_prefix'=>'64',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NICARAGUA',
	'short_name'=>'NI',
	'iso_code'=>'NIC',
	'tel_prefix'=>'505',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NIGER',
	'short_name'=>'NE',
	'iso_code'=>'NER',
	'tel_prefix'=>'227',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NIGERIA',
	'short_name'=>'NG',
	'iso_code'=>'NGA',
	'tel_prefix'=>'234',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NIUE',
	'short_name'=>'NU',
	'iso_code'=>'NIU',
	'tel_prefix'=>'683',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NORFOLK ISLAND',
	'short_name'=>'NF',
	'iso_code'=>'NFK',
	'tel_prefix'=>'672',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NORTHERN MARIANA ISLANDS',
	'short_name'=>'MP',
	'iso_code'=>'MNP',
	'tel_prefix'=>'1670',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'NORWAY',
	'short_name'=>'NO',
	'iso_code'=>'NOR',
	'tel_prefix'=>'47',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'OMAN',
	'short_name'=>'OM',
	'iso_code'=>'OMN',
	'tel_prefix'=>'968',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PAKISTAN',
	'short_name'=>'PK',
	'iso_code'=>'PAK',
	'tel_prefix'=>'92',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PALAU',
	'short_name'=>'PW',
	'iso_code'=>'PLW',
	'tel_prefix'=>'680',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PALESTINIAN TERRITORY, OCCUPIED',
	'short_name'=>'PS',
	'iso_code'=>'Ps',
	'tel_prefix'=>'970',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PANAMA',
	'short_name'=>'PA',
	'iso_code'=>'PAN',
	'tel_prefix'=>'507',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PAPUA NEW GUINEA',
	'short_name'=>'PG',
	'iso_code'=>'PNG',
	'tel_prefix'=>'675',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PARAGUAY',
	'short_name'=>'PY',
	'iso_code'=>'PRY',
	'tel_prefix'=>'595',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PERU',
	'short_name'=>'PE',
	'iso_code'=>'PER',
	'tel_prefix'=>'51',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PHILIPPINES',
	'short_name'=>'PH',
	'iso_code'=>'PHL',
	'tel_prefix'=>'63',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PITCAIRN',
	'short_name'=>'PN',
	'iso_code'=>'PCN',
	'tel_prefix'=>'11',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'POLAND',
	'short_name'=>'PL',
	'iso_code'=>'POL',
	'tel_prefix'=>'48',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PORTUGAL',
	'short_name'=>'PT',
	'iso_code'=>'PRT',
	'tel_prefix'=>'351',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'PUERTO RICO',
	'short_name'=>'PR',
	'iso_code'=>'PRI',
	'tel_prefix'=>'1787',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'QATAR',
	'short_name'=>'QA',
	'iso_code'=>'QAT',
	'tel_prefix'=>'974',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'REUNION',
	'short_name'=>'RE',
	'iso_code'=>'REU',
	'tel_prefix'=>'262',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ROMANIA',
	'short_name'=>'RO',
	'iso_code'=>'ROM',
	'tel_prefix'=>'40',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'RUSSIAN FEDERATION',
	'short_name'=>'RU',
	'iso_code'=>'RUS',
	'tel_prefix'=>'70',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'RWANDA',
	'short_name'=>'RW',
	'iso_code'=>'RWA',
	'tel_prefix'=>'250',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAINT HELENA',
	'short_name'=>'SH',
	'iso_code'=>'SHN',
	'tel_prefix'=>'290',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAINT KITTS AND NEVIS',
	'short_name'=>'KN',
	'iso_code'=>'KNA',
	'tel_prefix'=>'1869',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAINT LUCIA',
	'short_name'=>'LC',
	'iso_code'=>'LCA',
	'tel_prefix'=>'1758',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAINT PIERRE AND MIQUELON',
	'short_name'=>'PM',
	'iso_code'=>'SPM',
	'tel_prefix'=>'508',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAINT VINCENT AND THE GRENADINES',
	'short_name'=>'VC',
	'iso_code'=>'VCT',
	'tel_prefix'=>'1784',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAMOA',
	'short_name'=>'WS',
	'iso_code'=>'WSM',
	'tel_prefix'=>'684',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAN MARINO',
	'short_name'=>'SM',
	'iso_code'=>'SMR',
	'tel_prefix'=>'378',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAO TOME AND PRINCIPE',
	'short_name'=>'ST',
	'iso_code'=>'STP',
	'tel_prefix'=>'239',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SAUDI ARABIA',
	'short_name'=>'SA',
	'iso_code'=>'SAU',
	'tel_prefix'=>'966',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SENEGAL',
	'short_name'=>'SN',
	'iso_code'=>'SEN',
	'tel_prefix'=>'221',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SERBIA AND MONTENEGRO',
	'short_name'=>'CS',
	'iso_code'=>'CS',
	'tel_prefix'=>'381',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SEYCHELLES',
	'short_name'=>'SC',
	'iso_code'=>'SYC',
	'tel_prefix'=>'248',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SIERRA LEONE',
	'short_name'=>'SL',
	'iso_code'=>'SLE',
	'tel_prefix'=>'232',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SINGAPORE',
	'short_name'=>'SG',
	'iso_code'=>'SGP',
	'tel_prefix'=>'65',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SLOVAKIA',
	'short_name'=>'SK',
	'iso_code'=>'SVK',
	'tel_prefix'=>'421',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SLOVENIA',
	'short_name'=>'SI',
	'iso_code'=>'SVN',
	'tel_prefix'=>'386',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SOLOMON ISLANDS',
	'short_name'=>'SB',
	'iso_code'=>'SLB',
	'tel_prefix'=>'677',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SOMALIA',
	'short_name'=>'SO',
	'iso_code'=>'SOM',
	'tel_prefix'=>'252',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SOUTH AFRICA',
	'short_name'=>'ZA',
	'iso_code'=>'ZAF',
	'tel_prefix'=>'27',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
	'short_name'=>'GS',
	'iso_code'=>'GS',
	'tel_prefix'=>'11',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SPAIN',
	'short_name'=>'ES',
	'iso_code'=>'ESP',
	'tel_prefix'=>'34',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SRI LANKA',
	'short_name'=>'LK',
	'iso_code'=>'LKA',
	'tel_prefix'=>'94',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SUDAN',
	'short_name'=>'SD',
	'iso_code'=>'SDN',
	'tel_prefix'=>'249',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SURINAME',
	'short_name'=>'SR',
	'iso_code'=>'SUR',
	'tel_prefix'=>'597',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SVALBARD AND JAN MAYEN'
	,'short_name'=>'SJ'
	,'iso_code'=>'SJM'
	,'tel_prefix'=>'47',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SWAZILAND',
	'short_name'=>'SZ',
	'iso_code'=>'SWZ',
	'tel_prefix'=>'268',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SWEDEN',
	'short_name'=>'SE',
	'iso_code'=>'SWE',
	'tel_prefix'=>'46',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SWITZERLAND',
	'short_name'=>'CH',
	'iso_code'=>'CHE',
	'tel_prefix'=>'41',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'SYRIAN ARAB REPUBLIC',
	'short_name'=>'SY',
	'iso_code'=>'SYR',
	'tel_prefix'=>'963',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TAIWAN, PROVINCE OF CHINA',
	'short_name'=>'TW',
	'iso_code'=>'TWN',
	'tel_prefix'=>'886',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TAJIKISTAN',
	'short_name'=>'TJ',
	'iso_code'=>'TJK',
	'tel_prefix'=>'992',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TANZANIA, UNITED REPUBLIC OF',
	'short_name'=>'TZ',
	'iso_code'=>'TZA',
	'tel_prefix'=>'255',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'THAILAND',
	'short_name'=>'TH',
	'iso_code'=>'THA',
	'tel_prefix'=>'66',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TIMOR-LESTE',
	'short_name'=>'TL',
	'iso_code'=>'TL',
	'tel_prefix'=>'670',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TOGO',
	'short_name'=>'TG',
	'iso_code'=>'TGO',
	'tel_prefix'=>'228',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TOKELAU',
	'short_name'=>'TK',
	'iso_code'=>'TKL',
	'tel_prefix'=>'690',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TONGA',
	'short_name'=>'TO',
	'iso_code'=>'TON',
	'tel_prefix'=>'676',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TRINIDAD AND TOBAGO',
	'short_name'=>'TT',
	'iso_code'=>'TTO',
	'tel_prefix'=>'1868',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TUNISIA',
	'short_name'=>'TN',
	'iso_code'=>'TUN',
	'tel_prefix'=>'216',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TURKEY'
	,'short_name'=>'TR'
	,'iso_code'=>'TUR'
	,'tel_prefix'=>'90',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TURKMENISTAN',
	'short_name'=>'TM',
	'iso_code'=>'TKM',
	'tel_prefix'=>'7370',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TURKS AND CAICOS ISLANDS',
	'short_name'=>'TC',
	'iso_code'=>'TCA',
	'tel_prefix'=>'1649',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'TUVALU',
	'short_name'=>'TV',
	'iso_code'=>'TUV',
	'tel_prefix'=>'688',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UGANDA',
	'short_name'=>'UG',
	'iso_code'=>'UGA',
	'tel_prefix'=>'256',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UKRAINE',
	'short_name'=>'UA',
	'iso_code'=>'UKR',
	'tel_prefix'=>'380',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UNITED ARAB EMIRATES',
	'short_name'=>'AE',
	'iso_code'=>'ARE',
	'tel_prefix'=>'971',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UNITED KINGDOM',
	'short_name'=>'GB',
	'iso_code'=>'GBR',
	'tel_prefix'=>'44',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UNITED STATES',
	'short_name'=>'US',
	'iso_code'=>'USA',
	'tel_prefix'=>'1',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UNITED STATES MINOR OUTLYING ISLANDS',
	'short_name'=>'UM',
	'iso_code'=>'UM',
	'tel_prefix'=>'1',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'URUGUAY',
	'short_name'=>'UY',
	'iso_code'=>'URY',
	'tel_prefix'=>'598',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'UZBEKISTAN',
	'short_name'=>'UZ',
	'iso_code'=>'UZB',
	'tel_prefix'=>'998',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'VANUATU',
	'short_name'=>'VU',
	'iso_code'=>'VUT',
	'tel_prefix'=>'678',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'VENEZUELA',
	'short_name'=>'VE',
	'iso_code'=>'VEN',
	'tel_prefix'=>'58',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'VIET NAM',
	'short_name'=>'VN',
	'iso_code'=>'VNM',
	'tel_prefix'=>'84',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'VIRGIN ISLANDS, BRITISH',
	'short_name'=>'VG',
	'iso_code'=>'VGB',
	'tel_prefix'=>'1284',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'VIRGIN ISLANDS, U.S.',
	'short_name'=>'VI',
	'iso_code'=>'VIR',
	'tel_prefix'=>'1340',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'WALLIS AND FUTUNA',
	'short_name'=>'WF',
	'iso_code'=>'WLF',
	'tel_prefix'=>'681',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'WESTERN SAHARA',
	'short_name'=>'EH',
	'iso_code'=>'ESH',
	'tel_prefix'=>'212',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'YEMEN',
	'short_name'=>'YE',
	'iso_code'=>'YEM',
	'tel_prefix'=>'967',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ZAMBIA',
	'short_name'=>'ZM',
	'iso_code'=>'ZMB',
	'tel_prefix'=>'260',
	     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

DB::table('countries')->Insert(
	['name'=>'ZIMBABWE',
	'short_name'=>'ZW',
	'iso_code'=>'ZWE',
	'tel_prefix'=>'263',     'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
    }
}
