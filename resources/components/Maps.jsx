import { useState, useEffect } from "react";
import {
  useJsApiLoader,
  GoogleMap,
  Marker,
  DirectionsRenderer,
} from "@react-google-maps/api";

function Maps({ startLocation, endLocation, h, w }) {
  const { isLoaded, loadError } = useJsApiLoader({
    id: "google-map-script",
    googleMapsApiKey: "AIzaSyDEvj4tgd_JkdfzYHtY_DA_w0dhWDNNwZQ",
  });

  const [mapReady, setMapReady] = useState(false)
  const [directionsResponse, setDirectionsResponse] = useState(null);
  const [originLatLng, setOriginLatLng] = useState(null);
  const [destinationLatLng, setDestinationLatLng] = useState(null);

  useEffect(() => {
    if (isLoaded && !loadError) {
      const geocoder = new window.google.maps.Geocoder();
      if (startLocation) {
        geocoder.geocode({ address: startLocation }, (results, status) => {
          if (status === "OK" && results[0]) {
            setOriginLatLng(results[0].geometry.location);
            setMapReady(true)
          } else {
            console.error("Geocode error for startLocation:", status);
          }
        });
      }
      if (endLocation) {
        geocoder.geocode({ address: endLocation }, (results, status) => {
          if (status === "OK" && results[0]) {
            setDestinationLatLng(results[0].geometry.location);
            setMapReady(true)
          } else {
            console.error("Geocode error for endLocation:", status);
          }
        });
      }
    }
  }, [isLoaded, loadError, startLocation, endLocation]);

  useEffect(() => {
    if (mapReady && originLatLng && destinationLatLng) {
      calculateRoute();
    }
  }, [mapReady, originLatLng, destinationLatLng]);

  async function calculateRoute() {
    const directionsService = new window.google.maps.DirectionsService();
    const results = await new Promise((resolve, reject) => {
      directionsService.route(
        {
          origin: originLatLng,
          destination: destinationLatLng,
          travelMode: window.google.maps.TravelMode.DRIVING,
        },
        (response, status) => {
          if (status === "OK") {
            resolve(response);
          } else {
            reject(status);
          }
        }
      );
    });
    setDirectionsResponse(results);
  }

  return isLoaded ? (
    <GoogleMap
      center={{ lat: 0, lng: 0 }}
      zoom={2}
      mapContainerStyle={{ width: h, height: w }}
      options={{
        zoomControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false,
      }}
    >
      {originLatLng && <Marker position={originLatLng} />}
      {directionsResponse && <DirectionsRenderer directions={directionsResponse} />}
    </GoogleMap>
  ) : (
    <div>Loading...</div>
  );
}

export default Maps;
