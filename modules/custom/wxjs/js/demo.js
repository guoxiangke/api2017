(function($) {
  jQuery(document).ready(function ($) {
    wx.ready(function () {
      var shareData =  drupalSettings.wxjs.shareData;
      wx.onMenuShareAppMessage(shareData);
      wx.onMenuShareTimeline(shareData);
    });
  });
}( jQuery ));
