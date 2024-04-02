<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\UX\StimulusBundle\StimulusBundle::class => ['all' => true],
    Symfony\UX\Turbo\TurboBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['all' => true],
    ApiPlatform\Symfony\Bundle\ApiPlatformBundle::class => ['all' => true],
    Survos\Bundle\MakerBundle\SurvosMakerBundle::class => ['dev' => true, 'test' => true],
    Symfony\UX\TwigComponent\TwigComponentBundle::class => ['all' => true],
    Survos\CoreBundle\SurvosCoreBundle::class => ['all' => true],
    Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
    Survos\BootstrapBundle\SurvosBootstrapBundle::class => ['all' => true],
    SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle::class => ['all' => true],
    KnpU\OAuth2ClientBundle\KnpUOAuth2ClientBundle::class => ['all' => true],
    Survos\AuthBundle\SurvosAuthBundle::class => ['all' => true],
    Survos\CommandBundle\SurvosCommandBundle::class => ['all' => true],
    Survos\InspectionBundle\SurvosInspectionBundle::class => ['all' => true],
    Survos\ApiGrid\SurvosApiGridBundle::class => ['all' => true],
    Survos\WorkflowBundle\SurvosWorkflowBundle::class => ['all' => true],
    FOS\JsRoutingBundle\FOSJsRoutingBundle::class => ['all' => true],
    SpomkyLabs\PwaBundle\SpomkyLabsPwaBundle::class => ['all' => true],
    Survos\PwaExtraBundle\SurvosPwaExtraBundle::class => ['all' => true],
    Survos\CrawlerBundle\SurvosCrawlerBundle::class => ['all' => true],
    Pierstoval\SmokeTesting\SmokeTestingBundle::class => ['dev' => true, 'test' => true],
];
