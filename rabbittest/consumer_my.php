<?php
/**
* rabbitmq 生产者
* @date 2017-10-2
* @author chenweirui
*/

// 路由器关键字
$routingkey='mykey';
// 交换机名称
$exchangeName = 'myexchange';
$useQueueName = 'queue5';//连接RabbitMQ
$conn_args = array( 'host'=>'127.0.0.1' , 'port'=> '5672', 'login'=>'guest' , 'password'=> 'guest','vhost' =>'/');
$conn = new AMQPConnection($conn_args);
$conn->connect();
//设置queue名称，使用exchange，绑定routingkey
$channel = new AMQPChannel($conn);
$q = new AMQPQueue($channel);
$q->setName($useQueueName);
$q->setFlags(AMQP_DURABLE);
//$q->declare();
$q->bind($exchangeName, $routingkey);
//消息获取
while(1) {
	$messages = $q->get(AMQP_AUTOACK) ;
	if ($messages){
		//var_dump(json_decode($messages->getBody(), true ));
		print_r($messages->getBody());
	} else {
		break;
	}
}
$conn->disconnect();
?>