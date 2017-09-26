<?php

/**
 * @file
 * Contains \Drupal\ga_push\Plugin\RulesAction\Social.
 */

namespace Drupal\ga_push\Plugin\RulesAction;

use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'Ga Push Social' action.
 *
 * @RulesAction(
 *   id = "ga_push_social",
 *   label = @Translation("Ga push: social"),
 *   category = @Translation("GA Push"),
 *   context = {
 *     "socialNetwork" = @ContextDefinition("string",
 *       label = @Translation("Social network"),
 *       description = @Translation("The network on which the action occurs (e.g. Facebook, Twitter)."),
 *       required = TRUE
 *     ),
 *     "socialAction" = @ContextDefinition("string",
 *       label = @Translation("Social action"),
 *       description = @Translation("The type of action that happens (e.g. Like, Send, Tweet)."),
 *       required = TRUE
 *     ),
 *     "socialTarget" = @ContextDefinition("string",
 *       label = @Translation("Social target"),
 *       description = @Translation("Specifies the target of a social interaction. This value is typically a URL but can be any text. (e.g. http://mycoolpage.com)."),
 *       required = TRUE
 *     ),
 *   },
 * )
 */
class Social extends RulesActionBase {

  /**
   * Executes the action with the given context.
   *
   */
  protected function doExecute($network, $action, $target) {
    ga_push_add_social(array(
      'socialNetwork' => $network,
      'socialAction' => $action,
      'socialTarget' => $target,
    ));
  }
}
