<style type="text/css">
    i{
        border: none;
    }
    .hover:hover{
        color: orange;
    }
    .checked{
        color: orange;
    }
    .icons{
        letter-spacing: 6px;
        color: black;
    }
    .icon{
        background: transparent;
    }
</style>
    <div class="col-lg-12">
        
        <?php if($this->session->flashdata('Updated')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Updated'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Sent')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Sent'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Inserted')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Inserted'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Thank')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Thank'); ?></div>
        <?php } ?>
        <?php if(validation_errors()) {?>
            <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Phone')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Phone'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Invalid')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Invalid'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Error')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Error'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('user')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('user'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Email')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Email'); ?></div>
        <?php } ?>
    </div>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Inbox</h3>
            <div class="table-responsive">
                <table class="table text-nowrap datatable">
                    <!-- <thead>
                        <tr>
                            <th class="border-top-0">#</th>
                            <th class="border-top-0">First Name</th>
                            <th class="border-top-0">Last Name</th>
                            <th class="border-top-0">Username</th>
                            <th class="border-top-0">Role</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <?php $i = 0;
                        foreach ($results as $value) { ?>
                            <tr>
                                <td width="5%"><?=++$i?></td>
                                <td width="15%"><?=$value->subject?></td>
                                <td width="70%"><?=$value->msg_detail?></td>
                                <td width="10%" class="icons">
                                    <a href="<?=BASE_URL('DataController/UpdateStarredMail/'.$value->id.'/'.$value->starred_msg)?>" class="icon"><?php
                                        if($value->starred_msg == 1){ ?><i class="fa fa-star checked"></i>
                                    <?php }else{?>
                                        <i class="fa fa-star"></i>
                                    <?php } ?></a>
                                    <a href="<?=BASE_URL('DataController/DeletedMail/'.$value->id)?>" class="icon"><?php
                                        if($value->delete_msg == 0){ ?><i class="fa fa-trash"></i>
                                    <?php }?></a>
                                    <a href="<?=BASE_URL('DataController/Spam_Mail/'.$value->id)?>" class="icon"><?php
                                        if($value->spam_msg == 0){ ?><i class="fas fa-exclamation-triangle"></i>
                                    <?php }?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>