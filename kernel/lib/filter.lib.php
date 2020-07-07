<?php
//各种变量的过滤
class FilterLib {
	static public $validate = array(
			'ctrl'=>'/^[A-Za-z0-9]{2,20}$/',
			'ac'=>'/^[A-Za-z0-9]{2,40}$/',
			'require'=> '/.+/',//不能为空,必须至少有一个字符
			'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
			'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/',
			'currency' => '/^\d+(\.\d+)?$/',//货币
			'number' => '/^\d+$/',//非负整数（正整数 + 0）
			'int'=>"/^[0-9]*[1-9][0-9]*$/",//正整数
			'zip' => '/^[1-9]\d{5}$/',//邮编
			'chinese'=>"/^[\x7f-\xff]+$/",//是否为汉字
			'integer' => '/^[-\+]?\d+$/',//带正负号的数字
			'double' => '/^[-\+]?\d+(\.\d+)?$/',//正正负号的数字，包括小数点
			'english' => '/^[A-Za-z]+$/',//英语大小写字母
			'phone'=> "/^1[3,5,6,7,8]\d{9}$/",//手机
			'telphone'=>"/^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/",//电话号码
			'tel'=>'/^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/',//电话
			'date'=>"/^(1|2)[0-9]{3}-[0-9]{2}-[0-9]{2}$/",//2012-12-12
			'time'=>"/^[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/",
			'datetime'=>"/^(1|2)[0-9]{3}-[0-9]{2}-[0-9]{2} [0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/",
			'dateformat'=>"/^(1|2)[0-9]{3}[0-9]{2}[0-9]{2}$/",//20121229
			"uname"=>'/^[a-zA-z](\w+)$/',//以字母开头，数字与下划线组成
			'ip'=>'/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',
			'char'=>'//',
			'qq'=>'/^[1-9]\d{4,9}$/',
			'uid'=>'/\w{12}/',
            'md5'=>'/^[a-z0-9]{32}$/',
	);
	
	static public function regex($value,$rule) {
		// 检查是否有内置的正则表达式
		if(isset(self::$validate[strtolower($rule)]))
			$rule   =   self::$validate[strtolower($rule)];
		
		return preg_match($rule,$value)===1;
	}
	static function length($value,$max = 0 ,$min = 0){
		if(!$max && !$min)stop('内容长度为：0');
		$length = mb_strlen($value,DB_CHARSET);
		if($max){
			if($length > $max || $length < $min)
				return 0;
		}else{
			if( $length < $min)
				return 0;
		}
		return 1;
	}
	static function preg($value,$rule){
		if(is_array($rule)){
			foreach($rule as $k=>$v){
				if(!self::regex($value , $v )){
					return 0;
					break;
				}
			}
		}else{
			if(!self::regex($value , $rule )){
				return 0;
			}
		}
		
		return 1;
	}
	
/* 	
	公民身份号码是由：17位数字码和1位校验码组成。
	6位地址码，8位出生日期码，3位顺序码和1位校验码。
	顺序码表示在同一地址码所标识的区域范围内，对同年同月同日出生的人编定的顺序号，顺序码的奇数分配给男性，偶数分配给女性。
	身份证最后一位校验码算法如下：
	1. 将身份证号码前17位数分别乘以不同的系数，从第1位到第17位的系数分别为：7 9 10 5 8 4 2 1 6 3 7 9 10 5 8 4 2
	2. 将得到的17个乘积相加。
	3. 将相加后的和除以11并得到余数。
	4. 余数可能为0 1 2 3 4 5 6 7 8 9 10这些个数字，其对应的身份证最后一位校验码为1 0 X 9 8 7 6 5 4 3 2。
	*/
	static function idAuth($number , $date = '' , $sex = ''){
		$rs['number'] = $number;
// 		if( 15 == strlen($number) ){
// 			$number = self::idcard_15to18($number);
// 		}
		
		if( 18 != strlen($number)  ){
			return array( 'error' => 1 , 'data'=> '身份证号为:18位(如最后一位为X,就写X)' );
		}
		$lastNum = substr($number, -1);
// 		if($lastNum == 'x' || $lastNum == 'X'){
			
// 		}
// 		6位地址码,先取前2位,判断省份
		$aCity=array(
					11=>"北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",21=>"辽宁",22=>"吉林",23=>"黑龙江",31=>"上海",32=>"江苏",
					33=>"浙江",34=>"安徽",35=>"福建",36=>"江西",37=>"山东",41=>"河南",42=>"湖北",43=>"湖南",44=>"广东",45=>"广西",46=>"海南",
					50=>"重庆",51=>"四川",52=>"贵州",53=>"云南",54=>"西藏",61=>"陕西",62=>"甘肃",63=>"青海",64=>"宁夏",65=>"新疆",71=>"台湾",
					81=>"香港",82=>"澳门",91=>"国外");
		$twnNum = substr($number,0,2);
		$f= 0;
		foreach($aCity as $k=>$v){
			if($k == $twnNum){
				$f= 1;
			}
		}
		if(!$f){
			return array( 'error' => 1 , 'data'=> '省份所对应的ID错误' );
		}
		$rs['province'] = $aCity[$twnNum];
		//判断出生日期
		$date = substr($number,6,8);
		$rs['date'] = $date;
		if( ! self::regex($date, 'dateFormat') ){
			return array( 'error' => 1 , 'data'=> '日期格式错误' );
		}
		//性别
		$sex = substr($number,16,1);
		if($sex % 2 == 0)$rs['sex'] = "女";
		else $rs['sex'] = "男";
		//验证第18位
		//将身份证号码前17位数分别乘以不同的系数
		$code = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
		//将得到的17个乘积相加。将相加后的和除以11并得到余数,如下 
		$szVerCode =array('1','0','X','9','8','7','6','5','4','3','2');
		$total = 0;
		for ($i = 0;$i < 17;$i++) {
			$total += $number[$i] * $code[$i];
		}
		if($szVerCode[$total % 11] != $lastNum ){
			return array( 'error' => 1 , 'data'=> '第18位验证码错误' );
		}
		// 		6位地址码
		$data = file(KERNEL_PATH."class/ID6number.txt");
		$addrNumber = substr($number,0,6);
		$f = 0 ;
		foreach($data as $k=>$v){
			$tmp = explode(' ', $v);
			if($addrNumber == $tmp[0]){
				$f = 1;
				$rs['city'] = $tmp[1];
				break;
			}
		}

		if(!$f)return array( 'error' => 1 , 'data'=> '省份详细信息错误' );
		return array( 'error' => 0 , 'data'=> $rs );
	}
	
// 	将15位身份证升级到18位
	static function idcard_15to18($idcard){
		// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
		if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
			$idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
		}else{
			$idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
		}
// 	　	return $idcard;
	}

    static function checkIPRequest($ip = null) {
	    if(!$GLOBALS[KERNEL_NAME]['main']['ipCntLimit']){
            return true;
        }

	    if(!$ip){
            $ip = get_client_ip();
        }
        $key = ContainerLib::get("kernelRedisObj")->getAppKeyById($GLOBALS[KERNEL_NAME]['rediskey']['black_ip']['key'], $ip , KERNEL_NAME);
        $ipCnt =  ContainerLib::get("kernelRedisObj")->get($key);
        if($ipCnt){
            if($ipCnt >= $GLOBALS[KERNEL_NAME]['main']['ipCntLimit']){
                return false;
            }
            ContainerLib::get("kernelRedisObj")->incr($key);
            return true;
        }

        ContainerLib::get("kernelRedisObj")->set($key,1,5 * 60);

        return true;
    }

    static $prefix = "apiReturnDataCheckInit";

    static function  intelligentCheck($type,$value){
        if ($type == 'int') {
            $value = intval($value);
        } elseif ($type == 'string') {
            $value = (string)$value;
        }

        return $value;
    }


    static function throwErr($msg){
        exit(self::$prefix . "-".$msg);
    }

    //一个规则，检查一个值，最小单位
    static function checkOneKey($rule,$value){
        if (arrKeyIssetAndExist($rule,'must')) {
            if(!$value){
                self::throwErr("checkOneKey is null");
            }
        }
        $value = self::intelligentCheck($rule['type'],$value);
        return $value;
    }
    //检测一维 数字下标 数组
    static function checkArrayNumberAutoIncr($rule,$data){
        if (arrKeyIssetAndExist($rule,'must')) {
            if(!$data){
                self::throwErr("checkArrayNumberAutoIncr is null");
            }
        }

        if(!is_array($data)){
            self::throwErr("checkArrayNumberAutoIncr is not arr type");
        }

        if(arrKeyIssetAndExist($rule,'list')){
            $nextRule = array($rule['list']['subset']['subset_key'] =>$rule['list']['subset']);
            foreach ($data as $k=>$v){
                $data[$k] = self::apiReturnDataCheckInit( $nextRule ,$v);
            }
        }elseif(!arrKeyIssetAndExist($rule,'subset')){
            $oneRule = array("type"=>$rule['type'],'must'=>$rule['type']);
            foreach ($data as $k=>$v){
                $value = self::checkOneKey($oneRule,$v);
                $data[$k] = $value;
            }
        }else{
            $nextRule = array($rule['subset']['subset_key'] =>$rule['subset']);
            foreach ($data as $k=>$v){
                $data[$k] = self::apiReturnDataCheckInit( $nextRule ,$v);
            }
        }

        return $data;
    }

    //检测一维 数字下标 数组
    static function checkObj($rule,$data){
        if (arrKeyIssetAndExist($rule,'must')) {
            if(!$data){
                self::throwErr("checkObj is null 1");
            }
        }

        if(!is_array($data)){
            self::throwErr("checkObj is not arr type");
        }

        //证明，已经是最底层了，不会再有子集了
        if(!arrKeyIssetAndExist($rule,'subset')){
            $ruleList = $rule['list'];
//            var_dump($ruleList);exit;
            foreach ($ruleList as $k=>$v){
                if($v['must']){
                    if(!isset($data[$k]) && !$data[$k]){
                        var_dump($k);
                        self::throwErr("checkObj <$k> is null 2");
                    }
                }

                if(!arrKeyIssetAndExist($v,'subset')){
                    $value = self::checkOneKey($v,$data[$k]);
                    $data[$k] = $value;
                }else{
                    $nextRule = array($v['subset']['subset_key'] =>$v['subset']);
                    $data[$k] = self::apiReturnDataCheckInit($nextRule,$data[$k]);
                }
            }
            return $data;
        }else{
            $nextRule = array($rule['subset']['subset_key'] =>$rule['subset']);
            foreach ($data as $k=>$v){
                $data[$k] = self::apiReturnDataCheckInit( $nextRule ,$v);
            }
        }

        return $data;
    }


    // string bool int float
    // array obj

    //[1,2,3,4,5,6] 一维 对等 数组    key:array_number_auto_incr   rule:   type:int  must:1
    //[ [1,2,3,4,5,6] , [1,2,3,4,5,6] , [1,2,3,4,5,6] ]  二维 对等 数组   key:array_number_auto_incr   rule:   must:1  list:[array_number_auto_incr]

    //{a:"12345",b:"5678",c:"wang"} key:obj
    //{a:"12345",b:"5678",c:" {a:"12345",b:"5678",c:"wang"} } 二维 非对等 对象


    //key:array_number_auto_incr   rule:   must:1  list:[object]
    //[ {a:"12345",b:"5678",c:"wang"} ,{a:"12345",b:"5678",c:"wang"}  ,{a:"12345",b:"5678",c:"wang"}  ]  ,一维数组 嵌  一维 对等 对象
    //{ [1,2,3,4,5,6] , [1,2,3,4,5,6] , [1,2,3,4,5,6] }    //一维对象 嵌入 一维对等数组



    // {a:"12345",b:"5678",c:"wang"}
    // {a:"12345",b:"5678",c:"wang":[]}
    static function apiReturnDataCheckInit($apiReturn,$data){
	    //这是根节点的处理
        foreach($apiReturn as $k=>$v){
            if($k =='scalar') {//标量
                $data = self::checkOneKey($v,$data);
                return $data;
            }elseif($k == 'array_number_auto_incr'){//一维数组，数字自增下标
                $data = self::checkArrayNumberAutoIncr($v,$data);
                return $data;
            }elseif($k == 'obj'){//正常，最普通的一个KEY的数组
                    $data = self::checkObj($v,$data);
            }else{
                self::throwErr(" api config return info err!");
            }
        }

        return $data;
    }

    static function apiReturnDataCheck($rule,$data){

    }
	
}
