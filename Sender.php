<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender {
    public $connection;
    public $channel;
    protected $channelName;

    public function __construct($channelName)
    {
        $this->connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '12345678');
        $this->channel = $this->connection->channel();
        $this->channelName = $channelName;
    }

    public function send($message)
    {
        $msg = new AMQPMessage($message);
        // $this->channel->queue_declare($this->channelName, false, false, false, false);
        $this->channel->basic_publish($msg, '', $this->channelName);
    }

    private function closeConn()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function __destruct() {
        $this->closeConn();
    }
}