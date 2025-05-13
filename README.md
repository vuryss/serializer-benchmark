# Serializer benchmark

Created mainly to compare the performance of vuryss/serializer compared to symfony/serializer to make sure we're still outperforming it.

## Usage

- Run the docker environment with
```bash
docker compose up -d
```
- Install the libraries with
```bash
docker compose exec library composer install
```
- Run the benchmark with
```bash
docker compose exec library vendor/bin/phpbench run --report=all
```
