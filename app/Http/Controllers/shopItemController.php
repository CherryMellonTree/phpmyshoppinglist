<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\shopItem;
use App\Models\shop;
use \Datetime;
class shopItemController extends Controller
{
    private function extrajunk(){
        $style = "<style>
        #myTable2 {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        #myTable2 td, #myTable2 th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        #myTable2 tr:nth-child(even){background-color: #f2f2f2;}
        #myTable2 tr:hover {background-color: #ddd;}
        #myTable2 th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #965626;
          color: white;
        }
        </style>";
        $test = "<script>function sortTable(n) {  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;  table = document.getElementById(\"myTable2\");  switching = true;  dir = \"asc\";  while (switching) {    switching = false;    rows = table.rows;    for (i = 1; i < (rows.length - 1); i++) {      shouldSwitch = false;      x = rows[i].getElementsByTagName(\"TD\")[n];      y = rows[i + 1].getElementsByTagName(\"TD\")[n];      if (dir == \"asc\") {        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {          shouldSwitch = true;          break;        }      } else if (dir == \"desc\") {        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {          shouldSwitch = true;          break;        }      }    }    if (shouldSwitch) {      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);      switching = true;      switchcount ++;    } else {      if (switchcount == 0 && dir == \"asc\") {        dir = \"desc\";        switching = true;      }    }  }}</script>";
        return $test.$style;
    }

    //API calls
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return shopItem::all();

    }
    public function getallshops()
    {
        // echo url()->current();
        return shop::all();
    }
    
    //webpage calls
    public function getitemsoneshop($shopid){
        $all = shopItem::all();
        echo $this->extrajunk();
        echo "<h1> Item list </h1>";
        echo "<div> This is a list of all the items you are looking to buy from ".shop::find($shopid)['shopName']." : </div>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">item name</th><th onclick=\"sortTable(2)\">item due date</th><th onclick=\"sortTable(3)\"> number needed </th><th onclick=\"sortTable(4)\"> pref shop name</th><th onclick=\"sortTable(5)\"> distance to shop</th><th onclick=\"sortTable(6)\"> previous visit </th></tr>";
        foreach($all as $row) {
            if ($row['itemPreferedStoreID'] == $shopid){
                $currentShop = shop::find($row['itemPreferedStoreID']);
                echo "<tr><td>".str_pad($row['id'], 3, '0', STR_PAD_LEFT)."</td><td>".$row['itemName']."</td><td>".date('d/m',strtotime($row['itemDueDate']))."</td><td>".str_pad($row["numberNeeded"], 2, '0', STR_PAD_LEFT)."</td><td>".$currentShop['shopName']."</td><td>".$currentShop['shopDistance']." km</td><td>".date('d/m',strtotime($currentShop['lastVisit']))."</td></tr>";
            }
        }
        echo "</table>";
    }
    public function getallitems(){
        $all = shopItem::all();
        echo $this->extrajunk();
        echo "<h1> Item list </h1>";
        echo "<div> This is a list of all the items you are looking to buy: </div>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">item name</th><th onclick=\"sortTable(2)\">item due date</th><th onclick=\"sortTable(3)\"> number needed </th><th onclick=\"sortTable(4)\"> pref shop name</th><th onclick=\"sortTable(5)\"> distance to shop</th><th onclick=\"sortTable(6)\"> previous visit </th></tr>";
        foreach($all as $row) {
            $currentShop = shop::find($row['itemPreferedStoreID']);
            // echo $currentShop;
            // echo $row;
            echo "<tr><td>".str_pad($row['id'], 3, '0', STR_PAD_LEFT)."</td><td>".$row['itemName']."</td><td>".date('d/m',strtotime($row['itemDueDate']))."</td><td>".str_pad($row["numberNeeded"], 2, '0', STR_PAD_LEFT)."</td><td>".$currentShop['shopName']."</td><td>".$currentShop['shopDistance']." km</td><td>".date('d/m',strtotime($currentShop['lastVisit']))."</td></tr>";
            // echo $row['id'];
            // echo "</br>".$row['itemName'];
            // echo "</br>".$row['itemDueDate'];
            // echo "</br>".$row["numberNeeded"];
            // echo "</br>".$currentShop['shopName'];
            // echo "</br>".$currentShop['shopDistance'];
            // echo "</br>".$currentShop['lastVisit'];
        }
        echo "</table>";
    }
    public function showshops(){
        $all = shop::all();
        echo $this->extrajunk();
        echo "<h1> Shop list </h1>";
        echo "<div> This is a list of all the shops registered so far: </div>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">Name</th><th onclick=\"sortTable(2)\">Distance</th><th onclick=\"sortTable(3)\">last visit</th></tr>";
        foreach($all as $row) {
                echo "<tr><td>".str_pad($row['id'], 2, '0', STR_PAD_LEFT)."</td><td> <a href=\"".substr($_SERVER['REQUEST_URI'], 0,0 )."/items/".$row['id']."\">".$row['shopName']."</a></td><td>".$row['shopDistance']."</td><td>".date('d/m',strtotime($row['lastVisit']))."</td></tr>";
        }
    }

    public function additems(){
        $form = "
        <h1>Add new elements to the database</h1>
        <h2>New Shops </h2>
        <form action=\"add/item\" method=\"post\">
        <label for=\"shopname\">Name:</label><br>
        <input type=\"text\" id=\"shopname\" name=\"shopname\" value=\"scam.io\"><br>
        <label for=\"distance\">Shop Distance:</label><br>
        <input type=\"number\" step=\"0.01\" id=\"distance\" name=\"distance\" value=\"0\"><br>
        <label for=\"lastvisit\">Most recent visit:</label><br>
        <input type=\"date\" id=\"lastvisit\" name=\"lastvisit\"><br><br>
        <input type=\"submit\" value=\"Submit\">
      </form> 
      
      <p>You can use this form to create new items for your shoppinglist.</p>";
      echo $form;
    }
    public function additemswithparams(Request $request){
        DB::table('shops')->insert([
            'shopname' => $request['shopname'],
            'shopDistance' => $request['distance'],
            'lastVisit' => DateTime::createFromFormat('Y-m-d',$request['lastvisit'])->format(DateTime::ATOM)
        ]);
        echo "<h2>You successfully created a new shop called ".$request['shopname'].".</h2></br>";
        echo "<a href=\"../additems\">Return to the add items page. </a>";
    }
    // Autogenerated & unused
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
