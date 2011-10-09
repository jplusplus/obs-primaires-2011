
var fileProvider = "http://nkb.fr/temp";
// fileProvider = ".";

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

function refreshJSON(show_error){
    
    $('#loader').show();
    $("#refresh").prop("disabled", true);

    /* $.getJSON(fileProvider + '/refreshJSON.php?callback=?', function(data) {

        if (show_error == true){
            if (data.msg != "OK"){
                throw_error(data.msg);
            }  
        }
        
        JSON2chart();

    }); */

    JSON2chart();
}

function JSON2chart(){

    //Récupère les données dans le fichier JSON local
    $.getJSON(fileProvider + '/sendJSON.php?callback=?', function(data) {

        $('#loader').hide();
        $("#refresh").prop("disabled", false);

        if (data != false){

            var votants = data.votants;

            $('#votants').html(votants);

            var blancs_nuls = Math.round((data.blancs_nuls / votants)*10000)/100 + "%"
            if (votants == 0){
                blancs_nuls = 0;
            }
            
            $('#blancs_nuls').html(blancs_nuls);
            $('#bureaux_vote').html(data.bureaux_vote);

            var completion =(eval(data.bureaux_vote));
            chart_options.title.text = "Résultats de la primaire socialiste (" +  Math.round(completion*100) + "% comptabilisé)";

            var heure_maj = data.heure_maj;
            heure_maj = heure_maj.replace("+02:00", "Z");
            var derniere_maj = prettyDate(heure_maj);
            if (derniere_maj == ''){
                derniere_maj = "à l'instant";
            }

            $('#derniere_maj').html(derniere_maj);

            
            //vide les données sur le chart
            chart_options.series[0].data = new Array();
            chart_options.xAxis.categories = new Array();

            //remplit le chart avec les données du JSON
            $.each(candidats, function(key, val) {
                var candidat_data = data[val];
                chart_options.xAxis.categories.push(candidat_data['nom_prenom']);

                var point_valeur = candidat_data['pourcentage'];

                var candidat_short = val.substring(0,3);
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
        color:"#82858F",
        image:"images/martine.png",
        imagew:105,
        imageh:168,
        imagey_correction:-143,
        imagex_correction:-100
    },
    //Manuel Valls
    "man":{
        color:"#848D64",
        image:"images/valls.png",
        imagew:82,
        imageh:185,
        imagey_correction:-156,
        imagex_correction:-70
    },
    //Arnaud Montebourg
    "arn":{
        color:"#442A33",
        image:"images/montebourg.png",
        imagew:120,
        imageh:171,
        imagey_correction:-140,
        imagex_correction:-110
    },
    //Ségolène Royal
    "seg":{
        color:"#B05758",
        image:"images/sego.png",
        imagew:67,
        imageh:187,
        imagey_correction:-150,
        imagex_correction:-60
    },
    //François Hollande
    "fra":{
        color:"#252D3D",
        image:"images/hollande.png",
        imagew:120,
        imageh:171,
        imagey_correction:-151,
        imagex_correction:-110
    },
    //Jean-Francois Baylet
    "jea":{
        color:"#B47633",
        image:"images/baylet.png",
        imagew:85,
        imageh:172,
        imagey_correction:-152,
        imagex_correction:-65
    }
};