<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <title>
            Résultats des Primaires Socialistes 2011 - Le Nouvel Observateur
        </title>

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("jquery", "1.4.2");
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
            var candidats = ['arnaudmontebourg', 'martineaubry', 'jeanmichelbaylet', 'manuelvalls', 'francoishollande', 'segoleneroyal'];

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
                        'François Hollande',
                        'Ségolène Royal',
                        'Jean-François Baylet',
                        'Manuel Valls',
                        'Arnaud Montebourg'
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
                        return ''+
                            this.x +': '+ this.y +' %';
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
                refreshJSON();

                $('#refresh').click(function(){
                    refreshJSON();
                });

            });
        </script>

    </head>
    <body>
        <div id="error"></div>
        <div id="container">
            <div id="chart">

            </div>
            <div id="button_holder">
                <button id="refresh" class="refresh">Rafraîchir les résultats</button>
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
            <div id="footer">
                <p style="margin:0 0 5px 5px;">Ces résultats sont partiels et concernent uniquement les bureaux de vote dépouillés à cette heure et qui ont été validés par les instances départementales d’organisation des primaires.</p>
                <div class="social"><img src="images/logo.png" style="float:left; margin:0 35px"/><fb:like style="float:right;" font="arial" width="105" show_faces="false" action="like" layout="button_count" href="http://www.facebook.com/LeNouvelObs" class=" fb_edge_widget_with_comment fb_iframe_widget"><span><iframe scrolling="no" id="ffef5a20edba0c" name="f24acc2f373cce4" style="border: medium none; overflow: hidden; height: 20px; width: 105px;" title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?action=like&amp;channel_url=http%3A%2F%2Fstatic.ak.fbcdn.net%2Fconnect%2Fxd_proxy.php%3Fversion%3D3%23cb%3Df5fc427923278a%26origin%3Dhttp%253A%252F%252Ftempsreel.nouvelobs.com%252Ff126f18fbfb82%26relation%3Dparent.parent%26transport%3Dpostmessage&amp;extended_social_context=false&amp;font=arial&amp;href=http%3A%2F%2Fwww.facebook.com%2FLeNouvelObs&amp;layout=button_count&amp;locale=fr_FR&amp;node_type=link&amp;sdk=joey&amp;show_faces=false&amp;width=105"></iframe></span></fb:like><iframe scrolling="no" frameborder="0" style="float:right;width:59px;height:20px;" src="http://platform.twitter.com/widgets/follow_button.html?lang=fr&amp;show_count=false&amp;link_color=ffffff&amp;screen_name=LeNouvelObs&amp;"></iframe></div>
            </div>
        </div>
    </body>
</html>