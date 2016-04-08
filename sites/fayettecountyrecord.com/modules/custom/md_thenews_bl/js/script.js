/*------------------------------------------------------------------------
# KickStars - June 03, 2013
# ------------------------------------------------------------------------
# Designed by BestWebSoft & HTML by MegaDrupal
# Websites:  http://www.megadrupal.com -  Email: info@megadrupal.com
--------------------------------------------------------------------------*/


jQuery(document).ready(function($) {
        var twitter_account = Drupal.settings.twitter_account;
        var twitter_max = Drupal.settings.twitter_num;
        $("#sys_lst_tweets").tweet({
        modpath: location.href.substring(0,location.href.lastIndexOf("/")+1) + "?q=md_thenews_bl/tweet",
        count: twitter_max,
        username: twitter_account,
        template: '<p class="rs tweet-mind">{text}</p><p class="rs timestamp">{time}</p><i class="icon iTwitter"></i>'
        });
});