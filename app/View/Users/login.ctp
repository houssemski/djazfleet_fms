

<style>
    .wrapper {
        padding-top: 0px;
        background-color: transparent;
    }
    #topnav, .side-menu-fixed, .row {
        display: none;
    }

    .container {
        padding-right: 0px;
        padding-left: 0px;
        margin-right: 0;
        margin-left: 0;
    }
	.container-fluid
	{
	padding-top : 0px !important;
	}
    </style>

<div class="clearfix"></div>
<div class="wrapper-page">
    <?php if(Configure::read("gestion_commercial") == '1') {
        if(Configure::read("engin") == '1'){ ?>
            <div class="text-center">
                <img src="../img/--logo_engines.png"/>
            </div>
        <?php   } elseif (Configure::read("parc_master") == '1'){ ?>
            <div class="text-center">
                <img src="../img/parc_master.png"/>
            </div>
        <?php }elseif (Configure::read("logistia") == '1'){ ?>
            <div class="text-center">
                <img src="../img/logo_logistia.png"/>
            </div>
        <?php }else { ?>

                <?php if( Configure::read("transport_personnel") == '1') { ?>
            <div class="text-center" style="margin-left: -30px;">
                <img src="../img/--logo_etusa_0.png"/>
            </div>
      <?php  }elseif (Configure::read("utranx_ade") == '1'){ ?>
                <div class="text-center">
                    <img src="../logo/ade.png"/>
                </div>
            <?php } else { ?>


        <div class="text-center" style="margin-left: -30px;">
            <img src="../img/--logo_utranx.png"/>
        </div>
    <?php }


     } }else { ?>
        <?php if(Configure::read("parc_master") == '1'){ ?>
            <div class="text-center">
                <img src="../img/parc_master.png"/>
            </div>
         <?php }elseif (Configure::read("logistia") == '1'){ ?>
            <div class="text-center">
                <img src="../img/logo_logistia.png"/>
            </div>
        <?php }elseif (Configure::read("utranx_ade") == '1'){ ?>
            <div class="text-center">
                <img src="../logo/ade.png"/>
            </div>
        <?php }else{ ?>
            <div class="text-center">
                <img src="../img/--logo_utranx.png"/>
            </div>
            <?php } ?>
     <?php }?>

    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0"><?= __('Sign In') ?></h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal m-t-20" >
                <?php  echo $this->Form->create('User'); ?>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <?php echo $this->Form->input('username', array(
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => __('Username')));?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <?php echo $this->Form->input('password', array(
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => __('Password')));?>
                    </div>
                </div>



                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light custom-submit" type="submit"><?= __('Log In') ?></button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <?php if(Configure::read("gestion_commercial") == '1') {
                        if(Configure::read("engin") == '1') { ?>
                            <span>Copyright © 2015 - 2022&nbsp&nbsp;<a href="#" target="_blank"> Engines Soft v 2.5.0.3</a></span>

                        <?php   }elseif (Configure::read("logistia") == '1'){ ?>
                            <span>Copyright © 2015 - 2022&nbsp&nbsp;<a href="#" target="_blank"> LOGISTIA v 2.5.0.3</a></span>
                        <?php }else { ?>
                            <span>Copyright © 2015 - 2022&nbsp&nbsp;<a href="#" target="_blank"> UtranX v 2.5.0.3</a></span>

                        <?php   }
                            ?>


                        <?php } else { ?>
                            <?php
                            if (Configure::read("logistia") == '1'){
                            ?>
                                <span>Copyright © 2015 - 2022&nbsp&nbsp;<a href="#" target="_blank"> LOGISTIA v 2.5.0.3</a></span>
                                <?php
                            }else{
                                ?>
                            <span>Copyright © 2015 - 2022&nbsp&nbsp;<a href="#" target="_blank"> UtranX v 2.5.0.3</a></span>
                                <?php
                            }
                                ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end card-box-->



</div>
<!-- end wrapper page -->



<script>
    var resizefunc = [];
</script>







