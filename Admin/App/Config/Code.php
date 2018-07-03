<?php

namespace App\Config;

class_alias('\Base\Config\\' . ucfirst(APP_ENV) . '\Code', "BaseCodeConfig");

class Code extends \BaseCodeConfig
{
    public $menu = [
        'index' => [
            'name' => '写真管理',
            'sub' => [
                'index' => ['name' => '写真撮影一覧', 'uri' => '/admin/list'],
            ]
        ],
    ];
    
    public $sex = [
        [
            'name' => '男',
            'value' => '1'
        ],
        [
            'name' => '女',
            'value' => '2'
        ]
    ];

    public $sendMail = [
        [
            'name' => '日本語',
            'value' => '0'
        ],
        [
            'name' => '简体中文',
            'value' => '1'
        ],
        [
            'name' => '繁體中文',
            'value' => '2'
        ],
        [
            'name' => 'English',
            'value' => '3'
        ],
        [
            'name' => '한국어',
            'value' => '4'
        ],
    ];

    public $paging = [
        'index' => [
            10 => '10件',
            20 => '20件',
            50 => '50件',
            0 => 'すべて',
        ],
    ];
    
    public $login = [
            'username' => 'admin',
            'password' => '123456'
    ];

    public $order = [
        'user' => [
           'a' => [
                'field' => 'a.created',
                'type' => 'desc',
            ],
        ]
    ];
    
    public $uploadDir = [
        'demo' => WEB_PATH . '/upload/demo/',
    ];

    public $sendBody = [
        [
            'title' => '【waza】【撮影写真のご送付】',
            'body' =>'このたび、wazaサービスをご利用いただき、ありがとう御座います。<br><br>
お客様の今回ご撮影頂いた写真の認証情報を送付致します。<br><br>
氏名：!<br>
認証コード：@<br>
閲覧期限：#（&日）<br><br><br>
【Samurai Styleのアプリでご覧になる場合】<br>
サービス一覧のwazaのアイコンをタップしていただき、画面の指示に従って、ご確認ください。<br><br><br>
【Webやスマホのブラウザーでご覧になる場合】<br>
下記URLをクリックしていただき、画面の指示に従って、ご確認ください。<br>
'.WAZAWEB,
        ],
        [
            'title' => '【Waza】【发送照片】',
            'body' =>'这次感谢您使用waza服务。<br><br>
我们将向您发送客户拍摄照片的认证信息。<br><br>
姓名：!<br>
验证码：@<br>
观看截止日期：#（&日）<br><br><br>
[在看到武士风格的应用]<br>
请点击服务列表中的waza图标并按照屏幕上的说明进行检查。<br><br><br>
【使用网页浏览器或智能手机浏览器浏览时】<br>
请点击下面的URL并按照屏幕上的说明进行操作，请检查。<br>
'.WAZAWEB,
        ],
        [
            'title' => '【Waza】【發送照片】',
            'body' =>'這次感謝您使用waza服務。<br><br>
我們將向您發送客戶拍攝照片的認證信息。<br><br>
姓名：!<br>
驗證碼：@<br>
觀看截止日期：#（&日）<br><br><br>
[在看到武士風格的應用]<br>
請點擊服務列表中的waza圖標並按照屏幕上的說明進行檢查。<br><br><br>
【使用網頁瀏覽器或智能手機瀏覽器瀏覽時】<br>
請點擊下面的URL並按照屏幕上的說明進行操作，請檢查。<br>
'.WAZAWEB,
        ],
        [
            'title' => '【Waza】 【Your Photos】',
            'body' => 'Thank you for using waza service this time.<br><br>
We will send you the authentication information of the photographed photograph of the customer.<br><br>
Name: !<br>
Authentication code: @<br>
Viewing deadline: # (&)<br><br><br>
[When seeing with the application of Samurai Style]<br>
Please tap the waza icon in the service list and follow the instructions on the screen, please check.<br><br><br>
【When you browse with web browser or smartphone browser】<br>
Please click the URL below and follow the instructions on the screen, please check.<br>
'.WAZAWEB,
        ],
        [
            'title' => '[waza] [촬영 사진 송부]',
            'body' => '이번에 waza 서비스를 이용해 주셔서 고마워요 있습니다.<br><br>
고객 이번에 촬영하신 사진의 인증 정보를 보내드립니다.<br><br>
이름 : !<br>
인증 코드 : @<br>
열람 기간 : # (&날)<br><br><br>
[Samurai Style 응용 프로그램에서 보시려면]<br>
서비스 목록 waza 아이콘을 눌러 주시고, 화면의 지시에 따라 확인하시기 바랍니다.<br><br><br>
[Web과 스마트 폰의 브라우저에서 보시는 경우]<br>
아래 URL을 클릭하시면 화면의 지시에 따라 확인하시기 바랍니다.<br>
'.WAZAWEB,
        ]
    ];

    public $nationality = [
        "Afghanistan - AFG",
        "Aland Islands - ALA",
        "Albania - ALB",
        "Algeria - DZA",
        "American Samoa - ASM",
        "Andorra - AND",
        "Angola - AGO",
        "Anguilla - AIA",
        "Antarctica - ATA",
        "Antigua and Barbuda - ATG",
        "Argentina - ARG",
        "Armenia - ARM",
        "Aruba - ABW",
        "Australia - AUS",
        "Austria - AUT",
        "Azerbaijan - AZE",
        "Bahamas - BHS",
        "Bahrain - BHR",
        "Bangladesh - BGD",
        "Barbados - BRB",
        "Belarus - BLR",
        "Belgium - BEL",
        "Belize - BLZ",
        "Benin - BEN",
        "Bermuda - BMU",
        "Bhutan - BTN",
        "Bolivia - BOL",
        "Bosnia and Herzegovina - BIH",
        "Botswana - BWA",
        "Bouvet Island - BVT",
        "Brazil - BRA",
        "British Indian Ocean Territory - IOT",
        "Brunei - BRN",
        "Bulgaria - BGR",
        "Burkina Faso - BFA",
        "Burundi - BDI",
        "Cambodia - KHM",
        "Cameroon - CMR",
        "Canada - CAN",
        "Cape Verde - CPV",
        "Cayman Islands - CYM",
        "Central African Republic - CAF",
        "Chad - TCD",
        "Chile - CHL",
        "China - CHN",
        "Christmas Island - CXR",
        "Cocos (Keeling) Islands - CCK",
        "Colombia - COL",
        "Comoros - COM",
        "Cook Islands - COK"
 ,"Republic of the Congo - COG"
 ,"Democratic Republic of the Congo - COD"
 ,"Costa Rica - CRI"
 ,"Ivory Coast - CIV"
 ,"Croatia - HRV"
 ,"Cuba - CUB"
 ,"Curaçao - CUW"
 ,"Cyprus - CYP"
 ,"Northern Cyprus - TRN"
 ,"Czech Republic - CZE"
 ,"Czechoslovakia - CSK"
 ,"Denmark - DNK"
 ,"Djibouti - DJI"
 ,"Dominica - DMA"
 ,"Dominican Republic - DOM"
 ,"Ecuador - ECU"
 ,"Egypt - EGY"
 ,"El Salvador - SLV"
 ,"England - ENG"
 ,"Equatorial Guinea - GNQ"
 ,"Eritrea - ERI"
 ,"Estonia - EST"
 ,"Ethiopia - ETH"
 ,"European Union - EU}"
 ,"Falkland Islands - FLK"
 ,"Faroe Islands - FRO"
 ,"Fiji - FJI"
 ,"Finland - FIN"
 ,"France - FRA"
 ,"French Guiana - GUF"
 ,"French Polynesia - PYF"
 ,"French Southern and Antarctic Lands - ATF"
 ,"Gabon - GAB"
 ,"Gambia - GMB"
 ,"Georgia - GEO"
 ,"Germany - DEU"
 ,"East Germany - GDR"
 ,"West Germany - FRG"
 ,"Ghana - GHA"
 ,"Gibraltar - GIB"
 ,"Greece - GRC"
 ,"Greenland - GRL"
 ,"Grenada - GRD"
 ,"Guadeloupe - GLP"
 ,"Guam - GUM"
 ,"Guatemala - GTM"
 ,"Guernsey - GGY"
 ,"Guinea - GIN"
 ,"Guinea-Bissau - GNB"
 ,"Guyana - GUY"
 ,"Haiti - HTI"
 ,"Honduras - HND"
 ,"Hong Kong - HKG"
 ,"Hungary - HUN"
 ,"Iceland - ISL"
 ,"India - IND"
 ,"Indonesia - IDN"
 ,"Iran - IRN"
 ,"Iraq - IRQ"
 ,"Ireland - IRL"
 ,"Isle of Man - IMN"
 ,"Israel - ISR"
 ,"Italy - ITA"
 ,"Jamaica - JAM"
 ,"Japan - JPN"
 ,"Jersey - JEY"
 ,"Jordan - JOR"
 ,"Kazakhstan - KAZ"
 ,"Kenya - KEN"
 ,"Kiribati - KIR"
 ,"North Korea - PRK"
 ,"South Korea - KOR"
 ,"Kosovo - KOS"
 ,"Kuwait - KWT"
 ,"Kyrgyzstan - KGZ"
 ,"Laos - LAO"
 ,"Latvia - LVA"
 ,"Lebanon - LBN"
 ,"Lesotho - LSO"
 ,"Liberia - LBR"
 ,"Libya - LBY"
 ,"Liechtenstein - LIE"
 ,"Lithuania - LTU"
 ,"Luxembourg - LUX"
 ,"Macau - MAC"
 ,"Macedonia - MKD"
 ,"Madagascar - MDG"
 ,"Malawi - MWI"
 ,"Malaysia - MYS"
 ,"Maldives - MDV"
 ,"Mali - MLI"
 ,"Malta - MLT"
 ,"Marshall Islands - MHL"
 ,"Martinique - MTQ"
 ,"Mauritania - MRT"
 ,"Mauritius - MUS"
 ,"Mayotte - MYT"
 ,"Mexico - MEX"
 ,"Federated States of Micronesia - FSM"
 ,"Moldova - MDA"
 ,"Monaco - MCO"
 ,"Mongolia - MNG"
 ,"Montenegro - MNE"
 ,"Montserrat - MSR"
 ,"Morocco - MAR"
 ,"Mozambique - MOZ"
 ,"Myanmar - MMR"
 ,"Namibia - NAM"
 ,"Nauru - NRU"
 ,"Nepal - NPL"
 ,"Netherlands - NLD"
 ,"Netherlands Antilles - ANT"
 ,"Caribbean Netherlands - BES"
 ,"New Caledonia - NCL"
 ,"New Zealand - NZL"
 ,"Nicaragua - NIC"
 ,"Niger - NER"
 ,"Nigeria - NGA"
 ,"Niue - NIU"
 ,"Norfolk Island - NFK"
 ,"Northern Ireland - NIR"
 ,"Northern Mariana Islands - MNP"
 ,"Norway - NOR"
 ,"Oman - OMN"
 ,"Pakistan - PAK"
 ,"Palau - PLW"
 ,"Palestine - PSE"
 ,"Panama - PAN"
 ,"Papua New Guinea - PNG"
 ,"Paraguay - PRY"
 ,"Peru - PER"
 ,"Philippines - PHL"
 ,"Pitcairn Islands - PCN"
 ,"Poland - POL"
 ,"Portugal - PRT"
 ,"Puerto Rico - PRI"
 ,"Qatar - QAT"
 ,"Réunion - REU"
 ,"Romania - ROU"
 ,"Russia - RUS"
 ,"Rwanda - RWA"
 ,"Saint Barthélemy - BLM"
 ,"Saint Helena, Ascension and Tristan da Cunha - SHN"
 ,"Saint Kitts and Nevis - KNA"
 ,"Saint Lucia - LCA"
 ,"Saint Martin - MAF"
 ,"Saint Pierre and Miquelon - SPM"
 ,"Saint Vincent and the Grenadines - VCT"
 ,"Samoa - WSM"
 ,"San Marino - SMR"
 ,"São Tomé and Príncipe - STP"
 ,"Saudi Arabia - SAU"
 ,"Scotland - SCO"
 ,"Senegal - SEN"
 ,"Serbia - SRB"
 ,"Serbia and Montenegro - SCG"
 ,"Seychelles - SYC"
 ,"Sierra Leone - SLE"
 ,"Singapore - SGP"
 ,"Sint Maarten - SXM"
 ,"Slovakia - SVK"
 ,"Slovenia - SVN"
 ,"Solomon Islands - SLB"
 ,"Somalia - SOM"
 ,"South Africa - ZAF"
 ,"South Georgia and the South Sandwich Islands - SGS"
 ,"South Sudan - SSD"
 ,"Spain - ESP"
 ,"Sri Lanka - LKA"
 ,"Sudan - SDN"
 ,"Suriname - SUR"
 ,"Svalbard and Jan Mayen - SJM"
 ,"Swaziland - SWZ"
 ,"Sweden - SWE"
  ,"Switzerland - CHE"
 ,"Syria - SYR"
 ,"Taiwan - TWN"
 ,"Tajikistan - TJK"
 ,"Tanzania - TZA"
 ,"Thailand - THA"
 ,"Timor-Leste - TLS"
 ,"Togo - TGO"
 ,"Tokelau - TKL"
 ,"Tonga - TON"
 ,"Trinidad and Tobago - TTO"
 ,"Tunisia - TUN"
 ,"Turkey - TUR"
 ,"Turkmenistan - TKM"
 ,"Turks and Caicos Islands - TCA"
 ,"Tuvalu - TUV"
 ,"Uganda - UGA"
 ,"Ukraine - UKR"
 ,"United Arab Emirates - ARE"
 ,"United Kingdom - GBR"
 ,"United Nations - UNO"
 ,"United States - USA"
 ,"United States Minor Outlying Islands - UMI"
 ,"Uruguay - URY"
 ,"Soviet Union - URS"
 ,"Uzbekistan - UZB"
 ,"Vanuatu - VUT"
 ,"Vatican City - VAT"
 ,"Venezuela - VEN"
 ,"Vietnam - VNM"
 ,"British Virgin Islands - VGB"
 ,"United States Virgin Islands - VIR"
 ,"Wales - WAL"
 ,"Wallis and Futuna - WLF"
 ,"Western Sahara - ESH"
 ,"Yemen - YEM"
 ,"Yugoslavia - YUG"
 ,"Zambia - ZMB"
 ,"Zimbabwe - ZWE"
    ];
}
