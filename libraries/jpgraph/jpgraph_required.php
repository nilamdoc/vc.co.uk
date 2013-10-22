<?php
if (defined('JPGRAPH_REQUIRED_LOADED')) {
    return;
}
define('JPGRAPH_REQUIRED_LOADED', true);
require dirname(__FILE__) . '/jpgraph.php';
require dirname(__FILE__) . '/jpgraph_stock.php';
require dirname(__FILE__) . '/jpgraph_bar.php';
require dirname(__FILE__) . '/jpgraph_line.php';
require dirname(__FILE__) . '/jpgraph_scatter.php';
require dirname(__FILE__) . '/jpgraph_contour.php';
require dirname(__FILE__) . '/jpgraph_regstat.php';
require dirname(__FILE__) . '/jpgraph_flags.php';
require dirname(__FILE__) . '/jpgraph_plotline.php';
require dirname(__FILE__) . '/jpgraph_canvas.php';
require dirname(__FILE__) . '/jpgraph_error.php';
require dirname(__FILE__) . '/jpgraph_pie.php';
require dirname(__FILE__) . '/jpgraph_pie3d.php';
require dirname(__FILE__) . '/jpgraph_polar.php';
require dirname(__FILE__) . '/jpgraph_radar.php';
require dirname(__FILE__) . '/jpgraph_table.php';
?>