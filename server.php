<?php
if(rand(0, 10000) < 200){
	echo "Service Execution Requested from Server";
}
if(rand(0, 10000) > 9800){
	echo "Data Transferring...";
}
if(rand(10000, 20000) > 19800){
	echo "Communicating...";
}
?>