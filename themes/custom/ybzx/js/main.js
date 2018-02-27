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
    if($('link[href="/taxonomy/term/354"]').length==1){//思麦首页二维码
      $("h1").html("<a style='color:#1e6bb8;' href=\'http://mp.weixin.qq.com/s?__biz=MzA5MTMxNzA0Ng==&mid=401367380&idx=1&sn=54677c54b12afc904fb461694ce5a973#rd\'>"+$("h1").text()+"</a>")
      $('.wechat_comments-indent').first().append('<img src="/sites/default/files/qr_smjh.jpg">');
    }
  });
})(jQuery);
