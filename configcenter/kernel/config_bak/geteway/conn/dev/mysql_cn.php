<?php
$db_config =  array(

    'geteway'=>
        array(
            'master'=>array(
                'type'=>'postgreSQL',
                'host'=>'127.0.0.1',
                'user'=>'games',
                'pwd'=>'pu6zMh2CQ55Q',
                'port'=>'3306',
                'db_name'=>'kxgame',
                'db_preifx'=>'',
                'char'=>'utf8',
            ),
            'slave'=>array(
                'type'=>'mysql',
                'host'=>'127.0.0.1',
                'user'=>'games',
                'pwd'=>'pu6zMh2CQ55Q',
                'port'=>'3306',
                'db_name'=>'kxgame',
                'db_preifx'=>'',
                'char'=>'utf8',
            ),
        ),
    'geteway_log'=>
        array(
            'master'=>array(
                'type'=>'postgreSQL',
                'host'=>'127.0.0.1',
                'user'=>'games',
                'pwd'=>'pu6zMh2CQ55Q',
                'port'=>'3306',
                'db_name'=>'kxgame_log',
                'db_preifx'=>'',
                'char'=>'utf8',
            ),
            'slave'=>array(
                'type'=>'mysql',
                'host'=>'127.0.0.1',
                'user'=>'games',
                'pwd'=>'pu6zMh2CQ55Q',
                'port'=>'3306',
                'db_name'=>'kxgame_log',
                'db_preifx'=>'',
                'char'=>'utf8',
            ),
        ),
);
$GLOBALS['db_config'] = $db_config;
