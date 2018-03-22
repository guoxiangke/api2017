<?php
/**
 * @file
 * Contains \Drupal\wxapi\Plugin\QueueWorker\YoutubeQueue.
 */
namespace Drupal\youtube_queue\Plugin\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
/**
 * A Node Publisher that publishes nodes on CRON run.
 *
 * @QueueWorker(
 *   id = "cron_youtube_publisher",
 *   title = @Translation("Cron Get Youtube"),
 *   cron = {"time" = 60}
 * )
 */
class YoutubeQueue extends QueueWorkerBase {
	
  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    //Lambda process video!
    //https://gist.github.com/Jaesin/898a0b74072c7573748b
    $request = \Drupal::httpClient()
      ->post('https://l.yongbuzhixi.com/youtube/download/mp4', [
        'timeout' => 300,
        'body' => '{"vid":"'.$data->vid.'"}'
      ]);
    \Drupal::logger('YoutubeQueue')->notice(json_decode($request->getBody())->message);
    return $request->getStatusCode()==200?TRUE:FALSE;
  }
}