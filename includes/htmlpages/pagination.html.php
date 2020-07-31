
<?php if(isset($no_of_pages)):?>
    <div>

        <ul class="pagination">
            <?php for($i = 0; $i<$no_of_pages; $i++):?>
                <li <?php if(isset($_GET["pgn"]) && $i == $_GET["pgn"]){echo("class='active'");}?>>
                    <a href="<?php if(isset($_GET["pgn"])){
                        echo preg_replace("/pgn\=[0-9]*/i","pgn=".$i, $_SERVER["REQUEST_URI"]);
                    }else{echo $_SERVER["REQUEST_URI"]."&pgn=".$i;}?>">
                        <?php echo($i);?>
                    </a> </li>
            <?php endfor; ?>
        </ul>
    </div>
    <div class="btn btn-info">
        <?php if(!empty($counter)){echo($counter[0]);} ?>
    </div>
<?php endif; ?>