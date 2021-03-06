<?php

namespace Drupal\cdn;

use Drupal\cdn\StackMiddleware\DuplicateContentPreventionMiddleware;
use Drupal\Core\Config\BootstrapConfigStorageFactory;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @see \Drupal\cdn\EventSubscriber\ConfigSubscriber::onSave()
 */
class CdnServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    if ($this->cdnStatusIsEnabled()) {
      $container->register('http_middleware.cdn.duplicate_content_prevention', DuplicateContentPreventionMiddleware::class)
        ->addArgument(new Reference('request_stack'))
        // Set the priority so that this middleware runs:
        // - before http_middleware.page_cache, to ensure responses generated by
        //   this middleware are not cached by the Page Cache.
        // - after ban.middleware, to allow malicious spiders/bots to still be
        //   banned, without having to run this middleware.
        ->addTag('http_middleware', ['priority' => 230]);
    }
  }

  /**
   * @return bool
   */
  protected function cdnStatusIsEnabled() {
    return BootstrapConfigStorageFactory::get()->read('cdn.settings')['status'] === TRUE;
  }

}
