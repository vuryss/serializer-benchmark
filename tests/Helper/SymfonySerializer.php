<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Helper;

use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Messenger\Transport\Serialization\Normalizer\FlattenExceptionNormalizer;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\Extractor\SerializerExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Mapping\Loader\LoaderChain;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\FormErrorNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\MimeMessageNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ProblemNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer;

class SymfonySerializer
{
    private static Serializer $serializer;
    private static PropertyInfoExtractor $propertyInfoExtractor;
    private static PropertyAccessor $propertyAccessor;
    private static ReflectionExtractor $reflectionExtractor;
    private static PropertyNormalizer $propertyNormalizer;
    private static ClassMetadataFactory $classMetadataFactory;
    private static MetadataAwareNameConverter $metadataAwareNameConverter;
    private static ClassDiscriminatorFromClassMetadata $classDiscriminatorFromClassMetadata;
    private static MimeTypes $mimeTypes;

    public static function instance(): Serializer
    {
        if (!isset(self::$serializer)) {
            self::$serializer = new Serializer(
                [
                    new UnwrappingDenormalizer(self::getPropertyAccessor()),
                    new FlattenExceptionNormalizer(),
                    new ProblemNormalizer(true, []),
                    new UidNormalizer([]),
                    new DateTimeNormalizer([]),
                    new ConstraintViolationListNormalizer([]),
                    new MimeMessageNormalizer(self::getPropertyNormalizer()),
                    new DateTimeZoneNormalizer(),
                    new DateIntervalNormalizer(),
                    new FormErrorNormalizer(),
                    new BackedEnumNormalizer(),
                    new DataUriNormalizer(self::getMimeTypes()),
                    new JsonSerializableNormalizer(null, null, []),
                    new ArrayDenormalizer(),
                    new ObjectNormalizer(
                        self::getClassMetadataFactory(),
                        self::getMetadataAwareNameConverter(),
                        self::getPropertyAccessor(),
                        self::getPropertyInfo(),
                        self::getClassDiscriminatorFromClassMetadata(),
                        null,
                        [],
                        self::getPropertyInfo(),
                    ),
                ],
                [new JsonEncoder()],
            );
        }

        return self::$serializer;
    }

    private static function getPropertyInfo(): PropertyInfoExtractor
    {
        if (!isset(self::$propertyInfoExtractor)) {
            self::$propertyInfoExtractor = new PropertyInfoExtractor(
                [
                    new SerializerExtractor(
                        self::getClassMetadataFactory(),
                    ),
                    new ReflectionExtractor(),
                ],
                [
                    new PhpStanExtractor(),
                    new PhpDocExtractor(),
                    new ReflectionExtractor(),
                ],
                [
                    new PhpDocExtractor(),
                ],
                [
                    new ReflectionExtractor(),
                ],
                [
                    new ReflectionExtractor(),
                ]
            );
        }

        return self::$propertyInfoExtractor;
    }

    private static function getPropertyAccessor(): PropertyAccessor
    {
        if (!isset(self::$propertyAccessor)) {
            self::$propertyAccessor = new PropertyAccessor(
                3,
                2,
                new ArrayAdapter(0, false),
                self::getReflectionExtractor(),
                self::getReflectionExtractor(),
            );
        }

        return self::$propertyAccessor;
    }

    private static function getReflectionExtractor(): ReflectionExtractor
    {
        if (!isset(self::$reflectionExtractor)) {
            self::$reflectionExtractor = new ReflectionExtractor();
        }

        return self::$reflectionExtractor;
    }

    private static function getPropertyNormalizer(): PropertyNormalizer
    {
        if (!isset(self::$propertyNormalizer)) {
            self::$propertyNormalizer = new PropertyNormalizer(
                self::getClassMetadataFactory(),
                self::getMetadataAwareNameConverter(),
                self::getPropertyInfo(),
                self::getClassDiscriminatorFromClassMetadata(),
            );
        }

        return self::$propertyNormalizer;
    }

    private static function getClassMetadataFactory(): ClassMetadataFactory
    {
        if (!isset(self::$classMetadataFactory)) {
            self::$classMetadataFactory = new ClassMetadataFactory(
                new LoaderChain(
                    [new AttributeLoader()]
                )
            );
        }

        return self::$classMetadataFactory;
    }

    private static function getMetadataAwareNameConverter(): MetadataAwareNameConverter
    {
        if (!isset(self::$metadataAwareNameConverter)) {
            self::$metadataAwareNameConverter = new MetadataAwareNameConverter(self::getClassMetadataFactory());
        }

        return self::$metadataAwareNameConverter;
    }

    private static function getClassDiscriminatorFromClassMetadata(): ClassDiscriminatorFromClassMetadata
    {
        if (!isset(self::$classDiscriminatorFromClassMetadata)) {
            self::$classDiscriminatorFromClassMetadata = new ClassDiscriminatorFromClassMetadata(
                self::getClassMetadataFactory(),
            );
        }

        return self::$classDiscriminatorFromClassMetadata;
    }

    private static function getMimeTypes(): MimeTypes
    {
        if (!isset(self::$mimeTypes)) {
            self::$mimeTypes = new MimeTypes();
        }

        return self::$mimeTypes;
    }
}
