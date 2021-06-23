let form = document.querySelector('#formSubir'); //obtenemos el formulario donde estan los datos 
form.addEventListener('submit', function(){
    let inputFile = document.querySelector('#inputFile').files[0];
    let progressBar = document.querySelector('#progressBar');

    let formdata = new FormData();

    formdata.append("archivo", inputFile);

    let ajax = new xmlHttpRequest();
/*
    ajax.upload.addEventListener("progress", function(e){
        let porcentaje = (e.loaded / e.total) * 100;
        progressBar.value = Math.round(porcentaje);
        ajax.open("POST","subir");
        ajax.send(formdata);
    })
*/
});