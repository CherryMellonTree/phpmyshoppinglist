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
        form{
            float:left;
            padding:20px;
            height:450;
            background-color:#f1f1f1;
            width:47%;
        }
        label{
            padding:10px;

        }
        input{
            padding: 5px;
            margin-bottom: 6px;
            border-radius:10px;
        }
        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        footer, h1 {
            background-color: #777;
            padding: 10px;
            text-align: center;
            color: white;
        }
        h2{
            background-color: #666;
            padding: 10px;
            text-align: center;
            color: white;
        }
        .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
          }
          
          .button:hover {background-color: #3e8e41}
          
          .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
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
        echo "<footer> This is a list of all the items you are looking to buy from ".shop::find($shopid)['shopName']." : </footer>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">item name</th><th onclick=\"sortTable(2)\">item due date</th><th onclick=\"sortTable(3)\"> number needed </th><th onclick=\"sortTable(4)\">price</th><th onclick=\"sortTable(5)\"> pref shop name</th><th onclick=\"sortTable(6)\"> distance to shop </th><th onclick=\"sortTable(7)\"> previous visit </th></tr>";
        foreach($all as $row) {
            if ($row['itemPreferedStoreID'] == $shopid){
                $currentShop = shop::find($row['itemPreferedStoreID']);
                echo "<tr><td>".str_pad($row['id'], 3, '0', STR_PAD_LEFT)."</td><td>".$row['itemName']."</td><td>".date('d/m',strtotime($row['itemDueDate']))."</td><td>".str_pad($row["numberNeeded"], 2, '0', STR_PAD_LEFT)."</td><td>".str_pad($row["price"], 5, '0', STR_PAD_LEFT)."€</td><td>".$currentShop['shopName']."</td><td>".$currentShop['shopDistance']." km</td><td>".date('d/m',strtotime($currentShop['lastVisit']))."</td></tr>";
            }
        }
        echo "</table>";
    }
    public function getallitems(){
        $all = shopItem::all();
        echo $this->extrajunk();
        echo "<h1> Item list </h1>";
        echo "<footer> This is a list of all the items you are looking to buy: </footer>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">item name</th><th onclick=\"sortTable(2)\">item due date</th><th onclick=\"sortTable(3)\"> number needed </th><th onclick=\"sortTable(4)\">price</th><th onclick=\"sortTable(5)\"> pref shop name</th><th onclick=\"sortTable(6)\"> distance to shop </th><th onclick=\"sortTable(7)\"> previous visit </th></tr>";
        foreach($all as $row) {
            $currentShop = shop::find($row['itemPreferedStoreID']);
            // echo $currentShop;
            // echo $row;
            echo "<tr><td>".str_pad($row['id'], 3, '0', STR_PAD_LEFT)."</td><td>".$row['itemName']."</td><td>".date('d/m',strtotime($row['itemDueDate']))."</td><td>".str_pad($row["numberNeeded"], 2, '0', STR_PAD_LEFT)."</td><td>".str_pad($row["price"], 5, '0', STR_PAD_LEFT)."€</td><td>".$currentShop['shopName']."</td><td>".$currentShop['shopDistance']." km</td><td>".date('d/m',strtotime($currentShop['lastVisit']))."</td></tr>";
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
        echo "<footer> This is a list of all the shops registered so far: </footer>";
        echo "<table id=\"myTable2\">";
        echo "<tr><th onclick=\"sortTable(0)\">ID</th><th onclick=\"sortTable(1)\">Name</th><th onclick=\"sortTable(2)\">Distance</th><th onclick=\"sortTable(3)\">last visit</th><th onclick=\"sortTable(4)\">items needed</th></tr>";
        foreach($all as $row) {
                $count = count(shopItem::all()->where('itemPreferedStoreID', $row['id']));
                echo "<tr><td>".str_pad($row['id'], 2, '0', STR_PAD_LEFT)."</td><td> <a href=\"".substr($_SERVER['REQUEST_URI'], 0,0 )."/items/".$row['id']."\">".$row['shopName']."</a></td><td>".$row['shopDistance']."</td><td>".date('d/m',strtotime($row['lastVisit']))."</td><td>".$count."</td></tr>";
        }
    }

    public function additemsandshops(){
        echo $this->extrajunk();
        $all = shop::all();
        $shoplist ="<p> Prefered Store</p>";
        foreach($all as $row){
            $shoplist = $shoplist."<input type=\"radio\" id=\"".$row["id"]."\" name=\"shop\" value=\"".$row['id']."\"><label for=\"".$row["id"]."\">".$row['shopName']."</label>";
        };
        $shoplist = $shoplist."</br>";
        $form = "
        <h1>Add new elements to the database</h1>
        <form action=\"api/add/shop\" method=\"post\">
        <h2>New Shops </h2>
        </br>
        <label for=\"shopname\">Name:</label><br>
        <input type=\"text\" id=\"shopname\" name=\"shopname\" value=\"scam.io\"><br>
        </br>
        <label for=\"distance\">Shop Distance:</label><br>
        <input type=\"number\" step=\"0.01\" id=\"distance\" name=\"distance\" value=\"0\"><br>
        </br>
        <label for=\"lastvisit\">Most recent visit:</label><br>
        <input type=\"date\" id=\"lastvisit\" name=\"lastvisit\"><br><br>
        <input type=\"submit\" value=\"Submit\">
        </form> 
        <form action=\"api/add/item\" method=\"post\">
        <h2>New Items </h2>
        <label for=\"itemName\">Name:</label><br>
        <input type=\"text\" id=\"itemName\" name=\"itemName\" value=\"A smoothie\"><br>
        <label for=\"price\">Price:</label><br>
        <input type=\"number\" step=\"0.01\" id=\"price\" name=\"price\" value=\"0.5\"><br>
        <label for=\"numberNeeded\">Number needed:</label><br>
        <input type=\"number\" step=\"1\" id=\"numberNeeded\" name=\"numberNeeded\" value=\"3\"><br>".
        $shoplist
        ."<label for=\"itemDueDate\">Due date:</label><br>
        <input type=\"date\" id=\"itemDueDate\" name=\"itemDueDate\"><br><br>
        <input type=\"submit\" value=\"Submit\">
        </form> 
        <fill></fill>
      <footer><p>You can use this form to create new items for your shoppinglist.</p></footer>";
      echo $form;
    }
    public function additemswithparams(Request $request){
        echo $this->extrajunk();
        DB::table('shop_items')->insert([
            'itemName' => $request['itemName'],
            'itemDueDate' => DateTime::createFromFormat('Y-m-d',$request['itemDueDate'])->format(DateTime::ATOM),
            'itemPreferedStoreID' => $request['shop'],
            'price' => $request['price'],
            'numberNeeded' => $request['numberNeeded'],
        ]);
        echo "<h2>You successfully created a new item called ".$request['itemName'].".</h2></br>";
        echo "<button class=\"button\"><a href=\"../../additems\">Return to the add items page.</a> </button>";
    }
    public function addshopwithparams(Request $request){
        echo $this->extrajunk();
        DB::table('shops')->insert([
            'shopname' => $request['shopname'],
            'shopDistance' => $request['distance'],
            'lastVisit' => DateTime::createFromFormat('Y-m-d',$request['lastvisit'])->format(DateTime::ATOM)
        ]);
        echo "<h2>You successfully created a new shop called ".$request['shopname'].".</h2></br>";
        echo "<button class=\"button\"><a href=\"../../additems\">Return to the add items page.</a> </button>";
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
