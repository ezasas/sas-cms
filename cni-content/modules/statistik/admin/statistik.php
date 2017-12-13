<?php if (!defined('basePath')) exit('No direct script access allowed');
    $month = '';
    $year   = '';
    
    if (!empty($_POST['bulan']) && !empty($_POST['tahun'])) {
        $month = $_POST['bulan'];
        $year = $_POST['tahun'];
    } 
    
    ?>

<?php $this->stats->displayVisitorFilter($month, $year); ?>

<div class="row-fluid">
    <!--/span-->
    <div class="row">
        <div class="col-sm-7">
            <?php $this->stats->displayVisitorStatistic($month, $year); ?>
        </div>
        <div class="col-sm-5">
            <?php $this->stats->displayVisitorReferrer($month, $year); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->stats->displayVisitorOS($month, $year); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->stats->displayVisitorBrowsers($month, $year); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->stats->displayVisitorMap($month, $year); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->stats->displayVisitorCountry($month, $year); ?>
        </div>
    </div>
    <div class="row">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
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
                                    Online Visitor
                                </th>
                                <th>
                                    Total Visitor
                                </th> 
                                <th>
                                    This Day
                                </th>
                                <th>
                                    This Month
                                </th>
                                <th>
                                    This Year
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $this->stats->getOnlineVisitor(); ?>
                                </td>
                                <td>
                                    <?php echo $this->stats->getTotalVisitor(); ?>
                                </td>
                                <td>
                                    <?php echo $this->stats->getVisitorDay(); ?>
                                </td>
                                <td>
                                    <?php echo $this->stats->getVisitorMonth(); ?>
                                </td>
                                <td>
                                    <?php echo $this->stats->getVisitorYear(); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.widget-main -->
            </div>
            <!-- /.widget-body -->
        </div>
    </div>
     
</div>
<!--/span-->
</div>