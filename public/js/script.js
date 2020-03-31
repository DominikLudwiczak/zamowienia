function change_sidebar()
{
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('w-100');
    var hr = document.getElementById('linia');
    if(hr.style.display == 'none')
        hr.style.display = "block";
    else
        hr.style.display = "none";
}

function selectRedirect(val)
{
    var route = "/orders/new/"+val;
    window.location.href = route;
}

var num_of_nums = 0;
var last_value = '';
var last_type;
function telephone(event, id)
{
    var input = document.getElementById(id);
    if(event.inputType == 'insertText' || event.inputType == 'deleteContentBackward')
    {
        var key = event.data;
        if(event.inputType == 'deleteContentBackward')
        {
            if(last_value.slice(-2)[0] == ' ' || (last_value.slice(-1)[0] == ' ' && num_of_nums % 3 == 0))
                last_value = last_value.slice(0, last_value.length-2);
            else
                last_value = last_value.slice(0, last_value.length-1);
            num_of_nums--;
            last_type = 'delete';
        }
        else if(num_of_nums < 9)
        {
            var regex = /[0-9]/;
            if(!regex.test(key))
                input.value = last_value;
            else
            {
                num_of_nums++;
                console.log(last_type);
                if((num_of_nums-1) % 3 == 0 && last_type == 'delete' && num_of_nums-1 > 0)
                    last_value = last_value + ' ';
                last_value = last_value + key;
                if(num_of_nums % 3 == 0 && num_of_nums < 8)
                    last_value = last_value + ' ';
                last_type = 'text';
            }
        }
    }
    console.log(num_of_nums);
    input.value = last_value;
}

$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});