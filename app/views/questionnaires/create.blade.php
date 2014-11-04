
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Create Question</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>'questionnaires.store', 'id'=>'store-questionnaires', 'role'=>'form') )}}
		<div class="error-msg"></div>
		<div class="row">
			<div class="col-md-9">
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
			<div id="questionOptionWrapper" class="hide"> </div>

			<!-- WRAPPER FOR SUB QUESTIONS -->
			<div id="subquestionOptionWrapper" class="hide"> </div>

		</div>

	{{Form::close()}}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-labeled btn-default" data-dismiss="modal">
		<span class="btn-label">
			<i class="glyphicon glyphicon-remove"></i>
		</span>
		Cancel
	</button>
	<button type="button" class="btn btn-labeled btn-warning" id="modal_preview_question">
		<span class="btn-label">
			<i class="fa fa-eye"></i>
		</span>
		 Preview
	</button>	

	<button type="button" class="btn btn-labeled btn-success" id="modal_add_question">
	 <span class="btn-label">
	  <i class="glyphicon glyphicon-save"></i>
	 </span>Save
	</button>

</div>


<script type="text/javascript">
$(function(){
	var $doc = $(this);

	$("#modal_add_question").click(function(e){
		//_debug($('form#store-questionnaires :input').not(':hidden, button'));
		//return false;

		var $datax = $('form#store-questionnaires :input').not(':hidden, button');
		var tempFormElemet = "<form></form>";
		 tempFormElemet = $( tempFormElemet).html($datax.clone())

		e.preventDefault();
		$('form#store-questionnaires').ajaxrequest({
			dataContent: $datax,
			msgPlace: '.error-msg',
			validate: {etype: 'group', vdata: $(tempFormElemet)},
			redirectDelay: 500,
			closeButton: true
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
				//Hides Sub Question Panel
				//var $xyz = $subQWrper.find('.SubquestionOptionType');

				//$xyz.next('br').remove();
				//$xyz.remove();
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
			$('#questionOptionWrapper').find('.questionOptionPanel').remove();
		},

		AddOption 	: function(parentID, dis){
					//_debug('got me');
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
			var opt = $('#hiddenOptions')
						.find('input')
						/*.val(function(i,v){
							//_debug(opentextValue)
							//_debug(i);
							return ( $('.questionoptiontype').text() === 'opentext' ) 
									? '"'+opentextValue+'"'
									: '';
						})*/
						.prop('name', questionOption + '_' + currentSn)
						.prop('readonly', function(i, v){
							return ( questionOption === 'opentext') 
									? 'readonly' 
									: '';
						})
						.attr('validate', function(i,v){
							return ( questionOption === 'opentext') 
									? '' 
									: 'required';
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
			$('#subquestionOptionWrapper .SubquestionOptionPanel').remove();

			//We clear any error message visible
			$qns.hideErrorMsg();
		},

		AddPanel : function (parentID, dis){
			var $hidden = $('#hiddenSubquestionOptionPanel');
			var panelCounter = $(parentID + ' .SubquestionPanelCounter').get().length;
			var panelGeneratedID = new Date().getTime();
			var htmlx = $hidden
						.find('.SubquestionPanelCounter')
						.text( panelCounter + 1 )
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

			//Lets Auto Add Atleast 2 Options if Checkbox or Radio is the "sub-question optio type"
			//If it's Open text we auto Add Just 1
			$('#'+ panelGeneratedID + ' .panel-body').append( function(index){
				var subquestionOption = $('#'+ panelGeneratedID +' .subquestionoptiontypelabel').text();
				var counter = ( subquestionOption === 'opentext' ) ? 1 : 2;
				var countedHTMLx = '';

				for(i =0; i < counter; i++){
					countedHTMLx += $subQns.otherFunc.hiddenSubquestionOptions(i, subquestionOption);
				}

				return countedHTMLx;
			});
		},

		RemovePanel: function (parentID, dis){
			//You get all the serial numbers that are after the currently clicked
			//Return Javascript Object
			var thisNumber = $(parentID + ' .SubquestionPanelCounter').text();
			var $numbers = $('#subquestionOptionWrapper ' + ' .SubquestionPanelCounter:gt('+ (thisNumber - 1) +')');

			//We alterate through all the gathered numbers and minus 1.
			if( $numbers.length > 0 )
			{
				$.each($numbers, function(i,v){
					//_debug( $(this) );
					$(this).text( function(index, text){
						return parseInt(text) - 1;
					} )
				});
			}

			//We remove the panel
			$(parentID).remove();

			//We have to adjust the number of the subQuestion and the 
		},

		AddOption : function (parentID, dis){
			var $xyz = $(parentID + ' .panel-body');
			var currentSn = $xyz.find('.number').get().length;
			var subquestionOption = $(parentID +' .subquestionoptiontypelabel').text();

			$xyz.append($subQns.otherFunc.hiddenSubquestionOptions(currentSn, subquestionOption));
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
			$divWrapper.next('br').remove();

			//Then remove the element
			$divWrapper.remove();
		},

		otherFunc	: {
			hiddenSubquestionOptions : function (counter, subquestionOption){
				var uniqueID = new Date().getTime();
				return	'<br>' + $('#hiddenSubquestionOptions')
								.find('.SubquestionOptions .number').text(counter + 1)
								.end()
								.find('input.SubquestionOptionsInput')
								.prop('name', subquestionOption + '_' + uniqueID + '_' + (counter + 1))
								.prop('readonly', function(i, v){
									return ( subquestionOption === 'opentext') 
											? 'readonly' 
											: '';
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
		}
	};


	function defaultQuestionPanel(){
		$qns.subQuestionPanel('hide'); //We hide subQuestion panel
		$qns.optionType('show'); //We show Question Options Type
		$qns_opt.AddPanel('radio'); //We Add Radio Panel

		//We Add 2 radio Options
		for(i=0; i < 2; i++){
			$qns_opt.AddOption('#questionOptionWrapper .questionOptionPanel', 'dis');
		}

	}

	function defaultSubQuestionPanel(){
		$qns.subQuestionPanel('show'); //We show subQuestion Panel
		$qns.optionType('hide'); //We hide Question Options Type
		$subQns.ShowAddButton('#subquestionOptionWrapper .SubquestionOptionType', 'radio');

		//We Add 2 subquestion radio panel
		for(k=0; k < 2; k++){
			$subQns.AddPanel('#subquestionOptionWrapper', 'dis');
		}
	}

	/**  HAS SUB QUESTION **/
	$('#has_subquestion').change(function(e){
		var has_subquestion = $(this).val();

		if( has_subquestion === 1 )
		{
			defaultSubQuestionPanel();
			//$qns.child('show'); //We have to show Question child
		}else if( has_subquestion === 0 ){
			defaultQuestionPanel();
		}//else{
			//$qns.child('hide') //We have to hide Question child
			//$qns.optionType('hide'); //We show Question Options Type
			//$qns.subQuestionPanel('hide'); //We hide subQuestion panel
		//}

		/** **/
		//$qns.child('show');
		$qns.hideErrorMsg();
	});

	/** QUESTION OPTIONS PANEL**/
	$('#questionOptionWrapper').on('change', '#selectQuestionOptionType', function(e){
		var option = $(this).val();

		if( option !== '' )
		{
			$qns_opt.AddPanel(option);
		}else{
			$qns_opt.RemovePanel();
		}

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


	/** SELECT SUB-QUESTION OPTION TYPE **/
	$('#subquestionOptionWrapper').on('change', '#selectSubquestionOptionType', function(e){
		e.preventDefault();
		var option = $(this).val();
		$subQns.ShowAddButton('#subquestionOptionWrapper .SubquestionOptionType', option);
	});

	/** ADD SUB-QUESTION PANEL **/
	$('#subquestionOptionWrapper').on('click', '.addSubquestionButton', function(e){
		e.preventDefault();
		$subQns.AddPanel('#subquestionOptionWrapper', this);
	});

	/** ON QUESTION OPTION REMOVE ICON CLICKED **/
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
        	</div>
      
            <div class="col-md-1">
              <a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
            </div>
        </div>
	</div>
</div>

<!-- SUB-QUESTION OPTION TYPE -->
<div class="hide" id="hiddenSubquestionOptionType">
	<div class="row SubquestionOptionType">
		<div class="col-md-6">
			<div class="form-group">
				<label for="selectSubquestionOptionType" class="font-sm bg-color-pink label"> Sub-Question Options Type </label>

				<select class="form-control" id="selectSubquestionOptionType" name="subquestion_optiontype" validate="required"> 
					<!--<option value=""> .. Select ..</option>-->
					<option value="radio" selected="selected">Radio</option>
					<option value="checkbox">Checkbox</option>
					<option value="opentext">Open Text</option>
				</select>
			</div>
		</div>

		<!-- SUB QUESTION ADD BUTTON -->
		<div class="col-md-4 addSubquestionButton hide">
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
		        </h3>
		      </div>
		      <div class="panel-body">
		      	<div class="row Subquestionquestion">
			      	<div class="form-group">
				       
			        	<div class="col-md-2">
			        		<input type="text" class="form-control SubquestionInputLabel" placeholder="Label" validate="required">
			        	</div>
			      
			            <div class="col-md-9">
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
	        <label class="col-md-2 number">1.</label>
        	<div class="col-md-9">
        		<input type="text" class="form-control SubquestionOptionsInput" placeholder="Type option">
        	</div>
      
            <div class="col-md-1">
              <a class="action removebutton" href="#"><i class="fa fa-times text-danger fa-2x"></i></a>
            </div>
        </div>
	</div>
</div>