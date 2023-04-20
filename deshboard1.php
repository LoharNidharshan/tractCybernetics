<?php
session_start();

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
// Connect to database
$db = mysqli_connect('localhost', 'root', 'root', 'jfsa');

// Retrieve user details from database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

// Display user details on home page
// echo "Welcome back, " . $user['username'] . "! Your email is: " . $user['email'] . ".";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DPS</title>

  <!-- BOOTSTRAP only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

  <!-- jquery -->
  <script src="libs/jquery.js"></script>
  <link rel="stylesheet" href="libs/jquery-ui-1.12.1/jquery-ui.css">
  <script src="libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
  <script src="libs/jquery-ui-1.12.1/jquery-ui.js"></script>

  <!-- Leaflet -->

  <link rel="stylesheet" href="libs/leaflet/leaflet.css" />
  <script src="libs/leaflet/leaflet.js"></script>

  <!-- ZoomBar & slider-->
  <script src="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.js"></script>
  <link rel="stylesheet" href="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.css" />
  <script src="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.js"></script>
  <link rel="stylesheet" href="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.css" />

  <!-- MousePosition -->
  <script src="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.js"></script>
  <link rel="stylesheet" href="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" />

  <!-- line-measure -->
  <link rel="stylesheet" href="libs/polyline-measure/line-measure.css" />
  <script src="libs/polyline-measure/line-measure.js"></script>
  <link rel="stylesheet" href="libs/leaflet-measure-master/leaflet-measure.css" />
  <script src="libs/leaflet-measure-master/leaflet-measure.js"></script>
  <script src="libs/feat.js"></script>


  <!-- draw -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>



  <!-- github -->
  <script src="https://kartena.github.io/Proj4Leaflet/lib/proj4-compressed.js"></script>
  <script src="https://kartena.github.io/Proj4Leaflet/src/proj4leaflet.js"></script>



  <!-- legend -->

  <link rel="stylesheet" href="libs/leaflet-wms-legend/leaflet.wmslegend.css" />
  <script src="libs/leaflet-wms-legend/leaflet.wmslegend.js"></script>


  <!-- csslink -->
  <link rel="stylesheet" href="style5.css">



  <!-- html2pdfcdn -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script> -->

  <script src="libs/leaflet-image.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

  <!-- fontawsome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

  <!-- json -->

  <script>
    $(function () {
      var availableTags = ['Pimpalgaon Tarf Khed,Khed', 'Rohakal,Khed', 'Kanersar,Khed', 'Chinchoshi,Khed', 'Sabalewadi,Khed', 'Sidhegavhan,Khed', 'Torne Bk,Khed', 'Hedruj,Khed', 'Davadi,Khed', 'Nimgaon,Khed', 'Kadus,Khed', 'Talawade,Khed', 'Kohinde Bk.,Khed', 'Bahirwadi,Khed', 'Pangari,Khed', 'Pait,Khed', 'Shelu,Khed', 'Koregaon Kh,Khed', 'Koregaon bk,Khed', 'Chandus,Khed', 'Retavadi,Khed', 'Kharpudi Bk,Khed', 'Pimpari Bk,Khed', 'Kharpudi Kh,Khed', 'Kalewadi,Khed', 'Padali,Khed', 'Koye,Khed', 'Gosasi,Khed', 'Vadgaon Ghenand,Khed', 'Manjarewadi,Khed', 'Kurkundi,Khed', 'Raundhalwadi,Khed', 'Kalus,Khed', 'Shive,Khed', 'Gargotiwadi,Khed', 'Kiwale,Khed', 'Jaidwadi,Khed', 'Khalchi Bhamburwadi,Khed', 'Arudewadi,Khed', 'Kohinkarwadi,Khed', 'Gulani,Khed', 'Pur,Khed', 'Jaulke Kh.,Khed', 'Waki BK,Khed', 'Ahire,Khed', 'Dhamane,Khed', 'Askhed Bk,Khed', 'Kaman,Khed', 'Chas,Khed', 'Papalwadi,Khed', 'Mirajewadi,Khed', 'Wakalwadi,Khed', 'Takalkarwadi,Khed', 'Donde,Khed', 'Wahagaon,Khed', 'Karanj Vihire,Khed', 'Koyali Tarf Chakan,Khed', 'Akharwadi,Khed', 'Jaulke Bk.,Khed', 'Vaphgaon,Khed', 'Chichbaiwadi,Khed', 'Gadakwadi,Khed', 'Chaudharwadi,Khed', 'Warude,Khed', 'Butewadi,Khed', 'Waki Tarf Wada,Khed', 'Gonvadi,Khed', 'Pimpari Kh.,Khed', 'Bahul,Khed', 'Chakan,Khed', 'Rajgurunagar,Khed', 'Shelgaon,Khed', 'Askhed Kh,Khed', 'Parale,Khed', 'Malkhed,Haveli', 'Bakori,Haveli', 'Gogalwadi,Haveli', 'Kondhanpur,Haveli', 'Mandavi Kh,Haveli', 'Mandavi Bk.,Haveli', 'Khadakwadi,Haveli', 'Aambi,Haveli', 'Alandi Mhatobachi,Haveli', 'Walati,Haveli', 'Manerwadi,Haveli', 'Tikekarwadi,Haveli', 'Khanapur,Haveli', 'Sashte,Haveli', 'Tarade,Haveli', 'Dongargaon,Haveli', 'Thoptewadi,Haveli', 'Gorhe Kh.,Haveli', 'Dehu,Haveli', 'Malinagar,Haveli', 'Vitthal Nagar,Haveli', 'Gorhe Bk.,Haveli', 'Bivari,Haveli', 'Sangarun,Haveli', 'Agalambe,Haveli', 'Arvi,Haveli', 'Pimpri Tarf Sandas,Haveli', 'Sangavi Tarf Sandas,Haveli', 'Jambhali,Haveli', 'Ashtapur,Haveli', 'Bhagatwadi,Haveli', 'Gaud Dara,Haveli', 'Wade Bolhai,Haveli', 'Shindwane,Haveli', 'Kalyan,Haveli', 'Ghera Sinhgad,Haveli', 'Kudaje,Haveli', 'Donaje,Haveli', 'Wanjalewadi,Haveli', 'Burkegaon,Haveli', 'Nhavi Sandas,Haveli', 'Shindewadi,Haveli', 'Gawadewadi,Haveli', 'Murkutenagar,Haveli', 'Khamgaon Tek,Haveli', 'Ramoshiwadi,Haveli', 'Mokarwadi,Haveli', 'Khadewadi,Haveli', 'Bahuli,Haveli', 'Tanaji Nagar,Haveli', 'Sonapur,Haveli', 'Vardare,Haveli', 'Sambharewadi,Haveli', 'Khamgaon Mawal,Haveli', 'Mogarwadi,Haveli', 'Mordarwadi,Haveli', 'Avasare,Haveli', 'Rahatvade,Haveli', 'Hingangaon,Haveli', 'Shiraswadi,Haveli', 'Katavi,Mawal', 'Kale,Mawal', 'Prabhachiwadi,Mawal', 'Yelse,Mawal', 'Ardav (Adavi),Mawal', 'Kadadhe,Mawal', 'Nane,Mawal', 'Tung,Mawal', 'Tikona,Mawal', 'Chavsar,Mawal', 'Boravli,Mawal', 'Inglun,Mawal', 'Khand,Mawal', 'Kolechafesar,Mawal', 'Kusur,Mawal', 'Morave,Mawal', 'Pimpriwadi,Mawal', 'Shivali,Mawal', 'Thoran,Mawal', 'Ukasan,Mawal', 'Vadeshwar,Mawal', 'Kusgaon P.m.,Mawal', 'Takave Bk.,Mawal', 'Shevati,Mawal', 'Pansoli,Mawal', 'Atvan,Mawal', 'Malegao Bk.,Mawal', 'Apati,Mawal', 'Bhajgaon,Mawal', 'Bhoyre,Mawal', 'Divad,Mawal', 'Govitri,Mawal', 'Jovan,Mawal', 'Kondiwade,Mawal', 'Pachane,Mawal', 'Pale,Mawal', 'Udhewadi,Mawal', 'Vadavali,Mawal', 'Pangloli,Mawal', 'Karandoli,Mawal', 'Dhaiwali,Mawal', 'Shilatane,Mawal', 'Takave Kh.,Mawal', 'Rajpuri,Mawal', 'Kurvande,Mawal', 'Lonawale,Mawal', 'Malavandi Thule,Mawal', 'Ambegaon,Mawal', 'Kunewadi,Mawal', 'Dahuli,Mawal', 'Mangarul,Mawal', 'Somwadi,Mawal', 'Kondivade N.m,Mawal', 'Dudhivare,Mawal', 'Vagheshwar,Mawal', 'Shilimb,Mawal', 'Sawale,Mawal', 'Pusane,Mawal', 'Malegao Kh,Mawal', 'Ajivali,Mawal', 'Valakh,Mawal', 'Sawantwadi,Mawal', 'Malewadi,Mawal', 'Mahagaon,Mawal', 'Lohagad,Mawal', 'Kambare N.m.,Mawal', 'Dhalewadi,Mawal', 'Budhavadi,Mawal', 'Gevhandhe,Mawal', 'Nagatali,Mawal', 'Rakaswadi,Mawal', 'Kusavali,Mawal', 'Wahangao,Mawal', 'Kiwale,Mawal', 'Shirdhe,Mawal', 'Jamboli,Mawal', 'Nandgaon,Mawal', 'Shindgaon,Mawal', 'Kambare Andar,Mawal', 'Kashal,Mawal', 'Khandashi,Mawal', 'Nesave,Mawal', 'Valavanti,Mawal', 'Dhangavhan,Mawal', 'Ovale,Mawal', 'Yelghol,Mawal', 'Velholi,Mawal', 'Karanjgaon,Mawal', 'Sangise,Mawal', 'Pale Nane Mawal,Mawal', 'Mormarwadi,Mawal', 'Mau,Mawal', 'Kacharewadi,Mawal', 'Vaund,Mawal', 'Brahmanwadi,Mawal', 'Done,Mawal', 'Kothurne,Mawal', 'Shire,Mawal', 'Belaj,Mawal', 'Jeware,Mawal', 'Vehergaon,Mawal', 'Budhle N.M.,Mawal', 'Vadivale,Mawal', 'Adhale bk,Mawal', 'Adhale kh.,Mawal', 'Shivane,Mawal', 'Phalne,Mawal', 'Ghonshet,Mawal', 'Sai,Mawal', 'Bhadawali,Mawal', 'Majgaon,Mawal', 'Pimpal Khunte,Mawal', 'Malawali P.m.,Mawal', 'Bedse,Mawal', 'Thugaon,Mawal', 'Varu,Mawal', 'Phagane,Mawal', 'Kadav,Mawal', 'Gevhande Khadak,Mawal', 'Keware,Mawal', 'Thakursai,Mawal', 'Brahmanoli,Mawal', 'Muthe,Mulshi', 'Padalgharwadi,Mulshi', 'Mugaon,Mulshi', 'Valane,Mulshi', 'Ugavali,Mulshi', 'Jawal,Mulshi', 'Ghutake,Mulshi', 'Ekole,Mulshi', 'Tailbaila,Mulshi', 'Bhambarde,Mulshi', 'Botarwadi,Mulshi', 'Chandivali,Mulshi', 'Andgaon,Mulshi', 'Dhamanohol,Mulshi', 'Koloshi,Mulshi', 'Sakhari,Mulshi', 'Kharavade,Mulshi', 'Pimploli,Mulshi', 'Masgaon,Mulshi', 'Wadavali,Mulshi', 'Admal,Mulshi', 'Bhembhatmal,Mulshi', 'Palase,Mulshi', 'Patharshet,Mulshi', 'Saiv Kh,Mulshi', 'Bhode,Mulshi', 'Mulshi Kh,Mulshi', 'Tata Talav,Mulshi', 'Karmoli,Mulshi', 'Shedani,Mulshi', 'Kolwan,Mulshi', 'Sathesai,Mulshi', 'Mugavde,Mulshi', 'Katavadi,Mulshi', 'Davje,Mulshi', 'Malegaon,Mulshi', 'Wanjale,Mulshi', 'Watunde,Mulshi', 'Vede,Mulshi', 'Mandede,Mulshi', 'Jatede,Mulshi', 'Kashing,Mulshi', 'Amaralewadi,Mulshi', 'Barape_Bk,Mulshi', 'Bhalgudi,Mulshi', 'Saltar,Mulshi', 'Shirvali,Mulshi', 'Nive,Mulshi', 'Andhale,Mulshi', 'Ambarwet,Mulshi', 'Vandre,Mulshi', 'Vadgaon,Mulshi', 'Pimpri,Mulshi', 'Rihe,Mulshi', 'Katarkhadak,Mulshi', 'Nandgaon,Mulshi', 'Padalghar,Mulshi', 'Mose Kh.,Mulshi', 'Dhadavali,Mulshi', 'Gadhale,Mulshi', 'Chinchwad,Mulshi', 'Kule,Mulshi', 'Hulavalewadi,Mulshi', 'Tamhini Bk,Mulshi', 'Warak,Mulshi', 'Vegre,Mulshi', 'Kolavade,Mulshi', 'Kondhur,Mulshi', 'Pethshahapur,Mulshi', 'Devghar,Mulshi', 'Ambavane,Mulshi', 'Kolavali,Mulshi', 'Pomgaon,Mulshi', 'Male,Mulshi', 'Kumbheri,Mulshi', 'Jamgaon,Mulshi', 'Share,Mulshi', 'Disali,Mulshi', 'Shileshwar,Mulshi', 'Bhadas Bk.,Mulshi', 'Gavadewadi,Mulshi', 'Dongrgaon,Mulshi', 'Hotale,Mulshi', 'Nanegaon,Mulshi', 'Asade,Mulshi', 'Chikhali Bk.,Mulshi', 'Belwade,Mulshi', 'Tav,Mulshi', 'Chale,Mulshi', 'Darawali (Dakhli),Mulshi', 'Morewadi,Mulshi', 'Bharekarwadi,Mulshi', 'Kasarsai,Mulshi', 'Visakhar,Mulshi', 'Walen,Mulshi', 'Hadasi,Mulshi', 'Kalamshet,Mulshi', 'Vitthalwadi,Mulshi', 'Andeshe,Mulshi', 'Khubawali,Mulshi', 'Temghar,Mulshi', 'Lavarde,Mulshi', 'Khechre,Mulshi', 'Marnewadi,Mulshi', 'Bhuini,Mulshi', 'Savargaon,Mulshi', 'Akole,Mulshi', 'Kondhavale,Mulshi', 'Paud,Mulshi', 'Dakhane,Mulshi', 'Sambhave,Mulshi', 'Khamboli,Mulshi', 'Kemasewadi,Mulshi', 'Adgaon,Mulshi', 'Chikhalgaon,Mulshi', 'Ravade,Mulshi', 'Nandivali,Mulshi', 'Dasave,Mulshi', 'Bhambavade,Bhor', 'Bhongavli,Bhor', 'Dhangavadi,Bhor', 'Gunand,Bhor', 'Kenjal,Bhor', 'Khadki,Bhor', 'Kikavi,Bhor', 'Morwadi,Bhor', 'Nhavi,Bhor', 'Nidhan,Bhor', 'Nigade,Bhor', 'Pande,Bhor', 'Panjalwadi,Bhor', 'Rajapur,Bhor', 'Sangavi Kh,Bhor', 'Sarole,Bhor', 'Savardare,Bhor', 'Taprewadi,Bhor', 'Umbare,Bhor', 'Vathar Kh,Bhor', 'Wagajwadi,Bhor', 'Degaon,Bhor', 'Didghar,Bhor', 'Jambhali,Bhor', 'Kambare,Bhor', 'Kanjale,Bhor', 'Karandi,Bhor', 'Ketkavane,Bhor', 'Khopi,Bhor', 'Kolavadi,Bhor', 'Kurungvadi,Bhor', 'Kusgaon,Bhor', 'Malegaon,Bhor', 'Parvadi,Bhor', 'Ranje,Bhor', 'Salavade,Bhor', 'Sangavi Bk,Bhor', 'Sonavadi,Bhor', 'Virwadi,Bhor', 'Tamhanwadi,Daund', 'Sahajpurwadi,Daund', 'Nandur,Daund', 'Dalimb,Daund', 'Takali,Daund', 'Vadgaon Bande,Daund', 'Koregaon Bhiwar,Daund', 'Telewadi,Daund', 'Panwali,Daund', 'Pilanwadi,Daund', 'Mirwadi,Daund', 'Dahitane,Daund', 'Devkarwadi,Daund', 'Boribhadak,Daund', 'Boriaindi,Daund', 'Boratewadi,Daund', 'Bharatgaon,Daund', 'Jawajebuwachiwadi,Daund', 'Kamatwadi,Daund', 'Kasurdi,Daund', 'Bhandgaon,Daund', 'Patethan,Daund', 'Tambewadi,Daund', 'Ladkatwadi,Daund', 'Khutbav,Daund', 'Pimpalgaon,Daund', 'Delvadi (Ekeriwadi),Daund', 'Undawadi,Daund', 'Nathachiwadi,Daund', 'Valki,Daund', 'Rahu,Daund', 'Khamgaon,Daund', 'Nangaon,Daund', 'Amoni Mal,Daund', 'Ganesh Road,Daund', 'Varwand,Daund', 'Khopodi,Daund', 'Handalwadi,Daund', 'Wakhari,Daund', 'Dapodi,Daund', 'Pargaon,Daund', 'Deshmukh Mala,Daund', 'Nimbalkar Wasti,Daund', 'Galandwadi,Daund', 'Kodit Kh.,Purandar', 'Pur,Purandar', 'Pokhar,Purandar', 'Warwadi,Purandar', 'Kumbhoshi,Purandar', 'Somurdi,Purandar', 'Gherapurandhar,Purandar', 'Supe  Kh.,Purandar', 'Misalwadi,Purandar', 'Thapewadi,Purandar', 'Bhivari,Purandar', 'Bhivadi,Purandar', 'Bahirwadi,Purandar', 'Bhopgaon,Purandar', 'Patharwadi,Purandar', 'Pimpale,Purandar', 'Panvadi,Purandar', 'Hivare,Purandar', 'Kodit Budruk,Purandar', 'Askarwadi,Purandar', 'Chambali,Purandar', 'Borhalewadi,Purandar', 'Garade,Purandar', 'Ambawane,Velhe', 'Chinchale Bk,Velhe', 'Karajwane,Velhe', 'Adavali,Velhe', 'Askawadi,Velhe', 'Ketkavane,Velhe', 'Kolwadi,Velhe', 'Lasirgaon,Velhe', 'Margasani,Velhe', 'Khambawadi,Velhe', 'Mangdari,Velhe', 'Mangaon,Velhe', 'Pole,Velhe', 'Kasedi,Velhe', 'Chikhali Kh,Velhe', 'Bhalvadi,Velhe', 'Thangaon,Velhe', 'Shirkoli,Velhe', 'Ghodshet,Velhe', 'Ambed,Velhe', 'Khamgaon,Velhe', 'Vinzar,Velhe', 'Wangani,Velhe', 'Varasgaon,Velhe', 'Ambegaon Kh,Velhe', 'Gholapghar,Velhe', 'Kambegi,Velhe', 'Ranjane,Velhe', 'Dapode,Velhe', 'Chinchale Kh,Velhe', 'Kuran Bk,Velhe', 'Vadghar,Velhe', 'Givashi,Velhe', 'Koshimghar,Velhe', 'Mose Bk,Velhe', 'Saiv Bk.,Velhe', 'Ranavdi,Velhe', 'Boravale,Velhe', 'Nigade Bk.,Velhe', 'Panshet,Velhe', 'Kondgaon,Velhe', 'Malavli,Velhe', 'Kathawadi,Velhe', 'Rule,Velhe', 'Kuran Kh,Velhe', 'Dhindli,Velhe', 'Ambegaon Bk,Velhe', 'Osade,Velhe', 'Nigade Mose,Velhe', 'Kandave,Velhe', 'Wanjalwadi,Velhe', 'Kurvathi,Velhe', 'Pimpale Jagtap,Shirur', 'Wajewadi,Shirur', 'Kasari,Shirur', 'Jategaon Kh.,Shirur', 'Takali Bhima,Shirur', 'Kondhapuri,Shirur', 'Khairewadi,Shirur', 'Rautwadi,Shirur', 'Karandi,Shirur', 'Amdabad,Shirur', 'Jategaon Bk.,Shirur', 'Kendur,Shirur', 'Shastabad,Shirur', 'Khandale,Shirur', 'Sone Sangavi,Shirur', 'Hivare,Shirur', 'Burunjwadi,Shirur', 'Darekarwadi,Shirur', 'Vitthalwadi,Shirur', 'Dingrajwadi,Shirur', 'Malthan,Shirur', 'Waghale,Shirur', 'Varude,Shirur', 'Shivtakrar Mahalungi,Shirur', 'Shingadwadi,Shirur', 'Ranjangaon Sandas,Shirur', 'Rakshewadi,Shirur', 'Pimpale Dumal,Shirur', 'Pimpari Dumala,Shirur', 'Nimgaon Bhogi,Shirur', 'Mukhai,Shirur', 'Motewadi,Shirur', 'Midgulwadi,Shirur', 'Lakhewadi,Shirur', 'Karanjawane,Shirur', 'Golegaon,Shirur', 'Dhanore,Shirur', 'Dhamari,Shirur', 'Dahiwadi,Shirur', 'Chincholi,Shirur', 'Bhambarde,Shirur', 'Arangaon,Shirur', 'Ambale,Shirur', 'Ganegaon Burunjwadi,Shirur', 'Kanhur mesai,Shirur', 'Pabal,Shirur', 'Andhalgaon,Shirur', 'Nimone,Shirur', 'Nhavara,Shirur', 'Kohakdewadi,Shirur', 'Uralgaon,Shirur', 'Alegaon Paga,Shirur', 'Nagargaon,Shirur', 'Babhulsar Kh.,Shirur', 'Chavhanwadi,Shirur', 'Parodi,Shirur', 'Nimgaon Mhalungi,Shirur', 'Karade,Shirur', 'Nighoje,Khed', 'Moi,Khed', 'Khalumbre,Khed', 'Mahalunge,Khed', 'Kanhewadi Tarf Chakan,Khed', 'Sangurdi,Khed', 'Shinde,Khed', 'Wasuli,Khed', 'Yevalewadi,Khed', 'Sawardari,Khed', 'Kuruli,Khed', 'Medankarwadi,Khed', 'Nanekarwadi,Khed', 'Sudumbare,Mawal', 'Chimbali,Khed', 'Indori,Mawal', 'Biradwadi,Khed', 'Bhamboli,Khed', 'Ambethan,Khed', 'Kharabwadi,Khed', 'Warale,Khed', 'Kadachiwadi,Khed', 'Sudhavadi,Mawal', 'Jambavade,Mawal', 'Bhare,Mulshi', 'Kasar Amboli,Mulshi', 'Mukhaiwadi,Mulshi', 'Uravade,Mulshi', 'Bhukum,Mulshi', 'Nande,Mulshi', 'Sus,Mulshi', 'Bavadhan Bk,Mulshi', 'Vadki,Haveli', 'Ghotavde,Mulshi', 'Talegaon Dabhade (R),Mawal', 'Urse,Mawal', 'Parandwadi,Mawal', 'Bhilarewadi,Haveli', 'Jambhulwadi,Haveli', 'Kolavadi,Haveli', 'Sasewadi,Bhor', 'Shindewadi,Bhor', 'Lavale,Mulshi', 'Man,Mulshi', 'Sanas Nagar,Haveli', 'Nandoshi,Haveli', 'Pirangut,Mulshi', 'Vadgaon Shinde,Haveli', 'Loni-Kalbhor,Haveli', 'Dive,Purandar', 'Ambegaon,Mulshi', 'Pawarwadi,Purandar', 'Kalewadi,Purandar', 'Sonori,Purandar', 'Bhugaon,Mulshi', 'Manjari Kh.,Haveli', 'Manjari Bk,Haveli', 'Kolavdi,Haveli', 'Shevalwadi,Haveli', 'Kadamvak Wasti,Haveli', 'Holkarwadi,Haveli', 'Autad Handewadi,Haveli', 'Vadachiwadi,Haveli', 'Pisoli,Haveli', 'Bebad Ohol,Mawal', 'Dhamne,Mawal', 'Godumbare,Mawal', 'Shirgaon,Mawal', 'Gahunje,Mawal', 'Salumbe,Mawal', 'Sangavade,Mawal', 'Jambe,Mulshi', 'Nere,Mulshi', 'Dattawadi,Mulshi', 'Hinjavadi,Mulshi', 'Marunji,Mulshi', 'Mahalunge,Mulshi', 'Materewadi,Mulshi', 'Bhoirwadi,Mulshi', 'Bhegdewadi,Mulshi', 'Chande,Mulshi', 'Mulkhed,Mulshi', 'Godambewadi,Mulshi', 'Bhowarapur,Haveli', 'Uruli Kanchan,Haveli', 'Peth,Haveli', 'Koregaon Mul,Haveli', 'Prayagdham,Haveli', 'Sortapwadi,Haveli', 'Kunjirwadi,Haveli', 'Theur,Haveli', 'Naygaon,Haveli', 'Mangewadi,Haveli', 'Nimbalkarwadi,Haveli', 'Kirkitwadi,Haveli', 'Khadakwasale,Haveli', 'Nanded ,Haveli', 'Kopare,Haveli', 'Kondhave Dhavade,Haveli', 'Mendhewadi,Mawal', 'Varale,Mawal', 'Malawadi,Mawal', 'Ambi,Mawal', 'Brahman Wadi,Mawal', 'Sate,Mawal', 'Mohitewadi,Mawal', 'Chikhalse,Mawal', 'Ahirvade,Mawal', 'Kusgaon Kh.,Mawal', 'Khadkale (CT),Mawal', 'Kamshet,Mawal', 'Paravadi,Mawal', 'Sadavli,Mawal', 'Ozarde,Mawal', 'Baur,Mawal', 'Brahmanwadi,Mawal', 'Karunj,Mawal', 'Adhe Kh.,Mawal', 'Somatane,Mawal', 'Jadhavwadi,Mawal', 'Akurdi,Mawal', 'Nanoli Tarf Chakan,Mawal', 'Sangavi,Mawal', 'Umbare Navalakh,Mawal', 'Badhalawadi,Mawal', 'Naygaon,Mawal', 'Nanoli N.m.,Mawal', 'Jambhul,Mawal', 'Kanhe,Mawal', 'Ambale,Mawal', 'Nigade,Mawal', 'Kalhat,Mawal', 'Pawalewadi,Mawal', 'Boraj,Mawal', 'Patan,Mawal', 'Kusgaon Bk. (CT),Mawal', 'Devale,Mawal', 'Aundhe kh.,Mawal', 'Dongargaon,Mawal', 'Aundholi,Mawal', 'Varsoli,Mawal', 'Karla,Mawal', 'Waksai,Mawal', 'Devghar,Mawal', 'Sadapur,Mawal', 'Kune N.m.,Mawal', 'Bhaje,Mawal', 'Malvali,Mawal', 'Mudhavare,Mawal', 'Taje,Mawal', 'Pathargaon,Mawal', 'Pimploli,Mawal', 'Santosh Nagar ,Khed', 'Rakshewadi,Khed', 'Waki Kh,Khed', 'Holewadi,Khed', 'Chandoli,Khed', 'Varachi Bhamburwadi,Khed', 'Sandbhorwadi,Khed', 'Pacharnewadi,Khed', 'Dhorewadi,Khed', 'Vadgaon Tarf Khed,Khed', 'Shiroli,Khed', 'Satkarsthal,Khed', 'Koregaon Bhima _CT,Shirur', 'Sanaswadi ,Shirur', 'Shikrapur,Shirur', 'Talegaon Dhamdhere,Shirur', 'Apti,Shirur', 'Vadu Bk.,Shirur', 'Shirur_Annapur_Saradwadi_Tardobachiwadi_Kardilwad,Shirur', 'Dhok Sangavi,Shirur', 'Karegaon,Shirur', 'Ranjangaon Ganpati,Shirur', 'Vanpuri,Purandar', 'Udachiwadi,Purandar', 'Singapur,Purandar', 'Zendewadi,Purandar', 'Jadhavwadi,Purandar', 'Kumbharvalan,Purandar', 'Ambodi,Purandar', 'Gurholi,Purandar', 'Bhose,Khed', 'Alandi,Khed', 'Dhanore,Khed', 'Rase,Khed', 'Solu,Khed', 'Pimpalgaon Tarf Chakan,Khed', 'Tulapur,Haveli', 'Nirgudi,Haveli', 'Markal,Khed', 'Charholi Kh.,Khed', 'Kelgaon,Khed', 'Shivapur,Haveli', 'Khed Shivapur,Haveli', 'Ramnagar,Haveli', 'Kasurdi,Bhor', 'Shivare,Bhor', 'Velu,Bhor', 'Hrishchandri,Bhor', 'Kapurhol,Bhor', 'Divale,Bhor', 'Kamthadi,Bhor', 'Kelavade,Bhor', 'Nasrapur,Bhor', 'Naygaon,Bhor', 'Varve Bk.,Bhor', 'Varve Kh.,Bhor', 'Ketkawale,Purandar', 'Chivewadi,Purandar', 'Devadi,Purandar', 'Awhalwadi,Haveli', 'Loni-kand,Haveli', 'Kesnand,Haveli', 'Taleranwadi,Haveli', 'Bhavadi,Haveli', 'Perane,Haveli', 'Phulgaon,Haveli', 'Wadhu Kh,Haveli', 'Wagholi,Haveli', 'Dhumalicha Mala,Daund', 'Kedgaon,Daund', 'Kedgaon Station,Daund', 'Dhaygudewadi,Daund', 'Boripardhi,Daund', 'Yawat Station,Daund', 'Yawat,Daund', 'Chandkhed,Mawal', 'Darumbare,Mawal', 'Vadgaon,Mawal', 'Golegaon,Khed', 'Narhe,Haveli'];
      $("#search").autocomplete({
        source: availableTags
      });
    });
  </script>
  <style>


  </style>
</head>

<body>



  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <!-- Profile Image -->

    <div class="text-center">

      <div class="avatar-upload">


        <h3 class="profile-username text-center pt-4">
          <?php echo $_SESSION['username']; ?>
        </h3>

        <p class="text-muted text-center">
          <?php echo $user['email']; ?>
        </p>


      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->


    <!--<button class="tablinks" >view download history</button>-->

    <form action="Logout.php" method="post">
      <button class="tablinks text-center" name="Logout" type="submit"><i class="fas fa-sign-out"></i> Logout</button>
    </form>


  </div>
  <div id="main0">
    <div id="main">
      <img src="images/Final logo.png" alt="image not found">
      <div id="main_search">
        <input type="text" placeholder="Search.." name="search2" id="search" onclick="SearchMe()"> <span id="btnData2"
          type="button" onclick="SearchMe()"><i class="far fa-search abc"></i></span>

        <button class="btn-success p-2 border-0" id="btnData1" type="button" onclick="ClearMe()">Clear</button>

      </div>
      <p style="font-size:20px;cursor:pointer;  float: right; padding-right: 5%;  padding-top: 25px; color: azure; "
        onclick="openNav()">
        <?php echo $_SESSION['username']; ?></p>

    </div>
    <div id="map"></div>
  </div>

  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      //document.getElementById("main").style.marginLeft = "250px";
      //document.getElementById("map").style.marginLeft = "250px";


    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      //document.getElementById("main").style.marginLeft = "0";
      //document.getElementById("map").style.marginLeft = "0";
    }
    // 

    // upload image
    $(document).ready(function () {

      $("#imageUpload").change(function (data) {

        var imageFile = data.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(imageFile);

        reader.onload = function (evt) {
          $('#imagePreview').attr('src', evt.target.result);
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
        }

      });



    });

    var map, geojson;

    //Add Basemap
    var map = L.map("map", {}).setView([18.55, 73.85], 10, L.CRS.EPSG4326);

    var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });


    var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var Esri_WorldImagery = L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      {
        attribution:
          "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community"
      }
    );

    var baseLayers = {
      SImagery: Esri_WorldImagery,
      GoogleImage: googleSat,
      OSM: osm,
    };

    var wms_layer3 = L.tileLayer.wms(
      "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
      {
        layers: "DP:Changes_Overlay",
        format: "image/png",
        transparent: true,
        tiled: true,
        version: "1.1.0",
        attribution: "Dp Layers",
        opacity: 1,

      }
    );


    var wms_layer = L.tileLayer.wms(
      "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
      {
        layers: "DP:DP",
        format: "image/png",
        transparent: true,
        tiled: true,
        version: "1.1.0",
        attribution: "Dp Layers",
        opacity: 0.7,

      }
    );
    wms_layer.addTo(map);

    var wms_layer1 = L.tileLayer.wms(
      "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
      {
        layers: "DP:Revenue",
        format: "image/png",
        transparent: true,
        tiled: true,
        version: "1.1.0",
        attribution: "Revenue",

      }
    );


    var wms_layer2 = L.tileLayer.wms(
      "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
      {
        layers: "DP:RP",
        format: "image/png",
        transparent: true,
        tiled: true,
        version: "1.1.0",
        attribution: "Taluka",
        opacity: 0.4,
        visible: false,
      }
    );


    var wms_layer4 = L.tileLayer.wms(
      "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
      {
        layers: "DP:UGC",
        format: "image/png",
        transparent: true,
        tiled: true,
        version: "1.1.0",
        attribution: "ugc boundary",
        opacity: 1,

      }
    );



    var WMSlayers = {
      UGC: wms_layer4,
      DP: wms_layer,
      RP: wms_layer2,
      Revenue: wms_layer1,
      Change_Overlay: wms_layer3,
    };



    map.on('dblclick', function (e) {
      var lat = e.latlng.lat.toFixed(15);
      var lng = e.latlng.lng.toFixed(15);
      console.log(lat, lng)
      var popupContent = '<a href="https://earth.google.com/web/search/' + lat + "," + lng + '" target="_blank">Open in Google Earth</a>'
      L.popup()
        .setLatLng(e.latlng)
        .setContent(popupContent)
        .openOn(map);
    });

    var control = new L.control.layers(baseLayers, WMSlayers).addTo(map);


    // Initialise the FeatureGroup to store editable layers
    var editableLayers = new L.FeatureGroup();
    map.addLayer(editableLayers);

    var drawPluginOptions = {
      position: 'topright',
      draw: {
        polygon: {
          allowIntersection: true, // Restricts shapes to simple polygons
          shapeOptions: {
            color: 'blue'
          }
        },

        polyline: {
          allowIntersection: true, // Restricts shapes to simple polylines
          shapeOptions: {
            color: 'blue'
          }
        },

        circle: {
          allowIntersection: true, // Restricts shapes to simple polylines
          shapeOptions: {
            color: "blue",


          }
        },
        // disable toolbar item by setting it to false
        // Turns off this drawing tool
        rectangle: false,
        marker: false,
      },
      edit: {
        featureGroup: editableLayers, //REQUIRED!!
        remove: false
      }
    };

    // Initialise the draw control and pass it the FeatureGroup of editable layers
    // -----------------------------------------------------
    var drawControl = new L.Control.Draw({
      edit: {
        featureGroup: editableLayers
      }
    });
    map.addControl(drawControl);

    // var editableLayers = new L.FeatureGroup();
    // map.addLayer(editableLayers);

    map.on('draw:created', function (e) {
      drawnItems.addLayer(e.layer);
    });
    // -----------------------------------php to handle kml export
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $kml = '<?xml version="1.0" encoding="UTF-8"?>';
      $kml .= '<kml xmlns="http://www.opengis.net/kml/2.2">';
      $kml .= '<Document>';
      $kml .= '<Placemark>';
      $kml .= '<name>Drawn Polyline</name>';
      $kml .= '<LineString>';
      $kml .= '<tessellate>1</tessellate>';
      $kml .= '<coordinates>';

      $layers = json_decode($_POST['layers']);
      foreach ($layers as $layer) {
        $latlngs = $layer->latlngs;
        foreach ($latlngs as $latlng) {
          $kml .= $latlng->lng . ',' . $latlng->lat . ',0 ';
        }
      }

      $kml .= '</coordinates>';
      $kml .= '</LineString>';
      $kml .= '</Placemark>';
      $kml .= '</Document>';
      $kml .= '</kml>';

      header('Content-type: application/vnd.google-earth.kml+xml');
      header('Content-Disposition: attachment; filename="drawn_polyline.kml"');
      echo $kml;
      exit;
    }
    ?>
    // ---------------------------------------------------------------------

    uri = "http://geoserver.tractcybernetics.com:8080/geoserver/DP/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=DP:DP", {
      // namedToggle: false,

    };
    L.wmsLegend(uri);
    //

    // control
    // mouse position
    L.control.mousePosition({
      position: "bottomleft",
      prefix: "lat : long"
    })
      .addTo(map);

    //Scale

    L.control
      .scale({
        imperial: false,
        maxWidth: 200,
        metric: true,
        position: 'bottomleft',
        updateWhenIdle: false
      })
      .addTo(map);

    //line mesure
    L.control
      .polylineMeasure({
        position: "topleft",
        unit: "kilometres",
        showBearings: true,
        clearMeasurementsOnStop: false,
        showClearControl: true,
        showUnitControl: true
      })
      .addTo(map);

    //area measure
    var measureControl = new L.Control.Measure({
      position: "topleft"
    });
    measureControl.addTo(map);

    $('#btnData2').click(function () {
      SearchMe();
    });

    $('#btnData1').click(function () {
      ClearMe()();
    });

    function SearchMe() {
      var array = $('#search').val().split(",");

      if (array.length == 1) {
        var sql_filter1 = "Gut_Number Like '" + array[0] + "'"
        fitbou(sql_filter1)
        wms_layer1.setParams({
          cql_filter: sql_filter1,
          styles: 'highlight',
        }); wms_layer1.addTo(map);
      }
      else if (array.length == 2) {
        var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Taluka Like '" + array[1] + "'"
        fitbou(sql_filter1)
        wms_layer1.setParams({
          cql_filter: sql_filter1,
          styles: 'highlight',
        }); wms_layer1.addTo(map);
      }
      else if (array.length >= 3) {
        var guts = array.slice(2, array.length).join(", ")
        var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Gut_Number IN (" + guts + ")" + "AND Taluka Like '" + array[1] + "'"
        fitbou(sql_filter1)
        wms_layer1.setParams({
          cql_filter: sql_filter1,
          styles: 'highlight',
        }); wms_layer1.addTo(map);
      }
    }
    function fitbou(filter) {
      var layer = 'DP:Revenue'
      var urlm = "http://geoserver.tractcybernetics.com:8080/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" + layer + "&CQL_FILTER=" + filter + "&outputFormat=application/json";
      console.log(urlm)
      $.getJSON(urlm, function (data) {
        geojson = L.geoJson(data, {
        });
        map.fitBounds(geojson.getBounds());
      });
    };

    function ClearMe() {
      map.setView([18.55, 73.85], 10, L.CRS.EPSG4326)
    };








  </script>

</body>

</html>