var inputs = document.getElementsByClassName('form-control')


for (var i=0;i<inputs.length;i++){
    inputs[i].addEventListener('click', function(e){ 
        e.preventDefault() 
        var formulaire = this.parentNode.parentNode 
        var content = this.parentNode.parentNode.parentNode 
        var httpRequest = new XMLHttpRequest() 
        formulaire.addEventListener('submit',function(e){ 
        e.preventDefault()
        var data = new FormData(formulaire)
        var xhr = httpRequest
        xhr.onreadystatechange = function (){
            if (xhr.readyState === 4){
                if(xhr.status == 200){
                    var reponse = document.createElement('p')
                    reponse.id='rep'
                    reponse.innerHTML = httpRequest.responseText
                    content.appendChild(reponse)
                }
            }
        }
        xhr.open('POST', '/cnam/requests.php', true)
        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
        xhr.send(data)
        })
    })

}
    

