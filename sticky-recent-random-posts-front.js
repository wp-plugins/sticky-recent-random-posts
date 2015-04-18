(function($){
    $(function() {
      	var mn_scroll_duration=parseInt(mn_post_display_options_obj.mn_display_bar_duration);
      	var mn_animation_duration=parseInt(mn_post_display_options_obj.mn_display_bar_animation_duration);
      	mn_scroll_duration=(mn_scroll_duration)?mn_scroll_duration:0;
      	mn_animation_duration=(mn_animation_duration)?mn_animation_duration:0;
      	$(window).one("scroll",function(e){
		      	setTimeout(function(){
		      		$("#mn_sticky_bar_wrapper").animate({'left':'0%'},mn_animation_duration);
		      	},mn_scroll_duration);
     	});
    });
})(jQuery);