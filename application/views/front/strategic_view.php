<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box hc-box">
                    <div class="widget-header widget-header-flat">
                        <h4 class="widget-title">
                            <i class="ace-icon fa fa-signal"></i>

                        </h4>

                        <!-- #section:custom/widget-box.toolbar -->
                        <div class="widget-toolbar">
                            <a href="#" data-action="fullscreen" class="orange2">
                                <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="reload">
                                <i class="ace-icon fa fa-refresh"></i>
                            </a>

                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>

                        <!-- /section:custom/widget-box.toolbar -->
                    </div>
                    <?php
                    ?>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div id="strategicChart"></div>
                        </div>
                    </div>
                    <?php
                    if (isset($strategic_chart)) {
                        echo js_asset('highcharts/highcharts.js', 'polkam');
                        echo js_asset('highcharts/exporting.js', 'polkam');
                        echo js_asset('highcharts/highcharts.indo.js', 'polkam');
                        ?>
                        <script type="text/javascript">
                            $(function () {
    <?php echo $strategic_chart; ?>
                                $('.hc-box').on(
                                        'fullscreened.ace.widget',
                                        function () {
                                            var box = $(this), wm = $('.widget-main', box);
                                            //check ini expand apa shrink
                                            if (box.hasClass('fullscreen')) {
                                                strategicChart.setSize(wm.width(), wm.height(), false);
                                            } else {
                                                strategicChart.setSize(wm.width(), 400, false);
                                            }
                                        }
                                );

                            });
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="widget-box uu-box">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title smaller">
                    <i class="ace-icon fa fa-quote-left smaller-80"></i>
                    Perundangan Terkait
                </h4><!-- #section:custom/widget-box.toolbar -->
                <div class="widget-toolbar">
                    <a href="#" data-action="fullscreen" class="orange2">
                        <i class="ace-icon fa fa-expand"></i>
                    </a>

                    <a href="#" data-action="reload">
                        <i class="ace-icon fa fa-refresh"></i>
                    </a>

                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <?php
            echo js_asset('jquery-ui.custom.js', 'ace');
            echo js_asset('bootbox.js', 'ace');
            echo js_asset('vis/vis.min.js', 'polkam');
            echo css_asset('vis/vis.min.css', 'polkam')
            ?>
            <script type="text/javascript">
                //global setting used by all network
                var options = {
                    height: '350px',
                    interaction: {dragNodes: false},
                    nodes: {shape: 'box'},
                    physics: {
                        solver: 'hierarchicalRepulsion',
                        hierarchicalRepulsion: {
                            centralGravity: 0.0,
                            springLength: 200,
                            springConstant: 0.1,
                            nodeDistance: 115,
                            damping: 0.09
                        }
                    },
                    edges: {
                        smooth: {type: 'continuous'}
                    },
                    layout: {
                        hierarchical: {
                            direction: 'UD'
                        }
                    }
                };
                //history
                var sejarah = null;
                function drawHistory() {
                    if (sejarah !== null) {
                        sejarah.destroy();
                        sejarah = null;
                    }
                    var nodes = new vis.DataSet([
                        {
                            id: 0,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/16953/UUD1945dlmsatunaskah.pdf',
                            level: 0,
                            label: 'Pasal 4 ayat (1) UUD 1945',
                            title: 'Presiden Republik Indonesia memegang kekuasaan Pemerintahan menurut Undang-Undang Dasar'
                        }, {
                            id: 1,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/14447/kp0111969.pdf',
                            level: 1,
                            label: 'Keppres RI no 11/1969',
                            title: 'STRUKTUR ORGANISASI SERTA TUGAS POKOK DAN FUNGSI BADAN URUSAN LOGISTIK'
                        }, {
                            id: 2,
                            level: 1,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/6966/PP0072003.pdf',
                            label: 'PP no 7/2003',
                            title: 'PENDIRIAN PERUSAHAAN UMUM (PERUM) BULOG'
                        }, {
                            id: 3,
                            level: 0,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/16953/UUD1945dlmsatunaskah.pdf',
                            label: 'Pasal 5 ayat (2) UUD 1945 amandemen IV',
                            title: 'Presiden menetapkan Peraturan Pemerintah untuk menjalankan Undang-undang sebagaimana mestinya'
                        }
                    ]);
                    var edges = [];

                    edges.push({from: 0, to: 1});
                    edges.push({from: 3, to: 2});

                    // create a history
                    var container = document.getElementById('sejarah');
                    var data = {
                        nodes: nodes,
                        edges: edges
                    };

                    sejarah = new vis.Network(container, data, options);

                    // add event listeners
                    bindPDFpopup(sejarah, nodes);
                }
                var asetLPND = null;
                function drawAsetLPND() {
                    if (asetLPND !== null) {
                        asetLPND.destroy();
                        asetLPND = null;
                    }
                    var edges = [];

                    var nodes = new vis.DataSet([
                        {
                            id: 0,
                            level: 1,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/5636/KEPPRES%20NO%20103%20TH%202001.pdf',
                            label: 'Keppres RI no 103/2001',
                            title: 'Kedudukan, Tugas, Fungsi, Kewenangan, Susunan Organisasi dan Tata Kerja Lembaga Pemerintah Non Departemen'
                        }, {
                            id: 1,
                            level: 0,
                            label: 'UU no 33/2004',
                            url: 'http://sipuu.setkab.go.id/PUUdoc/336/UU%20NO%2033%20TH%202004.pdf',
                            title: 'Perimbangan Keuangan antara Pemerintah Pusat dengan Pemerintah Daerah'
                        }, {
                            id: 2,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/7305/UU0172003.pdf',
                            level: 0,
                            label: 'UU no 17/2003',
                            title: 'Keuangan Negara'}]);


                    edges.push({from: 1, to: 0});
                    edges.push({from: 2, to: 0});

                    // create a history
                    var container = document.getElementById('asetlpnd');
                    var data = {
                        nodes: nodes,
                        edges: edges
                    };

                    asetLPND = new vis.Network(container, data, options);

                    // add event listeners
                    bindPDFpopup(asetLPND, nodes);
                }
                var trans = null;
                function drawTrans() {
                    if (trans !== null) {
                        trans.destroy();
                        trans = null;
                    }
                    var edges = [];

                    var nodes = new vis.DataSet([
                        {
                            id: 0,
                            level: 1,
                            label: 'UU Pasar Modal no 8/1995',
                            title: 'Pasar Modal',
                            url: 'http://sipuu.setkab.go.id/PUUdoc/7087/UU0081995.pdf'
                        }, {
                            id: 1,
                            level: 1,
                            label: 'UU no 21/2011',
                            url: 'http://sipuu.setkab.go.id/PUUdoc/17367/UU0212011.pdf',
                            title: 'Otoritas Jasa Keuangan'}
                    ]);
                    edges.push({from: 1, to: 0});

                    // create a history
                    var container = document.getElementById('transparansi');
                    var data = {
                        nodes: nodes,
                        edges: edges
                    };

                    trans = new vis.Network(container, data, options);

                    // add event listeners
                    bindPDFpopup(trans, nodes);
                }
                var proses = null;
                function drawProcess() {
                    if (proses !== null) {
                        proses.destroy();
                        proses = null;
                    }
                    var edges = [];

                    var nodes = new vis.DataSet([
                        {
                            id: 0,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/8838/PP%20NO%2045%20TH%202005.pdf',
                            level: 1,
                            label: 'PP no 45/2005',
                            title: 'Pendirian, Pengurusan, Pengawasan dan Pembubaran Badan Usaha Milik Negara'
                        }, {
                            id: 1,
                            level: 1,
                            url: 'http://sipuu.setkab.go.id/PUUdoc/6966/PP0072003.pdf',
                            label: 'PP no 7/2003',
                            title: 'Pendirian Perusahaan Umum Bulog'
                        }, {
                            id: 2,
                            level: 2,
                            label: 'pendapat MK',
                            url: 'http://www.mahkamahkonstitusi.go.id/putusan/putusan_sidang_2050_48%20PUU%202013-UU-KeuanganNegara-telahucap-18Sept2014-%20wmActionWiz.pdf',
                            title: 'Pengujian UU No.17/2003 tentang Keuangan Negara'
                        }, {
                            url: 'http://sipuu.setkab.go.id/PUUdoc/15392/UU%20NO%2015%20TH%202006.pdf',
                            id: 3,
                            level: 0,
                            label: 'UU no 15/2006',
                            title: 'Badan Pemeriksa Keuangan'
                        }, {
                            id: 4,
                            level: 0,
                            label: 'UU no 9/1969',
                            url: 'http://sipuu.setkab.go.id/PUUdoc/4008/UU0091969.pdf',
                            title: 'Bentuk-bentuk Usaha Negara'
                        }, {
                            id: 5,
                            level: 0,
                            url: 'http://hukum.unsrat.ac.id/uu/s1925_448.pdf',
                            label: 'UU Perbendaharaan Indonesia',
                            title: 'Pengaturan Tentang Cara Pengurusan dan Pertanggungjawaban Keuangan Republik Indonesia'
                        }]);

                    edges.push({from: 4, to: 1});
                    edges.push({from: 3, to: 1});
                    edges.push({from: 1, to: 2});
                    edges.push({from: 4, to: 5});

                    // create a history
                    var container = document.getElementById('proses');
                    var data = {
                        nodes: nodes,
                        edges: edges
                    };

                    proses = new vis.Network(container, data, options);

                    // add event listeners
                    bindPDFpopup(proses, nodes);
                }
                function bindPDFpopup(visObj, nodes) {
                    visObj.on('select', function (params) {
//                        $.each(params.nodes, function (i, v) {
                        var url = nodes.get(params.nodes[0]).url;
                        if (url) {
                            //prepare element
                            var pdfobj = $('<object width="100%" height="100%" data="' + url + '"></object>', {
                                type: 'application/pdf'
                            });
                            var ele = $('<div/>', {
                                id: 'foo',
                                class: 'col-xs-10 vh-80'
                            });
                            pdfobj.appendTo(ele);
                            //show popup
                            bootbox.alert({
                                size: 'large',
                                message: ele
                            });
                        }
//                        });
                        visObj.unselectAll();
                    });
                }
            </script>
            <script type="text/javascript">
                function draw() {
                    drawHistory();
                    drawAsetLPND();
                    drawTrans();
                    drawProcess();
                }
                $(function () {
                    draw();
                    $('.uu-box').on(
                            'fullscreened.ace.widget',
                            function () {
                                draw();
                            }
                    );

                    //cek event
                    $('.panel-collapse').on('show.bs.collapse', function () {
//                        console.log('show');
                    });
                    $('.panel-collapse').on('shown.bs.collapse', function () {
                        draw();
                    });
                });



            </script>
            <style>
                .vh-80{height: 80vh}             
            </style>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- #section:elements.accordion -->
                            <div id="accordion" class="accordion-style1 panel-group">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" id="sesuatu">
                                                <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;Sejarah
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse in" id="collapseOne">
                                        <div class="vis-container" id="sejarah">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseProses">
                                                <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;Bentuk Perusahaan
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse" id="collapseProses">
                                        <div class="vis-container" id="proses">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;Aset BULOG sebagai LPND
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse" id="collapseTwo">
                                        <div class="vis-container" id="asetlpnd">
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;Transparansi
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse" id="collapseThree">
                                        <div class="vis-container" id="transparansi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /section:elements.accordion -->
                        </div><!-- /.col -->


                    </div>
                </div>
            </div>
        </div>
    </div>    
</div><!-- PAGE CONTENT ENDS -->
