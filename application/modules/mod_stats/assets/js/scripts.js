$(document).ready(function() {

    /** Get params for prepare data 
     * @param {string} link description
     * @returns {array} params
     * **/
    function getParamsForPrepareData(link) {

        if (link === undefined) {
            return false;
        }
        var splitedArray = link.split('/');
        /** Create array with params which we need**/
        var params = [];
        params[0] = splitedArray[splitedArray.length - 2];
        params[1] = splitedArray[splitedArray.length - 1];
        if (params instanceof Array) {
            return params;
        } else {
            return false;
        }
    }

    /**
     * Prepare data for drawing chart. Return chart type and data 
     * @param {string} className - php class name
     * @param {string} method - php method name
     * @returns {object}
     */

    function prepareData(className, method) {
        var returnResult;
        /** Send ajax request by className and method**/
        if (className != false && method != false) {
            $.ajax({
                async: false,
                type: 'get',
                data: 'notLoadMain=' + 'true',
                url: base_url + 'admin/components/init_window/mod_stats/getDiagramData/' + className + '/' + method,
                success: function(response) {
                    if (response) {
                        try {
                            returnResult = $.parseJSON(response);
                        } catch (e) {
                            return 'error parsing jsone';
                        }
                    }
                }
            });
        }

        if (returnResult !== undefined && returnResult.type === 'line') {
            returnResult = convertValuesForLineChart(returnResult);
        }

        return returnResult;
    }

    /**
     * Convert values to Float
     * @param {object} data
     * @returns {_L1.convertValuesForLineChart.data}
     */
    function convertValuesForLineChart(data) {
        var forProcessing = data.data;
        $.each(forProcessing, function(indexF) {
            newForProcessing = forProcessing[indexF];
            $.each(newForProcessing.values, function(indexS) {
                forProcessing[indexF].values[indexS].y = parseFloat(newForProcessing.values[indexS].y);
            });
        });
        data.data = forProcessing;
        return data;
    }

    /**
     * Convert data for pie to bar chart
     * @param {object} data
     * @returns {String}
     */
    function convertDataForPieToBarChart(data) {
        var inputData = data;
        var chartDataForReturn = [];
        var tmpData = {};
        tmpData.values = [];
        if (inputData === undefined) {
            return 'false';
        }

        $.each(inputData, function(index, value) {
            var stepObj = {};
            stepObj.label = value.key;
            stepObj.value = value.y;
            tmpData.values.push(stepObj);
        });
        tmpData.key = 'Bar data';
        chartDataForReturn.push(tmpData);
        return chartDataForReturn;
    }

    /**
     * Update bar chart
     * @returns 
     */
    function barChartUpdate() {
        var chart = nv.models.discreteBarChart()
                .x(function(d) {
            return d.label;
        })
                .y(function(d) {
            return d.value;
        });
        d3.select('#barChart svg')
                .call(chart);
        chart.update;
    }
    /**Draw lineWithFocusChart
     * @param {object} data
     * @returns chart
     **/
    function drawLineWithFocusChart(data) {
        var chartData = data;
        nv.addGraph(function() {
            var chart = nv.models.lineWithFocusChart();
            var orderDate = new Date();
            var day;
            var month;
            var year;
            chart.xAxis.tickFormat(function(d) {
                orderDate = new Date(d * 1000);
                day = orderDate.getDate();
                month = orderDate.getMonth() + 1;
                year = orderDate.getFullYear();
                return day + '/' + month + '/' + year;
            });
            chart.x2Axis.tickFormat(function(d) {
                orderDate = new Date(d * 1000);
                day = orderDate.getDate();
                month = orderDate.getMonth() + 1;
                year = orderDate.getFullYear();
                return day + '/' + month + '/' + year;
            });
            chart.yAxis
                    .tickFormat(d3.format(',.2f'));
            chart.y2Axis
                    .tickFormat(d3.format(',.2f'));
            chart.transitionDuration(500);
            d3.select('#chartLineWithFocus svg')
                    .datum(chartData)
                    .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;
        });
    }

    /**
     * Draw PieChart
     * @param {object} data
     * @returns chart
     */
    function drawPieChart(data) {
        var chartData = data;
        nv.addGraph(function() {
            var width = 500,
                    height = 500;
            var chart = nv.models.pieChart()
                    .x(function(d) {
                return d.key;
            })
                    .y(function(d) {
                return d.y;
            })
                    .color(d3.scale.category20().range())
                    .width(width)
                    .height(height);
            d3.select("#pieChart svg")
                    .datum(chartData)
                    .transition().duration(1200)
                    .attr('width', width)
                    .attr('height', height)
                    .call(chart);
            chart.dispatch.on('stateChange', function(e) {
                nv.log('New State:', JSON.stringify(e));
            });
            return chart;
        });
    }
    /**
     * Draw Bar chart
     * @param {object} data
     * @returns chart
     */
    function drawBarChart(data) {
        var chartData = data;
        chartData = convertDataForPieToBarChart(chartData);
        nv.addGraph(function() {
            var chart = nv.models.discreteBarChart()
                    .x(function(d) {
                return d.label;
            })
                    .y(function(d) {
                return d.value;
            })
                    .staggerLabels(true)
                    .tooltips(true)
                    .showValues(true)
                    .transitionDuration(250)
                    ;
            d3.select('#barChart svg')
                    .datum(chartData)
                    .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;
        });
    }




    /**
     * Menu hide/show blocks
     */
    $('.firstLevelMenu').unbind('click').bind('click', function() {
        var submenuBlock = $(this).closest('li').next('.submenu');
        if (!$(submenuBlock).is(":visible")) {
            $('.submenu').slideUp();
            submenuBlock.slideDown();
        }
    })

    /**
     * Click on menu item. Show the appropriate template with chart.
     */
    $('.linkChart').unbind('click').bind('click', function() {
        var thisEl = $(this);
        /** Get link for ajax from data attribute **/
        var dataHref = $(this).data('href');
        /** Get params for preparing data **/
        var params = getParamsForPrepareData(dataHref);
        /** Prepare chart data **/
        if (params !== 'false') {
            var chartData = prepareData(params[0], params[1]);
        }

        $.ajax({
            async: false,
            type: 'get',
            data: 'notLoadMain=' + 'true',
            url: base_url + dataHref,
            success: function(response) {
                if (response != false) {
                    $('#chartContainer').html(response);
                    $('.linkChart').removeClass('active');
                    thisEl.addClass('active');
                    if (chartData === undefined) {
                        console.log('Error getting data !');
                        return false;
                    }

                    if (chartData.type === 'line') {
                        drawLineWithFocusChart(chartData.data);
                    }
                    if (chartData.type === 'pie') {
                        drawPieChart(chartData.data);
                        drawBarChart(chartData.data);
                    }
                }
            }
        });
    });

    /**
     * Choose chart type 
     */
    $('#selectChartType').bind('change', function() {
        var selectElement = $(this);
        var chartType = selectElement.find("option:selected").val();
        $('.hideChart').hide();
        $('#' + chartType).fadeIn();

        barChartUpdate();

    });



    /**
     * Set time interval for day, week, month, year
     */
    $('.intervalButton').unbind('click').bind('click', function() {
        var CookieDate = new Date;
        var interval = $(this).data('group');
        var nowDate = new Date();
        var startDate = new Date();
        var endDate = new Date();
        var startDateForInput = '';
        var endDateForInput = '';

        /** Date for saving cookies(one year) **/
        CookieDate.setFullYear(CookieDate.getFullYear( ) + 1);

        /** Prepare times interval for day, week, month, year**/
        switch (interval) {
            case 'day':
                startDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate());
                endDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), (nowDate.getDate() + 1));
                break;
            case 'week':
                startDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate());
                endDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), (nowDate.getDate() + 7));
                break;
            case 'month':
                startDate = new Date(nowDate.getFullYear(), nowDate.getMonth());
                endDate = new Date(nowDate.getFullYear(), (nowDate.getMonth() + 1));
                break;
            case 'year':
                startDate = new Date(nowDate.getFullYear(), 0);
                endDate = new Date((nowDate.getFullYear() + 1), 0);
                break;
        }

        /** Prepare values for start and end date inputs **/
        startDateForInput = startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' + (startDate.getDate());
        endDateForInput = endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + (endDate.getDate());

        /** Set values for start and end date inputs **/
        $('.date_start').val(startDateForInput);
        $('.date_end').val(endDateForInput);

        /**Save cookies **/
        document.cookie = "interval=" + interval + ";expires=" + CookieDate.toGMTString() + ";";
        document.cookie = "date_from=" + startDate.getTime() + ";expires=" + CookieDate.toGMTString() + ";";
        document.cookie = "date_to=" + endDate.getTime() + ";expires=" + CookieDate.toGMTString() + ";";
        document.cookie = "start_date_input=" + startDateForInput + ";expires=" + CookieDate.toGMTString() + ";";
        document.cookie = "end_date_input=" + endDateForInput + ";expires=" + CookieDate.toGMTString() + ";";
    });

    /** Select and save to cookies group by type **/
    $('#selectGroupBy').unbind('change').bind('change', function() {
        var CookieDate = new Date();
        var selectElement = $(this);
        var groupBy = selectElement.find("option:selected").val();
        
        /** Date for saving cookies(one year) **/
        CookieDate.setFullYear(CookieDate.getFullYear( ) + 1);
        document.cookie = "group_by=" + groupBy + ";expires=" + CookieDate.toGMTString() + ";";
    })


});