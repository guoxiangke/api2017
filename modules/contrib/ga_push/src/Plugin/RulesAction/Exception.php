<?php

/**
 * @file
 * Contains \Drupal\ga_push\Plugin\RulesAction\Exception.
 */

namespace Drupal\ga_push\Plugin\RulesAction;

use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'Ga Push Exception' action.
 *
 * @RulesAction(
 *   id = "ga_push_exception",
 *   label = @Translation("Ga push: exception"),
 *   category = @Translation("GA Push"),
 *   context = {
 *     "exDescription" = @ContextDefinition("string",
 *       label = @Translation("Description"),
 *       description = @Translation("A description of the exception."),
 *       required = FALSE
 *     ),
 *     "exFatal" = @ContextDefinition("boolean",
 *       label = @Translation("Is Fatal?"),
 *       description = @Translation("Indicates whether the exception was fatal. true indicates fatal."),
 *     ),
 *   },
 * )
 */
class Exception extends RulesActionBase {

  /**
   * Executes the action with the given context.
   *
   */
  protected function doExecute($description, $isFatal) {
    ga_push_add_exception(array(
      'exDescription' => $description,
      'exFatal' => $isFatal
        )
    );
  }
}
