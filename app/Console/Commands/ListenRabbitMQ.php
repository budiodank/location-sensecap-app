<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Events\LocationUpdated;

class ListenRabbitMQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:rabbitmq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to RabbitMQ messages';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = app(AMQPStreamConnection::class);
        $channel = $connection->channel();

        $channel->queue_declare('locations', false, true, false, false);

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            event(new LocationUpdated($data['latitude'], $data['longitude']));
        };

        $channel->basic_consume('locations', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
