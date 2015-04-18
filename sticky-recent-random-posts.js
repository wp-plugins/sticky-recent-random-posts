(function($){
    $(function() {
        $(".mn_color_picker").wpColorPicker();

        $("#mn_display_bar_option").change(function(e){
        	if($(this).val()=="immediately")
        	{
        		$(".depends_on_mn_display_bar_option").hide();
        	}
        	else
        	{
        		$(".depends_on_mn_display_bar_option").show();
        	}
        });

        $("#mn_display_bar_option").trigger("change");
    });
})(jQuery);