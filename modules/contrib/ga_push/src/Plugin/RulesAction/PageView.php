<?php

/**
 * @file
 * Contains \Drupal\ga_push\Plugin\RulesAction\PageView.
 */

namespace Drupal\ga_push\Plugin\RulesAction;

use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'Ga Push Page View' action.
 *
 * @RulesAction(
 *   id = "ga_push_page_view",
 *   label = @Translation("Ga push: page view"),
 *   category = @Translation("GA Push"),
 *   context = {
 *     "location" = @ContextDefinition("string",
 *       label = @Translation("Location"),
 *       description = @Translation("URL of the page being tracked. By default, analytics.js sets this to the full document URL, excluding the fragment identifier."),
 *       required = false,
 *     ),
 *     "page" = @ContextDefinition("string",
 *       label = @Translation("Page"),
 *       description = @Translation("A string that is uniquely paired with each category, and commonly used to define the type of user interaction for the web object."),
 *       required = FALSE
 *     ),
 *     "title" = @ContextDefinition("string",
 *       label = @Translation("Title"),
 *       description = @Translation("The title of the page."),
 *       required = FALSE
 *     )
 *   },
 * )
 */
class PageView extends RulesActionBase {

  /**
   * Executes the action with the given context.
   *
   */
  protected function doExecute($location, $page, $title) {
    ga_push_add_pageview(array(
     'location' => $location,
      'page'     => $page,
      'title'    => $title));
  }
}
