let inputFiles = document.querySelector('#inputFile');
inputFiles.addEventListener('change',function(){
    let text = this.value;
    text = text.replace(/^.*\\/, "");
    document.getElementById("fileText").value = text;
    //document.getElementById("inputFile").value = text;
})