<?php

class OrderService{
    //下单入口
    function doing($uid,$gid,$num,$agentUid = 0){
        if(!$uid){
            return out_pc(8002);
        }

        if(!$gid){
            return out_pc(8073);
        }

        $goods = GoodsModel::db()->getById($gid);
        if(!$goods){
            return out_pc(1027);
        }

        if($goods['stock'] - $num <= 0 ){
            return out_pc(8336);
        }

        if($agentUid){
            $agent = AgentModel::db()->getById($agentUid);
            if(!$agent){
                return out_pc(1028);
            }
        }

        $agentAddr = AgentModel::getAddrStrById($agentUid);

        $order = array(
            'no'=>get_order_rand_no(),
            'pid'=>$goods['pid'],
            'gid'=>$gid,
            'uid'=>$uid,
            'price'=>$goods['sale_price'],
            'pay_type'=>$goods['pay_type'],
            'status'=>OrderModel::STATUS_WAIT_PAY,
            'a_time'=>time(),
            'pay_time'=>0,
            'express_no'=>"",
            'agent_uid'=>$agentUid,
            'address_agent'=>$agentAddr,
            'agent_withdraw_money_status'=>OrderModel::WITHDRAW_MONEY_STATUS_WAIT,
            'factory_withdraw_money_status'=>OrderModel::WITHDRAW_MONEY_FACTORY_WAIT,
        );

        $newId = OrderModel::db()->add($order);
        return out_pc(200,$newId);

    }
    //用户订单列表
    function getUserList($uid){
        $list =  OrderModel::getListByUid($uid);
        return out_pc(200,$list);
    }
    //支付完成 - 通知订单变更状态
    function finish($id){

    }

    function refund($id){

    }

    function getOneDetail($id){
        return OrderModel::db()->getById($id);
    }
}