var myApp = angular.module('myApp', ['chart.js']);
//var myApp = angular.module('myApp', []);

(function($){
	$(document).ready(function(){
		menuResponsivo();
		formFieldsWidgets();
		formAddRemoveCustom();
		formValidation();
		selectWithSearch();
		inputMaskMoney();
	});

	function formFieldsWidgets(){
		$( ".datepicker" ).datepicker({
	      format: 'dd/mm/yyyy',
	    });

	    $('.input-daterange').datepicker({
	      format: 'dd/mm/yyyy',
	    });
	}

	function selectWithSearch(){
		$(".chosen-select").chosen({no_results_text: "Sin resultados."}); 
	}

	function inputMaskMoney(){
		$(".input-money-mask").maskMoney({prefix:'$ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
		$(".input-money-mask-colones").maskMoney({prefix:'₡ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
	}

	function menuResponsivo(){
		var ancho_pantalla = $( window ).width();
		if(ancho_pantalla > 991){
			if(!$('nav#menu.collapse').hasClass('show')){
				$('nav#menu.collapse').addClass('show');
			}
		}

		$(window).resize(function(){
			var ancho_pantalla = $( window ).width();
			if(ancho_pantalla > 991){
				if(!$('nav#menu.collapse').hasClass('show')){
					$('nav#menu.collapse').addClass('show');
				}
			}else{
				if($('nav#menu.collapse').hasClass('show')){
					$('nav#menu.collapse').removeClass('show');
				}
			}
		})
	}

	function formValidation(){
		$('form.form-validation .form-submit').click(function(e){
			e.preventDefault();
			if(formValidationCustom('form.form-validation')){
				$('form.form-validation').submit();
			}else{
				$('html, body').animate({scrollTop : 0},800);
			}
			
		});
	}

	function formValidationCustom(form){
		$('.alert-form-validation').remove();
		$('input, textarea').css('border', '1px solid #ced4da');
		var msj_error = '';
		$(form + ' .input-required').each(function(){	
			$(this).css('border', '1px solid #ced4da');		
			if($(this).val()==''){
				$(this).css('border', '1px solid #ff0000');
				msj_error = 'Los campos enmarcados en rojo son obligatorios';
			}
		});
		$(form + ' .select-required').each(function(){		
			$(this).css('border', '1px solid #ced4da');
			if($(this).val()=='' || $(this).val()=='none' || $(this).val()=='? undefined:undefined ?'){
				$(this).css('border', '1px solid #ff0000');
				msj_error = 'Los campos enmarcados en rojo son obligatorios';
			}
		});

		$(form + ' .select-required.chosen-select').each(function(){					
			var nameFieldChosen = '#'+$(this).attr('name')+'_chosen .chosen-single';
			$(nameFieldChosen).css('border', '1px solid #ced4da');				
			if($(this).val()=='' || $(this).val()=='none' || $(this).val()=='? undefined:undefined ?'){				
				$(nameFieldChosen).css('border', '1px solid #ff0000');				
				msj_error = 'Los campos enmarcados en rojo son obligatorios';
			}
		});
		if(msj_error!=''){
			$(form).before('<div class="alert-form-validation alert alert-danger">'+msj_error+'</div>');
			
			return false;
		}else{
			return true;
		}
	}

	function formAddRemoveCustom(){
		// The maximum number of options
    	//var MAX_OPTIONS = 5;
		$('form')
		// Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#'+$(this).data('template')),
                $clone    = $template
                                .clone()
                                .removeClass('d-none')
                                .removeAttr('id')
                                .insertBefore($template),
                $option   = $clone.find('[name="'+$(this).data('campo')+'[]"]');

            
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="'+$(this).data('campo')+'[]"]');

            // Remove element containing the option
            $row.remove();
            
        })

        // Called after adding new field
        /*.on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length >= MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length < MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').removeAttr('disabled');
                }
            }
        });*/
	}
})(jQuery);