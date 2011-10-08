function renderChart(){
    chart = new Highcharts.Chart(chart_options);
}

function throw_error(msg){
    $('#error').html(msg);
    $('#error').show();
    $('#error').effect("bounce", {
        times:3
    }, 300);
}

function refreshJSON(){
    $.getJSON('http://nkb.fr/temp/refreshJSON.php?callback=?', function(data) {
        JSON2chart();
    });
}

function JSON2chart(){
    //Récupère les données dans le fichier JSON local
    $.getJSON('http://nkb.fr/temp/sendJSON.php?callback=?', function(data) {

        if (data != false){

            var votants = data.votants;

            $('#votants').html(votants);
            $('#blancs_nuls').html(Math.round((data.blancs_nuls / votants)*10000)/100 + "%");
            $('#bureaux_vote').html(data.bureaux_vote);

            var completion =(eval(data.bureaux_vote));
            chart_options.title.text = "Résultats de la primaire socialiste (" +  Math.round(completion*100) + "% comptabilisé)";

            var heure_maj = data.heure_maj;
            heure_maj = heure_maj.replace("+02:00", "Z");

            $('#derniere_maj').html(prettyDate(heure_maj));

            if (data.candidats.length>0){
                //vide les données sur le chart
                chart_options.series[0].data = new Array();
                chart_options.xAxis.categories = new Array();

                //remplit le chart avec les données du JSON
                $.each(data.candidats[0], function(key, val) {
                    chart_options.xAxis.categories.push(val['nom_prenom']);

                    var point_valeur = val['pourcentage'];
                    var candidat_short = key.substring(0,3);
                    var point_couleur = details_candidat[candidat_short].color;
                    var point_style = {
                        y: point_valeur,
                        color:point_couleur
                    };

                    chart_images[candidat_short] = {
                        y: point_valeur
                    };

                    chart_options.series[0].data.push(point_style);
                });

                //actualise le chart
                renderChart();
                addImages(chart_images);

            }else{
                throw_error("Aucun résultat disponible dans le fichier JSON");
            }
        }else{
            throw_error("Aucune donnée dans le fichier JSON");
        }
    });
}

function addImages(chart_images){

    var count = 0;
    var charth = $('#chart').height();

    $.each(chart_images, function(key, val){
        count++;
        var image = details_candidat[key].image;
        if (image){
            var imagew = details_candidat[key].imagew;
            var imageh = details_candidat[key].imageh;

            var xPos = chart.xAxis[0].translate(count) + details_candidat[key].imagex_correction;
            var yPos = charth - chart.yAxis[0].translate(chart_images[key].y) + details_candidat[key].imagey_correction;
            
            chart.renderer.image(image, xPos,yPos, imagew, imageh).attr({
                zIndex: 7
            }).add();
        }
    });
}

var details_candidat = {
    //Martine Aubry
    "mar":{
        color:"#D9D5D2",
        image:"images/martine.png",
        imagew:80,
        imageh:128,
        imagey_correction:-120,
        imagex_correction:-80
    },
    //Manuel Valls
    "man":{
        color:"#cca",
        image:"images/valls.png",
        imagew:62,
        imageh:141,
        imagey_correction:-129,
        imagex_correction:-60
    },
    //Arnaud Montebourg
    "arn":{
        color:"#DBC9C8",
        image:"images/montebourg.png",
        imagew:87,
        imageh:119,
        imagey_correction:-114,
        imagex_correction:-80
    },
    //Ségolène Royal
    "seg":{
        color:"#F3BABE",
        image:"images/sego.png",
        imagew:50,
        imageh:141,
        imagey_correction:-128,
        imagex_correction:-50
    },
    //François Hollande
    "fra":{
        color:"#C2D0E0",
        image:"images/hollande.png",
        imagew:80,
        imageh:114,
        imagey_correction:-116,
        imagex_correction:-80
    },
    //Jean-Francois Baylet
    "jea":{
        color:"#D5D8D9",
        image:"images/baylet.png",
        imagew:65,
        imageh:132,
        imagey_correction:-127,
        imagex_correction:-60
    }
};