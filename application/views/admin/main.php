<html>
    <head>
        <?php $this->load->view('admin/head') ?>
    </head>
    <body>
            <?php $this->load->view('admin/left') ?>
        <div id="rightSide">
            <?php $this->load->view('admin/header') ?>

            <?php $this->load->view($temp, $this->data); ?>

            <?php $this->load->view('admin/footer') ?>
        </div>
        <div class="clear"></div>
    </body>
</html>