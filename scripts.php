<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
?>
    <!-- FAVICON -->
    <link type="image/x-icon" href="<?=__ROOT__?>/favicon.ico" rel="shortcut icon">
    
    <!-- STYLES -->
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>style.css">
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>button.css">
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>form.css">
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>jquery.bubblepopup.v2.3.1.css" />
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>jquery.countdown.css" />
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>jquery.confirm.css" />
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>jquery-ui-1.8.20.custom.css" />
    <link rel="stylesheet" type="text/css" href="<?=__STYLE__?>dcaccordion.css" />
    
    <!-- SCRIPTS -->
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery-1.7.2.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery-ui-1.8.20.custom.min.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.metadata.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.mockjax.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.form.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.validate.js"></script>
    <script type='text/javascript' src="<?=__SCRIPT__?>jquery.cookie.js"></script>
    <script type='text/javascript' src="<?=__SCRIPT__?>jquery.hoverIntent.minified.js"></script>
    <script type='text/javascript' src="<?=__SCRIPT__?>jquery.dcjqaccordion.2.7.min.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.bubblepopup.v2.3.1.min.js" ></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.countdown.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>jquery.confirm.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>FancyZoom.js" ></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>FancyZoomHTML.js" ></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>json.js"></script>
    <script type="text/javascript" src="<?=__SCRIPT__?>ajax.js"></script>
	<script type="text/javascript" src="<?=__SCRIPT__?>script.js"></script>
    
    <!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient, .gradient-horizontal-gray {
	       filter: none;
	    }
	  </style>
	<![endif]-->

    <script type="text/javascript">
    var wait = 20;
	function doCountdown(){
		var timer = setTimeout(function(){
			wait--;
			if(wait > 0){
				doCountdown(); 
			} else {
				$('#message').addClass('hidden');
			};
		},1000);
	};

	function clearForm(e) {
        $(e).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'file':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });
        
        validator = $(e).validate();
        validator.resetForm();
    }
    
    function countProperties(obj) {
        var prop;
        var propCount = 0;
        
        for (prop in obj) {
            propCount++;
        }
        
        return propCount;
    }
    
    function isNumeric(id){
        var strValidChars = "0123456789.-%";
        var isValid = true;
        var strChar;
        var newValue;
        var strValue = id.val();
        
        // if (strValue.length == 0) return false;
        for (i=0;i<strValue.length && isValid == true; i++){
            strChar = strValue.charAt(i);
            if (strValidChars.indexOf(strChar) == -1) {
                isValid = false;
            }
        }
    
        if (isValid == false){
            newValue = strValue.substring(0, strValue.length-1);
            id.val(newValue);
        }
    }
    
    function isNumber(id){
        var strValidChars = "0123456789";
        var isValid = true;
        var strChar;
        var newValue;
        var strValue = id.val();
        
        // if (strValue.length == 0) return false;
        for (i=0;i<strValue.length && isValid == true; i++){
            strChar = strValue.charAt(i);
            if (strValidChars.indexOf(strChar) == -1) {
                isValid = false;
            }
        }
    
        if (isValid == false){
            newValue = strValue.substring(0, strValue.length-1);
            id.val(newValue);
        }
    }
    
    function setMaxLength(Object, MaxLen){
        if (Object.value.length > MaxLen) {
            Object.value = Object.value.substring(0, MaxLen);
        } 
        // return (Object.value.length <= MaxLen);
    }
    
    function fileLoaded(){
        $("#loadpage").addClass("hidden");
        $("#contents").removeClass("hidden");
    }
	
	function ajaxLoading(){
        $("#loadajax").removeClass("hidden");
        $("#ajax").addClass("hidden");
    }
	
	function ajaxLoaded(){
        $("#loadajax").addClass("hidden");
        $("#ajax").removeClass("hidden");
    }
    
	function ajaxLoad(uri,method){
		ajaxLoading();

		var requestURI = uri;
		var requestMethod = method;
		
		var request = $.ajax({
		  url: requestURI,
		  type: requestMethod,
		  dataType: "html"
		});
		
		request.success(function(content) {
		  	ajaxLoaded();	
			$("#ajax").html(content);
		});
		
		request.fail(function(jqXHR, textStatus) {
		  	ajaxLoaded();
			$("#ajax").html("<div class='spacer_100 clean'><!-- SPACER --></div>Fail loading content.");
		});
	}

	jQuery.validator.addMethod("notEqual", function(value, element, param) {
	  return this.optional(element) || value != param;
	});
	
    $(document).ready(function() {
		<? 
		if ($MESSAGE != ""):
			echo "doCountdown();";
		endif;
		?>
		
        setupZoom();
    
        $('#accordion').dcAccordion({
            eventType: 'click',
            autoClose: true,
            saveState: false,
            disableLink: true,
            speed: 'slow',
            showCount: false,
            autoExpand: true,
            cookie	: 'dcjq-accordion',
            classExpand	 : 'dcjq-current-parent'
        });
        
        $('input[type="reset"]').click(function(){
            clearForm(this.form);
        });
        
        $('.dummy_trigger').click(function(){
            $(this).prev().click();
            $(this).prev().focus();
        });
        
        $('.trigger').change(function(){
            $(this).next().css("text-align","left");
            $(this).next().val($(this).val());
            $(this).blur();
            $(this).next().focus();
        });
    });
    </script>
<? 
endif;
?>