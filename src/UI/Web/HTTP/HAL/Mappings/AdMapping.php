<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\UI\Web\HTTP\HAL\Mappings;

use Ads\CodeList\Ads\Ad;
use NilPortugues\Api\Mappings\HalMapping;

class AdMapping implements HalMapping
{
    /** @var UriBuilder */
    private $uriBuilder;

    public function __construct(UriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
    }

    /** @inheritdoc */
    public function getClass(): string
    {
        return Ad::class;
    }

    /** @inheritdoc */
    public function getAlias(): string
    {
        return '';
    }

    /** @inheritdoc */
    public function getAliasedProperties(): array
    {
        return [];
    }

    /** @inheritdoc */
    public function getHideProperties(): array
    {
        return [];
    }

    /**
     * 'username' is the ID for Posters
     */
    public function getIdProperties(): array
    {
        return ['id'];
    }

    /**
     * Returns a list of URLs. This urls must have placeholders to be replaced with the getIdProperties() values.
     *
     * @return array
     */
    public function getUrls(): array
    {
        return [
            'self' => $this->escapedUrl('draftAd', ['id' => '{id}']),
        ];
    }

    /** @inheritdoc */
    public function getCuries(): array
    {
        return [];
    }

    private function escapedUrl(string $routeName, array $parameters): string
    {
        $url = $this->uriBuilder->pathFor($routeName, $parameters);
        return str_replace(['%7B', '%7D'], ['{', '}'], $url);
    }
}
