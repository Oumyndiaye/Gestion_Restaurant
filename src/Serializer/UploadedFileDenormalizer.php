<?php
// api/src/Serializer/UploadedFileDenormalizer.php

namespace App\Serializer;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): UploadedFile
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $data instanceof UploadedFile;
    }
 /*   public function serialize()
{
    return serialize(array(
        $this->id,
        $this->username,
        $this->password,
        // see section on salt below
        // $this->salt,
    ));
}

 public function unserialize($serialized)
{
    list (
        $this->id,
        $this->username,
        $this->password,
        // see section on salt below
        // $this->salt
    ) = unserialize($serialized);
} */
}
