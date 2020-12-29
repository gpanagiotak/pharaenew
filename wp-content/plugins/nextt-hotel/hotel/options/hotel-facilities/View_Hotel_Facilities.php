<div class="wrap">

    <h2>Hotel Facilities</h2>

    <form method="POST" action="">

        <?php foreach(Hotel_Facilities::$view['display'] as $key=>$facility): ?>
                <p class="description" style="display: inline-block;min-width: 300px">
                    <label for="<?= $facility['key']?>" style="display:block; padding: 20px">

                        <input id="<?= $facility['key']?>" type="checkbox" name="<?= $facility['key']?>"
                           value="checked" <?php if(isset(Hotel_Facilities::$view['has'][$key]['check'])) echo Hotel_Facilities::$view['has'][$key]['check']?>>

                     <span class="hotel_icon <?=$facility['class']?>"></span> <?= $facility['text'] ?> </label>
                </p>
        <?php endforeach; ?>

        <p>
            <input name="save_hotel_facilities" type="submit" value="Save settings" class="button-primary"/>
        </p>
    </form>

</div>
