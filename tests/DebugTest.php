<?php

declare(strict_types=1);

namespace Conia\Error\Tests;

use Conia\Error\Handler;
use Conia\Error\Tests\Fixtures\TestDebugHandler;
use DivisionByZeroError;
use PHPUnit\Framework\Attributes\TestDox;

class DebugTest extends TestCase
{
    #[TestDox("Don't handle unregistered exception when in debug mode")]
    public function testDontHandleUnregisteredException(): void
    {
        $this->throws(DivisionByZeroError::class, 'test');

        $handler = new Handler($this->factory, debug: true);
        $handler->getResponse(new DivisionByZeroError('test'), null);
    }

    #[TestDox("Handle unregistered exception with debug handler")]
    public function testErrorHandlerLevel0(): void
    {
        $handler = new Handler($this->factory, debug: true);
        $handler->debugHandler(new TestDebugHandler());
        $response = $handler->getResponse(new DivisionByZeroError('test'), null);

        $this->assertEquals('DivisionByZeroError test', (string)$response->getBody());
    }
}
