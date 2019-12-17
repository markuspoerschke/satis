<?php

namespace Composer\Satis\Utility;

use Composer\Package\Link;
use Composer\Package\Package;

class SourceUrlRewriter
{
    /**
     * @var array
     */
    private $sourceUrls;

    public function __construct(array $sourceUrls)
    {
        $this->sourceUrls = $sourceUrls;
    }

    /**
     * @param Package[] $packages
     */
    public function rewriteUrls(array $packages)
    {
        if (count($this->sourceUrls) === 0) {
            return $packages;
        }

        foreach ($packages as $package) {
            $sourceUrl = $package->getSourceUrl();
            foreach ($this->sourceUrls as $baseUrl => $replacement) {
                if (strpos($sourceUrl, $baseUrl) === 0) {
                    $sourceUrl = $replacement.substr($sourceUrl, strlen($baseUrl) - 1);
                    $package->setSourceUrl($sourceUrl);
                    break;
                }
            }
        }
    }
}
