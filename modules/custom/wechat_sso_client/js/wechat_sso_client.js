/**
 * Created by dale on 2017/1/25.
 */
(function ($, Drupal) {
    Drupal.behaviors.wechatssoclient = {
        attach: function (context, settings) {
            if(typeof(wx) != "undefined" && wx !== null){
                wx.ready(function () {
                    if(!drupalSettings.user.uid){
                        // alert('即将跳转登录');
                        $('a[href="/user/login"]').click(function(e){
                            e.preventDefault();
                            var redirect_url = 'https://www.yongbuzhixi.com/wechat_login/1?sso=api&dest='+drupalSettings.path.currentPath;
                            window.location.replace(redirect_url);
                        })
                        if($('link[href="/taxonomy/term/13"]').length==1){//cc空中辅导自动登录
                            var redirect_url = 'https://www.yongbuzhixi.com/wechat_login/1?sso=api&dest='+drupalSettings.path.currentPath;
                            window.location.replace(redirect_url);
                            //cc空中辅导页面清理
                            $('.breadcrumb').hide();
                            $('textarea').attr('rows',2);
                        }
                    }
                });
            }
        }
    };
})(jQuery, Drupal);