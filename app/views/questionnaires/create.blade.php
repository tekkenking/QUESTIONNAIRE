<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">CREATE QUESTION</h4>
</div>

<div class="modal-body">
	{{Form::open( array('route'=>'questionnaires.store', 'id'=>'store-questionnaires', 'role'=>'form') )}}
		<div class="error-msg"></div>

		@include('questionnaires.includes.category_subcategories')

		<div class="row">

			<div class="col-md-1">
				<div class="form-group">
					<label for="questionlabel" class="font-sm bg-color-blue label">
					Label
					</label>
					<input type="text" id="questionlabel" class="form-control text-bold" name="question_label" placeholder="#" validate="required" />
				</div>
				
			</div>

			<div class="col-md-8">
				<div class="form-group">
					<label for="questionInput" class="font-sm bg-color-blue label">Enter Question</label>
					<input type="text" id="questionInput" class="form-control" name="question" placeholder="Enter Question" validate="required" />
				</div>
				
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label for="has_subquestion" class="font-sm bg-color-blue label">Sub-Question?</label>
					
					<select class="form-control" id="has_subquestion" name="subquestion" validate="required">
						<!--<option value="">.. Select ..</option> -->
						<option value=0 selected="selected">No</option>
						<option value=1>Yes</option>
					</select>
					
				</div>
			</div>

		</div>

		<div id="questionChild">

			<!-- WRAPPER FOR QUESTION OPTIONS -->
			<div id="questionOptionWrapper" class="hide"></div>

			<!-- WRAPPER FOR SUB QUESTIONS -->
			<div id="subquestionOptionWrapper" class="hide"></div>

		</div>

	{{Form::close()}}
</div>
<div class="modal-footer">

	<button type="button" class="btn btn-labeled btn-warning text-regular  scrolltotopbutton pull-left">
		<span class="btn-label">
			<i class="fa fa-arrow-up fa-lg"></i>
		</span> Scroll to top
	</button>

	<button type="button" class="btn btn-labeled btn-default" data-dismiss="modal">
		<span class="btn-label">
			<i class="glyphicon glyphicon-remove"></i>
		</span>
		Cancel
	</button>
	<!--<button type="button" class="btn btn-labeled btn-warning" id="modal_preview_question">
		<span class="btn-label">
			<i class="fa fa-eye"></i>
		</span>
		 Preview
	</button>	-->

	<button type="button" class="btn btn-labeled btn-success" id="modal_add_question">
	 <span class="btn-label">
	  <i class="glyphicon glyphicon-save"></i>
	 </span>Save
	</button>

</div>


<script type="text/javascript">
$(function(){
	var $doc = $(this);

	//We give the modal box width:70%
	$('.modal-dialog').css({width:'70%'});

	//Scroll to top
	$('.scrolltotopbutton').click(function(e){
		e.preventDefault();
		$('#remoteModal').scrollTo(0);
	});

	$("#modal_add_question").click(function(e){
		var $datax = $('form#store-questionnaires :input').not('.hide :input, button');
		var tempFormElemet = "<form></form>";
		 tempFormElemet = $( tempFormElemet).html($datax.clone())

		e.preventDefault();
		$('form#store-questionnaires').ajaxrequest({
			dataContent: $datax,
			msgPlace: '.error-msg',
			validate: {etype: 'group', vdata: $(tempFormElemet)},
			ajaxRefresh: '#widget-grid',
			closeButton: true,
			clearfields: true,
			clearfieldsExcludes: 'select#has_subquestion, input[name="_token"], select[name="questionsubcat"], select[name="subquestion_optiontype"], select[name*="answertype"], select#selectQuestionOptionType'
		});
	});

	var $qns = {

		/** HIDING ERROR **/
		hideErrorMsg : 	function()
		{
			var $ermsg =  $('.error-msg');
			if( $ermsg.hasClass('alert-danger') ){
				$ermsg.removeClass('alert-danger alert');
				$ermsg.text('');
			}
		},

		/** SUB QUESTION FUNCTION **/
		subQuestionPanel : function(status){ 
			var $subQWrper = $('#subquestionOptionWrapper');

			if( status === 'show' ){
				//Shows SubquestionOptionType
				var $hiddenSubquestionOptionType = $('#hiddenSubquestionOptionType').html();
				$subQWrper.html($hiddenSubquestionOptionType).removeClass('hide');
			}else{
				$subQWrper.html('').addClass('hide');
				
			}
		},

		/** IF SUB QUESTION IS NO. THEN WE SHOW QUESTION OPTIONS **/
		optionType 		: function(status){
			

			var $qnsOptWrper = $('#questionOptionWrapper');

			if( status === 'show' ){
				var $hiddenOptionType = $('#hiddenOptionType').html();

				$qnsOptWrper.html($hiddenOptionType).removeClass('hide');

			}else if( $qnsOptWrper.hasClass('hide') === false ){
				$qnsOptWrper.html('').addClass('hide');
			}
		},

		child 			: function(status){ /** HIDES QUESTION CHILD  **/
			/*var $qnsCh = $('#questionChild');

			if( status === 'show' ){
				$qnsCh.removeClass('hide');
			}else if( $qnsCh.hasClass('hide') === false ){
				$qnsCh.addClass('hide');
			}*/
		}
	};

	/** QUESTION OPTIONS  **/
	var $qns_opt = {

		AddPanel : function(option){
			//$('#questionOptionPanel').removeClass('hide')
			$('#questionOptionWrapper').find('.questionOptionPanel').remove();
			$('#questionOptionWrapper').append( $('#hiddenQuestionOptionPanel').html() );

			$('.questionOptionPanel .questionoptiontype').text(option);
		},

		RemovePanel : function(){
			//$('#questionOptionPanel').addClass('hide');
			//$('#questionOptionWrapper').find('.questionOptionPanel').remove();
		},

		AddOption 	: function(parentID, noClose){
			//We get the html contents of the options
			var $panelbody = $(parentID + ' .panel-body');
			var $snPlace = $panelbody.find('.number');

			var currentSn = $snPlace.get().length + 1;

			//This line is important
			var $hasError = $('#hiddenOptions').find('.form-group');
			if( $hasError.hasClass('has-error') ){
				$hasError.removeClass('has-error');
			}

			var questionOption = $(parentID + ' .questionoptiontype').text();
			var $cloned = $('#hiddenOptions').clone();

			if( questionOption === 'opentext' ){
				$cloned.find('select').remove();
			}else{
				$cloned.find('input').remove();
			}


			var opt = $cloned
						.find('.form-control')
						.prop('name', 'option_' + currentSn)
						.attr('readonly', function(i, v){
							return ( questionOption === 'opentext') 
									? 'readonly' 
									: false;
						})
						.attr('validate', function(i, v){
							return ( questionOption !== 'opentext') 
											? 'required' 
											: false;
						})
						.prop('placeholder', function(i, v){
							return ( questionOption === 'opentext') 
									? 'Open text is readonly here..' 
									: 'Type option here..';
						})
						.end()
						.html();

			$panelbody.append(opt + '<br>')
			.find('.number:last')
			.text(currentSn);

			//Would auto remove the close option icon
			if( noClose === true ){
				$panelbody.find('.removebutton:last').remove();
			}

		},

		RemoveOption 	: function(parentID, dis){

			//We get the closest overall Div Wrapper for that option
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
		}
			
	}


	/** SUB QUESTION OPTIONS  **/
	var $subQns = {
		ShowAddButton : function(parentID, option){
			

			if( option !== '' ){
				$(parentID + ' .addSubquestionButton').removeClass('hide');
			}else{
				$(parentID + ' .addSubquestionButton').addClass('hide');
			}

			$('.subquestionoptiontypelabel').text(option);

			//We remove any panel already visible
			//$('#subquestionOptionWrapper .SubquestionOptionPanel').remove();

			//We clear any error message visible
			$qns.hideErrorMsg();
		},

		AddPanel : function (parentID, noClose){
			var $hidden = $('#hiddenSubquestionOptionPanel');
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
						.find('.SubquestionOptionPanel')
						.prop('id', panelGeneratedID)
						.end()
						.html()

			$(parentID).append(htmlx);

			//If it's doubleopentext. Then we add it's template
			if( activeOptiontype === 'doubleopentext' ){
				$subQns.changePanelOption('#'+panelGeneratedID, activeOptiontype, true);
			}else{
			//Lets Auto Add Atleast 2 Options if Checkbox or Radio is the "sub-question optio type"
			//If it's Open text we auto Add Just 1

				$('#'+ panelGeneratedID + ' .panel-body').append( function (index){
					return $subQns.setUpSubQuestionOption(activeOptiontype);
				});

				//Would auto remove the close option icon
				if( noClose === true )
				{	
					$('#'+ panelGeneratedID + ' .panel-body').find('.removeCloseButton:lt(2)').remove()
				}
			}

		},

		RemovePanel: function (parentID, dis){
			//You get all the serial numbers that are after the currently clicked
			//Return Javascript Object
			var thisNumber = $(parentID + ' .SubquestionPanelCounter').text();

			//var $numbers = $('#subquestionOptionWrapper ' + ' .SubquestionPanelCounter:lt('+ (-thisNumber ) +')');
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

			//We have to adjust the number of the subQuestion and the 
		},

		setUpSubQuestionOption : function  (subquestionOption){
			//var subquestionOption = $('#selectSubquestionOptionType').val();
			var counter = ( subquestionOption === 'opentext' ) ? 1 : 2;
			var countedHTMLx = '';

			for(i =0; i < counter; i++){
				countedHTMLx += $subQns.hiddenSubquestionOptions(i, subquestionOption);
			}

			return countedHTMLx;
		},

		doubleOpenTextQ : function ( panelGeneratedID ){
			return $('#hiddenSubquestionDoubleopentextQuestions')
							.find('.SubquestionDoubleopentextQ.labelx')
							.prop('name', 'subquestion_label_' + panelGeneratedID)
							.end()
							.find('.SubquestionDoubleopentextQ.left, .SubquestionDoubleopentextQ.right')
							.prop('name', 'subquestion_' + panelGeneratedID + '[]')
							.end()
							.html() + '<br>';
		},

		doubleOpenTextO : function (counter){
				counter = (counter === undefined) ? 1 : counter + 1;

				var uniqueID = new Date().getTime();
			return $('#hiddenSubquestionsDoubleopentextOptions')
					.find('.SubquestionOptions .number').text(counter)
					.end()
					/*.find('.SubquestionDoubleopentextO.labelx')
					.prop('name', 'subquestionanswer_label_' + uniqueID)
					.end()*/
					.find('.SubquestionDoubleopentextO.right')
					.prop('name', 'option_'+uniqueID+'_'+counter)
					.end()
					.html() + '<br>';
		},
 
		changePanelOption : function (panelGeneratedID, option, noClose){
			$(panelGeneratedID + ' .subquestionoptiontypelabel').text(option);

			if( option === 'doubleopentext' ){
				//FETCH DOUBLE OPEN TEXT TEMPLATE
				$(panelGeneratedID + ' .panel-body')
				.html( $subQns.doubleOpenTextQ( panelGeneratedID ) )
				.append(function (index, oldHtml){
					return $subQns.doubleOpenTextO();
				});

				//Would auto remove the close option icon
				if( noClose === true )
				{	
					$(panelGeneratedID + ' .panel-body')
					.find('.removeCloseButton:lt(2)')
					.remove()
				}

				
				return false;
			}else{
				$(panelGeneratedID + ' .panel-body .SubquestionOptions')
				.prev('br')
				.remove()
				.end()
				.next('br')
				.remove()
				.end()
				.remove();

				$(panelGeneratedID + ' .panel-body')
				.html( function (index, old){
					var snx = $(panelGeneratedID + ' .SubquestionPanelCounter').text();
					
					return $('#hiddenSubquestionOptionPanel .panel-body')
						.find('input.SubquestionInputLabel')
						.prop('name', 'subquestion_label_' + snx)
						.end()
						.find('input.SubquestionInput')
						.prop('name', 'subquestion_' + snx)
						.end()
						.html()
				})
				.append( $subQns.setUpSubQuestionOption(option) );

				//Would auto remove the close option icon
				if( noClose === true )
				{	
					$(panelGeneratedID + ' .panel-body')
					.find('.removeCloseButton:lt(2)')
					.remove()
				}
			}
		},

		AddOption : function (parentID, dis){
			var $xyz = $(parentID + ' .panel-body');
			var currentSn = $xyz.find('.number').get().length;
			var subquestionOption = $(parentID +' .subquestionoptiontypelabel').text();

			if( subquestionOption === 'doubleopentext' ){
				$xyz.append($subQns.doubleOpenTextO(currentSn));
			}else{
				$xyz.append($subQns.hiddenSubquestionOptions(currentSn, subquestionOption));
			}
		},

		RemoveOption : function (parentID, dis){

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
		},

		hiddenSubquestionOptions	: function (counter, subquestionOption){
			
			var uniqueID = new Date().getTime();

			var $cloned =  $('#hiddenSubquestionOptions').clone();

			if( subquestionOption === 'opentext' ){
				$cloned.find('select.SubquestionOptionsInput').remove();
			}else{
				$cloned.find('input.SubquestionOptionsInput').remove();
			}

			return	'<br>' + $cloned
							.find('.SubquestionOptions .number').text(counter + 1)
							.end()
							.find('.SubquestionOptionsInput')
							.prop('name', 'option_' + uniqueID + '_' + (counter + 1))
							.attr('readonly', function(i, v){
								return ( subquestionOption === 'opentext') 
										? 'readonly' 
										: false;
							})
							.attr('validate', function(i,v){
								
								return ( subquestionOption === 'opentext') 
										? '' 
										: 'required';
							})
							.prop('placeholder', function(i, v){
								return ( subquestionOption === 'opentext') 
										? 'Open text is readonly here..' 
										: 'Type option here..';
							})
							.end()
							.html();
		}
	};


	function defaultQuestionPanel(){
		$qns.subQuestionPanel('hide'); //We hide subQuestion panel
		$qns.optionType('show'); //We show Question Options Type
		$qns_opt.AddPanel('radio'); //We Add Radio Panel

		//We Add 2 radio Options
		for(i=0; i < 2; i++){
			$qns_opt.AddOption('#questionOptionWrapper .questionOptionPanel', true);
		}

	}

	function defaultSubQuestionPanel(type){

		type = (type == undefined) ? 'radio' : type;
		$qns.optionType('hide'); //We hide Question Options Type
		$subQns.ShowAddButton('#subquestionOptionWrapper .SubquestionOptionType', type);

		//We Add 2 subquestion radio panel
		for(k=0; k < 2; k++){
			$subQns.AddPanel('#subquestionOptionWrapper', true);
		}

		//This would prevent the removal of all subquestion
		$('#subquestionOptionWrapper .removeButtonPanel:lt(1)').remove();
	}

	/**  HAS SUB QUESTION **/
	$('#has_subquestion').change(function(e){
		var has_subquestion = $(this).val();

		if( has_subquestion == "1" )
		{
			$qns.subQuestionPanel('show'); //We show subQuestion Panel
			defaultSubQuestionPanel();

			$('#subquestionOptionWrapper .stickplace').inModalStickItOnscroll({
				stickyClass : 'page-affix',
				stickyWrapperClass: 'stickplacewrapper',
				winny : '#remoteModal'
			});

		}else if( has_subquestion == "0" ){
			defaultQuestionPanel();
		}

		/******************/
		$qns.hideErrorMsg();
	});

	/** QUESTION OPTIONS PANEL**/
	$('#questionOptionWrapper').on('change', '#selectQuestionOptionType', function(e){
		var option = $(this).val();

		if( option !== '' ){
			$qns_opt.AddPanel(option);

			//We Add 2 Options if option is not opentext; else we add 1 opentext field
			var $counter = (option !== 'opentext') ? 2 : 1;
			for(i=0; i < $counter; i++){
				$qns_opt.AddOption('#questionOptionWrapper .questionOptionPanel', true);
			}
		}//else{
			//$qns_opt.RemovePanel();
		//}

	});

	/** ON QUESTION OPTION ADD BUTTON CLICKED **/
	$('#questionOptionWrapper').on('click', '.questionOptionPanel .addbutton', function(e){
		e.preventDefault();
		$qns_opt.AddOption('#questionOptionWrapper .questionOptionPanel', this);
	});

	/** ON QUESTION OPTION REMOVE ICON CLICKED **/
	$('#questionOptionWrapper').on('click', '.questionOptionPanel .removebutton', function(e){
		e.preventDefault();
		$qns_opt.RemoveOption('#questionOptionWrapper .questionOptionPanel', this);
	});


	/*$('#subquestionOptionWrapper').on('change', 'select#selectSubquestionOptionType',function (e){
		var option = $(this).val();
	});*/


	/** SUB-QUESTION PANEL OPTION TYPE CHANGER [ SELECT OPTION ] **/
	$('#subquestionOptionWrapper').on('change', '.panel-select-option > select', function(e){
		//e.preventDefault();
		var panelID = $(this).closest('.SubquestionOptionPanel').prop('id');
		var option  = $(this).val();
		$subQns.changePanelOption('#'+ panelID, option, true);
	});

	/** ADD SUB-QUESTION PANEL **/
	$('#subquestionOptionWrapper').on('click', '.addSubquestionButton button', function(e){
		e.preventDefault();

		//Would auto scroll to the newly created panel
		$('#remoteModal').scrollTo('.modal-footer');

		$subQns.AddPanel('#subquestionOptionWrapper', true);
	});

	/** REMOVE SUB QUESTION PANEL **/
	$('#subquestionOptionWrapper').on('click', '.removeButtonPanel', function(e){
		e.preventDefault();
		$subQns.RemovePanel( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});

	/** ADD SUB-QUESTION OPTION **/
	$('#subquestionOptionWrapper').on('click', '.addbutton', function(e){
		e.preventDefault();
		$subQns.AddOption( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});

	/** REMOVE SUB-QUESTION OPTION **/
	$('#subquestionOptionWrapper').on('click', '.removebutton', function(e){
		e.preventDefault();
		$subQns.RemoveOption( '#'+ $(this).closest('.SubquestionOptionPanel').prop('id'), this );
	});

	defaultQuestionPanel();

});
</script>

<!-- QUESTION OPTION TYPE -->
<div class="hide" id="hiddenOptionType">
	<div class="row questionOptionType">
		<div class="col-md-4">
			<div class="form-group">
				<label for="selectQuestionOptionType" class="font-sm bg-color-orange label"> Options Type </label>

				<select class="form-control" id="selectQuestionOptionType" name="optiontype" validate="required"> 
					<!-- <option value=""> .. Select ..</option> -->
					<option value="radio" selected="selected">Radio</option>
					<option value="checkbox">Checkbox</option>
					<option value="opentext">Open Text</option>
				</select>
			</div>
		</div>
	</div>
</div>

<!-- QUESTION OPTION CONTAINER -->
<div class="hide" id="hiddenQuestionOptionPanel">
	<div class="row questionOptionPanel">
		<div class="col-md-12">
			<div class="panel panel-success">
		      <div class="panel-heading">
		        <h3 class="panel-title">
		        	<span class="text-regular">Question Options Panel:</span>
		        	<span class="questionoptiontype label label-danger"></span>
		        	<button class="btn btn-sm btn-default panel-button addbutton font-sm text-regular"><i class="fa fa-plus"></i> Add Option</button>
		        </h3>
		      </div>
		      <div class="panel-body">

		      </div>
		    </div>
		</div>
	</div>
</div>

<!-- OPTIONS  -->
<div class="hide" id="hiddenOptions">
	<div class="row optionx">
	    <div class="form-group">
	        <label class="col-md-1 number">1.</label>
        	<div class="col-md-10">
        		<input type="text" class="form-control" placeholder="Type option">
        		<select class="form-control">
        			<option value=""> Select a rating scale </option>
        			@if( !empty($qoption_alias) )
        				@foreach( $qoption_alias as $option )
        					<option value="{{{$option->id}}}">{{{$option->name}}}</option>
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

<!-- SUB-QUESTION OPTION TYPE -->
<div class="hide" id="hiddenSubquestionOptionType">
	<div style="height:75px" class="stickplacewrapper">
		<div class="row SubquestionOptionType stickplace">
			<div class="col-md-6">
				<div class="form-group">
					<label for="selectSubquestionOptionType" class="font-sm bg-color-pink label"> Sub-Question Options Type </label>

					<select class="form-control" id="selectSubquestionOptionType" name="subquestion_optiontype" validate="required"> 
						<!--<option value=""> .. Select ..</option>-->
						<option value="radio" selected="selected">Radio</option>
						<option value="checkbox">Checkbox</option>
						<option value="opentext">Open Text</option>
						<option value="doubleopentext">Double Open Text</option>
					</select>
				</div>
			</div>

			<!-- SUB QUESTION ADD BUTTON -->
			<div class="col-md-2 addSubquestionButton hide">
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
</div>

<!-- SUB QUESTION OPTION CONTAINER -->
<div class="hide" id="hiddenSubquestionOptionPanel">
	<div class="row SubquestionOptionPanel">
		<div class="col-md-12">
			<div class="panel panel-info">
		      <div class="panel-heading">
		        <h3 class="panel-title">
		            <a href="#" class="panel-button panel-button-left removeButtonPanel"><i class="fa fa-times fa-2x"></i> </a>
		        	<span class="text-regular"> Sub-Question Panel <span class="SubquestionPanelCounter"></span>:</span>
		        	<span class="subquestionoptiontypelabel label bg-color-blueLight"></span>

		        	<button class="btn btn-sm btn-primary panel-button addbutton font-sm text-regular"><i class="fa fa-plus"></i> Add Option</button>


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
			        		<input type="text" class="form-control SubquestionInputLabel text-bold" placeholder="#" validate="required">
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
        		<input type="text" class="form-control SubquestionOptionsInput" placeholder="Type option">
        		<select class="form-control SubquestionOptionsInput">
        			<option value=""> Select a rating scale </option>
        			@if( !empty($qoption_alias) )
        				@foreach( $qoption_alias as $option )
        					<option value="{{{$option->id}}}">{{{$option->name}}}</option>
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