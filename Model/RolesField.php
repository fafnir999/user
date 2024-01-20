<?php

declare(strict_types=1);

namespace MsgPhp\User\Model;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\Domain\GenericDomainCollection;
use MsgPhp\User\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait RolesField
{
    /** @var iterable<array-key, UserRole> */
    protected $roles = [];

    /**
     * @return DomainCollection<array-key, UserRole>
     */
    public function getRoles(): DomainCollection
    {
        return GenericDomainCollection::fromValue($this->roles);
    }
}
