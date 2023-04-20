var map, geojson;

//Add Basemap
var map = L.map("map", {}).setView([18.55, 73.85], 10, L.CRS.EPSG4326);

var googleSat = L.tileLayer(
  "https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
  {
    maxZoom: 20,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
  }
);

var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

var Esri_WorldImagery = L.tileLayer(
  "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
  {
    attribution:
      "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
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
  "https://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
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
  "https://geoserver.tractcybernetics.com:8080/geoserver/DP/wms",
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

map.on("dblclick", function (e) {
  var lat = e.latlng.lat.toFixed(15);
  var lng = e.latlng.lng.toFixed(15);
  console.log(lat, lng);
  var popupContent =
    '<a href="https://earth.google.com/web/search/' +
    lat +
    "," +
    lng +
    '" target="_blank">Open in Google Earth</a>';
  L.popup().setLatLng(e.latlng).setContent(popupContent).openOn(map);
});

var control = new L.control.layers(baseLayers, WMSlayers).addTo(map);

// Initialise the FeatureGroup to store editable layers
var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

var drawPluginOptions = {
  position: "topright",
  draw: {
    polygon: {
      allowIntersection: true, // Restricts shapes to simple polygons
      shapeOptions: {
        color: "blue",
      },
    },

    polyline: {
      allowIntersection: true, // Restricts shapes to simple polylines
      shapeOptions: {
        color: "blue",
      },
      coordinates: [],
    },

    circle: {
      allowIntersection: true, // Restricts shapes to simple polylines
      shapeOptions: {
        color: "blue",
      },
    },
    // disable toolbar item by setting it to false
    // Turns off this drawing tool
    rectangle: false,
    marker: false,
  },
  edit: {
    featureGroup: editableLayers, //REQUIRED!!
    remove: false,
  },
};
// ---------------------------------------------------------
map.on("click", function (e) {
  coordinates.push([e.latlng.lat, e.latlng.lng]);
  polyline.setLatLngs(coordinates);
});

var saveButton = document.getElementById("save-btn");
saveButton.addEventListener("click", function () {
  var kml = '<?xml version="1.0" encoding="UTF-8"?>\n';
  kml += '<kml xmlns="http://www.opengis.net/kml/2.2">\n';
  kml += "<Document>\n";
  kml += "<Placemark>\n";
  kml += "<LineString>\n";
  kml += "<coordinates>\n";
  for (var i = 0; i < coordinates.length; i++) {
    kml += coordinates[i][1] + "," + coordinates[i][0] + "\n";
  }
  kml += "</coordinates>\n";
  kml += "</LineString>\n";
  kml += "</Placemark>\n";
  kml += "</Document>\n";
  kml += "</kml>";

  var blob = new Blob([kml], { type: "text/xml" });
  var url = window.URL.createObjectURL(blob);
  var link = document.createElement("a");
  link.href = url;
  link.download = "polyline.kml";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  window.URL.revokeObjectURL(url);
});

// Initialise the draw control and pass it the FeatureGroup of editable layers
var drawControl = new L.Control.Draw(drawPluginOptions);
map.addControl(drawControl);

// var editableLayers = new L.FeatureGroup();
// map.addLayer(editableLayers);

map.on("draw:created", function (e) {
  var type = e.layerType,
    layer = e.layer;

  editableLayers.addLayer(layer);
});

(uri =
  "https://geoserver.tractcybernetics.com:8080/geoserver/DP/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=DP:DP"),
  {
    // namedToggle: false,
  };
L.wmsLegend(uri);
//

// control
// mouse position
L.control
  .mousePosition({
    position: "bottomleft",
    prefix: "lat : long",
  })
  .addTo(map);

//Scale

L.control
  .scale({
    imperial: false,
    maxWidth: 200,
    metric: true,
    position: "bottomleft",
    updateWhenIdle: false,
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
    showUnitControl: true,
  })
  .addTo(map);

//area measure
var measureControl = new L.Control.Measure({
  position: "topleft",
});
measureControl.addTo(map);

$("#btnData2").click(function () {
  SearchMe();
});

$("#btnData1").click(function () {
  ClearMe()();
});

function SearchMe() {
  var array = $("#search").val().split(",");

  if (array.length == 1) {
    var sql_filter1 = "Gut_Number Like '" + array[0] + "'";
    fitbou(sql_filter1);
    wms_layer1.setParams({
      cql_filter: sql_filter1,
      styles: "highlight",
    });
    wms_layer1.addTo(map);
  } else if (array.length == 2) {
    var sql_filter1 =
      "Village__1 Like '" +
      array[0] +
      "'" +
      "AND Taluka Like '" +
      array[1] +
      "'";
    fitbou(sql_filter1);
    wms_layer1.setParams({
      cql_filter: sql_filter1,
      styles: "highlight",
    });
    wms_layer1.addTo(map);
  } else if (array.length >= 3) {
    var guts = array.slice(2, array.length).join(", ");
    var sql_filter1 =
      "Village__1 Like '" +
      array[0] +
      "'" +
      "AND Gut_Number IN (" +
      guts +
      ")" +
      "AND Taluka Like '" +
      array[1] +
      "'";
    fitbou(sql_filter1);
    wms_layer1.setParams({
      cql_filter: sql_filter1,
      styles: "highlight",
    });
    wms_layer1.addTo(map);
  }
}
function fitbou(filter) {
  var layer = "DP:Revenue";
  var urlm =
    "https://geoserver.tractcybernetics.com:8080/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" +
    layer +
    "&CQL_FILTER=" +
    filter +
    "&outputFormat=application/json";
  console.log(urlm);
  $.getJSON(urlm, function (data) {
    geojson = L.geoJson(data, {});
    map.fitBounds(geojson.getBounds());
  });
}

function ClearMe() {
  map.setView([18.55, 73.85], 10, L.CRS.EPSG4326);
}
