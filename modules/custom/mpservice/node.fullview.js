(function ($) {
  $(document).ready(function(){
    //br p delete!
    $('.field--name-body span').each(function(){
      if($(this).find('img').length>0) {
        return;
      }
      if($(this).text().length<=1)
        $(this).remove()
    })
    $('.field--name-body p').each(function(){
      if($(this).text().length<=1)
        $(this).remove()
    })
    $('.field--name-body section').each(function(){
      if($(this).find('img').length>0) {
        return;
      }
      if($(this).text().length<=6)
        $(this).remove()
    })
    $('.field--name-body p br').remove();

  });
})(jQuery);
