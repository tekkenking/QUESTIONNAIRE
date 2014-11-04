(function ($) {
	"use strict";
	
	$.fn.extend({
		deleteItemx : function(options){
			var refval, o, checkboxes = [], confirmMessage;

			o = $.extend({
				url:'',
				roleNameClass : '',
				emptyDeleteMsg: 'Nothing was selected',
				pageReload: false,
				ajaxRefresh: false,
				afterDelete: false, // CALLBACK FUNCTION : FALSE;
				afterDelete_args:'',
				highlightedClass: 'khaki-bg',
				confirmationMessage: "You're about to delete <b>[ :nameholder ]</b>. Are you sure?"
			}, options);
			
			return this.each(function(){
				$(this).on('click', function(e){
					e.preventDefault();
					e.stopImmediatePropagation(); // This would stop it from Double event fire

					if( $(this).hasClass('single_delete') ){
						var $closestTr =  $(this).closest('tr');
						refval = [$closestTr.find('td input[type="checkbox"]').val()];

						//_debug(refval);

						//Lets highlight the active role
						$closestTr.addClass(o.highlightedClass);
 
						confirmMessage = (o.roleNameClass === '') 
						?
							$closestTr.find('td').eq(1).text()
						:
							$closestTr.find('.'+ o.roleNameClass).text();

						confirmDeleteSmart($(this), refval, o.url, confirmMessage, 'single');
						return false;
					}


					if( $(this).hasClass('multiple_delete') ){
						$('input:checked').not('#default_checkbox').each(function(i){
							checkboxes[i] = $(this).val();
						});
							
						confirmMessage = checkboxes.length;

						if(confirmMessage === 0){
							//bootbox.alert(o.emptyDeleteMsg);
							$.smallBox({
								title : "<i class='fa fa-warning fa-lg'></i> Opps Error !!!",
								content : o.emptyDeleteMsg,
								color : "#C46A69",
								timeout : 3000
							});
							return false;
						}

						confirmDeleteSmart($(this), checkboxes, o.url, confirmMessage, 'multiple');

						//Very important line.
						//It will reset the number of selected checkbox to 0.
						checkboxes = [];
					}

					function confirmDeleteSmart(that, vals, urlDelete, confirmMessage, typex)
					{
						$.SmartMessageBox({
							title : "Confirm Delete",
							content : o.confirmationMessage.replace(':nameholder', confirmMessage),
							buttons : '[No][Yes]'
						}, function(ButtonPressed) {

							function afterDelete(){
								if( o.afterDelete !== false ){
									var callbacks = $.Callbacks();
									callbacks.add(o.afterDelete);
									callbacks.fire(o.afterDelete_args);
								}
							}

							if (ButtonPressed === "Yes") {

									//Ajax call for deleting the item in database
									$(that).ajaxrequest({
										dataContent: vals,
										url:urlDelete,
										wideAjaxStatusMsg: '.error-msg',
										msgPlaceFade: 3000,
										pageReload: o.pageReload,
										ajaxRefresh: o.ajaxRefresh
									});

									if(typex === 'single'){
										//For removing single item DOM
										$(that).closest('.deletethis').fadeOut('slow', function(){
											$(this).remove();
											afterDelete();
										});
									}

									if(typex === 'multiple'){
										$.each(vals, function(index, id){
										//For removing multiple item DOM
											$('input[value="'+ id +'"]').closest('.deletethis').fadeOut('slow', function(){
												$(this).remove();
												afterDelete();
											});
										});
									}

									$.smallBox({
										title : "<i class='fa fa-check fa-lg'></i> Completed !!!",
										content : "Deleted Successfully",
										color : "#3c763d",
										timeout : 3000
									});
							}
							if (ButtonPressed === "No") {

								that.closest('tr').removeClass(o.highlightedClass);
							}
				
						});
					}


					function confirmDelete(that, vals, urlDelete, confirmMessage, typex){

						bootbox.dialog(o.confirmationMessage.replace(':nameholder', confirmMessage),
						[
							{
								"label": "No",
								"class": "btn-gray",
								"callback": function(){
									//Lets highlight the active role
									that.closest('tr').removeClass(o.highlightedClass);
								}
							},
							{
								"label": "Yes",
								"class": "btn-danger",
								"callback": function(){
									//Ajax call for deleting the item in database
									$(that).ajaxrequest({
										dataContent: vals,
										url:urlDelete,
										wideAjaxStatusMsg: '.error-msg',
										msgPlaceFade: 3000,
										pageReload: o.pageReload,
										ajaxRefresh: o.ajaxRefresh
									});

									if(typex === 'single'){
										//For removing single item DOM
										$(that).closest('.deletethis').fadeOut('slow', function(){
											$(this).remove();
											afterDelete();
										});
									}

									if(typex === 'multiple'){
										$.each(vals, function(index, id){
										//For removing multiple item DOM
											$('input[value="'+ id +'"]').closest('.deletethis').fadeOut('slow', function(){
												$(this).remove();
												afterDelete();
											});
										});
									}

									function afterDelete(){
										if( o.afterDelete !== false ){
											var callbacks = $.Callbacks();
											callbacks.add(o.afterDelete);
											callbacks.fire(o.afterDelete_args);
										}
									}
								}
							}
						]);
					}

				});
			});
		},
	});
})(jQuery);