<?php
  $arr = array();
  $r = array("id"=>1, "name"=>"Product1");
  $arr[] = $r;
  $r = array("id"=>2, "name"=>"Product2");
  $arr[] = $r;
  $r = array("id"=>3, "name"=>"Product3");
  $arr[] = $r;
  $r = array("id"=>4, "name"=>"Product4");
  $arr[] = $r;
    foreach($arr as $r) {
        ?>
        <a href ="lab5_4_1_2.php?id=<?php echo $r["id"] ?>">
        <?php echo $r["name"] ?></a>    
        <br />
        <?php
    }
?>