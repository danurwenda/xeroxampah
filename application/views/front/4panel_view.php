<div class="row">
    <div class="col-sm-6 chart-col">
        <div class="top-left chart" id="TL"></div>
        <div class="bottom-left chart" id="BL"></div>
    </div>
    <div class="col-sm-6 chart-col">
        <div class="top-right chart" id="TR"></div>
        <div class="bottom-right chart" id="BR"></div>
    </div>
</div>
<?php
if (isset($charts)) {
    echo js_asset('highcharts/highcharts.js', 'polkam');
    echo js_asset('highcharts/exporting.js', 'polkam');
    echo js_asset('highcharts/highcharts.indo.js', 'polkam');
    ?>
    <script type="text/javascript">
        $(function () {
    <?php 
    echo $charts['TL'];
    echo $charts['TR'];
    echo $charts['BR'];
    echo $charts['BL'];
    ?>

        });
    </script>
<?php } ?>