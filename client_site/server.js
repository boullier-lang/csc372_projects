//Mathew Boullier
//Date: 2/22/2026
//A simple NODE.JS file that acts as the server.

//Updated on 2/28/2026
//Changed to now use handlebars and express
const express = require("express");
const handlebars = require("express-handlebars").create({defaultLayout: "main"});
const path = require("path");
const fs = require("fs");

//Declare our 'app'
const app = express();
app.engine("handlebars", handlebars.engine);
app.set("view engine", "handlebars");


//Register static elements
app.use(express.static(path.join(__dirname, 'public')));


//Now, just to get some more practice using node.js, I have decided
//to place hours of operations, services, and annoucements as data in a new
//data folder. They will be held in .json files. OBviously... it will change when we learn more
const hoursData = JSON.parse(fs.readFileSync(path.join(__dirname, "data/hours.json")));
const announcementsData = JSON.parse(fs.readFileSync(path.join(__dirname, "data/announcements.json")));
const servicesData = JSON.parse(fs.readFileSync(path.join(__dirname, "data/services.json")));



//Define our port
const PORT = 3000;

//Make our routes
app.get("/", (request, response) => {
	response.render("home_page", {
		title: "Golden Mane Salon",
		hours: hoursData.hours,
		announce: announcementsData.announcements
	});
})

app.get("/services", (request, response) => {
	response.render("services", {
		title: "Services",
		styles: "services.css",
		services: servicesData.services,
		hours: hoursData.hours,
		announce: announcementsData.announcements
	});
})

app.get("/staff", (request, response) => {
	response.render("staff", {
		title: "Staff"
	});
})


app.get("/about", (request, response) => {
	response.render("about", {
		title: "About",
		hours: hoursData.hours,
		announce: announcementsData.announcements
	});
})

app.get("/gift-cards", (request, response) => {
	response.render("gift-cards", {
		title: "Gift Cards"
	});
})

app.get("/reviews", (request, response) => {
	response.render("reviews", {
		title: "Reviews"
	});
})

//Test the 500 error
app.get("/test500", (req, res, next) => {
    const err = new Error("This is a test server error");
    next(err);
});

//Wildcard
app.get("/{*splat}", (request, response) => {
	response.render("404", {
		title: "Page Not Found"
	});
})

//500 error handling
app.use((err, req, res, next) => {
    console.error(err.stack); 

    res.status(500).render("500", {
        title: "Server Error"
    });
});

app.listen(PORT, () =>{
	console.log("Listening at: http://localhost:" + PORT + " !!");
});