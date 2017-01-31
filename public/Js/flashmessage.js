(function($) {
  $.flashmessage = function(msg, options) {
    var defaults = {
      container: 'div#successAdd',
      className: 'alert alert-success',
      timeToFade: 2000,
      type: 'notification'
    };

    var options = $.extend(defaults, options);
		if(msg.length > 0) {
	    var $msgBox = $('<div class="'+options.className+'" >'+msg+'</div>').css({
	      width: '100%'
	    }).hide();
	    $container = (typeof options.container == 'string') ? $(options.container) : options.container;

	    $container.prepend($msgBox);


	    $msgBox.fadeIn().addClass('open-message').delay(options.timeToFade).fadeOut(function(){ $msgBox.remove(); });
		}
    return '';
  };
})(jQuery);