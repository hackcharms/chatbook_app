<?php

namespace MyApp;

include('..\..\ajax\conection.php');

use MyApp\Connection\database as database;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class Chat extends database implements MessageComponentInterface
{
    protected $db;
    protected $clients;
    private $usersResouceId = [];
    private $resourceIdUsers = [];
    public function __construct()
    {
        $this->db = new database();
        $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);
        if (!array_key_exists($queryarray['username'], $this->usersResouceId)) {
            $this->usersResouceId[$queryarray['username']] = [$conn->resourceId];
        } else {
            array_push($this->usersResouceId[$queryarray['username']], $conn->resourceId);
        }
        // print_r()
        $this->db->update_value('login', 'user_name=' . $queryarray['username'], 'online_status=1');
        $this->clients->attach($conn);
        $this->resourceIdUsers[$conn->resourceId] = $queryarray['username'];
        echo "New connection! ({$queryarray['username']}={$conn->resourceId})\n";
        // print_r($queryarray);
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        if($_SESSION['username'])
        echo 'session avail'."\n";
        $data = json_decode($msg);
        $numRecv = count($this->usersResouceId[$data->to]);
        // $file = fopen('../json/' . $this->resourceIdUsers[$from->resourceId]. '_current_users.json', 'r');
        // $json = json_decode(fgets($file), true);
        echo sprintf(
            'UserId %d sending message "%s" to %d in current Active %d tab%s' . "\n",
            $this->resourceIdUsers[$from->resourceId],
            $data->msg,
            $data->to,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );
        // print_r($data);

        foreach ($this->clients as $client) {
            foreach ($this->usersResouceId[$data->to] as $id) {
                if ($client->resourceId == $id) {
                    // The sender is not the receiver, send to each client connected
                    $client->send(json_encode(['from' => $this->resourceIdUsers[$from->resourceId], 'msg' => $data->msg, 'img' => $data->img]));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $sizeRes = count($this->usersResouceId[$this->resourceIdUsers[$conn->resourceId]]);
        if ($sizeRes == 1) {
            unset($this->usersResouceId[$this->resourceIdUsers[$conn->resourceId]]);
        } else {
            $key = array_search($conn->resourceId, $this->usersResouceId[$this->resourceIdUsers[$conn->resourceId]]);
            unset($this->usersResouceId[$this->resourceIdUsers[$conn->resourceId]][$key]);
        }
        printf("User %s disconnected", $this->resourceIdUsers[$conn->resourceId]);
        $this->db->update_value('login', 'user_name=' . $this->resourceIdUsers[$conn->resourceId], 'online_status=0');
        unset($this->resourceIdUsers[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
