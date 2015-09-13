//Debuger
function _debug(msg){
	"use strict";
	if(window.console){
		console.log(msg);
	}else{
		bootbox.alert(msg);
	}
}


//This function is used to test " cast of a variable "
function typeString(o) {
	  if (typeof o != 'object')
	    return typeof o;

	  if (o === null)
	      return "null";
	  //object, array, function, date, regexp, string, number, boolean, error
	  var internalClass = Object.prototype.toString.call(o).match(/\[object\s(\w+)\]/)[1];
	  return internalClass.toLowerCase();
}

//To correct the problem of persistent content on remote modalbox call
$('body').on('hidden.bs.modal', '#remoteModal, #fullscreen', function (e) {
   $('#remoteModal, #fullscreen').removeData('bs.modal'); 
   $('#remoteModal .modal-content, #fullscreen .modal-content').html('');
});

//Plugin for Sticking Things on scroll
(function($){
	"use strict";

	$.fn.extend({
		inModalStickItOnscroll : function(options){
			var opt, $that, origOffsetY, origWrapperOffsetY, winny = $(window);
			
			opt = $.extend({
				stickyClass: '',
				winny : '',
				stickyWrapperClass: '',
				paddedPosition: 87,
				positionAjuster: 31,
			}, options);

			$that = $(this);
			
			winny = (opt.winny === '') ? winny : $(opt.winny);

			origWrapperOffsetY = parseInt($('.' + opt.stickyWrapperClass).position().top) + parseInt(opt.paddedPosition);

			origOffsetY = origWrapperOffsetY;

			//_debug(origWrapperOffsetY);

			winny.scroll(function(){

				//origOffsetY = parseInt($that.position().top) + parseInt(opt.paddedPosition);

				//if( origWrapperOffsetY > origOffsetY ){
				//	origOffsetY += origWrapperOffsetY;
				//}

				//origOffsetY += origWrapperOffsetY;

				//_debug(origOffsetY);

				stickIt($(this));
			});

			//Function to do the magic
			function stickIt(dis)
			{
				//_debug( dis.scrollTop() + ' >= ' + origOffsetY );

				if( dis.scrollTop() >= origOffsetY ){
					$('.scrolltotopbutton').removeClass('hide');
					$that.addClass(opt.stickyClass).css({top: ( parseInt(dis.scrollTop()) - opt.positionAjuster )});
				}else{
					$that.removeClass(opt.stickyClass).css({top: 0});
					$('.scrolltotopbutton').addClass('hide');
				}
			}

			//For chainability
			return $that;
		}
	});
})(jQuery);

//Plugin for Sticking Things on scroll
(function($){
	"use strict";

	$.fn.extend({
		stickItOnScroll : function(options){
			var opt, $that, origOffsetY, origWrapperOffsetY, winny = $(window);
			
			opt = $.extend({
				stickyClass: '',
				stickyWrapperClass: ''
			}, options);

			$that = $(this);

			origWrapperOffsetY = $('.'+ opt.stickyWrapperClass).offset().top;

			//Apply features onPage Load
			stickIt(winny);

			//Apply when scrolling the page
			winny.scroll(function(){
				origOffsetY = $that.offset().top;

				if( origWrapperOffsetY > origOffsetY ){
					origOffsetY += origWrapperOffsetY;
				}

				//_debug('Wrapper ' + origWrapperOffsetY +' > ' + 'Orig ' + origOffsetY + ' [SrollTop ] = ' + $(this).scrollTop());
				
				stickIt($(this));
			});

			//Function to do the magic
			function stickIt(dis)
			{
				if( dis.scrollTop() >= origOffsetY ){
					$('.scrolltotopbutton').removeClass('hide');
					$that.addClass(opt.stickyClass);
					//origOffsetY = origWrapperOffsetY;
				}else{
					$that.removeClass(opt.stickyClass);
					$('.scrolltotopbutton').addClass('hide');

				}
			}

			//For chainability
			return $that;
		}
	});
})(jQuery);

$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);

  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);

   // _debug(scrollY);

    scrollPane.animate({
    		scrollTop : scrollY }, 
    		parseInt(settings.duration), 
    		settings.easing, 
    		function(){
		      if (typeof callback == 'function') { callback.call(this); }
		    });
  });
}


//Generated Int for random auth 
function randMoment(){
	var randMoment = Number(moment().dayOfYear());
    var containsArr = [1, 10, 100, 2];
	randMoment = ( _.contains(containsArr, randMoment) === true ) ? 390 : randMoment;
	return randMoment;
}