function change_sidebar()
{
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('w-100');
}

function selectRedirect(val)
{
    var route = "/orders/new/"+val;
    window.location.href = route;
}

$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});