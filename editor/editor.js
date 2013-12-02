function initEditor(languageMode, languageMime, containerId, listener){
  var scriptSrc = "editor/codemirror/mode/" + languageMode + "/" + languageMode + ".js";
  $("#langScript").attr("src", scriptSrc);
  $.getScript(scriptSrc, function(){
    $("#" + containerId).html("");
    var room = location.search.split('&')[0];
    var editorRef = new Firebase('https://whiteboard-interviewer.firebaseIO.com/editor/' + room);
    var codeMirror = CodeMirror(document.getElementById(containerId), {lineNumbers: true, mode: languageMime});
    var editor = Firepad.fromCodeMirror(editorRef, codeMirror);
    
	if(listener) {
      $('#download').click(function(e){
        var options = new Object();
	    options.filename = 'whiteboard-interviewer-code.txt',
	    options.content = editor.getText(),
	    options.script = 'api/Utils/download.php'
	    downloadFile(options);
	  });
	}

  });
}

function initLangRef() {
  var room = location.search.split('&')[0];
  var langRef = new Firebase('https://whiteboard-interviewer.firebaseIO.com/editor/' + room + '/language');
  langRef.on('value', function(snapshot) {
    var language = snapshot.val();
    if(language != null) {
      initEditor(language.langMode, language.langMime, "editor-container", false);
      focusSelect(language.langMime);
  	  }
  });
  return langRef;
}

function langChanged(){
  var langId = $("#languages").val();
  var langMode = CodeMirror.modeInfo[langId].mode;
  var langMime = CodeMirror.modeInfo[langId].mime;
  langRef.set({langMime: langMime, langMode: langMode});
}

function initSelect(){
    $.each(CodeMirror.modeInfo, function (index, value){
       $("#languages").append("<option id='lang" + index + "' value='" + index + "'> " + value.name + " </option>");
    });
    $("#languages").change(langChanged);
}

function focusSelect(languageMime){
    var active = 0;
    $.each(CodeMirror.modeInfo, function (index, value){ if(value.mime === languageMime) active = index; });
    $("#lang" + active).attr("selected", "selected");
}

CodeMirror.modeInfo.sort(function(a,b){
   var aName = a.name.toLowerCase();
   var bName = b.name.toLowerCase(); 
   return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
});

function downloadFile(options) {
  options = options || {};	
  if(!options.script || !options.filename || !options.content){
	throw new Error("Please enter all the required config options!");
  } 

  var iframe = $('<iframe>',{
	width:1,
	height:1,
	frameborder:0,
	css:{
      display:'none'
	}}).appendTo('body');

	var formHTML = '<form action="" method="post">'+
	  '<input type="hidden" name="filename" />'+
	  '<input type="hidden" name="content" />'+
	  '</form>';
		
	setTimeout(function(){		
	  var body = (iframe.prop('contentDocument') !== undefined) ?
							iframe.prop('contentDocument').body :
							iframe.prop('document').body;
			
	  body = $(body);
	  body.html(formHTML);
			
	  var form = body.find('form');
		
	  form.attr('action',options.script);
	  form.find('input[name=filename]').val(options.filename);
	  form.find('input[name=content]').val(options.content);
			
	  form.submit();
	  },50);
}

var langRef = initLangRef();
initSelect();
focusSelect("text/x-java");
initEditor("clike", "text/x-java", "editor-container", true);
