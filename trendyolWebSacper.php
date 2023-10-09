<!DOCTYPE html>
<html>
<?php
$data = file_get_contents("https://www.trendyol.com/kadin-gomlek-x-g1-c75?pi=4");
preg_match_all('@p-card-chldrn-cntnr card-border">(.*?)<a href="/(.*?)"@si', $data, $link);

$price = 0;
$say = count($link[2]);
?>
<table>
    <tr>
        <th>№</th>
        <th>Description</th>
        <th>Price</th>
        <!-- <th>Sale</th> -->
        <th>İmage</th>
    </tr>
    <?php
    for ($i = 0; $i < $say; $i++) {

        $go = "https://www.trendyol.com/" . $link[2][$i];

        $nData = file_get_contents($go);
        preg_match_all('@<h1 class="pr-new-br" data-drroot="h1">(.*?)</h1>@si', $nData, $title);
        $titStr = implode(" ", $title[1]);
    ?>
        <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo $titStr; //print_r($title[1]); 
                ?></td>
            <?php

            preg_match_all('@<div class="product-price-container">(.*?)(.*?)(.*?)</div>@si', $nData, $price);
            $prStr = implode(" ", $price[0]);
            $pri = strip_tags($prStr);

            if (strlen($pri) == 0) {
                preg_match_all('@<div class="featured-prices">(.*?)(.*?)</div>@si', $nData, $price);
                $prStr = implode(" ", $price[0]);
                $pri = strip_tags($prStr);
            }
            ?>
            <td><?php echo $prStr;
                // print_r($price[0]);
                ?></td>
            <?php $path = "/product/media/images/";
            preg_match_all('/src="(.*?)"/', $nData, $image);
            foreach ($image[1] as $items) {
                // echo $items;
                $ext = pathinfo($items, PATHINFO_EXTENSION);
                if (strpos($items, $path)) {
                    if ($ext == 'jpg') {
            ?>
                        <td><?php echo '<img width = "200" src ="' . $items . '"><br>'; ?></td>
        </tr>
<?php break;
                        // echo $items.'<br>';
                    }
                }
            }
        } ?>

</table>