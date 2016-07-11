var margin = {top: 20, right: 20, bottom: 30, left: 40},
	width = 960 - margin.left - margin.right,
	height = 200 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
	.rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
	.range([height, 0]);

var xAxis = d3.svg.axis()
	.scale(x)
	.orient("bottom");

var yAxis = d3.svg.axis()
	.scale(y)
	.orient("left")
	.ticks(10);
	
var svg_east = d3.select(".bar-chart-east").append("svg")
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
.append("g")
	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.csv("data/team_stats_E.csv", type, function(error, data) {
	
x.domain(data.map(function(d) { return d.abb; }));
y.domain([0, d3.max(data, function(d) { return d.W; })]);
	
svg_east.append("g")
	.attr("class", "x axis")
	.attr("transform", "translate(0," + height + ")")
	.call(xAxis);

svg_east.append("g")
	.attr("class", "y axis")
	.call(yAxis)
.append("text")
	.attr("transform", "rotate(-90)")
	.attr("y", 6)
	.attr("dy", ".31em")
	.style("text-anchor", "end")
	.text("Wins");
	
svg_east.append("text")
	.attr("class", "barE_title")
	.attr("x", (width / 2))
	.attr("y", 0 + (margin.top / 2))
	.attr("text-anchor", "middle")
	.style("font-size", "1.5em")
	.style("font-family", "New York")
	.text("Win numbers of Eastern conference NBA teams");

svg_east.selectAll(".bar")
	.data(data)
.enter().append("rect")
	.attr("class", "barEast")
	.attr("x", function(d) { return x(d.abb); })
	.attr("width", x.rangeBand())
	.attr("y", function(d) { return y(d.W); })
	.attr("height", function(d) { return height - y(d.W); });

	
});
	
function type(d){
	d.W = +d.W;
	return d;
}