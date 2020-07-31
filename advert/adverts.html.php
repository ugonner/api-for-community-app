<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php"; ?>

<div class="page-heading text-center">

    <div class="container zoomIn animated">

        <h1 class="page-title">adverts<span class="title-under"></span></h1>
        <p class="page-description">
            adverts
        </p>

    </div>

</div>


<div class="container">

    <div class="row">

        <div class="col-sm-3">

        </div>

        <div class="col-sm-6">

            <!--<h2 class="title-style-2">advertS <span class="title-under"></span></h2>-->

            <?php if(!empty($adverts)):?>
                <?php
                include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/pagination.html.php";
                ?>
                <?php foreach($adverts as $d):?>
                    <div class="row">
                        <table class="table-responsive">
                            <thead><h3> <?php echo($d['title']);?></h3></thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Published<i class="glyphicon glyphicon-question-sign"></i>
                                    </td>
                                    <td><?php echo($d['advertpublic'])?></td>
                                    <td>
                                        Paid<i class="glyphicon glyphicon-question-sign"></i>
                                    </td>
                                    <td><?php echo($d['paid'])?></td>
                                </tr>

                                <tr>
                                    <td>
                                        title <i class="glyphicon glyphicon-book"></i>
                                    </td>
                                    <td><?php echo($d['title']); ?></td>
                                    <td colspan="2">
                                        <img src="<?php echo($d['advertimagedisplayname']);?>" style="width: 80px; height: 70px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        client:<i class="glyphicon glyphicon-user"></i>
                                    </td>
                                    <td>
                                        <b class="btn bg-transparent">
                                            <a class="btn bg-transparent" href="/api/user/index.php?guid=<?php echo $d["userid"];?>">
                                                <?php echo $d["firstname"];?>,
                                            </a>
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        url: <i class="glyphicon glyphicon-globe"></i>
                                    </td>
                                    <td><?php echo($d['adverturl'])?></td>
                                </tr>

                                <tr>
                                    <td>Placement</td>
                                    <td><?php echo($d['placementname']);?></td>
                                    <td>category:</td>
                                    <td> <?php echo($d['categoryname']);?></td>
                                </tr>
                                <tr>
                                    <td>Booked On <i class="glyphicon glyphicon-time"></i></td>
                                    <td>
                                        <b><?php echo date('y M d, l H:s a',strtotime($d["dateofpublication"]));?></b>
                                    </td>
                                    <td>Amount <i class="glyphicon glyphicon-bitcoin"></i></td>
                                    <td>
                                        <b><?php echo($d['amount']); ?></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="row">
                        <div class="btn" data-toggle="collapse" data-target="#editadvertdiv<?php echo($d['advertid'])?>">
                            <b>Actions</b><i class="caret"></i>
                        </div>
                        <div class="collapse" id="editadvertdiv<?php echo($d['advertid'])?>">
                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="paid"  />
                                        <label for="paidselect">Paid?</label>
                                        <select id="paidselect" name="value" class="input-lg form-control">
                                            <option value="">select</option>
                                            <option value="N">Not Paid</option>
                                            <option value="Y">Paid</option>
                                        </select>
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                           Update Pay Status
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group form-inline form-horizontal" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="categoryid"  />
                                        <label for="paidselect">Category</label>
                                        <select id="paidselect" name="value" class="input-lg form-control">
                                            <option value="">select</option>
                                            <?php foreach($headcategories as $adv_art_cat):?>
                                                <option value="<?php echo($adv_art_cat['id']);?>"><?php echo($adv_art_cat['name']);?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                            Update Category
                                        </button>
                                    </div>
                                </form>
                            </div>


                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group form-inline form-horizontal" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="public"  />
                                        <label for="paidselect">Publsh?</label>
                                        <select id="paidselect" name="value" class="input-lg form-control">
                                            <option value="">select</option>
                                            <option value="N">UnPublish</option>
                                            <option value="Y">Publish</option>
                                        </select>
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                            Update Publish Status
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group form-inline form-horizontal" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="placementid"  />
                                        <label for="paidselect">Placement</label>
                                        <select id="paidselect" name="value" class="input-lg form-control">
                                            <option value="">select</option>
                                            <option value="1">Home Page Top</option>
                                            <option value="2">Home Page Side</option>
                                            <option value="3">Other Page Top</option>
                                            <option value="4">Other Page Side</option>
                                        </select>
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                            Update Placement
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="title"  />
                                        <label for="ad-title">Title</label>
                                        <input type="text" class="form-control input-lg" name="value" value="<?php echo $d['title'];?>" />
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                            Update title
                                        </button>
                                    </div>
                                </form>
                            </div>


                            <div class="form-group form-inline form-horizontal">
                                <form class="form-group" action="/api/advert/index.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="advertid" value="<?php echo($d['advertid']);?>"  />
                                        <input type="hidden" name="pty" value="adverturl"  />
                                        <label for="ad-url">Url</label>
                                        <input type="url" class="form-control input-lg" name="value" value="<?php echo $d['adverturl'];?>" />
                                        <button type="submit" class="btn bg-transparent" name="editadvert">
                                            Update Url
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br><br>
                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    <h3 class="text-center">
                        No adverts Yet.
                    </h3>
                </div>
            <?php endif;?>

        </div>
        <div class="col-sm-3">

        </div>

    </div> <!-- /.row -->


</div>


<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/footer2.html.php"; ?>
