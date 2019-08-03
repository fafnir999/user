<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\Email;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new Email('username');

        self::assertSame('email', $credential::getUsernameField());
        self::assertSame('username', $credential->getUsername());
    }

    public function testInvoke(): void
    {
        $credential = new Email('username');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('username', $credential->getUsername());
        self::assertTrue($credential(new ChangeCredential(['email' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertFalse($credential(new ChangeCredential(['email' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
    }
}
