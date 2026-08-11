<?php

namespace ReportKit\Laravel\Tests;

use PHPUnit\Framework\TestCase;

class ComposerMetadataSmokeTest extends TestCase
{
    public function testReportkitExtraDeclaresLaravelRange()
    {
        $path = dirname(__DIR__) . '/composer.json';
        $json = json_decode(file_get_contents($path), true);

        $this->assertIsArray($json);
        $this->assertSame('5.5 → 13', $json['extra']['reportkit']['laravel']['display']);
        $this->assertSame('reportkit/laravel', $json['name']);
    }
}
