<?php
 $python="python";
 $ai="pytest.py";
 $cty=0;
 $lbl=0;
 $cmd=$python." ".$ai." ".$cty." ".$lbl." 2>&1";
 $out=null;
 $res=null;
 exec($cmd,$out,$res);
 dd($out);
 print_r($cmd);
 print_r($out);
 print_r($res);
?>