<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Complex1;

class DataFile
{
    public function __construct(
        public string $fileName,
        public string $fileIdentifier,
        public DataSourceOrigin $dataSource,
        public DataFileFormat $fileFormat,
    ) {}
}
