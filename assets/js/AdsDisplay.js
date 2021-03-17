    const DIRECTORY_URL = '/assets/images/upload/';
    var display = document.getElementById('Display');
    var id = display.getAttribute('data-id')

    fetch('/api/ads/'+id)
    .then(function(response) {
        if(response.status !== 200){
            document.querySelector('.spinner-border').style.display = 'none';
            display.innerHTML += '<div class="text-center mt-5">'
                +'<h2>4😭4 NotFound</h2>'
            +'</div>'
        }else{
            response.json().then(function(data){
                document.querySelector('.spinner-border').style.display = 'none';
                display.innerHTML += '<div class="row">'
                    +'<div class="col-12">'
                        +'<div id="carouselSlide" class="carousel slide shadow" data-bs-ride="carouselSlide">'

                            +'<div class="carousel-inner">'
                                for(var i = 0; i < data.adsPictures.length; i++){
                                    if(i == 0){
                                        document.querySelector('.carousel-inner').innerHTML += '<div class="carousel-item active">'
                                            +'<img src="'+ DIRECTORY_URL + data.adsPictures[i]['data'] +'" class="d-block w-100" alt=" alt="'+ data.title +'">'
                                        +'</div>'
                                    }else{
                                        document.querySelector('.carousel-inner').innerHTML += '<div class="carousel-item">'
                                            +'<img src="'+ DIRECTORY_URL + data.adsPictures[i]['data'] +'" class="d-block w-100" alt="'+ data.title +'">'
                                        +'</div>'
                                    }
                                }
                            document.getElementById('carouselSlide').innerHTML += '</div>'
                                +'<button class="carousel-control-prev bg-transparent" type="button" data-bs-target="#carouselSlide" data-bs-slide="prev">'
                                    +'<span class="carousel-control-prev-icon" aria-hidden="true"></span>'
                                    +'<span class="visually-hidden">Previous</span>'
                                +'</button>'
                                +'<button class="carousel-control-next bg-transparent" type="button" data-bs-target="#carouselSlide" data-bs-slide="next">'
                                    +'<span class="carousel-control-next-icon" aria-hidden="true"></span>'
                                    +'<span class="visually-hidden">Next</span>'
                                +'</button>'
                            +'</div>'
                    display.innerHTML += '</div>'
                    +'</div>'
                    +'<div class="col-12 mt-3" id="ContentAds">'
                        +'<h2>'+ data.title +'</h2>'
                        +'<p class="fw-bold">'+ data.adsCategory.label +'</p>'
                        if(data.adsCategory.code == 'rental'){
                            document.getElementById('ContentAds').innerHTML += '<p class="fw-bold">Prix : '+ new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.price) +' /mois</p>'
                        }else{
                        document.getElementById('ContentAds').innerHTML += '<p class="fw-bold">Prix : '+ new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.price) +'</p>' 
                        }
                        document.getElementById('ContentAds').innerHTML += '<p>'+ data.content +'</p>'
                    +'</div>'                
            })
        }
    })
    .catch(function(error) {
        document.querySelector('.spinner-border').style.display = 'none';
        display.innerHTML += '<div class="text-center mt-5">'
            +'<h2>Une erreur c\'est produite😭 Veuillez réessayer.</h2>'
        +'</div>'
    });