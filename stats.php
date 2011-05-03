<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'stats';

	$db = Database::getDatabase();

	$applications = DBObject::glob('Application', 'SELECT * FROM shine_applications ORDER BY name');

	$chart_app_activity = new Chart();
	$chart_app_activity->id          = 'chart_app_activity';
	$chart_app_activity->type        = 'column';
	$chart_app_activity->title       = 'App Activity by Week';
	$chart_app_activity->yAxisTitle  = '# Sparkle Updates';
	$chart_app_activity->xColumnName = 'YEARWEEK(dt)';
	$chart_app_activity->yColumnName = 'COUNT(*)';
	$chart_app_activity->query       = 'SELECT COUNT(*), YEARWEEK(dt) FROM `shine_sparkle_reports` GROUP BY YEARWEEK(dt) ORDER BY YEARWEEK(dt) ASC';

	Class Chart
	{
		public $id;
		public $type;
		public $title;
		public $xColumnName;
		public $yColumnName;
		public $query;
		public $appID;
		public $yAxisTitle;

		private $data;

		public function run()
		{
			$db = Database::getDatabase();
			$rows = $db->getRows($this->query);

			$this->data = array();
			foreach($rows as $row)
			{
				$x = $row[$this->xColumnName];
				$y = $row[$this->yColumnName];
				$this->data[$x] = $y;
			}
		}
		
		public function render()
		{
			$this->run();

			$categories = array_keys($this->data);
			$categories = "'" . implode(',', $categories) . "'";
			$data = implode(',', $this->data);

			$out  = "{$this->id} = new Highcharts.Chart({";
			$out .= "chart: { renderTo: '{$this->id}', defaultSeriesType: 'column' },";
			$out .= "title: { text: '{$this->title}' },";
			$out .= "xAxis: { categories: [$categories] },";
			$out .= "yAxis: { title: { text: '{$this->yAxisTitle}' } },";
			$out .= "series: [{ data: [$data] },]";
			$out .= "});";

			echo $out;
		}
	}
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">


                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Sparkle Stats</h2>
							<ul>
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="stats.php">All Apps</a></li>
								<?PHP foreach($applications as $a) : ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="stats.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
							</ul>
							<div class="clear"></div>
                        </div>
					</div>

					<div class="block" style="float:left;margin-right:2em;width:100%;">
						<div class="hd">
							<h2>OS Version</h2>
						</div>
						<div class="bd">
							<div id="chart_app_activity" class="chart"></div>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		<?PHP $chart_app_activity->render(); ?>
	});
</script>
