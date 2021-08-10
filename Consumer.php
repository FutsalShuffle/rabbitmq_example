<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer
{
    public $connection;
    public $channel;
    protected $channelName;

    public function __construct($channelName)
    {
        $this->connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '12345678');
        $this->channel = $this->connection->channel();
        $this->channelName = $channelName;
    }

    public function listen()
    {
        $this->channel->basic_consume(
            $this->channelName,             
            '',                         	
            false,                      	
            true,                       	
            false,                      	
            false,                      	
            array($this, 'callbackMethod')
        );

        while($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }

    public function callbackMethod($msg)
    {
        echo 'Получили сообщение:'.PHP_EOL;
        echo $msg->body . PHP_EOL;
        return true;
    }
}