<?php

echo !defined('security') ? die() : null;

$cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum = :d");

$cat->execute([
    ':d' => 1
]);

?>

<div class="col-lg-3 order-2 order-lg-1">
    <!-- Widget-Search start -->
    <form action="<?php echo site; ?>/search.php" method="GET">

        <aside class="widget widget-search mb-30">
            <input type="text" placeholder="Ürün arama " name="q" />
            <button type="submit">
                <i class="zmdi zmdi-search"></i>
            </button>
        </aside>

        <aside class="widget widget-categories  mb-30">
            <div class="widget-title">

                <h4>Kategoriler(<?php echo $cat->rowCount(); ?>)</h4>
            </div>
            <div id="cat-treeview" class="widget-info product-cat boxscrol2">
                <ul>
                    <?php

                    if ($cat->rowCount()) {
                        foreach ($cat as $ca) {

                            echo
                            '<li><a href="category/' . $ca['katsef'] . '"<span> <input type="radio" name="kat" value="' . $ca['id'] . '" />' . $ca['katbaslik'] . '</span></a></li>';
                        }
                    }

                    ?>
                </ul>
            </div>
        </aside>

        <aside class="widget shop-filter mb-30">
            <div class="widget-title">
                <h4>Fiyat</h4>
            </div>
            <div class="widget-info">
                <div class="price_filter">
                    <div class="price_slider_amount">

                        <input type="text" name="price1" placeholder="Min Fiyat" />
                        <input type="text" name="price2" placeholder="Max Fiyat" />
                    </div>

                </div>
            </div>

            <div class="widget-info">
                <div class="price_filter">
                    <div class="price_slider_amount">
                        <button type="submit" class="button-one submit-button mt-15"> Filtre Uygula </button>

                    </div>

                </div>
            </div>
        </aside>
    </form>


</div>