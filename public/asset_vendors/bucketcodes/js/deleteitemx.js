(function ($, undefined) {
	"use strict";
	
	var o, $that;

	$.fn.extend({
		deleteItemx : function(options){
			var refval, checkboxes = [], confirmMessage;

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
						var dataid = $closestTr.find('td:first input[type="checkbox"]').val();

						//_debug(dataid);

						dataid = (dataid === undefined) 
									? $(this).data('id') 
									: dataid;

						refval = [dataid];

						//_debug(refval);
						//return false;

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

				});
			});
		},


		deleteThis : function (options){
			/**
				The element must have data-deleteurl set wit the DELETE verb url
				<a href="#" data-deleteurl="http://example.com/item/2">
			*/
				o = $.extend({
					url : '',
					targetParent : '',
					targetName : '',
					highlightedClass : 'khaki-bg',
					ajaxType : 'DELETE',
					confirmationMessage : "You're about to delete :nameholder"
				}, options);

				return this.each(function(){

					$that = $(this);

					o.url = ( o.url === '' ) ? $that.data('deleteurl') : o.url;

					if( o.targetParent !== '' ){
						$(this).closest(o.targetParent).addClass(o.highlightedClass);
					}

					o.targetName = (o.targetName === '' || o.targetParent === '') 
						? 'me'
						: $that.closest(o.targetParent)
								.find(o.targetName)
								.text();

					$.SmartMessageBox(
						{
							title : "Confirm Delete",
							content : o.confirmationMessage.replace(':nameholder', o.targetName),
							buttons : '[No][Yes]'
						},

						function (ButtonPressed) {
							if( ButtonPressed === 'Yes' ){
								$that.ajaxrequest({
									url: 	o.url,
									wideAjaxStatusMsg: '.error-msg',
									msgPlaceFade: 3000,
									ajaxType : o.ajaxType,
									successCallback : removeItem
								});
							}else{
								if( o.targetParent !== '' ){
									$that.closest(o.targetParent).removeClass(o.highlightedClass);
								}
							}
						}

					);

					function removeItem(){
						$that.closest(o.targetParent).remove();
					}

				});
			},

	}

	);
})(jQuery);
