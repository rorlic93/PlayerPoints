var width = 1000;
var height = 400;

var margin = {top: 20, right: 20, bottom: 30, left: 50},
			width = 1000 - margin.left - margin.right,
			height = 600 - margin.top - margin.bottom;


var svg = d3.select(".stacked-bar")
    .append("svg")
    .attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
    .on("click", stopped, true);

//Click button to show
function createStackBar() {
    d3.selectAll(".stack-bar").remove();
    d3.selectAll(".bar-option").style("display", "inline");
    svg.selectAll(".pie-chart").style("display","none");

    //Coefficient of the weights
    var ptsWeight = 10;
    var astWeight = 10;
    var rebWeight = 10;
    var tovWeight = 10;
    var stlWeight = 10;
    var blkWeight = 10;

    var stackBarMargin = {top: 10, right: 20, bottom: 20, left: 100};
    var stackBarWidth = 1000 - stackBarMargin.left - stackBarMargin.right;
    var stackBarHeight = 300 - stackBarMargin.top - stackBarMargin.bottom;

    var barY0 = d3.scale.ordinal()
        .rangeRoundBands([stackBarHeight, 0], .2);

    var barY1 = d3.scale.linear();

    var barX = d3.scale.ordinal()
        .rangeRoundBands([0, stackBarWidth], .3, 0);

    var xAxs = d3.svg.axis()
        .scale(barX)
        .orient("bottom");

    var nest = d3.nest()
        .key(function(d) { return d.group; });

    var stack = d3.layout.stack()
        .values(function(d) { return d.values; })
        .x(function(d) { return d.abb; })
        .y(function(d) { return d.value; }) //the thickness of the value
        .out(function(d, barY0) { d.valueOffset = barY0; });

    var barColor  = d3.scale.linear()
        .domain([0, 6])
        .range(["red", "lightblue"])
        .interpolate(d3.interpolateLab);

    var stackedBarChart = svg.append("g")
        .attr("class","stack-bar")
        .attr("width", stackBarWidth + stackBarMargin.left + stackBarMargin.right)
        .attr("height", stackBarHeight + stackBarMargin.top + stackBarMargin.bottom)
        .append("g")
        .attr("transform", "translate(70,50)");

    d3.csv("data/teamBARChart.csv", function(error, barData) {
        barData.forEach(function(d) {
            //Assign the weights
            if (d.groupname == "Points") {
                d.value = (+d.value) * ptsWeight;
            } else if (d.groupname == "Assists"){
                d.value = (+d.value) * astWeight;
            } else if (d.groupname == "Rebounds"){
                d.value = (+d.value) * rebWeight;
            } else if (d.groupname == "Turnovers"){
                d.value = (+d.value) * tovWeight;
            } else if (d.groupname == "Steals"){
                d.value = (+d.value) * stlWeight;
            } else if (d.groupname == "Blocks"){
                d.value = (+d.value) * blkWeight;
            } else {
                d.value = +d.value;
            }
        });

        var dataByGroup = nest.entries(barData);

        stack(dataByGroup);
        barX.domain(dataByGroup[0].values.map(function(d) { return d.abb; }));
        barY0.domain(dataByGroup.map(function(d) { return d.key; }));
        barY1.domain([0, d3.max(barData, function(d) { return d.value; })]).range([barY0.rangeBand(), 0]);

        //Create the tooltips of a team's data 
        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, -128])
            .html(function(d) {
                return "<strong>"+ d.groupname +"</strong> of <strong><span style='color:blue'>" + d.team + "</span></strong>";
            });

        stackedBarChart.call(tip);

        //Horizontal group
        var group = stackedBarChart.selectAll(".bar-group")
            .data(dataByGroup)
            .enter().append("g")
            .attr("class", "bar-group")
            .attr("transform", function(d) { return "translate(0," + barY0(d.key) + ")"; });

        group.append("text")
            .attr("class", "group-label")
            .attr("x", -70)
            .attr("y", function(d) { return barY1(d.values[0].value / 2); })
            .attr("dy", ".35em")
            .text(function(d) { return d.values[0].groupname; });

        group.selectAll("rect")
            .data(function(d) { return d.values; })
            .enter().append("rect")
            .style("fill", function(d) { return barColor(d.group); })
            //.style("fill-opacity", "0.7")
            .attr("x", function(d) { return barX(d.abb); })
            .attr("y", function(d) { return barY1(d.value); })
            .attr("width", barX.rangeBand())
            .attr("height", function(d) { return barY0.rangeBand() - barY1(d.value); })
            .on("mouseover", tip.show)
            .on("mouseout", tip.hide);

        group.filter(function(d, i) { return !i; }).append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + barY0.rangeBand() + ")")
            .call(xAxs);

        //Change the display when click the radio
        d3.selectAll("input").on("change", change);

        //change after the first two seconds
        var timeout = setTimeout(function() {
            d3.select("input[value=\"stacked\"]").property("checked", true).each(change);
        }, 2000);

        function change() {
            clearTimeout(timeout);
            if (this.value == "multiples") {
                transitionMultiples();
            } else {
                transitionStacked();
            }
        }

        function transitionMultiples() {
            var t = stackedBarChart.transition().duration(750);
            var g = t.selectAll(".bar-group").attr("transform", function(d) { return "translate(0," + barY0(d.key) + ")"; });
            g.selectAll("rect").attr("y", function(d) { return barY1(d.value); });
            g.select(".group-label").attr("y", function(d) { return barY1(d.values[0].value / 2); });
            svg.selectAll(".pie-chart").style("display","none");
        }

        function transitionStacked() {
            var t = stackedBarChart.transition().duration(750);
            var g = t.selectAll(".bar-group").attr("transform", "translate(0," + barY0(barY0.domain()[0]) + ")");
            g.selectAll("rect").attr("y", function(d) { return barY1(d.value + d.valueOffset); });
            g.select(".group-label").attr("y", function(d) { return barY1(d.values[0].value / 2 + d.values[0].valueOffset); });
            //Display the pie chart
            svg.selectAll(".pie-chart").style("display","inline");
        }
    });
}

//Click button to hide
function hideStackBar() {
    d3.selectAll(".stack-bar").remove();
    d3.selectAll(".bar-option").style("display", "none");
    svg.selectAll(".pie-chart").style("display","inline");
}

function stopped() {
    if (d3.event.defaultPrevented) {
        d3.event.stopPropagation();
    }
}