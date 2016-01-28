<style type="text/css">
    .table > tbody > tr > td{
        padding:4px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div>
            <table id="sparkline-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Nilai awal</th>
                        <th class="center">Stats</th>
                        <th>Nilai akhir</th>
                        <th>Trend</th>
                        <th>
                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                            Tanggal terakhir
                        </th>
                        <th>Alert</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($indikators as $i) {
                        $arrData = $i->data;
                        $dataLength = count($arrData);
                        $data_sparkline = 'data-sparkline="';
                        if ($dataLength > 0) {
                            //create array buat sparkline
                            foreach ($arrData as $data) {
                                $data_sparkline.="$data, ";
                            }
                            //finishing string
                            $data_sparkline = substr($data_sparkline, 0, -2) . '"';
                            //check trend
                            $trend = ($dataLength > 1) ? $arrData[$dataLength - 1] - $arrData[$dataLength - 2] : 0;
                        }
                        ?>
                        <tr>
                            <td>
                                <?php
                                echo ($dataLength > 0) ? anchor('chart/' . $i->indikator_id, $i->code) : $i->code;
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($i->threshold)) {
                                    $l = $i->threshold;
                                    if ($l->latest_val > json_decode($l->threshold_vals)[0]) {
                                        //red
                                        echo "<span class='gred'>$i->indikator_name</span>";
                                    } else if ($l->latest_val > $l->forecast) {
                                        //yellow
                                        echo "<span class='gyellow'>$i->indikator_name</span>";
                                    } else {
                                        //default
                                        echo $i->indikator_name;
                                    }
                                } else {
                                    echo $i->indikator_name;
                                }
                                ?>
                            </td>
                            <td><?php echo $i->unit; ?></td>
                            <td class="align-right">
                                <?php
                                //get first data, if any
                                //ini udah sorted by date ascending
                                if ($dataLength > 0) {
                                    echo sprintf('%0.2f', $arrData[0]);
                                }
                                ?>
                            </td>
                            <td class="center" <?php
                            if ($dataLength > 0) {
                                echo $data_sparkline;
                            }
                            ?>></td>
                            <td class="align-right"><?php
                                //get last data, if any
                                //ini udah sorted by date ascending
                                if ($dataLength > 0) {
                                    echo sprintf('%0.2f', $arrData[$dataLength - 1]);
                                }
                                ?>
                            </td>
                            <td class="center" class="hidden-480">
                                <?php
                                if ($dataLength > 0) {
                                    if ($trend < 0) {
                                        echo '<span class="fa fa-arrow-down"></span>';
                                    } else if ($trend > 0) {
                                        echo '<span class="fa fa-arrow-up"></span>';
                                    } else {
                                        echo '<span class="glyphicon glyphicon-menu-hamburger"></span>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($dataLength > 0) {
                                    echo $i->last_update;
                                }
                                ?>
                            </td>
                            <td class="center">
                                <?php
                                if (isset($i->threshold)) {
                                    $l = $i->threshold;
                                    if ($l->latest_val > json_decode($l->threshold_vals)[0]) {
                                        //red
                                        echo image_asset('merahbulatan.png', 'polkam', ['data-alert' => 0]);
                                    } else if ($l->latest_val > $l->forecast) {
                                        //yellow
                                        echo image_asset('kuningbulatan.png', 'polkam', ['data-alert' => 1]);
                                    } else {
                                        echo image_asset('birubulatan.png', 'polkam', ['data-alert' => 2]);
                                    }
                                }
                                ?>                                
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
echo js_asset('jquery.dataTables.js', 'ace');
echo js_asset('jquery.dataTables.bootstrap.js', 'ace');
echo js_asset('highcharts/highcharts.js', 'polkam');
echo js_asset('highcharts/highcharts.indo.js', 'polkam');
?>
<script type="text/javascript">
    $(function () {
        /**
         * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
         * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
         */
        Highcharts.SparkLine = function (options, callback) {
            var defaultOptions = {
                chart: {
                    renderTo: (options.chart && options.chart.renderTo) || this,
                    backgroundColor: null,
                    borderWidth: 0,
                    type: 'area',
                    margin: [0, -50, 0, 0],
                    width: 133,
                    height: 20,
                    style: {
                        overflow: 'visible'
                    },
//                    skipClone: true
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    startOnTick: false,
                    endOnTick: false,
                    tickPositions: []
                },
                yAxis: {
                    endOnTick: false,
                    startOnTick: false,
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    tickPositions: [0]
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    backgroundColor: null,
                    borderWidth: 0,
                    shadow: false,
                    useHTML: true,
                    hideDelay: 0,
                    shared: true,
                    padding: 0,
                    positioner: function (w, h, point) {
                        return {x: point.plotX - w / 2, y: point.plotY - h};
                    }
                },
                plotOptions: {
                    series: {
                        color: '#0000FF',
                        animation: false,
                        lineWidth: 1,
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        marker: {
                            radius: 1,
                            states: {
                                hover: {
                                    radius: 2
                                }
                            }
                        },
                        fillOpacity: 0.25
                    },
                    column: {
                        negativeColor: '#910000',
                        borderColor: 'silver'
                    }
                }
            };
            options = Highcharts.merge(defaultOptions, options);

            return new Highcharts.Chart(options, callback);
        };

        var start = +new Date(),
                $tds = $("td[data-sparkline]"),
                fullLen = $tds.length,
                n = 0;

        // Creating 153 sparkline charts is quite fast in modern browsers, but IE8 and mobile
        // can take some seconds, so we split the input into chunks and apply them in timeouts
        // in order avoid locking up the browser process and allow interaction.
        function doChunk() {
            var time = +new Date(),
                    i,
                    len = $tds.length,
                    $td,
                    stringdata,
                    arr,
                    data,
                    chart;

            for (i = 0; i < len; i += 1) {
                $td = $($tds[i]);
                //put event binder on sparkline td element to url at the first column
                $td.on("mousedown", function () {
                    $(this).parent().find('a:first-child')[0].click();
                });
                stringdata = $td.data('sparkline');
                if ($.isNumeric(stringdata)) {
                    data = [stringdata];
                } else {
                    data = $.map(stringdata.split(', '), parseFloat);
                }
                $td.highcharts('SparkLine', {
                    series: [{
                            data: data,
                            pointStart: 1
                        }],
                    tooltip: {
                        headerFormat: '<span style="font-size: 10px">' + $td.parent().find('td:nth-child(2)').html() + '</span><br/>',
                        pointFormat: '<b>{point.y}</b> ' + $td.parent().find('td:nth-child(3)').html()
                    }
                });

                n += 1;

                // If the process takes too much time, run a timeout to allow interaction with the browser
                if (new Date() - time > 500) {
                    $tds.splice(0, i + 1);
                    setTimeout(doChunk, 0);
                    break;
                }

                // Print a feedback on the performance
                if (n === fullLen) {
                    console.log('Generated ' + fullLen + ' sparklines in ' + (new Date() - start) + ' ms');
                }
            }
        }
        doChunk();


        /* Create an array with the values of all the input boxes in a column */
        $.fn.dataTable.ext.order['dom-alert'] = function (settings, col)
        {
            return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
                return $('img', td).data('alert');
            });
        }
        //draw sparkline first, after that we use datatables
        //otherwise, sparkline will be drawn only on those rows in the first page
        var oTable1 =
                $('#sparkline-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                .dataTable({
                    paging: false,
                    bAutoWidth: false,
                    "columns": [
                        null, null, null,
                        {"bSortable": false},
                        {"bSortable": false, "width": '200px'},
                        {"bSortable": false},
                        null, null,
                        //custom sort for image
                        {"orderDataType": "dom-alert"}
                    ],
                    "order": [[0, "asc"]],
                    //,
                    //"sScrollY": "200px",
                    //"bPaginate": false,

                    //"sScrollX": "100%",
                    //"sScrollXInner": "120%",
                    //"bScrollCollapse": true,
                    //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                    //you may want to wrap the table inside a "div.dataTables_borderWrap" element

                    //"iDisplayLength": 50
                });
        /**
         var tableTools = new $.fn.dataTable.TableTools( oTable1, {
         "sSwfPath": "../../copy_csv_xls_pdf.swf",
         "buttons": [
         "copy",
         "csv",
         "xls",
         "pdf",
         "print"
         ]
         } );
         $( tableTools.fnContainer() ).insertBefore('#sparkline-table');
         */


        //oTable1.fnAdjustColumnSizing();


        $(document).on('click', 'th input:checkbox', function () {
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function () {
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });
        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                return 'right';
            return 'left';
        }
    });
</script>