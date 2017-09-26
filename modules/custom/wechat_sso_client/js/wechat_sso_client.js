/**
 * Created by dale on 2017/1/25.
 */
(function ($, Drupal) {
    Drupal.behaviors.wechatssoclient = {
        attach: function (context, settings) {
            if(typeof(wx) != "undefined" && wx !== null){
                wx.ready(function () {
                    if(!drupalSettings.user.uid){
                        alert('即将跳转登录');
                        var redirect_url = 'https://www.yongbuzhixi.com/wechat_login/1?sso=api&dest='+drupalSettings.path.currentPath;
                        window.location.replace(redirect_url);
                    }
                });
            }
        }
    };
})(jQuery, Drupal);