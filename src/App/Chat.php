<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn){
        echo "Nueva conexion (($conn->resourceId))\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) -1;
        echo sprintf('Conexion %d enviando mensage "%s" a %d otra conexion%s' . "\n",
                $from->resourceId, $msg,$numRecv==1 ? '' : 's');
                 echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if($from !== $client){
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexion ($conn->resurceId) desconectada\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "A ocurrido un error: {$e->getMessage()}\n";

        $conn->close();
    }
}