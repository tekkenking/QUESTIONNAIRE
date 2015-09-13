<div class="row">

	<div class="col-md-1">
		<div class="form-group">
			<input type="text" name="question_label" class="form-control text-bold" placeholder="#" value="{{{$question->label}}}" validate="required"/>
		</div>
	</div>

	<div class="col-md-11">
		<div class="form-group">
			<input type="text" name="question" class="form-control" placeholder="Change Question" value="{{{$question->question}}}" validate="required" required />
		</div>
	</div>
</div>

<div style="height:75px" class="stickplacewrapper">
	<div class="row stickplace">
		<div class="col-md-6">
			<div class="form-group">
				<label for="selectQuestionOptionType" class="font-sm bg-color-pink label"> Options Type </label>

				<select class="form-control" id="selectSubquestionOptionType" name="subquestion_optiontype" validate="required" required> 

					<?php $selection = ['radio' => 'Radio', 'checkbox' => 'Checkbox', 'opentext' => 'Open Text', 'doubleopentext' => 'Double Open Text']; ?>

					@foreach( $selection as $key => $text )
							<option value="{{$key}}" @if( $key == $question->subquestions[0]->answers[0]->answer_type ) selected="selected" @endif>
								{{$text}}
							</option>
					@endforeach


				</select>
			</div>
		</div>

		<div class="col-md-4 addSubquestionButton">
			<div class="form-group">
				<label class="font-sm bg-color-pink label"> + Sub-Question button </label>
				<button type="button" class="btn btn-labeled btn-default text-regular">
					<span class="btn-label">
						<i class="fa fa-plus fa-lg"></i>
					</span> Add Subquestion
				</button>
			</div>
		</div>

	</div>
</div>



<div id="subquestionOptionWrapper">
	<?php $panelCounter = 0; ?>
	@foreach( $question->subquestions as $subquestion )

		<?php $panelCounter++ ?>
		<div class="row SubquestionOptionPanel">
			<div class="col-md-12">
				<div class="panel panel-primary">
			      <div class="panel-heading">
			        <h3 class="panel-title">
			            <a href="#" class="panel-button panel-button-left removeButtonPanel"><i class="fa fa-times fa-2x"></i> </a>
			        	<span class="text-regular"> Sub-Question Panel <span class="SubquestionPanelCounter">{{{$panelCounter}}}</span>:</span>
			        	<span class="subquestionoptiontypelabel label bg-color-blueLight">{{$subquestion->answers[0]->answer_type}}</span>
			        	<button class="btn btn-sm btn-default panel-button addbutton font-sm text-regular"><i class="fa fa-plus"></i> Add Option</button>


		        	<div class="panel-select-option"> 
		        		<select class="form-control" name="answertype_{{$subquestion->id}}"> 
			        		<option value="radio" @if( $subquestion->answers[0]->answer_type === 'radio') selected="true" @endif>Radio</option>
							<option value="checkbox" @if( $subquestion->answers[0]->answer_type === 'checkbox') selected="true" @endif>Checkbox</option>
							<option value="opentext" @if( $subquestion->answers[0]->answer_type === 'opentext') selected="true" @endif>Open Text</option>

							<option value="doubleopentext" @if( $subquestion->answers[0]->answer_type === 'doubleopentext') selected="true" @endif>Double Open Text</option>
			        	 </select>
		        	</div>

			        </h3>
			      </div>
			      <div class="panel-body">
			      	<div class="row Subquestionquestion">
				      	<div class="form-group">
					       
				        	<div class="col-md-1">
				        		<input type="text" name="subquestion_label_{{{$subquestion->label}}}" class="form-control SubquestionInputLabel" placeholder="Label" value="{{{$subquestion->label}}}" validate="required">
				        	</div>

				            @if( $subquestion->answers[0]->answer_type === 'doubleopentext' )

				           		 	<?php
										$optFull = explode(':::', $subquestion->sub_question);
										$optLeft = isset($optFull[0]) ? $optFull[0] : '';
										$optRight = isset($optFull[1]) ? $optFull[1] : '';
									?>

			       		<div class="col-md-5">
			        		<input type="text" class="form-control SubquestionDoubleopentextQ right" placeholder="Type Sub-Question here..." name="subquestion_{{{$subquestion->id}}}[]" value="{{{$optLeft}}}" validate="required">
			        	</div>
			      
			           	<div class="col-md-5">
			        		<input type="text" class="form-control SubquestionDoubleopentextQ left" placeholder="Type Sub-Question here..." name="subquestion_{{{$subquestion->id}}}[]" value="{{{$optRight}}}" validate="required">
			        	</div>


				            @else
				        <div class="col-md-10">
				              <input type="text" name="subquestion_{{{$subquestion->id}}}" class="form-control SubquestionInput" placeholder="Type Sub-Question here..." value="{{{$subquestion->sub_question}}}" validate="required">
				            </div>

				            @endif
				        </div>
			      	</div>
			      	
			      	<?php $answersoption = 0; ?>
			      	@foreach( $subquestion->answers as $answer )
			      		<br>
						<div class="row SubquestionOptions">
						    <div class="form-group">
						    <?php $answersoption++; ?>
						        <label class="col-md-1 number">{{$answersoption}}.</label>
					        	<div class="col-md-10">

					@if( $answer->answer_type !== 'opentext' && $answer->answer_type !== 'doubleopentext' )
						<select name="option_{{{$answer->id}}}" class="form-control SubquestionOptionsInput" validate="required" required>
							<option value=""> Select option alias </option>
		        			@if( !empty($qoption_alias) )
		        				@foreach( $qoption_alias as $option )

		        					<option value="{{{$option->id}}}" @if( $answer->options->name == $option->name ) selected="selected" @endif>
		        					{{{$option->name}}}
		        					</option>
		        				@endforeach
		        			@endif
						</select> 
					@else 
						<input type="text" name="option_{{{$answer->id}}}" class="form-control SubquestionOptionsInput" placeholder="Open text is readonly here" readonly="true" />
					@endif

					        	</div>
					      
					            <div class="col-md-1 removeCloseButton">
					              <a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
					            </div>
					        </div>
						</div>
						
			      	@endforeach

			      </div>
			    </div>
			</div>
		</div>

	@endforeach
</div>

<script type="text/javascript">
$(function(){
	var $doc = $(this);

	$("#modal_update_question").click(function(e){
		//_debug($('form#store-questionnaires :input').not(':hidden, button'));
		//return false;

		var $datax = $('form#update-questionnaires :input').not('.hide :input, button');

		//_debug($datax);

		var tempFormElemet = "<form></form>";
		tempFormElemet = $( tempFormElemet).html($datax.clone())

		e.preventDefault();
		$('form#update-questionnaires').ajaxrequest({
			dataContent: $datax,
			extraContent : {subquestion : 1},
			msgPlace: '.error-msg',
			validate: {etype: 'group', vdata:$datax},
			//validate: {etype: 'inline'},
			//redirectDelay: 500,
			closeButton: true,
			close: true,
			ajaxRefresh: '#widget-grid',
			ajaxType: 'PUT'
		});
	});

	//Lets remove the close icons on panel
	var $subQns = {
			panel 	: {
				add 	: function(parentID, noClose){
					var $hidden = $('#hiddenSubquestionOptionPanel').clone();
					var panelCounter = $(parentID + ' .SubquestionPanelCounter').get().length;
					var panelGeneratedID = new Date().getTime();
					var activeOptiontype;
					var htmlx = $hidden
								.find('.SubquestionPanelCounter')
								.text( panelCounter + 1 )
								.end()
								.find('.subquestionoptiontypelabel')
								.text(function (index, oldText){
									return activeOptiontype = $('#selectSubquestionOptionType').val();
								})
								.end()
								.find('.panel-select-option > select')
								.prop('name', 'answertype_' + panelGeneratedID)
								.html(function (index, oldHtml){
									var d_option = { radio : "Radio", checkbox : 'Checkbox', opentext : 'Open Text', doubleopentext : 'Double Open Text' };
									var d_allOption = '';
											$.each(d_option, function(i,v){
												if( i === activeOptiontype ){
													d_allOption += '<option value='+i+' selected="true">'+ v +'</option>';
												}else{
													d_allOption += '<option value='+i+'>'+ v +'</option>';
												}
											});

									return d_allOption;
								})
								.end()
								.find('input.SubquestionInputLabel')
								.prop('name', 'subquestion_label_' + (panelCounter + 1))
								.end()
								.find('input.SubquestionInput')
								.prop('name', 'subquestion_' + (panelCounter + 1))
								.end()
								.find(' .panel-body > .row ')
								.html(function (index, old){

									if(activeOptiontype === 'doubleopentext'){
										var $mex = $('#hiddenSubquestionDoubleopentextQuestions .SubquestionDoubleopentextQuestions')
											.find('.SubquestionDoubleopentextQ.labelx')
											.prop('name', 'subquestion_label_' + (panelCounter + 1))
											.end()
											.find('.SubquestionDoubleopentextQ.right')
											.prop('name', 'subquestion_' + (panelCounter + 1) + '[]')
											.end()
											.find('.SubquestionDoubleopentextQ.right')
											.prop('name', 'subquestion_' + (panelCounter + 1) + '[]')
											.end()
											.html();

											return $mex;
									}else{
										return old;
									}
								})

								/**/
								.end()

								.find('.SubquestionOptionPanel')
								.prop('id', panelGeneratedID)
								.end()
								.html()

					//$(parentID + ' .SubquestionOptionType').after(htmlx);
					$(parentID).append(htmlx);

					//Lets Auto Add Atleast 2 Options if Checkbox or Radio is the "sub-question optio type"
					//If it's Open text we auto Add Just 1
					$('#'+ panelGeneratedID + ' .panel-body').append( function(index){
						/*var subquestionOption = $('#'+ panelGeneratedID +' .subquestionoptiontypelabel').text();*/
						var counter = ( activeOptiontype === 'opentext' || activeOptiontype === 'doubleopentext' ) ? 1 : 2;
						var countedHTMLx = '';

						for(i =0; i < counter; i++){
							countedHTMLx += $subQns.other.hiddenSubquestionOptions(i, activeOptiontype);
						}

						return countedHTMLx;
					});

					//Would auto remove the close option icon
					if( noClose === true )
					{	
						$('#'+ panelGeneratedID + ' .panel-body').find('.removeCloseButton:lt(2)').remove()
					}

				},

				changePanelOption : function (panelGeneratedID, option, noClose){
					$(panelGeneratedID + ' .subquestionoptiontypelabel').text(option);
					$(panelGeneratedID + ' .panel-body .SubquestionOptions')
						.prev('br')
						.remove()
						.end()
						.next('br')
						.remove()
						.end()
						.remove();

					$(panelGeneratedID + ' .panel-body')
					.append( $subQns.option.setUpSubQuestionOption(option) );

					//Would auto remove the close option icon
					if( noClose === true )
					{	
						$(panelGeneratedID + ' .panel-body')
						.find('.removeCloseButton:lt(2)')
						.remove()
					}
				},

				remove 	: function(parentID){
					//You get all the serial numbers that are after the currently clicked
					//Return Javascript Object
					var thisNumber = $(parentID + ' .SubquestionPanelCounter').text();

					var $numbers = $('#subquestionOptionWrapper ' + ' .SubquestionPanelCounter:gt('+ (thisNumber - 1 ) +')');

					//We alterate through all the gathered numbers and minus 1.
					if( $numbers.length > 0 )
					{
						$.each($numbers, function(i,v){
							$(this).text( function(index, text){
								return parseInt(text) - 1;
							} )
						});
					}

					//We remove the panel
					$(parentID).remove();
				}
			},

			option 	: {

				setUpSubQuestionOption : function (subquestionOption){

					var counter = ( subquestionOption === 'opentext' || subquestionOption === 'doubleopentext' ) ? 1 : 2;
					var countedHTMLx = '';

					for(i =0; i < counter; i++){
						countedHTMLx += $subQns.other.hiddenSubquestionOptions(i, subquestionOption);
					}

					return countedHTMLx;

				},

				add 	: function(parentID, dis){
					var $xyz = $(parentID + ' .panel-body');
					var currentSn = $xyz.find('.number').get().length;
					var subquestionOption = $(parentID +' .subquestionoptiontypelabel').text();

					//if( subquestionOption === 'doubleopentext' ){
						// STILL TO WORK HERE
					//	_debug('Still to work here');
					//}else{
					$xyz.append($subQns.other.hiddenSubquestionOptions(currentSn, subquestionOption));
					//}
				},

				remove 	: function(parentID, dis){
					var $divWrapper = $(dis).closest('.SubquestionOptions');

					//You get the currently clicked Serial Number
					var thisNumber = $divWrapper.find('.number').text();

					//You get all the serial numbers that are after the currently clicked
					//Return Javascript Object
					var $numbers = $(parentID + ' .number:gt('+ (thisNumber - 1) +')');

					//We alterate through all the gathered numbers and minus 1.
					if( $numbers.length > 0 )
					{
						$.each($numbers, function(i,v){
							$(this).text( function(index, text){
								return parseInt(text) - 1;
							} )
						});
					}

					//Remove the BR element first
					$divWrapper.prev('br').remove();

					//Then remove the element
					$divWrapper.remove();
				}
			},

			other 	: {
				autoRemovePanelCloseButton 	: function(){
					$('.removeButtonPanel:lt(1)').text('');
				},

				firstTwoPanelUniqueID 		: function(){
					var availPanels = $('.SubquestionOptionPanel').get();
					var counter = availPanels.length;
					
					for(i = 0; i < counter; i++){
						$(availPanels[i]).prop('id', new Date().getTime() + i);
					}

				},

				firstTwoPanelOptionRemoveIconDisabled : function(){
					var answer_type = $('#selectSubquestionOptionType').val();
					var count = (answer_type === 'opentext' || answer_type === 'doubleopentext') ? 1 : 2;
					$('.SubquestionOptionPanel')
					.find('.removeCloseButton:lt('+count+')')
					.text('');
				},

				hiddenSubquestionOptions 	: function(counter, subquestionOption){
					var uniqueID = new Date().getTime();
					var $cloned = $('#hiddenSubquestionOptions').clone();

					if( subquestionOption === 'opentext' || subquestionOption === 'doubleopentext' ){
						$cloned.find('select.SubquestionOptionsInput').remove();
					}else{
						$cloned.find('input.SubquestionOptionsInput').remove();
					}


					return '<br>' + $cloned
									.find('.SubquestionOptions .number').text(counter + 1)
									.end()
									.find('.SubquestionOptionsInput')
									.prop('name', 'option_' + uniqueID + '_' + (counter + 1))
									.prop('readonly', function(i, v){
										return ( subquestionOption === 'opentext' || subquestionOption === 'doubleopentext') 
												? 'readonly' 
												: false;
									})
									.attr('validate', function(i,v){
										return ( subquestionOption === 'opentext' || subquestionOption === 'doubleopentext') 
												? '' 
												: 'required';
									})
									.prop('placeholder', function(i, v){
										return ( subquestionOption === 'opentext' || subquestionOption === 'doubleopentext') 
												? 'Field is readonly' 
												: 'Type option here..';
									})
									.end()
									.html();
				}
			}
	}

	//This would auto remove the Close Panel button
	$subQns.other.autoRemovePanelCloseButton();

	//This would set a unique ID on the first set of panels
	$subQns.other.firstTwoPanelUniqueID();

	//Remove the "remove icon" from the first two option in panel
	$subQns.other.firstTwoPanelOptionRemoveIconDisabled();

	/** ADD SUB QUESTION PANEL **/
	$('.modal-body').on('click', '.addSubquestionButton', function(e){
		e.preventDefault();
		
		//Auto Scroll to the newly created panel
		$('#remoteModal').scrollTo('.modal-footer');

		$subQns.panel.add('#subquestionOptionWrapper', true);
	});

	/** SUB-QUESTION PANEL OPTION TYPE CHANGER [ SELECT OPTION ] **/
	$('#subquestionOptionWrapper').on('change', '.panel-select-option > select', function(e){
		e.preventDefault();

		var panelID = $(this).closest('.SubquestionOptionPanel').prop('id');
		var option  = $(this).val();

		$subQns.panel.changePanelOption('#'+ panelID, option, true);
	});

	/** REMOVE SUB QUESTION PANEL **/
	$('#subquestionOptionWrapper').on('click', '.removeButtonPanel', function(e){
		e.preventDefault();
		$subQns.panel.remove( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});

	/** ADD SUB-QUESTION OPTION **/
	$('#subquestionOptionWrapper').on('click', '.addbutton', function(e){
		e.preventDefault();
		$subQns.option.add( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});

	/** REMOVE SUB-QUESTION OPTION **/
	$('#subquestionOptionWrapper').on('click', '.removebutton', function(e){
		e.preventDefault();
		$subQns.option.remove( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});


	$('.stickplace').inModalStickItOnscroll({
		stickyClass : 'modal-affix',
		stickyWrapperClass: 'stickplacewrapper',
		winny : '#remoteModal'
	});

})
</script>

<!-- SUB QUESTION OPTION CONTAINER -->
<div class="hide" id="hiddenSubquestionOptionPanel">
	<div class="row SubquestionOptionPanel">
		<div class="col-md-12">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		        <h3 class="panel-title">
		            <a href="#" class="panel-button panel-button-left removeButtonPanel"><i class="fa fa-times fa-2x"></i> </a>
		        	<span class="text-regular"> Sub-Question Panel <span class="SubquestionPanelCounter"></span>:</span>
		        	<span class="subquestionoptiontypelabel label bg-color-blueLight"></span>
		        	<button class="btn btn-sm btn-default panel-button addbutton font-sm text-regular"><i class="fa fa-plus"></i> Add Option</button>


		        	<div class="panel-select-option"> 
		        		<select class="form-control"> 
			        		<option selected="true" value="">
			        			Option change [ Not required ]
			        		</option>
			        		<option value="radio">Radio</option>
							<option value="checkbox">Checkbox</option>
							<option value="opentext">Open Text</option>
							<option value="doubleopentext">Double Open Text</option>
			        	 </select>
		        	</div>
		        </h3>
		      </div>
		      <div class="panel-body">
		      	<div class="row Subquestionquestion">
			      	<div class="form-group">
				       
			        	<div class="col-md-1">
			        		<input type="text" class="form-control text-bold SubquestionInputLabel" placeholder="#" validate="required">
			        	</div>
			      
			            <div class="col-md-10">
			              <input type="text" class="form-control SubquestionInput" placeholder="Type Sub-Question here..." validate="required">
			            </div>
			        </div>
		      	</div>
		      </div>
		    </div>
		</div>
	</div>
</div>

<!-- SUB QUESTION OPTIONS  -->
<div class="hide" id="hiddenSubquestionOptions">
	<div class="row SubquestionOptions">
	    <div class="form-group">
	        <label class="col-md-1 number">1.</label>
        	<div class="col-md-10">
        		<input type="text" class="form-control SubquestionOptionsInput" value="">
        		<select class="form-control SubquestionOptionsInput">
					<option value=""> Select option alias </option>
        			@if( !empty($qoption_alias) )
        				@foreach( $qoption_alias as $option )
        					<option value="{{{$option->id}}}">
        					{{{$option->name}}}
        					</option>
        				@endforeach
        			@endif
				</select> 
        	</div>
      
            <div class="col-md-1 removeCloseButton">
              <a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
            </div>
        </div>
	</div>
</div>

<!-- SUB QUESTION DOUBLE OPEN TEXT ( question ) -->
<div class="hide" id="hiddenSubquestionDoubleopentextQuestions">
	<div class="row SubquestionDoubleopentextQuestions">
	    <div class="form-group">
	        
        	<div class="col-md-1">
        		<input type="text" class="form-control text-bold SubquestionDoubleopentextQ labelx" placeholder="#" validate="required">
        	</div>

        	<div class="col-md-5">
        		<input type="text" class="form-control SubquestionDoubleopentextQ right" placeholder="Type question" validate="required">
        	</div>
      
           	<div class="col-md-5">
        		<input type="text" class="form-control SubquestionDoubleopentextQ left" placeholder="Type question" validate="required">
        	</div>

        </div>
	</div>
</div>

<!-- SUB QUESTION DOUBLE OPEN TEXT ( option ) -->
<div class="hide" id="hiddenSubquestionsDoubleopentextOptions">
	<div class="row SubquestionOptions">
	    <div class="form-group">
	        
	         <label class="col-md-1 number">1.</label>

        	<!--<div class="col-md-1">
        		<input type="text" class="form-control text-bold SubquestionDoubleopentextO labelx" placeholder="#">
        	</div>-->

        	<div class="col-md-5">
        		<input type="text" readonly="true" class="form-control SubquestionDoubleopentextO right" placeholder="Open text">
        	</div>
      
           	<div class="col-md-5">
        		<input type="text" readonly="true" class="form-control SubquestionDoubleopentextO left" placeholder="Open text">
        	</div>

            <div class="col-md-1 removeCloseButton">
              <a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
            </div>

        </div>
	</div>
</div>