<?php
/* Set Connection Credentials */
$serverName="analyticscanvas.ckqrrmykmc4m.us-west-2.rds.amazonaws.com,1433";
$uid = "crosby";
$pwd = "bouncex2015";
$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>"",
                         "CharacterSet"=>"UTF-8");
 
/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
 
if( $conn === false ) {
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}
 
/* TSQL Query */
$tsql = "SELECT TOP 100 * FROM d3data.dbo.yearendaggregate";
$stmt = sqlsrv_query( $conn, $tsql);
 
if( $stmt === false ) {
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}
 
/* Process results */
$json = array();
 
do {
     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
     $json[] = $row;
     }
} while ( sqlsrv_next_result($stmt) );
 
/* Run the tabular results through json_encode() */
/* And ensure numbers don't get cast to trings */
echo json_encode($json,<code> JSON_NUMERIC_CHECK</code>);
/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
 
?>