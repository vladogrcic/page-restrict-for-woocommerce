<?php
if(count($trans_text) === count($trans_img)):
    for ($i=0; $i < count($trans_text); $i++):
        if(is_array($trans_text[$i])):
            for ($j=0; $j < count($trans_text[$i]); $j++):
                ?>
                <p>
                    <?php echo $trans_text[$i][$j]; ?>
                </p>
                <?php
            endfor;
        else:
            ?>
            <p>
                <?php echo $trans_text[$i]; ?>
            </p>
            <?php
        endif;
        if($trans_img[$i]):
        ?>
        <span style="display: inline-block; position: relative;">
            <img src="<?php echo $trans_img[$i] == $img[$i] ? $image_location.$trans_img[$i] : $trans_img[$i]; ?>">
        </span><br>
        <?php
        endif;
    endfor;
endif;
?> 