<?php
session_start();
if($_SESSION['autorizado']<>1){
    header("Location: index.php");
}
error_reporting(0);
require('class_lib/funciones.php');
if ($_SESSION['sucursal']=="1"){
  include('./class_lib/class_conecta_mysql.php');
  }
  if ($_SESSION['sucursal']=="2"){
  include('./class_lib/class_conecta_mysql2.php');
  }
  if ($_SESSION['sucursal']=="3"){
  include('./class_lib/class_conecta_mysql3.php');
  }


$db=conectar();
$set_names=$db->query("SET NAMES 'utf8'");
$codigo=$_POST['codigo'];
$id=$_POST['id'];
$cantidad=$_POST['cantidad'];
$precio=$_POST['precio'];
$descuento=$_POST['descuento'];
$total=$_POST['total'];
$factura=$_POST['factura'];


/*
$revisa = "Select * from detalle_coti where id= :iddd";
$resultadorevisa=$db->prepare($revisa);
$resultadorevisa->bindParam(":iddd",$id);
$resultadorevisa->execute();	
foreach ($resultadorevisa as $key =>$condi){
$metros=$condi['metros'];
}*/

//$total=0.00;
//$total=($nuevoprecio)*($cantidad*$metros);

$update = "Update detalle_coti set descuento= :descuento, precio= :precio, total= :total where id= :buscar";
$upd=$db->prepare($update);
$upd->execute(array(":descuento"=>$descuento,":precio"=>$precio, ":total"=>$total, ":buscar"=>$id));



$totalnuevo2=0;
$querytotal2 = "select * from detalle_coti where factura= :cod";
$resultadototal2=$db->prepare($querytotal2);
$rows = $resultadototal2->fetchAll(/* nothing here */);
if(!isset($rows[0]->total)){
      $resultadototal2->bindParam(":cod",$factura);	
      $resultadototal2->execute();
	  foreach ($resultadototal2 as $key =>$total2){
      $totalnuevo2+=$total2['total'];
      }
    }else{
   echo "0";
 }


$query4="Update coti set total=? where factura=?";
$resultado4=$db->prepare($query4);
$resultado4->bindParam(1,$totalnuevo2);	
$resultado4->bindParam(2,$factura);	
$resultado4->execute();	







?>
 