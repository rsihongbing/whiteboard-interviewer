function initEditor(languageMode, languageMime, containerId){
  var scriptSrc = "editor/codemirror/mode/" + languageMode + "/" + languageMode + ".js";
  $("#langScript").attr("src", scriptSrc);
  $.getScript(scriptSrc, function(){
    $("#" + containerId).html("");
    var room = location.search.split('&')[0];
    var editorRef = new Firebase('https://whiteboard-interviewer.firebaseIO.com/editor/' + room);
    var codeMirror = CodeMirror(document.getElementById(containerId), {lineNumbers: true, mode: languageMime});
    var editor = Firepad.fromCodeMirror(editorRef, codeMirror);
  });
}

function langChanged(){
  var langId = $("#languages").val();
  var langMode = CodeMirror.modeInfo[langId].mode;
  var langMime = CodeMirror.modeInfo[langId].mime;
  initEditor(langMode, langMime, "editor-container");
  focusSelect(langMime);
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
initSelect();
focusSelect("text/x-java");
initEditor("clike", "text/x-java", "editor-container" );
