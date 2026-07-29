# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## Unreleased

### Added

- `EndpointInterface::FORMAT_MULTIPART`, `FORMAT_URL` and `FORMAT_VOID` request-format constants. `FORMAT_MULTIPART` is not encodable by the request serializer itself — it requires a client with multipart body support (e.g. service-api-client-bundle with a multipart request-body factory)
- `Multipart\MetadataStream` — PSR-7 stream decorator carrying `filename`/`mime-type` metadata for multipart uploads
- `Multipart\UploadedFileStream` — `MetadataStream` adapter over a Symfony `UploadedFile`
- `StreamInterfaceDenormalizer` wired into `auto1.api.request.serializer`: passes streams through on denormalization, rejects streams on normalization with a hint to use `FORMAT_MULTIPART`

### Changed

- **BC break**: `LoggerAwareTrait::setLogger()` now returns `void` instead of `$this` (PSR-3 v2/v3 compatible signature) — update fluent call sites
- **BC break**: `monolog/monolog` and `symfony/monolog-bridge` are no longer required by this bundle (replaced by `psr/log`) — require Monolog directly if your application relies on it transitively

## 1.2.0 - 23-10-2018

### Added

- Url resolution can be altered with tagged service

## 0.1.4 - 12-04-2018

### Added

- debug command `bin/console auto1.debug.endpoints`

## 0.1.3 - 12-04-2018

### Added

- Support for service-api-handler
  - support for null as baserUrl
  - support for baseUrl late resolving
  - request class not required to exist anymore
  - leading slash allowed for request class

## 0.1.0 - 24-03-2018

### Added

- Bundle extracted from auto1 service-api project

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
