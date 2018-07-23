<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

use Ads\Builders\A;
use Ads\Ports\DomainEvents\EventPublisher;
use Ads\Posters\InMemoryPosters;
use Ads\Posters\PosterHasSignedUp;
use Ads\Posters\PosterInformation;
use Ads\Registration\SignUpPoster;
use Ads\Registration\UnavailableUsername;
use Behat\Behat\Context\Context;
use Faker\Factory;

class UserSignUpContext implements Context
{
    /** @var \Ads\Posters\Posters */
    private $posters;

    /** @var SignUpPoster */
    private $action;

    /** @var \Faker\Generator  */
    private $faker;

    /** @var bool */
    private $usernameIsUnavailable = false;

    public function __construct()
    {
        $this->posters = new InMemoryPosters();
        $this->action = new SignUpPoster($this->posters);
        $this->faker = Factory::create();
    }

    /**
     * @Given a poster with the username :username
     */
    public function aPosterWithTheUsername(string $username): void
    {
        $this->posters->add(A::poster()->withUsername($username)->build());
        EventPublisher::reset(); // we're not interested in previous events
    }

    /**
     * @When I sign up with the username :username
     */
    public function iSignUpWithTheUsername(string $username)
    {
        try {
            $this->action->signUp(PosterInformation::fromInput([
                'username' => $username,
                'password' => $this->faker->password(8),
                'name' => $this->faker->name,
                'email' => $this->faker->email,
            ]));
        } catch (UnavailableUsername $exception) {
            $this->usernameIsUnavailable = true;
        }
    }

    /**
     * @Then I should be asked to choose a different username
     */
    public function iShouldBeAskedToChooseADifferentUsername()
    {
        assertTrue($this->usernameIsUnavailable);
    }

    /**
     * @Then I should be notified that my account was created
     */
    public function iShouldBeNotifiedThatMyAccountWasCreated()
    {
        assertCount(1, EventPublisher::instance()->events());
        assertInstanceOf(PosterHasSignedUp::class, EventPublisher::instance()->events()[0]);
    }
}