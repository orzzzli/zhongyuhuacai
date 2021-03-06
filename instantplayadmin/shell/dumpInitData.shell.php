<?php
//表中的数据，也包括元数据，初始化的时候，得备份
class DumpInitData{

    private $_initTable = array(
        'base'=>array(
            'area_city','area_county','area_province','area_town','black_word','id_num','ip','mobile','university'
        ),
        'dynamic'=>array(
            'menu','admin_user','roles',
            'user','sms_rule','agent','factory','banner',
            'product_category','product_category_attr','product_category_attr_para'
        ),
    );

    private $database = "instantplay";
    private $host = "127.0.0.1";
    private $user = "root";
    private $ps = "root";
    private $targetDir = "D:/www/zhongyuhuacai_doc/init_data/";
    public $tbCategoryAttrId = 37;
    public $tbCategoryId = 8;//分类:1688抓取，空属性值ID

    public function __construct($c){
        $this->commands = $c;
    }

    function run(){
        $startTime = time();


//        $this->makeBaseTable();

        fopen("{$this->targetDir}init.sql","w+");
        $this->makeDynamicTable();

        $this->getMysqlDumpAppend("banner", " id = 1 ");

        $endTime = time();

        $total = $endTime - $startTime;
        out("total time:".$total);

    }

    function makeDynamicTable(){
        foreach ($this->_initTable['dynamic'] as $k=>$table){
            $sql = $this->getMysqlDump($table,1);
            echo "exec $sql \n";
            exec($sql);
        }
    }

    function makeBaseTable(){
        foreach ($this->_initTable['base'] as $k=>$table){
            $sql = $this->getMysqlDump($table);
            echo "exec $sql \n";
            exec($sql);
        }
    }

    function getMysqlDump($table){
        $baseSql = "mysqldump  --default-character-set=utf8 -t -h{$this->host} -u{$this->user} -p{$this->ps} {$this->database} $table >> {$this->targetDir}init.sql";
        return $baseSql;
    }

    function getMysqlDumpAppend($table,$where = ""){
        $commend = "mysqldump  --default-character-set=utf8 -t -h{$this->host} -u{$this->user} -p{$this->ps} {$this->database} $table";
        if($where){
            $commend .= " --where $where";
        }
        $baseSql = " $commend  >> {$this->targetDir}{$table}.sql";
        return $baseSql;
    }

}