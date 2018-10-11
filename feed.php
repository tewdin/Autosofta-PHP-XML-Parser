<?php
$path = "/www/tmp/xml_name.php";
$xml = simplexml_load_file($path,'SimpleXMLElement', LIBXML_NOCDATA);
$cars = array();

foreach ($xml->Vehicle as $item) {

    $title = $item->Make ." ". $item->Model ." ". $item->BodyType ." ". $item->EngineModel . " " . $item->YearModel;
    $price = intval($item->Price);
    $price = number_format($price, 0, '.', ' ');
    $mileage = intval($item->Mileage);
    $mileage = number_format($mileage, 0, '.', ' ');
    $carid = (int)$item->Id;
    
    $img = $item->Images;
    $img = $img[0];
    $img = str_replace(' ', '', $img);
    $img = explode(',', $img);

    $year = "$item->YearModel";
    $inspected = "$item->Inspected";
    $transmission = "$item->Transmission";
    $color = $item->Color.", ".$item->ColorType;
    $fuel = "$item->FuelType";
    $type = "$item->VehicleType";
    $driver = "$item->DriverType";
    $cylinder = "$item->CylinderVol";
    $economy = "$item->EuEconomy_combined";
    $power = "$item->PowerKw";
    $co2 = "$item->Emission_co2";
    $doors = "$item->NumOfDoor";
    $seats = "$item->NumOfSeats";
    $body = "$item->Accessories";
    $body = str_replace(',',', ',$body);
    
    $car = array($carid, $title, $price, $img, $year, $inspected, $mileage, $transmission, $color, $fuel, $type, $driver, $cylinder, $economy, $power, $co2, $doors, $seats, $body);

    if(!in_array($cars, $car)){ $cars[] = $car; }

    if($page->id == 1){
?>

<a class="auto" href="/haku/?auto=<?php echo $carid; ?>"><div class="img" style="background: url('<?php echo $img[0]; ?>') no-repeat center center / cover"></div><h3><?php echo $title; ?></h3><div class="hinta"><?php echo $price; ?> €</div></a>

<?php }}
// ProcessWire's session
$session->cars = array();
$session->cars = $cars;

if($input->get->auto AND $page->id == 25487){

    $car = (int)$input->get->auto;
    foreach($cars as $item){
        if($item[0] == $car){
            // Keep track about the cars you have watched before
            $session->recent[] = $car;
            $title = $item[1];
?>

<div id="auto" class="autot"><div class="container">

<div id="back"><a href="/#autot">&laquo; Takaisin vaihtoautoihin</a></div>
<h1><?php echo $title; ?></h1>
<div id="pics" class="left gallery">

<?php
$i=1;
foreach($item[3] as $img){
    echo "<a class='";
    if($i == 1){ echo "first "; }
    echo "id$i' href='$img'><img src='$img' alt='$title'/></a>"; 
    $i++;
}
?>

</div>

<div id="info" class="right">
    <table>
        <tr><td>Vuosimalli:</td><td><?php echo $item[4]; ?></td></tr>
        <tr><td>Katsastettu:</td><td><?php echo $item[5]; ?></td></tr>
        <tr><td>Mittarilukema:</td><td><?php echo $item[6]; ?> km</td></tr>
        <tr><td>Hinta:</td><td><?php echo $item[2]; ?> €</td></tr>
        <tr><td>Vaihteisto:</td><td><?php echo $item[7]; ?></td></tr>
        <tr><td>Väri:</td><td><?php echo $item[8]; ?></td></tr>
        <tr><td>Polttoaine:</td><td><?php echo $item[9]; ?></td></tr>
        <tr><td>Tyyppi:</td><td><?php echo $item[10]; ?></td></tr>
        <tr><td>Vetotapa:</td><td><?php echo $item[11]; ?></td></tr>
        <tr><td>Sylinteritilavuus:</td><td><?php echo $item[12]; ?></td></tr>
        <tr><td>Eko:</td><td><?php echo $item[13]; ?></td></tr>
        <tr><td>Teho:</td><td><?php echo $item[14]; ?> Kw</td></tr>
        <tr><td>Päästöt:</td><td><?php echo $item[15]; ?> co2</td></tr>
        <tr><td>Ovien määrä:</td><td><?php echo $item[16]; ?></td></tr>
        <tr><td>Penkkien määrä:</td><td><?php echo $item[17]; ?></td></tr>
    </table>
</div>
<div class="clear"></div>

<div class="left">

<div id="accessories"><h2>Lisävarusteet</h2><?php echo $item[18]; ?></div>

</div>

<div class="right"><?php include('_form.php'); ?></div>

<div class="clear"></div><div id="share"></div>

</div></div>

<?php }}} ?>
