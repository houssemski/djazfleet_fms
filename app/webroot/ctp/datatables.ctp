
<style>
    #adBlockerPopup .modal-header{background: #e74c3c;color: #fff;}
    #adBlockerPopup .modal-header h4{color: #fff;}
    #adBlockerPopup .modal-footer{text-align: center;}
    #adBlockerPopup .modal-footer i{color:#fff;padding-right: 5px;}
    #adBlockerPopup .modal-footer .btn{border-radius:0px;width: 200px;height: 40px;font-size: 17px;}
</style>
<?php

$this->start('css'); ?>
    <?= $this->Html->css('cake_datatables/bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/font-awesome.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/dataTables.bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/responsive.bootstrap'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/fixedHeader.bootstrap.min'); ?>
    <?= $this->Html->css('cake_datatables/datatables-extensions/scroller.bootstrap.min'); ?>

<?php $this->end();
$this->start('script'); ?>

<?= $this->Html->script('cake_datatables/jquery-1.12.3'); ?>
<?= $this->Html->script('cake_datatables/bootstrap.min'); ?>
<?= $this->Html->script('cake_datatables/jquery.dataTables.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.bootstrap.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.responsive.min'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.fixedHeader'); ?>
<?= $this->Html->script('cake_datatables/datatables-extensions/dataTables.scroller.min'); ?>

<script type="text/javascript">
    /* Adblock */
    $(document).ready(function(){
        (function(){
            var adBlockFlag = document.createElement('div');
            adBlockFlag.innerHTML = '&nbsp;';
            adBlockFlag.className = 'adsbox';
            $('body').append(adBlockFlag);
            window.setTimeout(function() {
              if (adBlockFlag.offsetHeight === 0) {
                showAdBlockPopUp();
                $('body').addClass('adblock');
              }
              adBlockFlag.remove();
            }, 100);

            function showAdBlockPopUp(){
                var adBlockerPopup = $('#adBlockerPopup');
                adBlockerPopup.modal({
                    backdrop: 'static',
                    keyboard: false
                });
                adBlockerPopup.modal('show');
            }

            $(document).on('click', '#adBlockerPopupRefresh', function(){
                location.reload();
            });

        })();
    });
</script>

<?php $this->end(); ?>


