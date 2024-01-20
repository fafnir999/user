<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use Fafnir999\CoreBundle\Domain\Contract\Infrastructure\DomainEventBusInterface;
use MsgPhp\Domain\DomainMessageBus;
use MsgPhp\Domain\Factory\DomainObjectFactory;
use MsgPhp\User\Command\AddUserEmail;
use MsgPhp\User\Event\UserEmailAdded;
use MsgPhp\User\Repository\UserEmailRepository;
use MsgPhp\User\User;
use MsgPhp\User\UserEmail;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AddUserEmailHandler
{
    private $factory;
    private $bus;
    private $repository;

    public function __construct(DomainObjectFactory $factory, DomainEventBusInterface $bus, UserEmailRepository $repository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(AddUserEmail $command): void
    {
        $context = $command->context;
        $context['user'] = $this->factory->reference(User::class, ['id' => $command->userId]);
        $context['email'] = $command->email;
        $userEmail = $this->factory->create(UserEmail::class, $context);

        $this->repository->save($userEmail);
        $this->bus->dispatch($this->factory->create(UserEmailAdded::class, compact('userEmail', 'context')));
    }
}
