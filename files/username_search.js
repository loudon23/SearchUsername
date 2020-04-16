var display_request = 0;
var current_request = 0;
var loading_img;
var username_input;

$(document).ready(function () {
    $('[name=username]').after('<li id="loader_area" style="list-style-type: none;" hidden=""><img id="loading_img" src="plugin_file.php?file=SearchRelatedIssue/ajax-loader.gif"></li>');
    loading_img = document.getElementById('loader_area');

    username_input = document.getElementsByName('username')[0];
    var bug_report_token = document.getElementsByName('bug_report_token')[0];

    if (username_input.value.length > 0) {
        search_request(username_input.value, bug_report_token.value);
    }
    var current_timer = 0;
    $('[name=username]').bind("input", function () {
        if (this.value.length > 0 && this.value.trim() != 0) {

            loading_img.removeAttribute('hidden');
            clearTimeout(current_timer);
            var search_string = this.value;
            var token = $('[name=bug_report_token]').val();
            current_timer = setTimeout(function () {
                search_request(search_string, token);
            }, 700);
        }

        if (username_input.value.length < 1) {
            $(".search_result").remove();
        }
    })
});

function search_request(search_string, token) {
    current_request++;
    $.ajax({
        type: 'post',
        url: 'plugin.php?page=SearchUsername/search',
        data: {
            'referal': search_string,
            'bug_report_token': token,
            'request_id': current_request,
        },
        response: 'text',
        success: function (data, textStatus, jqXHR) {
            try {
                var response = JSON.parse(data);
                if (response['request_id'] > display_request) {
                    $(".search_result").remove();
                    $('[id=loader_area]').after(response['data']);
					$(".search_result").on('click', function(event){
						var selected = event.target.text;
						$('[name=username]').val(selected);
						
						$('[name=username]').parent("form").submit();
					});
                    display_request = response['request_id'];
                }
            } catch (err) {
                console.log(err);
            }
            if (username_input.value.length < 1) {
                $(".search_result").remove();
            }
            loading_img.setAttribute('hidden', '');
        }
    })
}

