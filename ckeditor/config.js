CKEDITOR.editorConfig = function( config ){
	config.enterMode = CKEDITOR.ENTER_BR;
	
	config.toolbar = 'Full';
	config.toolbar_Full =
	[
		['Source','-','Templates'],['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],['Undo','Redo','-','Find','Replace'],
		['BidiLtr', 'BidiRtl'],['Link','Unlink','Anchor'],['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Styles','Format','Font','FontSize'],['TextColor','BGColor']
	];
	
	config.toolbar = 'Basic';
	config.toolbar_Basic =
	[
		['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
	];
};


