<?php

declare(strict_types=1);

namespace TwigStan\Twig;

use Symfony\Component\Filesystem\Path;
use Twig\Environment;
use TwigStan\Twig\Loader\AbsolutePathLoader;

final readonly class TwigFileNormalizer
{
    public function __construct(
        private Environment $twig,
    ) {}

    public function normalize(string $twigFileName): string
    {
        if (str_starts_with($twigFileName, '@')) {
            return $twigFileName;
        }

        if (Path::isAbsolute($twigFileName)) {
            /**
             * @var AbsolutePathLoader $loader
             */
            $loader = $this->twig->getLoader();

            return $loader->maybeResolveAbsolutePath($twigFileName);
        }

        return sprintf('@%s', $twigFileName);
    }
}
