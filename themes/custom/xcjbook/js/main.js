/**
 * Created by dale.guo on 12/28/16.
 */
(function ($) {
  $(document).ready(function(){
    //br p delete!
    $('.page-node-type-article article span').each(function(){
      if($(this).find('img').length>0) {
        return;
      }
      if($(this).text().length<=1)
        $(this).remove()
    })
    $('.page-node-type-article article p').each(function(){
      if($(this).text().length<=1)
        $(this).remove()
    })
    $('.page-node-type-article article section').each(function(){
      if($(this).find('img').length>0) {
        return;
      }
      if($(this).text().length<=6)
        $(this).remove()
    })
    $('.page-node-type-article article p br').remove();

    //comment click show all
    $('.vocabulary-lylist .comment .field--name-comment-body').click(function(){
      if($(this).prop('scrollHeight')>35){
        $(this).toggleClass('collspan');
      }
    })
    $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').hide();
    $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').next('.indented').hide();


    $('.toogleshowcomments .showall').click(function(){
      $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').show();
      $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').next('.indented').show();
      $(this).addClass('weui-bar__item_on');
      $('.toogleshowcomments .shownone').removeClass('weui-bar__item_on');
    })
    $('.toogleshowcomments .shownone').click(function(){
      $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').hide();
      $('.vocabulary-lylist .field--name-field-lylist-comment-lymeta-nid').parents('article.comment').next('.indented').hide();
      $(this).addClass('weui-bar__item_on');
      $('.toogleshowcomments .showall').removeClass('weui-bar__item_on');
    })

    $('.vocabulary-lylist .comment .field--name-comment-body').each(function(){
      if($(this).prop('scrollHeight')<=35){
        $(this).addClass('nobefore');
      }
    })



  });
})(jQuery);



(function ($, Drupal) {
  /**
   * Initialise the tabs JS.
   */
  Drupal.behaviors.comment_lylist_form = {
    attach: function (context, settings) {
      if($('.path-comment .comment-lylist-comments-form').length>0){
        $('#page').hide();
        $('#page-wrapper').append($('.comment-lylist-comments-form').clone());
      }
    }
  };

})(jQuery, Drupal);
