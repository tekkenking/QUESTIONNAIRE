<div class="row">
	<div class="col-md-1">
		<div class="form-group">
		<label for="questionlabel" class="font-sm bg-color-blue label">Label</label>
			<input type="text" id="questionlabel" name="question_label" class="form-control" placeholder="#" value="{{{$question->label}}}" validate="required"/>
		</div>
	</div>


	<div class="col-md-11">
		<div class="form-group">
		<label for="questionInput" class="font-sm bg-color-blue label">Edit Question</label>
			<input type="text" name="question" class="form-control" placeholder="Change Question" id="questionInput" value="{{{$question->question}}}" validate="required" required />
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="selectQuestionOptionType" class="font-sm bg-color-orange label"> Options Type </label>

			<select class="form-control" id="selectQuestionOptionType" name="optiontype" validate="required" required> 

				<?php $selection = ['radio' => 'Radio', 'checkbox' => 'Checkbox', 'opentext' => 'Open Text']; ?>

				@foreach( $selection as $key => $text )
					<option value="{{$key}}" @if( $key == $question->answers[0]->answer_type ) selected="selected" @endif>{{$text}}</option>
				@endforeach


			</select>
		</div>
	</div>

	<div class="col-md-3 addSubquestionButton">
		<div class="form-group">
		<label class="font-sm bg-color-orange label"> + Add Options button </label>
			<button type="button" class="btn btn-labeled btn-default text-regular addOption">
				<span class="btn-label">
					<i class="fa fa-plus fa-lg"></i>
				</span> Click to add options..
			</button>
		</div>
	</div>

</div>

<div class="well well-sm well-primary" id="questionOptionWrapper">
	<?php $answersoption = 0; ?>

	@foreach( $question->answers as $value )
		<div class="row optionx">
			<div class="form-group">
				<?php $answersoption++; ?>
				<label class="col-md-1 number">{{$answersoption}}.</label>

				<div class="col-md-10">
					 
					@if( $value->answer_type !== 'opentext' )
						<select name="option_{{$value->id}}" class="form-control" validate="required" required>
							<option value=""> Select option alias </option>
		        			@if( !empty($qoption_alias) )
		        				@foreach( $qoption_alias as $option )
		        					<option value="{{{$option->id}}}" @if( $value->options->name == $option->name ) selected="selected" @endif>
		        					{{{$option->name}}}
		        					</option>
		        				@endforeach
		        			@endif
						</select> 
					@else 
						<input type="text" name="option_{{$value->id}}" class="form-control" placeholder="Open text is readonly here" readonly="true" />
					@endif
					
				</div>

				<div class="col-md-1 removeCloseButton">
	              	<a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
	            </div>
			</div>
		</div>
		<br>
	@endforeach
</div>

<input type="hidden" name="subquestion" value="0" />


<script type="text/javascript">
$(function(){

	var $doc = $(this);

	$("#modal_update_question").click(function(e){
		//_debug($('form#store-questionnaires :input').not(':hidden, button'));
		//return false;

		//var $datax = $('form#update-questionnaires :input').not('button');

		//var tempFormElemet = "<form></form>";
		//tempFormElemet = $( tempFormElemet).html($datax.clone())

		e.preventDefault();
		$('form#update-questionnaires').ajaxrequest({
			//dataContent: $datax,
			msgPlace: '.error-msg',
			//validate: {etype: 'inline', vdata:$datax},
			validate: {etype: 'inline'},
			redirectDelay: 500,
			closeButton: true,
			close: true,
			ajaxRefresh: '#widget-grid',
			ajaxType: 'PUT'
		});
	});


	var $qns = {
		option : {
			remove 	: function(parentID, dis){
						var $divWrapper = $(dis).closest('.optionx');

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
						$divWrapper.next('br').remove();

						//Then remove the element
						$divWrapper.remove();
			},

			add 	: function(parentID, dis){
				var $xyz = $(parentID);
				var currentSn = $xyz.find('.number').get().length;
				var answer_type = $('#selectQuestionOptionType').val();

				$xyz.append($qns.option.getInput(currentSn, answer_type));
			},

			getInput : function(sn, answer_type){
				//var uniqueID = new Date().getTime();
				var $cloned = $('#hiddenOptions').clone();

				if( answer_type === 'opentext' ){
					$cloned.find('select.form-control').remove();
				}else{
					$cloned.find('input.form-control').remove();
				}

				return		$cloned
							.find('.form-group').removeClass(function(index, old){
								if($(this).hasClass('has-error')){
									$(this).removeClass('has-error');
								}
							})
							.end()
							.find('.number').text(sn + 1)
							.end()
							.find('.form-control')
							//.prop('name', answer_type + '_' + uniqueID + '_' + (sn + 1))
							.prop('name', 'option_' + (sn + 1))
							.prop('readonly', function(i, v){
								return ( answer_type === 'opentext') 
										? 'readonly' 
										: false;
							})
							.attr('validate', function(i,v){
								return ( answer_type === 'opentext') 
										? '' 
										: 'required';
							})
							.prop('placeholder', function(i, v){
								return ( answer_type === 'opentext') 
										? 'Open text is readonly here..' 
										: 'Type option here..';
							})
							.removeAttr('value')
							.end()
							.find('.removeCloseButton')
							.html(function(index, old){
								if( old === '' ){
									return '<a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>';
								}
							})
							.end()
							.html() + '<br>';
			}
		},

		removeDefaultTimes : function(parentID){
			var answer_type =  $('#selectQuestionOptionType').val();
			var xn = ( answer_type === 'opentext' ) ? 1 : 2;

			$(parentID).find('.removeCloseButton:lt('+ xn +')').text('');
		}
	}


	$qns.removeDefaultTimes('#questionOptionWrapper');

	/** ON QUESTION OPTION REMOVE ICON CLICKED **/
	$('.modal-body').on('click', '.removeCloseButton .removebutton', function(e){
		e.preventDefault();
		$qns.option.remove('#questionOptionWrapper', this);
	});

	/** ON QUESTION OPTION REMOVE ICON CLICKED **/
	$('.modal-body').on('click', '.addSubquestionButton .addOption', function(e){
		e.preventDefault();
		$qns.option.add('#questionOptionWrapper', this);
	});

	/** QUESTION ANSWER TYPE**/
	$('.modal-body').on('change', '#selectQuestionOptionType', function(e){
		var option, oldOption, counter, confirm_state;

		//We get the currently changed answer_type
		option = $(this).val();

		//We detect the old answer_type and save
		oldOption = ( $('#questionOptionWrapper input:first').prop('readonly') )
						? 'opentext' : 'other';

		//We change the options if the current answer_type is Open text and the OLD answer_type is either RADIO OR CHECKBOX
		if( option === 'opentext' && oldOption === 'other' ){

			confirm_state = confirm('By Changing the option to "OPEN TEXT", You\'ll loose any answers already populated.\n Do you want to continue?');

			if( confirm_state === false ){
				$(this).val('radio');
			 return false; 
			}

			//We first remove all current options
			$('#questionOptionWrapper').text('');

			//We Add 1 Options if option is opentext
			counter = 1;
			for(i=0; i < counter; i++){
				$qns.option.add('#questionOptionWrapper', this);
			}
		//We change the options if the current answer_type is not open_text and old answer_type is open_text. Because we dont want to change the options if the current answer_type and old answer_type is either RADIO OR CHECKBOX
		}else if( option !== 'opentext' && oldOption === 'opentext'){
			$('#questionOptionWrapper').text('');

			counter = 2;
			for(i=0; i < counter; i++){
				$qns.option.add('#questionOptionWrapper', this);
			}
		}

		//We auto adjust the neccessary close option icon
		$qns.removeDefaultTimes('#questionOptionWrapper');

	});

});
</script>

<div class="hide" id="hiddenOptions">
	<div class="row optionx">
		<div class="form-group">
			<label class="col-md-1 number">1.</label>

			<div class="col-md-10">
				<input type="text" class="form-control" />
				<select class="form-control">
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
