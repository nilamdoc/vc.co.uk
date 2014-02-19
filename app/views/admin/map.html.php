<script src="/js/raphael.js"></script>
<script src="/js/world.js"></script>

 <script>
            Raphael("forworldmap", 1000, 400, function () {
                var r = this;
                r.rect(0, 0, 1000, 400, 10).attr({
                    stroke: "none",
                    fill: "0-#9bb7cb-#adc8da"
                });
                var over = function () {
                    this.c = this.c || this.attr("fill");
                    this.stop().animate({fill: "#bacabd"}, 500);
                },
                    out = function () {
                        this.stop().animate({fill: this.c}, 500);
                    };
                r.setStart();
                var hue = Math.random();
                var myCountryArray = new Array();
								
                for (var country in worldmap.shapes) {
                    // var c = Raphael.hsb(Math.random(), .5, .75);
                    // var c = Raphael.hsb(.11, .5, Math.random() * .25 - .25 + .75);
                     var myRPath = r.path(worldmap.shapes[country]).attr({stroke: "#ccc6ae", fill: "#f0efeb", "stroke-opacity": 0.25});

                     myCountryArray[myRPath.id] = country;
                     myRPath.hover(function() {
                     	showTooltip(myCountryArray[this.id]);
                     });
                }
                var world = r.setFinish();
                world.hover(over, out);
                // world.animate({fill: "#666", stroke: "#666"}, 2000);
                world.getXY = function (lat, lon) {
                    return {
                        cx: lon * 2.6938 + 465.4,
                        cy: lat * -2.6938 + 227.066
                    };
                };
                world.getLatLon = function (x, y) {
                    return {
                        lat: (y - 227.066) / -2.6938,
                        lon: (x - 465.4) / 2.6938
                    };
                };
                var latlonrg = /(\d+(?:\.\d+)?)[\xb0\s]?\s*(?:(\d+(?:\.\d+)?)['\u2019\u2032\s])?\s*(?:(\d+(?:\.\d+)?)["\u201d\u2033\s])?\s*([SNEW])?/i;
                world.parseLatLon = function (latlon) {
                    var m = String(latlon).split(latlonrg),
                        lat = m && +m[1] + (m[2] || 0) / 60 + (m[3] || 0) / 3600;
                    if (m[4].toUpperCase() == "S") {
                        lat = -lat;
                    }
                    var lon = m && +m[6] + (m[7] || 0) / 60 + (m[8] || 0) / 3600;
                    if (m[9].toUpperCase() == "W") {
                        lon = -lon;
                    }
                    return this.getXY(lat, lon);
                };
                for (var country in worldmap.shapes) {
<?php foreach($details as $dd){
	if($dd['lastconnected.loc']!=""){
?>
	  r.circle().attr({fill: "#00f", stroke: "#f00", r: 2}).attr(world.getXY(<?=$dd['lastconnected.loc']?>));
<?php }
}?>


									
								}
                try {
                    navigator.geolocation && navigator.geolocation.getCurrentPosition(function (pos) {
                        r.circle().attr({fill: "none", stroke: "#f00", r: 5}).attr(world.getXY(pos.coords.latitude, pos.coords.longitude));
                    });
                } catch (e) {}
                var frm = document.getElementById("latlon-form"),
                    dot = r.circle().attr({fill: "r#FE7727:50-#F57124:100", stroke: "#fff", "stroke-width": 2, r: 0}),
                    // dot2 = r.circle().attr({stroke: "#000", r: 0}),
                    ll = document.getElementById("latlon"),
                    cities = document.getElementById("cities");
            });
        </script>

		<script>
			//this var will hold all country data from initial ajax call
			var mycountryarray = new Array();			
			jsonresponse = '<?php echo $coun;?>';

			mycountryarray = $.parseJSON(jsonresponse);			
			$(document).ready(function(){


				$("#forworldmap").mousemove(function(e){
				  $("#forworldmapcomment").position({
					my: "bottom-20",
					of: e,
					collision: "fit"
				  });
				});
				$("#forworldmap").mouseout(function(e){
				  $("#forworldmapcomment").html("");
				});
			});
			function showTooltip(country) {
				if (mycountryarray[country]) {
					$("#forworldmapcomment").html("<h2>"+country + " " + worldmap.names[country] + ": "+ mycountryarray[country]+"</h2>");
				} else {
			$("#forworldmapcomment").html("<h2>"+country + " " + worldmap.names[country] + ": 0</h2>");
				}
			}
</script>
<div class="container">
	<div class="row-fluid">
			<div class="row-fluid" style="text-align:center;">
				<div class="span12">
					<div id="forworldmap"></div>
					<!--Awesome world map modified from http://raphaeljs.com/ Raphael, check it out!-->
				</div>
			</div>
		<div id="forworldmapcomment" style="position:absolute;min-height:100px"></div>		
		</div>
	</div>
</div>
<br>
<br>
<br>