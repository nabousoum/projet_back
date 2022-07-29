<?php
// api/src/DataProvider/DetailItemDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use App\Entity\Detail;

final class DetailItemDataProvider implements ItemDataProviderInterface, SerializerAwareDataProviderInterface
{
    use SerializerAwareDataProviderTrait;

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
        // Retrieve data from anywhere you want, in a custom format
        $data = '...';

        // Deserialize data using the Serializer
        return $this->getSerializer()->deserialize($data, Detail::class, 'custom');
    }
}