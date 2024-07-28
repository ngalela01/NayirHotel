

$(document).ready(function(){
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy', // Format de date souhaité
        autoclose: true, // Fermer le calendrier lorsque la date est sélectionnée
        startDate: '0d' // Empêcher la sélection de dates antérieures à aujourd'hui
    });
});
