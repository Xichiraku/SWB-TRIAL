<?php

namespace App\Support;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\DB;
use SessionHandlerInterface;

class MongoSessionHandler implements SessionHandlerInterface
{
    protected string $connectionName;

    protected string $collectionName;

    protected ?Container $container;

    protected mixed $collection = null;

    public function __construct(string $connectionName = 'mongodb', string $collectionName = 'sessions', ?Container $container = null)
    {
        $this->connectionName = $connectionName;
        $this->collectionName = $collectionName;
        $this->container = $container;
    }

    protected function getCollection(): mixed
    {
        if ($this->collection === null) {
            $database = DB::connection($this->connectionName)->getMongoDB();
            $this->collection = $database->selectCollection($this->collectionName);
        }

        return $this->collection;
    }

    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($sessionId): string|false
    {
        $document = $this->getCollection()->findOne([
            '$or' => [
                ['_id' => $sessionId],
                ['id' => $sessionId],
            ],
        ]);

        if (!$document || !isset($document['payload'])) {
            return '';
        }

        return base64_decode($document['payload']);
    }

    public function write($sessionId, $data): bool
    {
        $payload = base64_encode($data);

        $document = [
            '_id' => $sessionId,
            'id' => $sessionId,
            'payload' => $payload,
            'last_activity' => time(),
        ];

        if ($this->container && $this->container->bound('request')) {
            $request = $this->container->make('request');
            $document['ip_address'] = $request->ip();
            $document['user_agent'] = substr((string) $request->header('User-Agent'), 0, 500);
        }

        $this->getCollection()->updateOne(
            ['_id' => $sessionId],
            ['$set' => $document],
            ['upsert' => true]
        );

        return true;
    }

    public function destroy($sessionId): bool
    {
        $this->getCollection()->deleteOne(['_id' => $sessionId]);

        return true;
    }

    public function gc($maxLifetime): int|false
    {
        $this->getCollection()->deleteMany([
            'last_activity' => [
                '$lt' => time() - (int) $maxLifetime,
            ],
        ]);

        return true;
    }
}
