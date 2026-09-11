<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Warehouse;

class RegionWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data from your NEW_SITES.xlsx file
        $data = [
            'AHMEDABAD' => ['ANAND', 'BARODA-I', 'VADOD', 'KARACHIA', 'NADIAD'],

            'BANGALORE' => ['BANG-I/APMC/YESHWANTPURA', 'BELGAUM', 'BIDAR', 'DAVANGERE', 'DHARWAD', 'GADAG-I', 'GADAG-II(PEG)', 'GULBARGA-I', 'GULBARGA-II', 'HUBLI', 'NARGUND', 'SEDAM', 'SHIKARIPUR', 'SOUNDATTI', 'TUMKUR/GUBBI'],

            'BHOPAL' => ['BALAGHAT(PEG)', 'BHIND(PEG)', 'BHOPAL-I', 'BURHANPUR-I', 'CHHINDWARA(PEG)', 'KATNI', 'MAKSI(PEG)', 'MALANPUR', 'MORENA-I', 'MORENA-II(PEG)', 'NARSINGHPUR-I(PEG)', 'SANWAR', 'SHEOPURKALAN-I', 'SHEOPURKALAN-II(PEG)', 'SOHAGPUR'],

            'RAIPUR' => ['BHATAPARA-I (PEG)', 'BHATAPARA-II', 'BILASPUR-I', 'BILASPUR-II(PEG)', 'DHAMTARI', 'RAIGARH-I', 'RAIGARH-II(PEG)', 'RAIPUR-IV'],

            'CHANDIGARH' => ['ABOHAR-I', 'BATHINDA (PEG)', 'BHOGPUR', 'CHANALON', 'DRASS', 'ZANSKAR', 'GARSHANKAR', 'GURDASPUR', 'HOSHIARPUR', 'MANDI GOBINDGARH(PEG)', 'MANSA', 'MOGA-I', 'MOGA-II(PEG)', 'MOHALI', 'NABHA', 'NABHA BD', 'ROPAR(PEG)', 'SIRHIND'],

            'PANCHKULA' => ['ASSANDH', 'BARHI', 'CHARKHI DADRI', 'BIBIPUR (JIND)', 'MANDI ADAMPUR', 'DEHRA(PEG)', 'HISSAR', 'INDRI', 'JAGADHARI', 'KAITHAL', 'KARNAL-I', 'KARNAL-III', 'LADWA', 'MANDI', 'NARAINGARH', 'NARWANA', 'SIRSA', 'SOLAN', 'SONEPAT', 'TOHANA(PEG)'],

            'CHENNAI' => ['CHIDAMBARAM', 'CUDDALORE(PEG)', 'HOSUR(PEG)', 'KUMBAKONAM', 'MADURAI-II', 'MANNARGUDI', 'NAGERCOIL', 'SINGANALLUR ACC AND ICD', 'THANJAVUR', 'THOOTHUKUDI CFS', 'TRICHY', 'UDUMALPET', 'VIRUDHUNAGAR(PEG)'],

            'DELHI' => ['JASPUR', 'KASHIPUR-I', 'KASHIPUR-II', 'KHATIMA', 'SRI NAGAR(PEG)'],

            'GUWAHATI' => ['DHUBRI', 'DIMAPUR', 'JORHAT-I', 'SORBHOG'],

            'HYDERABAD' => ['ADILABAD', 'ADONI', 'BODHAN(PEG)', 'DUGGIRALA', 'GADWAL(PEG)', 'GUDIVADA', 'KADAPA (Part-I)', 'KAIKALUR', 'KAKINADA', 'KARIMNAGAR-I', 'MACHILIPATNAM', 'MEHABOOBNAGAR', 'NANDIKOTKUR', 'NANDYAL', 'NIDAMANUR', 'NIZAMABAD', 'ONGOLE', 'PEDAKAKANI', 'RAJAHMUNDRY', 'SARANGPUR', 'SIDDIPET', 'SURYAPET', 'TADEPALLIGUDEM', 'VADLAMUDI', 'VIJAYWADA-II'],

            'JAIPUR' => ['BARAN', 'BHARATPUR', 'BIKANER-I', 'BIKANER-II', 'CHOMU', 'DEOLI', 'HANUMANGARH -I', 'HANUMANGARH -II', 'JHUNJHUNU', 'KOTPUTLI', 'SIKAR', 'SITAPURA-II', 'SRIGANGANAGAR-I', 'SRIGANGANAGAR-II', 'SRIMADHOPUR'],

            'KOCHI' => ['EDATHALA,ALUVA', 'KAKKANAD', 'KAKKANCHERRY', 'KANJIKODE/PALLAKAD', 'KUNNAMTHANAM(PEG)'],

            'BHUBANESWAR' => ['ASKA(PEG)', 'BALASORE II', 'BALASORE(PEG)', 'BALJITPARA(PEG)', 'BARGARH-I', 'BERHAMPUR', 'BOLANGIR(PEG)', 'CHOUDWAR', 'JATNI(PEG)', 'JEYPORE', 'JUNAGARH(PEG)', 'KALAMATI', 'KENDUPALLI-I(PEG)', 'KENDUPALLI-II(PEG)', 'KOKSARA(PEG)', 'MARSHAGHAI(PEG)', 'NABARANGPUR(PEG)', 'SONEPUR(PEG)'],

            'KOLKATA' => ['BERHAMPORE(PEG)', 'CHANDRAKONA ROAD(PEG)', 'DURGACHAK', 'GARDEN REACH', 'KHARAGPUR(PEG)', 'MALDA(PEG)', 'MOGRA(GOARA)', 'PANIHATI', 'SARGACHI(PEG)', 'SARUL'],

            'LUCKNOW' => ['BAHRAICH', 'BALLIA', 'BANDA', 'BASTI', 'BHADOHI', 'BIJNORE', 'BISALPUR', 'CHANDAUSI-I', 'CHANDAUSI-II', 'CHIRGAON', 'DUMARIAGANJ', 'ETAWAH', 'FAIZABAD', 'GOLA GOKARNATH', 'HARDOI(PEG)', 'JAHANGIRABAD-I', 'JAHANGIRABAD-II', 'MAUNATH BHANJAN', 'MUZAFFAR NAGAR BD', 'MUZAFFAR NAGAR-I', 'NAINI(PEG)', 'RAMPUR', 'ROBERTSGANJ', 'SAHARANPUR BD', 'SHAHGANJ', 'SHAHJAHANPUR', 'SHAMLI'],

            'MUMBAI' => ['AKOLA-I', 'AKOLA-II(PEG)', 'AMBERNATH-I', 'GONDIA-II(PEG)', 'MIRAJ', 'MIRAJ BD', 'SANGLI', 'YAVATMAL(PEG)'],

            'PATNA' => ['BETTIAH(PEG)', 'DARBHANGA', 'HAZARIBAGH', 'KATIHAR', 'KHAGARIA(PEG)', 'MADHEPURA', 'MUNGER', 'SUPAUL'],
        ];

        $totalRegions = 0;
        $totalWarehouses = 0;

        foreach ($data as $regionName => $warehouses) {
            // Create or get region
            $region = Region::firstOrCreate(['name' => $regionName]);
            $totalRegions++;

            echo "✓ Region: {$regionName}\n";

            // Create warehouses for this region
            foreach ($warehouses as $warehouseName) {
                Warehouse::firstOrCreate([
                    'region_id' => $region->id,
                    'warehouse' => $warehouseName,
                    'location' => $regionName, // Using region name as location
                ]);
                $totalWarehouses++;
            }

            echo "  → Created " . count($warehouses) . " warehouses\n";
        }

        echo "\n✓ Successfully seeded {$totalRegions} regions and {$totalWarehouses} warehouses\n\n";
    }
}
