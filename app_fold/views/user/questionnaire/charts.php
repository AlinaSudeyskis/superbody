<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block_val chart_wrap">
    <div id="legend"></div>
    <div id="chartdiv"></div>
</div>
<?php $gender = $user_data['user_gender_eng'];
$prefix = ($gender === 'female') ? 'w amcharts' : 'amcharts';?>
<script>
    /* график */
    $(document).ready(function(){
        var minDate = new Date("<?php echo $min;?>"),
            maxDate = new Date("<?php echo $max;?>"),
            prefix  = "<?php echo $prefix;?>";

        AmCharts.ready(function () {
            generateChartData();
            createStockChart();
        });

        var chartData1 = [];
        var chartData2 = [];
        var chartData3 = [];
        var chartData4 = [];

        function generateChartData() {
            var a5, b5, c5;
            <?php if (!empty($anthropometric)) :
                foreach ($anthropometric as $key => $anthrop_data) :
                    $prev_value = ($key > 0) ? $anthropometric[$key-1]['weight'] : $anthrop_data['weight'];
                    $percent = (!empty($prev_value) and !empty($anthrop_data['weight']) and $prev_value > 0) ? (round($anthrop_data['weight'] * 100 / $prev_value) - 100) : null;
                    if ($percent > 0) {
                        $mark = "<span class='plas_chart'></span>";
                    }
                    elseif ($percent < 0){
                        $mark = "<span class='minus_chart'></span>";
                    } else {
                        $mark = "";
                    }?>
                    a5 = "<?php echo $anthrop_data['weight']?>";
                    b5 = "<?php echo $percent; ?>";
                    c5 = "<?php echo $mark; ?>";

                    var newDate = new Date("<?php echo $anthrop_data['date'];?>");

                    chartData1.push({
                        date: newDate,

                        value:  a5,
                        volume: b5,
                        tender: c5
                    });

                    <?php $prev_value = ($key > 0) ? $anthropometric[$key-1]['chest'] : $anthrop_data['chest'];
                    $percent = (!empty($prev_value) and !empty($anthrop_data['chest']) and $prev_value > 0) ? (round($anthrop_data['chest'] * 100 / $prev_value) - 100) : null;
                    if ($percent > 0) {
                        $mark = "<span class='plas_chart'></span>";
                    }
                    elseif ($percent < 0){
                        $mark = "<span class='minus_chart'></span>";
                    } else {
                        $mark = "";
                    }?>
                    a5 = "<?php echo $anthrop_data['chest']?>";
                    b5 = "<?php echo $percent; ?>";
                    c5 = "<?php echo $mark; ?>";


                    chartData2.push({
                        date: newDate,
                        value: a5,
                        volume: b5,
                        tender: c5
                    });

                    <?php $prev_value = ($key > 0) ? $anthropometric[$key-1]['waist'] : $anthrop_data['waist'];
                    $percent = (!empty($prev_value) and !empty($anthrop_data['waist']) and $prev_value > 0) ? (round($anthrop_data['waist'] * 100 / $prev_value) - 100) : null;
                    if ($percent > 0) {
                        $mark = "<span class='plas_chart'></span>";
                    }
                    elseif ($percent < 0){
                        $mark = "<span class='minus_chart'></span>";
                    } else {
                        $mark = "";
                    }?>
                    a5 = "<?php echo $anthrop_data['waist']?>";
                    b5 = "<?php echo $percent; ?>";
                    c5 = "<?php echo $mark; ?>";


                    chartData3.push({
                        date: newDate,
                        value: a5,
                        volume: b5,
                        tender: c5
                    });

                    <?php $prev_value = ($key > 0) ? $anthropometric[$key-1]['buttocks'] : $anthrop_data['buttocks'];
                    $percent = (!empty($prev_value) and !empty($anthrop_data['buttocks']) and $prev_value > 0) ? (round($anthrop_data['buttocks'] * 100 / $prev_value) - 100) : null;
                    if ($percent > 0) {
                        $mark = "<span class='plas_chart'></span>";
                    }
                    elseif ($percent < 0){
                        $mark = "<span class='minus_chart'></span>";
                    } else {
                        $mark = "";
                    }?>
                    a5 = "<?php echo $anthrop_data['buttocks']?>";
                    b5 = "<?php echo $percent; ?>";
                    c5 = "<?php echo $mark; ?>";


                    chartData4.push({
                        date: newDate,
                        value: a5,
                        volume: b5,
                        tender: c5
                    });
                <?php unset($anthrop_data);
                endforeach;
            endif;?>
        }

        function createStockChart() {
            var chart = new AmCharts.AmStockChart();

            // DATASETS //////////////////////////////////////////
            // create data sets first
            var dataSet1 = new AmCharts.DataSet();
            dataSet1.title = "Вес";
            dataSet1.fieldMappings = [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }];
            dataSet1.dataProvider = chartData1;
            dataSet1.categoryField = "date";

            var dataSet2 = new AmCharts.DataSet();
            dataSet2.title = "Обхват груди";
            dataSet2.compared = true;
            dataSet2.fieldMappings = [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }];
            dataSet2.dataProvider = chartData2;
            dataSet2.categoryField = "date";

            var dataSet3 = new AmCharts.DataSet();
            dataSet3.title = "Обхват талии";
            dataSet3.compared = true;
            dataSet3.fieldMappings = [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }];
            dataSet3.dataProvider = chartData3;
            dataSet3.categoryField = "date";

            var dataSet4 = new AmCharts.DataSet();
            dataSet4.title = "Обхват бедер";
            dataSet4.compared = true;
            dataSet4.fieldMappings = [{
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            }];
            dataSet4.dataProvider = chartData4;
            dataSet4.categoryField = "date";

            // set data sets to the chart
            chart.dataSets = [dataSet1, dataSet2, dataSet3, dataSet4];
            chart.addClassNames = true;
            chart.classNamePrefix = prefix;

            // PANELS ///////////////////////////////////////////
            // first stock panel
            var stockPanel1 = new AmCharts.StockPanel();
            stockPanel1.showCategoryAxis = true;
            stockPanel1.title = "Value";
            stockPanel1.percentHeight = 70;

            // graph of first stock panel
            var graph1 = new AmCharts.StockGraph();

            graph1.valueField = "value";
            graph1.comparable = true;
            graph1.compareField = "value";

            graph1.bullet = "round";
            graph1.bulletColor = "#FFFFFF";
            graph1.bulletBorderAlpha = 1;
            graph1.lineColor = "#00bff0";
            graph1.useDataSetColors = false;
            graph1.lineThickness = 1;
            graph1.bulletSize = 10;
            graph1.bulletBorderThickness = 1;
            graph1.bulletBorderColor = "#00bff0";
            graph1.fillAlphas = 0.2;
            graph1.balloonText = "<div class='graf_desk'>[[category]]<br>[[title]]: [[value]]</div><div class='graf_procent'>[[tender]][[volume]]%</div>";

            graph1.compareGraphBalloonText = "<div class='graf_desk'>[[category]]<br>[[title]]: [[value]]</div><div class='graf_procent'>[[tender]][[volume]]%</div>";
            graph1.compareGraphBullet = "round";
            graph1.compareGraphBulletBorderAlpha = 1;
            graph1.compareGraphBulletColor = "#FFFFFF";

            stockPanel1.addStockGraph(graph1);


            // set panels to the chart
            chart.panels = [stockPanel1];


            // OTHER SETTINGS ////////////////////////////////////
            var sbsettings = new AmCharts.ChartScrollbarSettings();
            sbsettings.enabled = false;
            chart.chartScrollbarSettings = sbsettings;

            // CURSOR
            var cursorSettings = new AmCharts.ChartCursorSettings();
            cursorSettings.enabled = false;
            chart.chartCursorSettings = cursorSettings;


            // PERIOD SELECTOR ///////////////////////////////////
            var periodSelector = new AmCharts.PeriodSelector();
            periodSelector.position = "top";
            periodSelector.inputFieldsEnabled = false;
            periodSelector.periodsText = "";
            periodSelector.periods = [
                {
                    period: "MM",
                    count: 1,
                    label: "Месяц"},
                {
                    period: "MM",
                    selected: true,
                    count: 12,
                    label: "Год"
                },
                {
                    period: "MAX",
                    label: "MAX"
                }];
            chart.periodSelector = periodSelector;

            var amBalloon = chart.balloon;
            amBalloon.color = "#ffffff";
            amBalloon.borderAlpha = 0;
            amBalloon.cornerRadius = 0;
            amBalloon.fillColor = "#4c4c4c";
            amBalloon.fillAlpha = 1;
            amBalloon.fontSize = 12;
            amBalloon.shadowAlpha = 0;
            amBalloon.horizontalPadding = 0;
            amBalloon.verticalPadding = 0;

            chart.colors = ["#FF6600", "#FCD202", "#B0DE09", "#de6115", "#2A0CD0", "#CD0D74", "#CC0000", "#00CC00", "#0000CC", "#DDDDDD", "#999999", "#333333", "#990000"];

            // CATEGORY AXES SETTINGS
            var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
            categoryAxesSettings.gridColor = "#ffffff";
            categoryAxesSettings.minPeriod = "hh";
            categoryAxesSettings.groupToPeriods = ['hh'];
            categoryAxesSettings.equalSpacing = true;
            chart.categoryAxesSettings = categoryAxesSettings;

            var valueAxesSettings = new AmCharts.ValueAxesSettings();
            valueAxesSettings.dashLength = 5;
            valueAxesSettings.labelsEnabled = false;
            chart.valueAxesSettings = valueAxesSettings;

            // create stock legend
            var stockLegend1 = new AmCharts.StockLegend();
            stockLegend1.markerSize = 9;
            stockLegend1.markerLabelGap = 10;
            stockLegend1.divId = 'legend';
            stockLegend1.forceWidth = true;
            stockLegend1.panelSpacing = 20;

            stockPanel1.stockLegend = stockLegend1;

            chart.write('chartdiv');
        }


    });
</script>
