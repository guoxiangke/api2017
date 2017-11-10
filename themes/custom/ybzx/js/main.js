/**
 * Created by dale.guo on 12/28/16.
 */
(function ($, Drupal) {
  Drupal.behaviors.dataOpen = {
    attach: function (context, settings) {

    }
  };
})(jQuery, Drupal);


(function ($) {
  $(document).ready(function(){
		$('.data-open').click(function(e){
  		$(this).toggleClass("data-close");
  		$(this).parent('div').next('.sub-articles').toggle( "fast" );
  	})
  });
})(jQuery);
