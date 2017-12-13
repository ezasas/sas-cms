<?php

/** CNI - PHP Visitor Statistics Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class Stats{

	public function displayVisitorFilter($month  = null, $year = null)
	{
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");
		?>
		<form class="form-inline" name="laporan" method="post">
		    <div class="row">
		        <div class="col-md-3">
		            <select name="bulan" class="form-control chosen-select" id="form-field-select-1">
		                <option value="">Bulan</option>
		                <option value="1" <?php if ($month == '1') { echo "selected"; }?>>Januari</option>
		                <option value="2" <?php if ($month == '2') { echo "selected"; }?> >Februari</option>
		                <option value="3" <?php if ($month == '3') { echo "selected"; }?> >Maret</option>
		                <option value="4" <?php if ($month == '4') { echo "selected"; }?> >April</option>
		                <option value="5" <?php if ($month == '5') { echo "selected"; }?> >Mei</option>
		                <option value="6" <?php if ($month == '6') { echo "selected"; }?> >Juni</option>
		                <option value="7" <?php if ($month == '7') { echo "selected"; }?> >Juli</option>
		                <option value="8" <?php if ($month == '8') { echo "selected"; }?> >Agustus</option>
		                <option value="9" <?php if ($month == '9') { echo "selected"; }?> >September</option>
		                <option value="10" <?php if ($month == '10') { echo "selected"; }?> >Oktober</option>
		                <option value="11" <?php if ($month == '11') { echo "selected"; }?> >November</option>
		                <option value="12" <?php if ($month == '12') { echo "selected"; }?> >Desember</option>
		            </select>
		        </div>
		        <div class="col-md-2
		        bdsf">
		            <select name="tahun" class="form-control chosen-select" id="form-field-select-1">
		                <option value="">Tahun</option>
		                <option value="2015" <?php if ($year == '2015') { echo "selected"; }?> >2015</option>
		                <option value="2016" <?php if ($year == '2016') { echo "selected"; }?> >2016</option>
		                <option value="2017" <?php if ($year == '2017') { echo "selected"; }?> >2017</option>
		                <option value="2018" <?php if ($year == '2018') { echo "selected"; }?> >2018</option>
		            </select>
		        </div>
		            <input type="submit" value="Submit" name="kirim" class="btn btn-sm btn-primary"/>
		    </div>
		</form>
		<?php
	}

	public function displayVisitorMap($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");    	

		$data = $system->db->getAll('select distinct(visitor_country), count(visitor_country) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_country');
	    $mapData = '';
	    foreach ($data as $value)
	    {
	        $mapData .= '["'.$value['visitor_country'].'", '.$value['jumlah'].'],';
	    }

	    ?>
    	<div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-globe"></i>
                    Visitor Map
                </h4>
                <div id="regions_div"></div>
            </div>
        </div>
        
		<script type="text/javascript" src="https://www.google.com/jsapi?sensor=false"></script>
		<script type="text/javascript">
		    google.load("visualization", "1", {packages:["geochart"]});
		    google.setOnLoadCallback(drawRegionsMap);
		    
		    function drawRegionsMap() {
		    
		        var data = google.visualization.arrayToDataTable([
		            ["Country", "Visit"],
		            <?php echo $mapData ?>
		        ]);
		    
		    var options = {};
		    
		    var chart = new google.visualization.GeoChart(document.getElementById("regions_div"));
		    
		    chart.draw(data, options);
		    }
		</script>
		<?php
	}

	public function displayVisitorBrowsers($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");

	    $data = $system->db->getAll('select distinct(visitor_browser), count(visitor_browser) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_browser');
	    $browserData = '';
	    foreach ($data as $value)
	    {
	        $browserData .= '
	        		<tr>
	                    <td>
	                    <img src="'.systemURL.'plugins/analytics/browsers/'.$value['visitor_browser'].'.gif" height="15px" width="15px"/>
	                    '.$value['visitor_browser'].'</td>
	                    <td>
	                        <b class="green">'.$value['jumlah'].'</b>
	                    </td>
	                </tr>';
	    }
	    ?>
    	<div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-desktop"></i>
                    Visitor Browser
                </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div style="display: block;" class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead class="thin-border-bottom">
                            <tr>
                                <th>
                                    Browser
                                </th>
                                <th>
                                    Visitor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $browserData ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.widget-main -->
            </div>
            <!-- /.widget-body -->
        </div>
        <?php
	}

	public function displayVisitorOS($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");
		$data = $system->db->getAll('select distinct(visitor_OS), count(visitor_OS) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_OS');
	    $OSData = '';
	    foreach ($data as $value)
	    {
	        $OSData .= '<tr>
	                    <td>
	                    <img src="'.systemURL.'plugins/analytics/os/'.str_replace(' ', '', $value['visitor_OS']).'.gif" height="15px" width="15px"/>
	                    '.$value['visitor_OS'].'</td>
	                    <td>
	                        <b class="green">'.$value['jumlah'].'</b>
	                    </td>
	                </tr>';
	    }
		?>
		<div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-windows"></i>
                    Visitor OS
                </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div style="display: block;" class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead class="thin-border-bottom">
                            <tr>
                                <th>
                                    OS
                                </th>
                                <th>
                                    Visitor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $OSData ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.widget-main -->
            </div>
            <!-- /.widget-body -->
        </div>
		<?php
	}

	public function displayVisitorCountry($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");
		$data = $system->db->getAll('select distinct(visitor_country), visitor_flag,count(visitor_country) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_country');
	    $CountryData = '';
	    foreach ($data as $value)
	    {
	        $CountryData .= '
	        		<tr>
	                    <td>
	                    '.$value['visitor_flag'].'
	                    '.$value['visitor_country'].'</td>
	                    <td>
	                        <b class="green">'.$value['jumlah'].'</b>
	                    </td>
	                </tr>'; 
	    }

		?>
		<div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-flag-o"></i>
                    Visitor Country
                </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div style="display: block;" class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead class="thin-border-bottom">
                            <tr>
                                <th>
                                    Country
                                </th>
                                <th>
                                    Visitor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $CountryData ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.widget-main -->
            </div>
            <!-- /.widget-body -->
        </div>
		<?php
	}

	public function displayVisitorReferrer($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");
		$data = $system->db->getAll('select visitor_referer, count(visitor_referer) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_referer');
		if (empty($data)) {
			?>
			<div class="widget-box transparent">
	            <div class="widget-header widget-header-flat">
	                <h4 class="widget-title lighter">
	                    <i class="ace-icon fa fa-link"></i>
	                    Referrer Websites 
	                </h4>
	                <div class="widget-toolbar">
	                    <a href="#" data-action="collapse">
	                    <i class="ace-icon fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="widget-body">
	                <div class="widget-main">
	                    <!-- #section:plugins/charts.flotchart -->
	                    <div id="piechart-placeholder">No data available</div>
	                    <!-- /section:plugins/charts.flotchart -->
	                </div>
	            </div>
	            <!-- /.widget-main -->
	        </div>
			<?php
			}
	    else {
	    	$ReferrerData = '';
		    foreach ($data as $value)
		    {
		        if (!empty($value['visitor_referer']))
		        {
		            $ReferrerData .= '{ label: "'.$value['visitor_referer'].'",  data: '.$value['jumlah'].'},';
		        }
		        else
		        {
		            $ReferrerData .= '{ label: "direct access",  data: '.$value['jumlah'].'},';
		        }
		    }

			?>
			<div class="widget-box transparent">
	            <div class="widget-header widget-header-flat">
	                <h4 class="widget-title lighter">
	                    <i class="ace-icon fa fa-link"></i>
	                    Referrer Websites 
	                </h4>
	                <div class="widget-toolbar">
	                    <a href="#" data-action="collapse">
	                    <i class="ace-icon fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="widget-body">
	                <div class="widget-main">
	                    <!-- #section:plugins/charts.flotchart -->
	                    <div id="piechart-placeholder"></div>
	                    <!-- /section:plugins/charts.flotchart -->
	                </div>
	            </div>
	            <!-- /.widget-main -->
	        </div>
		

			
			<script>
			$(document).ready(function() {
				var placeholder = $("#piechart-placeholder").css({"width":"90%", "min-height":"200px"});
		          var data = [
		            <?php echo $ReferrerData?>
		          ]
		          function drawPieChart(placeholder, data, position) {
		              $.plot(placeholder, data, {
		                series: {
		                    pie: {
		                        show: true,
		                        tilt:0.8,
		                        highlight: {
		                            opacity: 0.25
		                        },
		                        stroke: {
		                            color: "#fff",
		                            width: 2
		                        },
		                        startAngle: 2
		                    }
		                },
		                legend: {
		                    show: true,
		                    position: position || "ne", 
		                    labelBoxBorderColor: null,
		                    margin:[-30,15]
		                }
		                ,
		                grid: {
		                    hoverable: true,
		                    clickable: true
		                }
		             })
		         }
		         drawPieChart(placeholder, data);
		        
		         placeholder.data("chart", data);
		         placeholder.data("draw", drawPieChart);
		        
		        
		          //pie chart tooltip example
		          var $tooltip = $('<div class="tooltip top in"><div class="tooltip-inner"></div></div>').hide().appendTo("body");
		          var previousPoint = null;
		        
		          placeholder.on("plothover", function (event, pos, item) {
		            if(item) {
		                if (previousPoint != item.seriesIndex) {
		                    previousPoint = item.seriesIndex;
		                    var tip = item.series["label"] + " : " + item.series["percent"]+"%";
		                    $tooltip.show().children(0).text(tip);
		                }
		                $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
		            } else {
		                $tooltip.hide();
		                previousPoint = null;
		            }
		            
		         });
			});
			</script>
			<?php
	    }
	}

	public function displayVisitorStatistic($month  = null, $year = null)
	{
		global $system;
		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");
		$days = array();
    	$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	    foreach (range(1, $day) as $number) {
	        array_push($days, $number);
	    }   
		$data = $system->db->getAll('select distinct(visitor_day), count(id) as jumlah from '.$system->table_prefix.'visitors where visitor_month="'.$month.'" AND visitor_year="'.$year.'" GROUP BY visitor_day, visitor_month, visitor_year ');
	    $stat = '';
	    
	    $vom = array();
	    $vit = array();
	    foreach ($data as $value) {
	        $vom[$value['visitor_day']] = $value['jumlah'];
	        $vit[] = $value['visitor_day'];
	    }
	    
	    $vod = 0;
	    
	    foreach ($days as $value) {
	        if (in_array($value, $vit)) {
	            $vod = $vom[$value];
	        }
	        $stat .= '['.$value.','.$vod.'],';
	        $vod = 0;
	    }
	    $stat = substr($stat, 0,-1);
	    
		?>
		<div class="widget-box transparent">
	        <div class="widget-header widget-header-flat">
	            <h4 class="widget-title lighter">
	                <i class="ace-icon fa fa-line-chart"></i>
	                Visit Over Time
	            </h4>
	            <div class="widget-toolbar">
	                <a href="#" data-action="collapse">
	                <i class="ace-icon fa fa-chevron-up"></i>
	                </a>
	            </div>
	        </div>
	        <div class="widget-body">
	            <div class="widget-main padding-4">
	                <div id="sales-charts"></div>
	            </div>
	            <!-- /.widget-main -->
	        </div>
	        <!-- /.widget-body -->
	    </div>
	    <!-- /.widget-box -->
		
		<script type="text/javascript">
			$(document).ready(function() {
				var d2 = [ <?=$stat;?> ];
			    var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
			    $.plot("#sales-charts", [
			        { label: "Visitor", data: d2 }
			    ], {
			        hoverable: true,
			        shadowSize: 0,
			        series: {
			            lines: { show: true },
			            points: { show: true }
			        },
			        xaxis: {
			            ticks: 30,
			            tickLength: 0,
			            tickDecimals: 0
			        },
			        yaxis: {
			            min: 0,
			            tickDecimals: 0
			        },
			        grid: {
			            hoverable: true,
			            clickable: true
			        }
			    });
			    
			    $("<div id='tooltip'></div>").css({
			        position: "absolute",
			        display: "none",
			        border: "1px solid #fdd",
			        padding: "2px",
			        "background-color": "#fee",
			        opacity: 0.80
			    }).appendTo("body");
			    
			    $("#sales-charts").bind("plothover", function (event, pos, item) {
			    
			        if ($("#enablePosition:checked").length > 0) {
			            var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
			            $("#hoverdata").text(str);
			        }
			    
			        if ($("#enableTooltip:checked").length > 0) {
			            if (item) {
			                var x = item.datapoint[0].toFixed(2),
			                    y = item.datapoint[1].toFixed(2);
			    
			                $("#tooltip").html(item.series.label + " of " + x + " = " + y)
			                    .css({top: item.pageY+5, left: item.pageX+5})
			                    .fadeIn(200);
			            } else {
			                $("#tooltip").hide();
			            }
			        }
			    });

			    var $tooltip = $('<div class="tooltip top in"><div class="tooltip-inner"></div></div>').hide().appendTo("body");
			    var previousPoint = null;
		        sales_charts.on('plothover', function (event, pos, item) {
		            if(item) {
		                if (previousPoint != item.seriesIndex) {
		                    previousPoint = item.seriesIndex;
		                    var x = item.datapoint[0].toFixed(0),
		                        y = item.datapoint[1].toFixed(0);
		                    var tip = item.series['label'] + " Tanggal " + x + " : " + y;
		                    $tooltip.show().children(0).text(tip);
		                }
		                $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
		            } else {
		                $tooltip.hide();
		                previousPoint = null;
		            }
		            
		        });
			});
		</script>
		<?php
	}

	public function getOnlineVisitor(){
		global $system;

		$now = date('Y-m-d H:i:s');
		$onlineVisitor = $system->db->getOne('SELECT COUNT(id) FROM '.$system->table_prefix.'visitors WHERE visitor_date > ("'.$now.'" - INTERVAL 1440 SECOND)');

		return $onlineVisitor;
	}

	public function getTotalVisitor(){
		global $system;

		$onlineVisitor = $system->db->getOne('SELECT COUNT(id) FROM '.$system->table_prefix.'visitors WHERE 1');
			
		return $onlineVisitor;
	}

	public function getVisitorDay($day = null, $month = null, $year = null){
		global $system;

		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");

		$day = ! empty($day) ? $day : date("j");

		$visitor = $system->db->getOne('SELECT COUNT(id) FROM '.$system->table_prefix.'visitors WHERE visitor_day = '.$day.' && visitor_month = '.$month.' && visitor_year = '.$year.' ');
			
		return $visitor;
	}

	public function getVisitorMonth($month = null, $year = null){
		global $system;

		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");

		$visitor = $system->db->getOne('SELECT COUNT(id) FROM '.$system->table_prefix.'visitors WHERE visitor_month = '.$month.' && visitor_year = '.$year.' ');
			
		return $visitor;
	}

	public function getVisitorYear($year = null){
		global $system;

		$year = ! empty($year) ? $year : date("Y");

		$month = ! empty($month) ? $month : date("n");

		$visitor = $system->db->getOne('SELECT COUNT(id) FROM '.$system->table_prefix.'visitors WHERE visitor_year = '.$year.' ');
			
		return $visitor;
	}

	public function getVisitorPage($limit = 10){
		global $system;
		$page = $system->db->getAll('SELECT distinct( visitor_page )as page from '.$system->table_prefix.'visitors limit 0,'.$limit);
		$i = 1;
		$data = '';
		foreach($page as $v){
			
			$totalPage = $system->db->getOne('SELECT count( visitor_page )as total from '.$system->table_prefix.'visitors where visitor_page="'.$v['page'].'"');
			
			$data .= '<tr><td>'.$i.'</td><td>'.$v['page'].'</td><td>'.$totalPage.'</td></tr>';
			$i++;
		}
		
		$getVisitorPage = '<table class="table">'.$data.'</table>';
		
		return $getVisitorPage;
	}

}