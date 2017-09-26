<?php

/**
 * @file
 * Contains \Drupal\ga_push\Plugin\RulesAction\Event.
 */

namespace Drupal\ga_push\Plugin\RulesAction;

use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'Ga Push Event' action.
 *
 * @RulesAction(
 *   id = "ga_push_event",
 *   label = @Translation("Ga push: event"),
 *   category = @Translation("GA Push"),
 *   context = {
 *     "category" = @ContextDefinition("string",
 *       label = @Translation("Category"),
 *       description = @Translation("The name you supply for the group of objects you want to track.")
 *     ),
 *     "action" = @ContextDefinition("string",
 *       label = @Translation("Action"),
 *       description = @Translation("A string that is uniquely paired with each category, and commonly used to define the type of user interaction for the web object.")
 *     ),
 *     "label" = @ContextDefinition("string",
 *       label = @Translation("Label"),
 *       description = @Translation("An optional string to provide additional dimensions to the event data."),
 *       required = FALSE
 *     ),
 *     "value" = @ContextDefinition("integer",
 *       label = @Translation("Value"),
 *       description = @Translation("An integer that you can use to provide numerical data about the user event."),
 *       required = FALSE
 *     ),
 *     "non-interaction" = @ContextDefinition("boolean",
 *       label = @Translation("Non interaction"),
 *       description = @Translation("A boolean that when set to true, indicates that the event hit will not be used in bounce-rate calculation. (Not compatible with SSGA method)."),
 *       default_value = FALSE,
 *       required = FALSE
 *     )
 *   },
 * )
 */
class Event extends RulesActionBase {

  /**
   * Executes the action with the given context.
   *
   */
  protected function doExecute($category, $action, $label, $value, $nonInteraction) {
    dpm(array(
      'eventCategory'        => $category,
      'eventAction'          => $action,
      'eventLabel'           => $label,
      'eventValue'           => $value,
      'nonInteraction'       => $nonInteraction,
    ));
   ga_push_add_event(array(
      'eventCategory'        => $category,
      'eventAction'          => $action,
      'eventLabel'           => $label,
      'eventValue'           => $value,
      'nonInteraction'       => $nonInteraction,
    ));
  }
}
