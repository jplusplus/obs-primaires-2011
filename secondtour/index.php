<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <title>
            Résultats du second tour des Primaires Socialistes 2011 - Le Nouvel Observateur
        </title>

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("jquery", "1.6.4");
            google.load("jqueryui", "1.8.16");
        </script>
        <script src="highcharts/highcharts.js" type="text/javascript"></script>
        <script src="highcharts/themes/obs.js" type="text/javascript"></script>
        <script src="js/functions.js" type="text/javascript"></script>
        <script src="js/pretty.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="styles.css" />

        <script type="text/javascript">

            //initialise les variables globales
            var chart;
            var chart_images = {};
            var candidats = ['martineaubry',  'francoishollande'];

            var chart_options ={
                chart: {
                    renderTo: 'chart',
                    defaultSeriesType: 'column'
                },
                title: {
                    text: 'Résultats de la primaire socialiste'
                },
                subtitle: {
                    text: 'Source: <a href="http://resultats.lesprimairescitoyennes.fr" target="_blank">Les Primaires Citoyennes</a>'
                },
                xAxis: {
                    categories: [
                        'Martine Aubry',
                        'François Hollande'
                    ]
                },
                yAxis: {
                    min: 0,
                    max:80,
                    title: {
                        text: 'Score (%)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function() {
                        return '' + this.x
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        pointWidth:60
                    }
                },
                series: [{
                        name: 'Candidats',
                        data: [0, 0, 0, 0, 0, 0]
                }]
            };

            $(document).ready(function(){

                renderChart();
                refreshJSON(false);

                $('#refresh').click(function(){
                    refreshJSON(true);
                });

                            
                $('#error').click(function() {
                    $(this).hide();
                });

            });
        </script>

    </head>
    <body>
        <div id="container">
            <div id="error">Les erreurs s'affichent ici.</div>
            <div id="chart">

            </div>
            <div id="button_holder">
                <input id="refresh" class="refresh" value="Rafraîchir les résultats" type="button" />
                <img id='loader' src='images/ajax-loader-arrows.gif' alt="Chargement" />
            </div>
            <table class="metaresults">
                <tr>
                    <td>Votants: <span id="votants"></span></td>
                    <td>Blancs et nuls: <span id="blancs_nuls"></span></td>
                </tr>
            </table>
            <table class="metaresults">
                <tr>
                    <td>Dernière mise à jour <span id="derniere_maj"></span></td>
                    <td>Nombre de bureaux comptabilisés: <span id="bureaux_vote"></span></td>
                </tr>
            </table>
            <footer>
                <p style="margin:0 0 5px 15px;">
                    Ces résultats sont partiels et concernent uniquement les bureaux de vote dépouillés à cette heure et qui ont été validés par les instances départementales d’organisation des primaires.
                </p>

                <div class="social">
                    <img src="images/logo.png" style="float:left; margin:0 35px"/>

                    <div style="float:right;width:150px;height:20px;">
                        <a href="https://twitter.com/LeNouvelObs" class="twitter-follow-button" data-show-count="false" data-lang="fr">Suivre @LeNouvelObs</a>
                        <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
                    </div>

                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) {return;}
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>

                    <div class="fb-like" data-href="http://www.facebook.com/LeNouvelObs" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" style="margin-right:10px;float:right" data-font="verdana"></div>

                    
                </div>
            </footer>
        </div>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-26208352-2']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </body>
</html>