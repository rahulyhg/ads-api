<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\Builders;

use Ads\Posters\Email;
use Ads\Posters\Name;
use Ads\Posters\PosterHasSignedUp;
use Ads\Posters\Username;
use Carbon\Carbon;
use Faker\Factory;

class PosterHasSignedUpEventBuilder
{
    /** @var \Faker\Generator */
    private $faker;

    /** @var int */
    private $timestamp;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function occurredOn(int $timestamp): PosterHasSignedUpEventBuilder
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function build(): PosterHasSignedUp
    {
        return new PosterHasSignedUp(
            new Username($this->username ?? $this->normalizeUsername()),
            new Name($this->faker->name),
            Email::withAddress($this->faker->email),
            $this->timestamp ?? Carbon::now('UTC')->getTimestamp()
        );
    }

    private function normalizeUsername(): string
    {
        $username = str_replace('.', '_', $this->faker->userName);
        if (strlen($username) < 5) {
            $username .= str_repeat('a', 5 - strlen($username));
        }
        return $username;
    }
}