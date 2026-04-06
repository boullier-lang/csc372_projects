// Simple reviews.js file, which will display the reviews for the user to see.


//Date: 2/14/26
//Created a simple text-box to hold the API key, so I don't need to worry about keepnig it safe. Additionally, this API requires that it be called from the back-end, from what I can tell.
//It will give a CORS error no matter what. I wrote this with the intention to get it in a 'workable' state, and it seems that it does work, but fails at the CORS error.
 

let map; // dummy map element for PlacesService
const BUSINESS_NAME = "Golden Mane Salon Rhode Island"; 


  async function loadReviews() {
    const key = document.getElementById("apikey").value.trim();
    if (!key) return alert("Enter API Key!");

    document.getElementById("reviews").innerHTML = "Loading…";

    try {
      // 1) Get Place ID from Find Place
      const findUrl = `https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=${encodeURIComponent(BUSINESS_NAME)}&inputtype=textquery&fields=place_id&key=${key}`;
      const findResp = await fetch(findUrl);
      const findData = await findResp.json();

      if (!findData || !findData.candidates || findData.candidates.length === 0) {
        document.getElementById("reviews").innerText = "Business not found!";
        return;
      }

      const placeId = findData.candidates[0].place_id;
      console.log("Place ID:", placeId);

      // 2) Get Reviews from Place Details
      const detailsUrl = `https://maps.googleapis.com/maps/api/place/details/json?place_id=${placeId}&fields=name,rating,reviews&key=${key}`;
      const detailsResp = await fetch(detailsUrl);
      const detailsData = await detailsResp.json();

		//Check, do we actually get anything back?
      if (!detailsData || !detailsData.result) {
        document.getElementById("reviews").innerText = "Failed to load details";
        return;
      }

      const place = detailsData.result;
      const reviews = place.reviews || [];

      const container = document.getElementById("reviews");
      container.innerHTML = `<h3>${place.name}</h3>`;

		//If we didn't find anything, then just LEAVE
      if (reviews.length == 0) {
        container.innerHTML += "<p>No reviews found.</p>";
        return;
      }

		// 3) Finally, show our reviews...!
      reviews.forEach(r => {
        const div = document.createElement("div");
        div.className = "review";
        div.innerHTML = `
          <div class="author">${r.author_name}</div>
          <div class="text">${r.text}</div>
        `;
        container.appendChild(div);
      });

    } catch (err) {
      console.error(err);
      document.getElementById("reviews").innerText = "Error loading reviews.";
    }
  }
  
  
//I also added this just because... I need to show that i have something :/
function showLocation() {
  const container = document.getElementById("reviews");

//scawy i know where u are
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        container.innerHTML = `
          <h3>Your Location</h3>
          <p>Latitude: ${position.coords.latitude}</p>
          <p>Longitude: ${position.coords.longitude}</p>
          <p>Success! WE WIN.</p>
        `;
      },
      (error) => {
        container.innerHTML = `<p>Unable to get your location. Error code: ${error.code}</p>`;
      }
    );
  } else {
    container.innerHTML = "<p>Geolocation is not supported by your browser.</p>";
  }
}
  
  
  
  
document.getElementById("load_reviews").addEventListener("click", loadReviews);
document.getElementById("show_location").addEventListener("click", showLocation);