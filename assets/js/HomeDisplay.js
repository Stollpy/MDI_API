const DIRECTORY_URL = '/assets/images/upload/';

var affichage = document.getElementById('displayAds');

fetch('/api/ads')
.then(function(response) {
    if(response.status !== 200) {
        console.log('Problème de status' + response.status)
        return;
    }else{
        response.json().then(function(data){
            if(data['hydra:member'].length !== 0){
                document.querySelector('.spinner-grow').style.display = 'none';

                for(var i = 0; i<data['hydra:member'].length; i++){ 
                    
                    var pictures = data['hydra:member'][i]['adsPictures'];

                    affichage.innerHTML += '<div class="col-sm-12 col-md-6 col-lg-4 mt-3">\n'
                        +'<div class="card card'+data['hydra:member'][i]['id'] +' shadow" style="width: 100%;">\n'
                            +'<div id="carousel'+ data['hydra:member'][i]['id'] +'" class="carousel slide" data-bs-ride="carousel'+ data['hydra:member'][i]['id'] +'">\n'
                                +'<div class="carousel-inner carousel-inner'+data['hydra:member'][i]['id'] +'">\n'

                                for(var img = 0; img < pictures.length; img++) {
                                        if(img == 0){
                                            document.querySelector('.carousel-inner'+data['hydra:member'][i]['id'] ).innerHTML += '<div class="carousel-item active">\n'
                                            +'<img src="'+ DIRECTORY_URL + pictures[img]['data'] +'" class="d-block w-100" alt="'+ data['hydra:member'][i]['title'] +'">\n'
                                        +'</div>\n'
                                        }else{
                                            document.querySelector('.carousel-inner'+data['hydra:member'][i]['id'] ).innerHTML += '<div class="carousel-item">\n'
                                            +'<img src="'+ DIRECTORY_URL + pictures[img]['data'] +'" class="d-block w-100" alt="'+ data['hydra:member'][i]['title'] +'">\n'
                                        +'</div>\n'
                                        }
                                }

                                document.querySelector('#carousel'+data['hydra:member'][i]['id']).innerHTML += '</div>\n'
                                +'<button class="carousel-control-prev bg-transparent" type="button" data-bs-target="#carousel'+ data['hydra:member'][i]['id'] +'" data-bs-slide="prev">\n'
                                +'<span class=" bg-transparant border-none carousel-control-prev-icon" aria-hidden="true"></span>\n'
                                +'<span class="visually-hidden">Previous</span>\n'
                                +'</button>\n'
                                +'<button class="carousel-control-next bg-transparent" type="button" data-bs-target="#carousel'+ data['hydra:member'][i]['id'] +'" data-bs-slide="next">\n'
                                +'<span class="bg-transparant border-none carousel-control-next-icon" aria-hidden="true"></span>\n'
                                +'<span class="visually-hidden">Next</span>\n'
                                +'</button>\n'
                            +'</div>\n'
                            document.querySelector('.card'+data['hydra:member'][i]['id']).innerHTML += '<div class="card-body">\n'
                                +'<h5 class="card-title">'+ data['hydra:member'][i]['title'] +'</h5>\n'
                                +'<p class="card-text">Type d\'annonce : '+ data['hydra:member'][i]['adsCategory']['label'] +'</p>\n'
                                +'<p class="card-text">Prix : '+ new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data['hydra:member'][i]['price']) +'</p>\n'
                                +'<p class="card-text">'+ data['hydra:member'][i]['content'].slice(0, 125) +' [...]</p>\n'
                                +'<a href="/annonce/'+ data['hydra:member'][i]['id'] +'" class="btn btn-outline-primary">Voir l\'annonce</a>\n'
                            +'</div>\n'
                        +'</div>\n'
                    +'</div>\n'
                }
            }else{
                document.querySelector('.spinner-grow').style.display = 'none';
                affichage.innerHTML += '<div class="col-12 text-center mt-5">\n'
                    +'<h2>Aucune annonce 😭</h2>\n'
                +'</div>\n'
            }
        })
    }
})
.catch(function(error) {
    document.querySelector('.spinner-grow').style.display = 'none';
        affichage.innerHTML += '<div class="col-12 text-center mt-5">\n'
            +'<h2>Une erreur c\'est produite😭 Veuillez réessayer.</h2>\n'
        +'</div>\n'
});