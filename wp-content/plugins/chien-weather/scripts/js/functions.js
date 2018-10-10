(function($) {
    $(document).ready(function() {
        //Settings
        var $current = null;
        $('.chien-app #city').on('keyup', function() {
            clearTimeout($current);
            $('.chien-app #search-results').html('Seaching...');
            $this = $(this);
            var $city = $this.val();
            $current = setTimeout(function() {
                $.ajax({
                    url : chien.url,
                    type: 'POST',
                    dataType : 'json',
                    data : {
                        'action' : 'search_city_ajax',
                        'city' : $city
                    }
                }).done(function($result) {
                    console.log($result);
                    if ($result.success && $result.data.cod == "200") {
                        var $list = $result.data.list;
                        var $html = '';
                        for (i = 0; i < $result.data.count; i++) {
                            $html += '<p><label>';
                            $html += '<input type="checkbox" class="tog chien-weather-item" value="' + $list[i].name + '" />' + $list[i].name;
                            $html += '</label></p>';
                        }
                        $('.chien-app #search-results').html($html);
                    } else {
                        $('.chien-app #search-results').html('Error! Please try again.');
                    }
                }); //End Ajax
            }, 1000); //End SetTimeout
        }); //End Event



        var $first_click = 0;
        $('.chien-app #search-results').on('click', 'input[type="checkbox"]',function() {
            console.log(this);
            $this = $(this);
            $city_name = $this.attr('value');
            $search_selected = $('.chien-app #search-selected');
            if ($first_click == 0) {
                $search_selected.html('');
                $first_click = 1;
            }
            $html = '';
            $html += '<div>';
            $html += '<input name="chien_weather_setting[city_name][]" type="hidden" value="' + $city_name + '" />' + $city_name;
            $html += '<a href="#" class="chien-delete-item">(Delete)</a>';
            $html += '</div>';
            $search_selected.append($html);
            $this.remove();
        });//End Event Click on Checkbox


        $('.chien-app #search-selected').on('click', '.chien-delete-item', function() {
            $this = $(this);
            $this.parent().remove();
        });

        //Widget View
        $('.chien-weather-selector').on('change', function() {
            $this = $(this);
            var $option_selected = $('option:selected', this);
            $weather_icon = $option_selected.attr('data-weather-icon');
            $weather_text = $option_selected.attr('data-weather-text');
            $table_id = '#' + $this.val();
            $($table_id).addClass('chien-active');
            $($table_id).siblings().removeClass('chien-active');
            $('.chien-weather-icon').attr('src', 'http://openweathermap.org/img/w/' + $weather_icon + '.png');
            $('.chien-weather-text').html($weather_text);
        });

    });
})(jQuery);