<?php
return array(
    200=>'成功',

    //项目验证
//    9000=>'所有项目均已关闭',
    9001=>'单个项目已被关闭',
    9002=>'APP NAME 不在APP配置中',
    9003=>'APP 非开启状态',
    9005=>'请求IP在黑名单中',
    9006=>'请求IP在短时间内，请求次数过于频繁',

    9991=>'系统(php)抛出异常',
    9992=>'系统(php)可执行错误error',
    9993=>'系统(php)致使错误fatal error',
    9994=>"{0} err code not found",
    9995=>"err code is null",

    //常量相关
    9101=>'BASE_DIR 常量 未定义',
    9102=>'RUN_ENV 运常量 未定义',
    9103=>'APP_NAME 常量 未定义',
    9104=>'DEF_DB_CONN 默认连接DB的KEY',
    9105=>'DEF_REDIS_CONN 默认连接的REDIS KEY',
    9106=>'DOMAIN_URL 常量 未定义',
    9107=>'STATIC_URL 静态资源域名 常量 未定义',
    9108=>'ENV 常量 未定义',

    9111=>'OUT_TYPE 常量 未定义',
    9112=>'OUT_TYPE 常量 值错误',
    9113=>'BASE_DIR 常量 路径错误',
    9114=>'RUN_ENV  常量 值错误',
    9115=>'APP_DIR  常量 路径错误',
    9116=>'COUNTRY  常量 未定义',
    9117=>'COUNTRY  常量 值错误',
    9118=>'KERNEL_DIR 常量 未定义',
    9119=>'KERNEL_DIR 常量 路径错误',
    9120=>'ENV 常量 值错误',
    9121=>'APP_NAME 常量 值错误',
    9123=>'DOMAIN_URL 常量 未定义',
    9124=>'STATIC_URL 常量 未定义',

    9300=>"{0}:扩展未定义",

    //路由时的 错误
    9200=>'ctrl参数为空',
    9201=>'ac参数为空',
    9202=>'ctrl文件不存在',
    9203=>'ctrl类不存在',
    9204=>'ac方法不存在',
    9205=>'sign签名为空',
    9206=>'签名错误',
);
