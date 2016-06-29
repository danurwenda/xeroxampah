<style>

    svg {
        position: absolute;
    }

    rect {
        fill: white;
    }
.tooltip {
    position: absolute;
    top: 100px;
    left: 100px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border: 2px solid #DDD;
    background: #fff;
    opacity: 1;
    color: #000;
    padding: 10px;
    width: 300px;
    font-size: 15px;
    z-index: 120;
}
</style>
<div id="vis"></div>
<?php
echo js_asset('d3.v3.min.js','polkam');
echo js_asset('Tooltip.js','polkam');
echo js_asset('fdgraph.js','polkam');
?>
<script>
    $(function () {
    var myNetwork;
    myNetwork = Network();
    d3.selectAll("#layouts a").on("click", function (d) {
        var newLayout;
        newLayout = d3.select(this).attr("id");
        activate("layouts", newLayout);
        return myNetwork.toggleLayout(newLayout);
    });
    d3.selectAll("#filters a").on("click", function (d) {
        var newFilter;
        newFilter = d3.select(this).attr("id");
        activate("filters", newFilter);
        return myNetwork.toggleFilter(newFilter);
    });
    d3.selectAll("#sorts a").on("click", function (d) {
        var newSort;
        newSort = d3.select(this).attr("id");
        activate("sorts", newSort);
        return myNetwork.toggleSort(newSort);
    });
    $("#song_select").on("change", function (e) {
        var songFile;
        songFile = $(this).val();
        return d3.json("data/" + songFile, function (json) {
            return myNetwork.updateData(json);
        });
    });
    $("#search").keyup(function () {
        var searchTerm;
        searchTerm = $(this).val();
        return myNetwork.updateSearch(searchTerm);
    });
    return d3.json(base_url+"data/call_me_al.json", function (json) {
        return myNetwork("#vis", json);
    });
});

//    var width = self.frameElement ? 960 : innerWidth,
//            height = self.frameElement ? 500 : innerHeight-120;
//
//    var data = d3.range(20).map(function () {
//        return [Math.random() * width, Math.random() * height];
//    });
//
//    var color = d3.scale.category10();
//
//    var zoom = d3.behavior.zoom()
//            .on("zoom", zoomed);
//
//    var svg = d3.select("#main-container")
//            .on("touchstart", nozoom)
//            .on("touchmove", nozoom)
//            .append("svg")
//            .attr("width", width)
//            .attr("height", height);
//
//    var g = svg.append("g")
//            .call(zoom);
//
//    g.append("rect")
//            .attr("width", width)
//            .attr("height", height)
//            .on("click", clicked);
//
//    var view = g.append("g")
//            .attr("class", "view");
//
//    view.selectAll("circle")
//            .data(data)
//            .enter().append("circle")
//            .attr("transform", function (d) {
//                return "translate(" + d + ")";
//            })
//            .attr("r", 32)
//            .style("fill", function (d, i) {
//                return color(i);
//            });
//
//    function zoomed() {
//        view.attr("transform", "translate(" + d3.event.translate + ") scale(" + d3.event.scale + ")");
//    }
//
//    function clicked(d, i) {
//        if (d3.event.defaultPrevented)
//            return; // zoomed
//
//        d3.select(this).transition()
//                .style("fill", "black")
//                .transition()
//                .style("fill", "white");
//    }
//
//    function nozoom() {
//        d3.event.preventDefault();
//    }

</script>