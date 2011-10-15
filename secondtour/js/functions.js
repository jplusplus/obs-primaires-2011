
var fileProvider = "http://nkb.fr/temp/secondtour";
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

    //R�cup�re les donn�es dans le fichier JSON local
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
            chart_options.title.text = "R�sultats de la primaire socialiste (" +  Math.round(completion*100) + "% comptabilis�)";

            var heure_maj = data.heure_maj;
            heure_maj = heure_maj.replace("+02:00", "Z");
            var derniere_maj = prettyDate(heure_maj);
            if (derniere_maj == ''){
                derniere_maj = "� l'instant";
            }

            $('#derniere_maj').html(derniere_maj);

            
            //vide les donn�es sur le chart
            chart_options.series[0].data = new Array();
            chart_options.xAxis.categories = new Array();

            //remplit le chart avec les donn�es du JSON
            $.each(candidats, function(key, val) {
                var candidat_data = data[val];

                chart_options.xAxis.categories.push(candidat_data['nom_prenom'] + " : " + candidat_data['pourcentage'] + " %");

                var point_valeur = candidat_data['pourcentage'];

                var candidat_short = val.substring(0,3);
                if(details_candidat[candidat_short] != undefined) {
                    var point_couleur = details_candidat[candidat_short].color;
                    var point_style = {
                        y: point_valeur,
                        color:point_couleur
                    };

                    chart_images[candidat_short] = {
                        y: point_valeur
                    };

                    chart_options.series[0].data.push(point_style);
                }
            });

            //actualise le chart
            renderChart();
            addImages(chart_images);

        }else{
            throw_error("Aucune donn�e dans le fichier JSON");
        }
    });
}

function addImages(chart_images){

    var count = 0;
    var charth = $('#chart').height();

    $.each(chart_images, function(key, val){
        count++;
        if(details_candidat[key] != undefined) {
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
        }
    });
}

var details_candidat = {
    //Martine Aubry
    "mar":{
        color:"#D4988A",
        image:"images/martine.png",
        imagew:105,
        imageh:168,
        imagey_correction:-170,
        imagex_correction:-275
    },
    //Fran�ois Hollande
    "fra":{
        color:"#92B0CF",
        image:"images/hollande.png",
        imagew:120,
        imageh:171,
        imagey_correction:-180,
        imagex_correction:-280
    }
};