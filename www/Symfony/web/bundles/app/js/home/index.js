$(document).ready(function() {
   
   /* ------ Chart ------ */
   
    function displayChart() {
        var daysCollection = [];
        var daysPositionCollection = [];
        if ($('#chart').length) {
            new Chartist.Line(
                '#chart', {
                    labels: labels,
                    series: series,
                }, {
                    fullWidth: true,
                    chartPadding: { right: 20, top: 70 },
                    low: 0,
                    lineSmooth: Chartist.Interpolation.none()
                }, [
                    ['screen and (max-width: 1100px)', {
                        axisX: {
                            labelInterpolationFnc: function(value, index) {
                                return (dateCollection.length < 6 && index % Math.ceil(recordsLength/12) === 0) ? value : null;
                            }
                        }
                    }], ['screen and (min-width: 1100px)', {
                        axisX: {
                            labelInterpolationFnc: function(value, index) {
                                return (dateCollection.length < 7 && index % Math.ceil(recordsLength/18) === 0) ? value : null;
                            }
                        }
                    }], ['screen and (min-width: 1300px)', {
                        axisX: {
                            labelInterpolationFnc: function(value, index) {
                                return (dateCollection.length < 10 && index % Math.ceil(recordsLength/24) === 0) ? value : null;
                            }
                        }
                    }], ['screen and (min-width: 1600px)', {
                        axisX: {
                            labelInterpolationFnc: function(value, index) {
                                return (dateCollection.length < 13 && index % Math.ceil(recordsLength/30) === 0) ? value : null;
                            }
                        }
                    }], ['screen and (min-width: 1900px)', {
                        axisX: {
                            labelInterpolationFnc: function(value, index) {
                                return (dateCollection.length < 5 && index % Math.ceil(recordsLength/36) === 0) ? value : null;
                            }
                        }
                    }]
                ]
            ).on('data', function(context) {
                for (var index in context.data.labels) {
                    var label = context.data.labels[index];
                    if (label == '0:00') {
                        daysCollection.push(index);
                    }
                }
            }).on('draw', function(context) {
                if (context.type === 'point') {
                    if (daysCollection.indexOf(context.index.toString()) >= 0 && $.inArray(context.x, daysPositionCollection) == -1) {
                        daysPositionCollection.push(context.x);
                    }
                    if (recordsLength > 6*24) {
                        context.element.addClass('point_size_6');
                    } else if (recordsLength > 5*24) {
                        context.element.addClass('point_size_5');
                    } else if (recordsLength > 4*24) {
                        context.element.addClass('point_size_4');
                    } else if (recordsLength > 3*24) {
                        context.element.addClass('point_size_3');
                    } else if (recordsLength > 2*24) {
                        context.element.addClass('point_size_2');
                    } else if (recordsLength > 1*24) {
                        context.element.addClass('point_size_1');
                    } else {
                        context.element.addClass('point_size_0');
                    }
                } else if (context.type === 'line') {
                    if (recordsLength > 6*24) {
                        context.element.addClass('line_size_6');
                    } else if (recordsLength > 5*24) {
                        context.element.addClass('line_size_5');
                    } else if (recordsLength > 4*24) {
                        context.element.addClass('line_size_4');
                    } else if (recordsLength > 3*24) {
                        context.element.addClass('line_size_3');
                    } else if (recordsLength > 2*24) {
                        context.element.addClass('line_size_2');
                    } else if (recordsLength > 1*24) {
                        context.element.addClass('line_size_1');
                    } else {
                        context.element.addClass('line_size_0');
                    }
                }
            }).on('created', function(context) {
                for (var index in daysPositionCollection) {
                    context.svg.elem('line', {
                        x1: daysPositionCollection[index],
                        x2: daysPositionCollection[index],
                        y1: 465,
                        y2: 70 
                    }, 'vertical-line');
                    context.svg.elem('text', {
                        x: daysPositionCollection[index] - 30,
                        y: 50,
                        transform: 'rotate(-45, ' + daysPositionCollection[index] + ', ' + 15 + ')'
                    }, 'ct-label').text(dateCollection[index]);
                }
                daysPositionCollection = [];
            });
        }
    }
    displayChart();

    /* ------ Sidebar Filter ------ */
   
    var today = new Date();
    var limitStartDate = '08-11-2015';
    var limitEndDate = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    $('#date_1').datepicker({
        onSelect: function(selected) {
            $('#last_24_hours').prop('checked', false);
            $('#date_2').datepicker('option','minDate', selected);
        },
        dateFormat: 'dd-mm-yy'
    })
    .datepicker('option', 'maxDate', ($('#date_2').val()) ? $('#date_2').val() : limitEndDate)
    .datepicker('option','minDate', limitStartDate);
    $('#date_2').datepicker({
        onSelect: function(selected) {
            $('#last_24_hours').prop('checked', false);
            $('#date_1').datepicker('option', 'maxDate', selected);
        },
        dateFormat: 'dd-mm-yy'
    })
    .datepicker('option', 'minDate', ($('#date_1').val()) ? $('#date_1').val() : limitStartDate)
    .datepicker('option','maxDate', limitEndDate);
    $('#filter_form input, #filter_form select').keydown(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $('#submit_filter_button').trigger('click');
        }
    });
    $('.datepicker').change(function() {
        if (!$(this).val()) {
            if ($(this).attr('id') == 'date_1') {
                $('#date_2').datepicker('option', 'minDate', limitStartDate);
            } else {
                $('#date_1').datepicker('option', 'maxDate', limitEndDate);
            }
        }
    });
    $('#reset_filter').click(function(event) {
        event.preventDefault();
        $('#last_24_hours, #item_fieldset input').prop('checked', true);
        $('.datepicker').val('');
        $('#station option[value="25"]').prop('selected', true);
        $('#station').trigger("chosen:updated");
        $('#date_2').datepicker('option','minDate', limitStartDate);
        $('#date_1').datepicker('option', 'maxDate', limitEndDate);
    });
    $('#last_24_hours').change(function() {
        $('.datepicker').val('');
        $('#date_2').datepicker('option','minDate', limitStartDate);
        $('#date_1').datepicker('option', 'maxDate', limitEndDate);
    });
    $('#submit_filter_button').click(function(event) {
        event.preventDefault();
        Loading.start($(this));
        var items = [];
        $('#item_fieldset input:checked').each(function() {
            items.push($(this).val());
        });
        $.ajax({
            url: $('#filter_form').attr('action'),
            data: $('#filter_form').serializeObject()
        }).done(function(res) {
            history.pushState(title, '', this.url);
            $('#records_wrapper').hide().html(res).fadeIn();
            displayChart();
            document.title = title;
            Loading.stop($('#submit_filter_button'));
            if ($(window).width() <= 1200) {
                $('#display_sidebar_button').trigger('click');
            }
        });
    });
    
    /* ------ Print ------ */
    
    $('#print_button').click(function(event) {
        event.preventDefault();
        Loading.start($(this));
        $.post(window.location.href).done(function(res) {
            Loading.stop($('#print_button'));
            window.location.href = res.url;
        });
    });
    
});