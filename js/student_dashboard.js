// Fonction pour charger les nouvelles notifications via AJAX
function loadNotifications() {
    $.ajax({
        url: 'get_notifications.php',
        // Remplacez par le chemin correct vers le script PHP qui récupère les notifications
        success: function(data) {
            $('#notification-list').html(data);
        }
    });
}

// Charger les notifications au chargement de la page et toutes les 30 secondes
$(document).ready(function() {
    loadNotifications();
    setInterval(loadNotifications, 30000); // Rafraîchir toutes les 30 secondes
});
