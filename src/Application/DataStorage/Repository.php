<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\Application\DataStorage;

use Doctrine\ORM\EntityManager;

abstract class Repository
{
    /** @var EntityManager */
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }
}
