<?php

declare(strict_types=1);

namespace OpenTelemetry\Contrib\Instrumentation\Drupal;

use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\SemConv\TraceAttributes;

class IOInstrumentation extends InstrumentationBase {
  public const NAME = 'io';

  /**
   *
   */
  public static function register(): void {

    $instrumentation = new CachedInstrumentation(
      'io.opentelemetry.contrib.php.io',
      null,
      'https://opentelemetry.io/schemas/1.24.0'
    );

    static::create(
      instrumentation: $instrumentation,
      prefix: 'drupal.io',
    );
  }

  /**
   *
   */
  protected function registerInstrumentation(): void {

    // Define operations.
    $operations = [
      'fopen' => [
        'params' => ['filename', 'mode'],
      ],
      'fwrite' => [],
      'fread' => [],
      'file_get_contents' => [
        'params' => ['filename'],
      ],
      'file_put_contents' => [
        'params' => ['filename'],
      ],
      'curl_init' => [
        'params' => ['url'],
      ],
      'curl_exec' => [],
    ];

    // Register all operations with common params handling.
    $this->registerOperations(
      operations: $operations,
    );
  }
}
