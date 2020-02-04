<?php
include "connect.php";
$id=$_GET["id"];
mysqli_query($link,"update entitydetails set status='yes' where edid=$id");
?>
<script type="text/javascript">
window.location="adminrecords.php";
</script>
