<?php

namespace Lb;

class DepartementHelper
{

    // All region FR
    public static $regionName = array(
        'alsace' => '67,68',
        'aquitaine' => '24,33,40,47,64',
        'auvergne' => '03,15,43,63',
        'basse-normandie' => '14,50,61',
        'bourgogne' => '21,58,71,89',
        'bretagne' => '22,29,35,56',
        'centre' => '18,28,36,37,41,45',
        'champagne-ardenne' => '08,10,51,52',
        'corse' => '20',
        'franche-comte' => '25,39,70,90',
        'haute-normandie' => '27,76',
        'ile-de-france' => '75,77,78,91,92,93,94,95',
        'languedoc-roussillon' => '11,30,34,48,66',
        'limousin' => '19,23,87',
        'lorraine' => '54,55,57,88',
        'midi-pyrenees' => '09,12,31,32,46,65,81,82',
        'nord-pas-de-calais' => '59,62',
        'outre-mer' => '971,972,973,974,976', 
        'pays-de-la-loire' => '44,49,53,72,85',
        'picardie' => '02,60,80',
        'poitou-charentes' => '16,17,79,86',
        'provence-alpes-cote-d-azur' => '04,05,06,13,83,84',
        'rhone-alpes' => '01,07,26,38,42,69,73,74',
    );
    
    public static $regionRealName = array(
        'alsace' => 'Alsace',
        'aquitaine' => 'Aquitaine',
        'auvergne' => 'Auvergne',
        'basse-normandie' => 'Basse-Normandie',
        'bourgogne' => 'Bourgogne',
        'bretagne' => 'Bretagne',
        'centre' => 'Centre',
        'champagne-ardenne' => 'Champagne-Ardenne',
        'corse' => 'Corse',
        'franche-comte' => 'Franche-Comté',
        'haute-normandie' => 'Haute-Normandie',
        'ile-de-france' => 'Ile-de-France',
        'languedoc-roussillon' => 'Languedoc-Roussillon',
        'limousin' => 'Limousin',
        'lorraine' => 'Lorraine',
        'midi-pyrenees' => 'Midi-Pyrénées',
        'nord-pas-de-calais' => 'Nord-Pas de Calais',
        'outre-mer' => 'Outre-Mer', 
        'pays-de-la-loire' => 'Pays de la Loire',
        'picardie' => 'Picardie',
        'poitou-charentes' => 'Poitou-Charentes',
        'provence-alpes-cote-d-azur' => 'Provence-Alpes-Côte d\'Azur',
        'rhone-alpes' => 'Rhône-Alpes',
    );

    public static $regionCord = array(
        'alsace'                     => array('lat' => 48.24906, 'lng' => 7.5372876),   
        'aquitaine'                  => array('lat' => 44.24615, 'lng' => -0.1720401),  
        'auvergne'                   => array('lat' => 45.7100344, 'lng' => 3.2768445), 
        'basse-normandie'            => array('lat' => 48.9538229, 'lng' => -0.48921),  
        'bourgogne'                  => array('lat' => 47.5622854, 'lng' => 6.90629),   
        'bretagne'                   => array('lat' => 47.5909545, 'lng' => 6.997231),  
        'centre'                     => array('lat' => 47.6439674, 'lng' => 1.5905734), 
        'champagne-ardenne'          => array('lat' => 48.872864, 'lng' => 4.6373454),  
        'corse'                      => array('lat' => 42.1805878, 'lng' => 9.0473778), 
        'franche-comte'              => array('lat' => 47.1424245, 'lng' => 6.1973485), 
        'haute-normandie'            => array('lat' => 49.369262, 'lng' => 0.934343),   
        'ile-de-france'              => array('lat' => 48.6807925, 'lng' => 2.5025884), 
        'languedoc-roussillon'       => array('lat' => 43.6543875, 'lng' => 3.266995),  
        'limousin'                   => array('lat' => 45.6878315, 'lng' => 1.6202715), 
        'lorraine'                   => array('lat' => 48.715081, 'lng' => 6.264212),   
        'midi-pyrenees'              => array('lat' => 43.8090865, 'lng' => 1.5622975), 
        'nord-pas-de-calais'         => array('lat' => 50.5290254, 'lng' => 2.8936409), 
        'pays-de-la-loire'           => array('lat' => 47.417262, 'lng' => -0.8214825), 
        'picardie'                   => array('lat' => 49.6017669, 'lng' => 2.8176709), 
        'poitou-charentes'           => array('lat' => 46.1323699, 'lng' => -0.1747195),
        'provence-alpes-cote-d-azur' => array('lat' => 44.0544365, 'lng' => 5.9746),    
        'rhone-alpes'                => array('lat' => 45.317723, 'lng' => 5.4372395),  
    );

    // All departement FR
    public static $departmentName = array(
        "01" => "Ain",
        "02" => "Aisne",
        "03" => "Allier",
        "04" => "Alpes-de-Haute Provence",
        "05" => "Hautes-Alpes",
        "06" => "Alpes Maritimes",
        "07" => "Ardèche",
        "08" => "Ardennes",
        "09" => "Ariège",
        "10" => "Aube",
        "11" => "Aude",
        "12" => "Aveyron",
        "13" => "Bouches-du-Rhône",
        "14" => "Calvados",
        "15" => "Cantal",
        "16" => "Charente",
        "17" => "Charente-Maritime",
        "18" => "Cher",
        "19" => "Corrèze",
        "20" => "Corse",
        "21" => "Côte d'Or",
        "22" => "Côtes d'Armor",
        "23" => "Creuse",
        "24" => "Dordogne",
        "25" => "Doubs",
        "26" => "Drôme",
        "27" => "Eure",
        "28" => "Eure-et-Loire",
        "29" => "Finistère",
        "30" => "Gard",
        "31" => "Haute-Garonne",
        "32" => "Gers",
        "33" => "Gironde",
        "34" => "Hérault",
        "35" => "Ille-et-Vilaine",
        "36" => "Indre",
        "37" => "Indre-et-Loire",
        "38" => "Isère",
        "39" => "Jura",
        "40" => "Landes",
        "41" => "Loir-et-Cher",
        "42" => "Loire",
        "43" => "Haute-Loire",
        "44" => "Loire-Atlantique",
        "45" => "Loiret",
        "46" => "Lot",
        "47" => "Lot-et-Garonne",
        "48" => "Lozère",
        "49" => "Maine-et-Loire",
        "50" => "Manche",
        "51" => "Marne",
        "52" => "Haute-Marne",
        "53" => "Mayenne",
        "54" => "Meurthe-et-Moselle",
        "55" => "Meuse",
        "56" => "Morbihan",
        "57" => "Moselle",
        "58" => "Nièvre",
        "59" => "Nord",
        "60" => "Oise",
        "61" => "Orne",
        "62" => "Pas-de-Calais",
        "63" => "Puy-de-Dôme",
        "64" => "Pyrenées-Atlantiques",
        "65" => "Hautes-Pyrenées",
        "66" => "Pyrenées-Orientales",
        "67" => "Bas-Rhin",
        "68" => "Haut-Rhin",
        "69" => "Rhône",
        "70" => "Haute-Saône",
        "71" => "Saône-et-Loire",
        "72" => "Sarthe",
        "73" => "Savoie",
        "74" => "Haute-Savoie",
        "75" => "Paris",
        "76" => "Seine-Maritime",
        "77" => "Seine-et-Marne",
        "78" => "Yvelines",
        "79" => "Deux-Sèvres",
        "80" => "Somme",
        "81" => "Tarn",
        "82" => "Tarn-et-Garonne",
        "83" => "Var",
        "84" => "Vaucluse",
        "85" => "Vendée",
        "86" => "Vienne",
        "87" => "Haute-Vienne",
        "88" => "Vosges",
        "89" => "Yonne",
        "90" => "Territoire de Belfort",
        "91" => "Essonne",
        "92" => "Hauts-de-Seine",
        "93" => "Seine-Saint-Denis",
        "94" => "Val-de-Marne",
        "95" => "Val-d'Oise",
        "971" => "Guadeloupe",
        "972" => "Martinique",
        "973" => "Guyane",
        "974" => "Réunion",
        "976" => "Mayotte",
    );
    
    // All departement FR limitrophe
    public static $departmentLimitrophe = array(
        '01' => '38,39,69,71,73,74',
        '02' => '08,51,59,60,77,80',
        '03' => '18,23,42,58,63,71',
        '04' => '05,06,26,83,84',
        '05' => '04,26,38,73',
        '06' => '04,83',
        '07' => '26,30,38,42,43,48,84',
        '08' => '02,51,55',
        '09' => '11,31,66',
        '10' => '21,51,52,77,89',
        '11' => '09,31,34,66,81',
        '12' => '15,30,34,46,48,81,82',
        '13' => '30,83,84',
        '14' => '27,50,61,76',
        '15' => '12,19,43,46,48,63',
        '16' => '17,24,79,86,87',
        '17' => '16,24,33,79,85',
        '18' => '03,23,36,41,45,58',
        '19' => '15,23,24,46,63,87',
        '2A' => '2B',
        '2B' => '2A',
        '21' => '10,39,52,58,70,71,89',
        '22' => '29,35,56',
        '23' => '03,18,19,36,63,87',
        '24' => '16,17,19,33,46,47,87',
        '25' => '39,70,90',
        '26' => '04,05,07,38,84',
        '27' => '14,28,60,61,76,78,95',
        '28' => '27,41,45,61,72,78,91',
        '29' => '22,56',
        '30' => '07,12,13,34,48,84',
        '31' => '09,11,32,65,81,82',
        '32' => '31,40,47,64,65,82',
        '33' => '17,24,40,47',
        '34' => '11,12,30,81',
        '35' => '22,44,49,50,53,56',
        '36' => '18,23,37,41,86,87',
        '37' => '36,41,49,72,86',
        '38' => '01,05,07,26,42,69,73',
        '39' => '01,21,25,70,71',
        '40' => '32,33,47,64',
        '41' => '18,28,36,37,45,72',
        '42' => '03,07,38,43,63,69,71',
        '43' => '07,15,42,48,63',
        '44' => '35,49,56,85',
        '45' => '18,28,41,58,77,89,91',
        '46' => '12,15,19,24,47,82',
        '47' => '24,32,33,40,46,82',
        '48' => '07,12,15,30,43',
        '49' => '35,37,44,53,72,79,85,86',
        '50' => '14,35,53,61',
        '51' => '02,08,10,52,55,77',
        '52' => '10,21,51,55,70,88',
        '53' => '35,49,50,61,72',
        '54' => '55,57,67,88',
        '55' => '08,51,52,54,88',
        '56' => '22,29,35,44',
        '57' => '54,67',
        '58' => '03,18,21,45,71,89',
        '59' => '02,62,80',
        '60' => '02,27,76,77,80,95',
        '61' => '14,27,28,50,53,72',
        '62' => '59,80',
        '63' => '03,15,19,23,42,43',
        '64' => '32,40,65',
        '65' => '31,32,64',
        '66' => '09,11',
        '67' => '54,57,68,88',
        '68' => '67,88,90',
        '69' => '01,38,42,71',
        '70' => '21,25,39,52,88,90',
        '71' => '01,03,21,39,42,58,69',
        '72' => '28,37,41,49,53,61',
        '73' => '01,05,38,74',
        '74' => '01,73',
        '75' => '92,93,94',
        '76' => '14,27,60,80',
        '77' => '02,10,45,51,60,89,91,93,94,95',
        '78' => '27,28,91,92,95',
        '79' => '16,17,49,85,86',
        '80' => '02,59,60,62,76',
        '81' => '11,12,31,34,82',
        '82' => '12,31,32,46,47,81',
        '83' => '04,06,13,84',
        '84' => '04,07,13,26,30,83',
        '85' => '17,44,49,79',
        '86' => '16,36,37,49,79,87',
        '87' => '16,19,23,24,36,86',
        '88' => '52,54,55,67,68,70,90',
        '89' => '10,21,45,58,77',
        '90' => '25,68,70,88',
        '91' => '28,45,77,78,92,94',
        '92' => '75,78,91,93,94,95',
        '93' => '75,77,92,94,95',
        '94' => '75,77,91,92,93',
        '95' => '27,60,77,78,92,93',
        '971' => '972,973',
        '972' => '971,973',
        '973' => '971,972',
        '974' => '976',
        '976' => '974',
    );
    
    /**
     * Get all departement limitrophe from $dep
     * @param  string $dep 
     * @return string      
     */
    public static function getDepartementLimitrophe($dep = null)
    {
        if (is_null($dep))
            return false;

        if (strlen($dep > 3))
            $dep = substr($dep, 0, 2);
        if (strlen($dep) == 1)
            $dep = '0' . $dep;
        
        return (isset(self::$departmentLimitrophe[$dep])) ? self::$departmentLimitrophe[$dep] : false;
    }

    /**
     * Get departement name from number
     * @param  string $dep 
     * @return string      
     */
    public static function getDepartementName($dep = null)
    {
        if (is_null($dep))
            return false;

        if (strlen($dep) > 3)
            $dep = substr($dep, 0, 2);
        if (strlen($dep) == 1)
            $dep = '0' . $dep;
        
        return (isset(self::$departmentName[$dep])) ? self::$departmentName[$dep] : false;
    }

    /**
     * Get region name from a departement
     * @param  string $dep 
     * @return string      
     */
    public static function getRegionNameByDepartement($dep = null)
    {
        if (is_null($dep))
            return false;

        if (strlen($dep) > 3)
            $dep = substr($dep, 0, 2);
        if (strlen($dep) == 1)
            $dep = '0' . $dep;
        
        foreach(self::$regionName as $k => $v) {
            if (strpos($v, (string)$dep) !== false)
                    return self::$regionRealName[$k];
        }
        return false;
    }
    
    /**
     * Get list departement for SELECT Input
     * @return array 
     */
    public static function getListForSelect()
    {
        $regions = self::$regionName;
        ksort($regions);
        $res = array();
        
        foreach($regions as $region => $deps) {
            $depsByRegion = array();
            $deps = explode(',', $deps);
            foreach($deps as $dep) {
                $depsByRegion[$dep] = self::getDepartementName($dep);
            }
            asort($depsByRegion);
            $res[$region] = $depsByRegion;
        }
        
        return $res;
    }

}