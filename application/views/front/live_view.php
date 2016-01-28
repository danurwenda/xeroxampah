<?php
echo js_asset('hot.js', 'polkam');
echo css_asset('handsontable.full.min.css', 'polkam');
?>
<div id="live_data"></div>
<script type="text/javascript">
    $(function () {

<?php
$colStartNext = -1;
foreach ($tables as $t) {
    $colStart = $colStartNext + 2;
    $row = 2;
    foreach ($t['data'] as $rowdata) {
        $col = $colStart;
        foreach ($rowdata as $val) {
            $value = is_numeric($val) ? $val : "'$val'";
            $data[$row][$col] = $value;

            $col++;
            if ($colStartNext < $col) {
                $colStartNext = $col;
            }
        }
        $data[$row][$col + 1] = "''";
        $row++;
    }
}
?>
        var data = [
            //title
            ["<?php echo $livetitle; ?>", '', '', '', '', '', '', '', '', '', '', ''],
            //tables header
            [
<?php
foreach ($tables as $t) {
    echo "'',"; //buat nomor
    foreach ($t['headers'] as $h) {
        echo "'$h',";
    }
    echo "'',"; //buat pemisah dengan tabel berikutnya
}
?>
            ],
<?php
//convert array php to array js
foreach ($data as $d) {
    echo '[';
    foreach ($d as $v) {
        echo $v . ',';
    }
    echo '],';
}
?>
        ];

        var container = document.getElementById('live_data');
        var titleRenderer = function (instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.fontWeight = 'bold';
            td.style.textAlign = 'center';
            td.style.color = 'black';
        };
        var headerRenderer = function (instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (col != 5) {
                td.style.backgroundColor = '#BDD7EE';
            }
        };

        function heatmap(val) {
            return '#ffffff';
        }

        var valueRenderer = function (instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);

            if (col != 1 && col != 7) {
                td.style.textAlign = 'right';
            }
            td.style.backgroundColor = heatmap(value);
        };
        var hot = new Handsontable(container, {
            data: data,
            stretchH:'all',
            rowHeaders: false,
            colHeaders: false,
            contextMenu: false,
            editor: false,
            readOnly: true,
            readOnlyCellClassName:'',
            mergeCells: [
                {row: 0, col: 0, rowspan: 1, colspan: 12}//merge title row
            ],
            colWidths: [
                50, 200, 55, 55, 55,
                47,
                50, 200, 55, 55, 55, 55
            ],
            cells: function (row, col, prop) {
                var cellProperties = {};

                if (row === 0) {
                    cellProperties.renderer = titleRenderer;
                } else if (row === 1) {
                    cellProperties.renderer = headerRenderer;
                } else {
                    cellProperties.renderer = valueRenderer;
                }

                return cellProperties;
            }
        });

    });
</script>