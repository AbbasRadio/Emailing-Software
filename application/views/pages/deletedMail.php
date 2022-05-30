<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h2 class="box-title">Deleted Mails</h2>
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
                                <td><?=++$i?></td>
                                <td><?=$value->subject?></td>
                                <td><?=$value->msg_detail?></td>
                                <td>
                                    <a href="<?=BASE_URL('DataController/DeletedMail/'.$value->id.'/'.$value->delete_msg)?>" class="icon"><?php
                                        if($value->delete_msg == 1){ ?><i class="fa fa-inbox fa-2x"></i>
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