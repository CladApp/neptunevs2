$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        header: {
            center: '',
            right: '',
            left: ''
        }, 
        events: 'events',
        eventClick: function(calEvent, jsEvent, view) {
            $('#modalEventUser .modal-body').html('<div style="text-align:center;">Chargement en cours...</div><div style="width: 10px;margin:0 auto;"><div class="loading"></div></div>');
            $('#modalEventUser').modal('show');
            var event = {
                'id':calEvent.id, 
                'start':$.fullCalendar.formatDate(calEvent.start, 'u'), 
                'end':$.fullCalendar.formatDate(calEvent.end, 'u'), 
                'title':calEvent.title,
                'lieuId':calEvent.lieuId
            };
            $.ajax({
                data: event,
                url: $('#modalEventUser').attr("url"),               
                success: function(data){                    
                    $("#modalEventUser .modal-body").html(data);
                    $('#placeDescription').popover();
                }
            });
        },
        monthNames:['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
        viewDisplay: function(view) { 
            var d = $('#calendar').fullCalendar('getDate');
            var option = new Object();
            option['monthNames'] = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'];
            $('#calDate').html('<span>' + $.fullCalendar.formatDate( d, 'MMMM yyyy', option ) + '</span>');
    
        },
        eventRender: function(event, element) {         
            if(event.register){
                element.children().prepend('<i class="icon-star-empty registred" title="Je suis inscrit(e)"></i>&nbsp;');
            }
            
            var info = "Cours";
            
            if(event.scaphandre){
                info = 'Plongée scaphandre';
            }
            if(event.apnee){
                info = 'Plongée apnée';
            }
            if(event.scaphandre && event.apnee){
                info = 'Plongée scaphandre et apnée';
            }
            
            element.attr('title', info);
        },
        loading: function(isLoading, view ) {
            if (isLoading){
                //on load calendar remove class registred
                $('.registred').remove();
            }
            $('*').tooltip();
        //$('.register').append('<i class="icon-star-empty registred" title="Je suis inscrit(e)"></i>&nbsp;')
            
        },
        monthNamesShort: ['janv.','févr.','mars','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        titleFormat: {
            month: 'MMMM yyyy', // ex : Janvier 2010
            week: "d[ MMMM][ yyyy]{ - d MMMM yyyy}", // ex : 10 — 16 Janvier 2010, semaine à cheval : 28 Décembre 2009 - 3 Janvier 2010
            // todo : ajouter le numéro de la semaine
            day: 'dddd d MMMM yyyy' // ex : Jeudi 14 Janvier 2010
        },
        columnFormat: {
            month: 'ddd', // Ven.
            week: 'ddd d', // Ven. 15
            day: '' // affichage déja complet au niveau du 'titleFormat'
        },
        axisFormat: 'H:mm', // la demande de ferdinand.amoi : 15:00 (pour 15, simplementsupprimer le ':mm'
        timeFormat: {
            '': 'H:mm', // événements vue mensuelle.
            agenda: 'H:mm{ - H:mm}' // événements vue agenda
        },
        buttonText: {
            prev: '&nbsp;&#9668;&nbsp;',
            next: '&nbsp;&#9658;&nbsp;',
            prevYear: '&nbsp;&lt;&lt;&nbsp;',
            nextYear: '&nbsp;&gt;&gt;&nbsp;',
            today: 'Aujourd\'hui',
            month: 'mois',
            week: 'semaine',
            day: 'jour'
        },
        allDayDefault: false,
        ignoreTimezone: true,
        firstDay:1 // Lundi premier jour de la semaine 
    });
    
    $('#calPrev').click(function() {
        $('#calendar').fullCalendar('prev');
    });
    $('#calToday').click(function() {
        $('#calendar').fullCalendar('today');
    });
    $('#calNext').click(function() {
        $('#calendar').fullCalendar('next');
    });
});